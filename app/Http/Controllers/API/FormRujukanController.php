<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\form_rujukan;
use App\Models\FormRujukan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class FormRujukanController extends Controller
{
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            $rules = [
                'buku_tamu_kebutuhan_layanan_id' => 'required|exists:buku_tamu_kebutuhan_layanan,id',
                'tujuan_rujukan' => 'required|string',
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                DB::rollBack();
                return response()->json([
                    'message' => $validator->errors()->first(),
                    'errors' => $validator->errors(),
                ], 422);
            }

            $formRujukan = FormRujukan::create([
                'buku_tamu_kebutuhan_layanan_id' => $request->buku_tamu_kebutuhan_layanan_id,
                'tujuan_rujukan' => $request->tujuan_rujukan,
                'created_by' => auth()->id(),
            ]);

            // Update is_filled menjadi true pada tabel buku_tamu_kebutuhan_layanan
            DB::table('buku_tamu_kebutuhan_layanan')
                ->where('id', $request->buku_tamu_kebutuhan_layanan_id)
                ->update(['is_filled' => true, 'updated_by' => auth()->id()]);

            DB::commit();

            return response()->json([
                'message' => 'Data Form Rujukan berhasil disimpan.',
                'data' => $formRujukan
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

            $rules = [
                'tujuan_rujukan' => 'sometimes|string',
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json([
                    'message' => $validator->errors()->first(),
                    'errors' => $validator->errors(),
                ], 422);
            }

            $formRujukan = FormRujukan::findOrFail($id);
            $formRujukan->fill([
                'tujuan_rujukan' => $request->tujuan_rujukan,
                'updated_by' => auth()->id(),
            ]);
            $formRujukan->save();

            DB::commit();

            return response()->json([
                'message' => 'Data Form Singkat berhasil diperbarui.',
                'data' => $formRujukan
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
            $formRujukan = FormRujukan::findOrFail($id);

            return response()->json([
                'message' => 'Data Form Singkat berhasil diambil.',
                'data' => $formRujukan
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Data tidak ditemukan',
                'error' => $e->getMessage()
            ], 404);
        }
    }

    public function getFormRujukanByBukuTamu($bukuTamuId)
    {
        try {
            $formRujukan = DB::table('form_rujukans')
                ->join('buku_tamu_kebutuhan_layanan', 'form_rujukans.buku_tamu_kebutuhan_layanan_id', '=', 'buku_tamu_kebutuhan_layanan.id')
                ->where('buku_tamu_kebutuhan_layanan.buku_tamu_id', $bukuTamuId)
                ->select('form_rujukans.id', 'form_rujukans.tujuan_rujukan', 'form_rujukans.buku_tamu_kebutuhan_layanan_id')
                ->get();

            if ($formRujukan->isEmpty()) {
                return response()->json([
                    'status' => 'error',
                    'message' => "Data Form Singkat tidak ditemukan untuk buku_tamu_id: $bukuTamuId"
                ], 404);
            }

            $data = $formRujukan->map(function ($formRujukan) {
                return [
                    'id' => $formRujukan->id,
                    'tujuan_rujukan' => $formRujukan->tujuan_rujukan,
                    'buku_tamu_kebutuhan_layanan_id' => $formRujukan->buku_tamu_kebutuhan_layanan_id,
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
