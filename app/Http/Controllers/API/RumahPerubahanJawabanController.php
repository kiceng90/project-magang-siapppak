<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\RumahPerubahanJawaban;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\DatabaseRumahPerubahan;

class RumahPerubahanJawabanController extends Controller
{
        public function store(Request $request)
        {
            try {
                DB::beginTransaction();
    
                // Verifikasi pengguna dari token
                $user = auth()->user(); // Pengguna yang login saat ini
                if (!$user) {
                    return response()->json([
                        'code' => 401,
                        'message' => 'Unauthorized',
                    ], 401);
                }
    
                // Validasi input (termasuk data penghuni)
                $rules = [
                    'id_materi' => 'required|exists:m_rumah_perubahan_materi,id',
                    'nama' => 'required|string|max:255',
                    'nik' => 'required|string|max:16',
                    'id_kabupaten' => 'required|exists:m_kabupaten,id',
                    'id_kecamatan' => 'required|exists:m_kecamatan,id',
                    'id_kelurahan' => 'required|exists:m_kelurahan,id',
                    'alamat' => 'required|string',
                    'no_telepon' => 'required|string|max:15',
                ];
    
                $validator = Validator::make($request->all(), $rules);
                if ($validator->fails()) {
                    return response()->json([
                        'code' => 422,
                        'message' => $validator->errors()->first(),
                        'errors' => $validator->errors()
                    ], 422);
                }
    
                // Try using direct DB insert instead of Eloquent
                $id = DB::table('rumah_perubahan_jawaban')->insertGetId([
                    'id_user' => $user->id,
                    'id_materi' => $request->id_materi,
                    'nama' => $request->nama,
                    'nik' => $request->nik,
                    'id_kabupaten' => $request->id_kabupaten,
                    'id_kecamatan' => $request->id_kecamatan,
                    'id_kelurahan' => $request->id_kelurahan,
                    'alamat' => $request->alamat,
                    'no_telepon' => $request->no_telepon,
                    'created_by' => $user->id,
                    'updated_by' => $user->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
    
                $jawaban = RumahPerubahanJawaban::find($id);
                
                DB::commit();
                
                return response()->json([
                    'code' => 201,
                    'data' => $jawaban,
                    'message' => 'Jawaban created successfully'
                ], 201);
            } catch (\Exception $e) {
                DB::rollback();
                    
                return response()->json([
                    'code' => 500,
                    'message' => 'An error occurred: ' . $e->getMessage()
                ], 500);
            }
        }

        public function complete($id)
        {
            try {
                DB::beginTransaction();
                
                $user = auth()->user();
                if (!$user) {
                    return response()->json([
                        'code' => 401,
                        'message' => 'Unauthorized',
                    ], 401);
                }
                
                $jawaban = RumahPerubahanJawaban::findOrFail($id);
                
                if ($jawaban->id_user !== $user->id) {
                    return response()->json([
                        'code' => 403,
                        'message' => 'Forbidden: You do not have permission to update this record',
                    ], 403);
                }
                
                $totalScore = DB::table('rumah_perubahan_detail_jawaban')
                    ->where('id_jawaban', $id)
                    ->sum('skor');
                
                $jawaban->is_done = true;
                $jawaban->is_selesai = true;
                $jawaban->skor = $totalScore;
                $jawaban->updated_by = $user->id;
                $jawaban->save();
                
                DB::commit();
                
                return response()->json([
                    'code' => 200,
                    'data' => [
                        'id' => $jawaban->id,
                        'skor' => $jawaban->skor,
                        'is_done' => $jawaban->is_done,
                        'is_selesai' => $jawaban->is_selesai
                    ],
                    'message' => 'Jawaban marked as completed successfully'
                ], 200);
                
            } catch (\Exception $e) {
                DB::rollback();
                                
                return response()->json([
                    'code' => 500,
                    'message' => 'An error occurred: ' . $e->getMessage()
                ], 500);
            }
        }

        public function index(Request $request)
        {
            try {
                $user = auth()->user(); 
                
                // Restrict access to admin users only
                if ($user->id_role !== 1) {
                    return response()->json([
                        'error' => 'Unauthorized. Only administrators can access this data.'
                    ], 403);
                }
                
                $limit = $request->limit ? intval($request->limit) : 10;
                $order = $request->order ? $request->order : 'DESC';
                $sortby = $request->sortby ? $request->sortby : 'id';

                $jawaban = RumahPerubahanJawaban::query();

                if ($request->filled('search')) {
                    $jawaban->where(function ($q) use ($request) {
                        $s = $request->search;
                        $q->where('nama', 'ILIKE', '%' . $s . '%')
                        ->orWhere('nik', 'ILIKE', '%' . $s . '%')
                        ->orWhere('alamat', 'ILIKE', '%' . $s . '%')
                        ->orWhere('no_telepon', 'ILIKE', '%' . $s . '%');
                    });
                }
                
                // Filter by materi if requested
                if ($request->filled('id_materi')) {
                    $jawaban->where('id_materi', $request->id_materi);
                }

                // Load relationships
                $jawaban->with(['user', 'materi', 'kabupaten', 'kecamatan', 'kelurahan']);

                $jawaban = $jawaban->orderBy($sortby, $order)->paginate($limit);
                
                return response()->json($jawaban);
            } catch (\Exception $e) {
                return response()->json(['error' => $e->getMessage()], 500);
            }
        }
        public function createNewAttempt(Request $request)
        {
            try {
                $user = auth()->user();
                if (!$user) {
                    return response()->json(['message' => 'Unauthorized'], 401);
                }
                
                $previousJawaban = RumahPerubahanJawaban::find($request->id_jawaban_previous);
                
                if (!$previousJawaban) {
                    return response()->json(['message' => 'Jawaban sebelumnya tidak ditemukan'], 404);
                }
                
                // Create a new jawaban record
                $newJawaban = $previousJawaban->replicate();
                $newJawaban->skor = 0;
                $newJawaban->is_done = false;
                $newJawaban->is_selesai = false;
                $newJawaban->created_at = now();
                $newJawaban->updated_at = now();
                $newJawaban->save();
                
                return response()->json([
                    'success' => true,
                    'id_jawaban' => $newJawaban->id,
                    'message' => 'Attempt baru berhasil dibuat'
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan: ' . $e->getMessage()
                ], 500);
            }
        }
        public function export(Request $request)
        {
            $kategori = $request->query('kategori');
            $materi = $request->query('materi');
            $search = $request->query('search');
            $startdate = $request->query('startdate');
            $enddate = $request->query('enddate');

            return Excel::download(new DatabaseRumahPerubahan($kategori, $materi, $search, $startdate, $enddate), 'Database Rumah Perubahan.xlsx');
        }

    }
