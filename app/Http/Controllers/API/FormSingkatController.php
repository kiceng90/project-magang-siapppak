<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\form_singkat;
use App\Models\FormSingkat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class FormSingkatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            // Validasi input
            $rules = [
                'buku_tamu_kebutuhan_layanan_id' => 'required|exists:buku_tamu_kebutuhan_layanan,id',
                'keterangan' => 'nullable|string',
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                DB::rollBack();
                return response()->json([
                    'message' => $validator->errors()->first(),
                    'errors' => $validator->errors(),
                ], 422);
            }

            $formSingkat = FormSingkat::create([
                'buku_tamu_kebutuhan_layanan_id' => $request->buku_tamu_kebutuhan_layanan_id,
                'keterangan' => $request->keterangan,
                'created_by' => auth()->id(),
            ]);

            DB::table('buku_tamu_kebutuhan_layanan')
                ->where('id', $request->buku_tamu_kebutuhan_layanan_id)
                ->update(['is_filled' => true, 'updated_by' => auth()->id()]);

            DB::commit();

            return response()->json([
                'message' => 'Data Form Singkat berhasil disimpan.',
                'data' => $formSingkat
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Terjadi kesalahan saat menyimpan data',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            // Validasi input
            $rules = [
                'keterangan' => 'sometimes|string',
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json([
                    'message' => $validator->errors()->first(),
                    'errors' => $validator->errors(),
                ], 422);
            }

            // Cari data FormSingkat yang akan diperbarui
            $formSingkat = FormSingkat::findOrFail($id);
            $formSingkat->fill([
                'keterangan' => $request->keterangan,
                'updated_by' => auth()->id(),
            ]);
            $formSingkat->save();

            DB::commit();

            return response()->json([
                'message' => 'Data Form Singkat berhasil diperbarui.',
                'data' => $formSingkat
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Terjadi kesalahan saat memperbarui data',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $formSingkat = FormSingkat::findOrFail($id);

            return response()->json([
                'message' => 'Data Form Singkat berhasil diambil.',
                'data' => $formSingkat
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Data tidak ditemukan',
                'error' => $e->getMessage()
            ], 404);
        }
    }

    public function getFormSingkatByBukuTamu($bukuTamuId)
    {
        try {
            // Ambil data Form Singkat berdasarkan buku_tamu_id
            $formSingkat = DB::table('form_singkats')
                ->join('buku_tamu_kebutuhan_layanan', 'form_singkats.buku_tamu_kebutuhan_layanan_id', '=', 'buku_tamu_kebutuhan_layanan.id')
                ->where('buku_tamu_kebutuhan_layanan.buku_tamu_id', $bukuTamuId)
                ->select('form_singkats.id', 'form_singkats.keterangan', 'form_singkats.buku_tamu_kebutuhan_layanan_id')
                ->get();

            if ($formSingkat->isEmpty()) {
                return response()->json([
                    'status' => 'error',
                    'message' => "Data Form Singkat tidak ditemukan untuk buku_tamu_id: $bukuTamuId"
                ], 404);
            }

            // Format data response
            $data = $formSingkat->map(function ($formSingkat) {
                return [
                    'id' => $formSingkat->id,
                    'keterangan' => $formSingkat->keterangan,
                    'buku_tamu_kebutuhan_layanan_id' => $formSingkat->buku_tamu_kebutuhan_layanan_id,
                ];
            });

            return response()->json([
                'status' => 'success',
                'data' => $data
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to fetch Form Singkat details: ' . $e->getMessage()
            ], 500);
        }
    }
}
