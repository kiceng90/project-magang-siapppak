<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Jawaban;
use App\Models\Materi;
use App\Models\ProgresSubkategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Image;
use App\Exports\DatabasePesertaExport;
use App\Exports\LaporanElearningExport;
use App\Exports\RekapBulananElearningExport;
use App\Exports\RekapTahunanElearningExport;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;

class DatabasePesertaController extends Controller
{
    public function index(Request $request)
    {
        try {
            $limit = $request->limit ? intval($request->limit) : 10;
            $order = $request->order ?? 'DESC';
            $sortby = $request->sortby ?? 'id';

            $jawaban = ProgresSubkategori::select('id', 'id_user', 'id_sub_kategori', 'is_completed', 'updated_at')
                ->with(['user.role', 'subkategori.kategori'])
                ->where('is_completed', true);

            if (!$request->start_date) {
            $request->request->add(['start_date' => date('Y-m-d', strtotime('01/01'))]);
            }
            if (!$request->end_date) {
                $request->request->add(['end_date' => date('Y-m-d', strtotime('12/31'))]);
            }
            $jawaban->whereBetween('updated_at', [
                $request->start_date . " 00:00:00",
                $request->end_date . " 23:59:59"
            ]);

            if ($request->filled('search')) {
                $search = trim($request->search);

                $jawaban->where(function ($query) use ($search) {
                    $query
                        ->orWhereHas('user', function ($userQuery) use ($search) {
                            $userQuery->whereRaw('LOWER(name) LIKE ?', ['%' . strtolower($search) . '%']);
                        })
                        ->orWhereHas('user.role', function ($userQuery) use ($search) {
                            $userQuery->whereRaw('LOWER(name) LIKE ?', ['%' . strtolower($search) . '%']);
                        })
                        ->orWhereHas('subkategori', function ($subquery) use ($search) {
                            $subquery->whereRaw('LOWER(name) LIKE ?', ['%' . strtolower($search) . '%']);
                        })
                        ->orWhereHas('subkategori.kategori', function ($catQuery) use ($search) {
                            $catQuery->whereRaw('LOWER(name) LIKE ?', ['%' . strtolower($search) . '%']);
                        });
                });
            }
            if ($request->filled('id_kategori') && $request->id_kategori != "0") {
                $jawaban->whereHas('subkategori.kategori', function ($query) use ($request) {
                    $query->where('id', $request->id_kategori);
                });
            }
            if ($request->filled('id_subkategori') && $request->id_subkategori != "0") {
                $jawaban->whereHas('subkategori', function ($query) use ($request) {
                    $query->where('id', $request->id_subkategori);
                });
            }

            $jawaban->orderBy($sortby, $order);
            $jawabanPaginated = $jawaban->paginate($limit);

            return response()->json($jawabanPaginated, 200);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function getSertifikatData($id)
    {
        try {
            $progres = ProgresSubkategori::with(['user', 'subKategori', 'subKategori.materi' => function ($query) {
                $query->where('is_active', true);
            }])
                ->where('id', $id)
                ->firstOrFail();
            $formattedId = str_pad($progres->id, 4, '0', STR_PAD_LEFT);
            $data = [
                'nosurat' => "NO : 400.9.12.1/$formattedId/436.7.8/2025",
                'user_name' => $progres->user->name,
                'sub_category_name' => $progres->subKategori->name,
                'formatted_date' => $progres->updated_at->format('d F Y'),
                'materi_list' => $progres->subKategori->materi->map(function ($mat) {
                    return ['name' => $mat->name];
                })
            ];

            return response()->json($data, 200);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function rekapTahunan(Request $request)
    {
        return Excel::download(new RekapTahunanElearningExport($request->id_kategori, $request->id_subkategori, $request->tahun_awal, $request->tahun_akhir), 'rekap_tahunan.xlsx');
    }

    public function rekapBulanan(Request $request)
    {
        return Excel::download(new RekapBulananElearningExport($request->id_kategori, $request->id_subkategori, $request->bulan_awal, $request->bulan_akhir), 'rekap_bulanan.xlsx');
    }

    public function laporanElearning(Request $req)
    {
        ini_set('max_execution_time', 600);

        $rules = [
            'type' => 'required|in:laporanElearning',
            'periode' => 'nullable|in:1,2,3,4',
            'start_date' => 'nullable|date_format:Y-m-d H:i:s|required_if:periode,4',
            'end_date' => 'nullable|date_format:Y-m-d H:i:s|required_if:periode,4',
            'id_kategori' => 'nullable|integer|exists:App\Models\Kategori,id',
            'id_subkategori' => 'nullable|integer|exists:App\Models\SubKategori,id',
            'search' => 'nullable|string',
            'is_download' => 'nullable|boolean',
        ];

        $validator = Validator::make($req->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'code' => 422,
                'message' => $validator->errors()->first(),
                'errors' => $validator->errors(),
            ], 422);
        }

        $query = ProgresSubkategori::with('user', 'subKategori.kategori');

        switch ($req->periode) {
            case 1:
                $start_date = Carbon::now()->startOfMonth()->format('Y-m-d H:i:s');
                $end_date = Carbon::now()->endOfMonth()->format('Y-m-d H:i:s');
                $query->whereBetween('updated_at', [$start_date, $end_date]);
                break;
        
            case 2:
                $start_date = Carbon::now()->subMonths(2)->startOfMonth()->format('Y-m-d H:i:s');
                $end_date = Carbon::now()->subMonths(2)->endOfMonth()->format('Y-m-d H:i:s');
                $query->whereBetween('updated_at', [$start_date, $end_date]);
                break;
        
            case 3:
                $start_date = Carbon::now()->startOfYear()->format('Y-m-d H:i:s');
                $end_date = Carbon::now()->endOfYear()->format('Y-m-d H:i:s');
                $query->whereBetween('updated_at', [$start_date, $end_date]);
                break;
        
            case 4:
                $start_date = $req->start_date 
                    ? Carbon::parse($req->start_date)->format('Y-m-d H:i:s')
                    : Carbon::now()->format('Y-m-d H:i:s');
                $end_date = $req->end_date 
                    ? Carbon::parse($req->end_date)->format('Y-m-d H:i:s')
                    : Carbon::now()->format('Y-m-d H:i:s');
                $query->whereBetween('updated_at', [$start_date, $end_date]);
                break;
        
            default:
                break;
        }        

        if ($req->kategori) {
            $query->whereHas('subKategori.kategori', function ($q) use ($req) {
                $q->where('id', $req->kategori);
            });
        }
        if ($req->subkategori) {
            $query->whereHas('subKategori', function ($q) use ($req) {
                $q->where('id', $req->subkategori);
            });
        }

        $data = $query->orderBy('updated_at', 'ASC')->get();

        if ($req->is_download) {
            return Excel::download(new LaporanElearningExport($req->id_kategori, $req->id_subkategori, $req->search, $req->periode, $req->start_date, $req->end_date), 'LaporanElearning_' . date('Y-m-d') . '.xlsx');
        }

        return response()->json([
            'code' => 200,
            'message' => 'Data berhasil diambil',
            'data' => $data,
        ], 200);
    }

    public function export(Request $request)
    {
        $kategori = $request->query('kategori');
        $subkategori = $request->query('subkategori');
        $search = $request->query('search');
        $startdate = $request->query('startdate');
        $enddate = $request->query('enddate');

        return Excel::download(new DatabasePesertaExport($kategori, $subkategori, $search, $startdate, $enddate), 'database_peserta.xlsx');
    }

}
