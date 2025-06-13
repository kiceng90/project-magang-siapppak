<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\IdentifikasiKebutuhan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class IdentifikasiKebutuhanController extends Controller
{
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            $rules = [
                'buku_tamu_id' => 'required|exists:buku_tamu,id|unique:identifikasi_kebutuhans,buku_tamu_id',
                'dpa' => 'required|boolean',
                'hasil_assesment' => 'required|string',
                'disposisi_pimpinan' => 'required|boolean',
                'narasi' => 'nullable|string'
            ];

            if ($request->dpa == 1) {
                $rules['narasi'] = 'required|string';
            }

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                DB::rollBack();
                return response()->json([
                    'message' => $validator->errors()->first(),
                    'errors' => $validator->errors(),
                ], 422);
            }

            $identifikasi = IdentifikasiKebutuhan::create([
                'buku_tamu_id' => $request->buku_tamu_id,
                'dpa' => $request->dpa,
                'hasil_assesment' => $request->hasil_assesment,
                'disposisi_pimpinan' => $request->disposisi_pimpinan,
                'narasi' => $request->dpa == 1 ? $request->narasi : null,
            ]);

            DB::commit();

            return response()->json([
                'message' => 'Data Identifikasi Kebutuhan berhasil disimpan.',
                'data' => $identifikasi
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

            $identifikasi = IdentifikasiKebutuhan::findOrFail($id);

            $rules = [
                'dpa' => 'required|boolean',
                'hasil_assesment' => 'required|string',
                'disposisi_pimpinan' => 'required|boolean',
                'narasi' => 'nullable|string'
            ];

            if ($request->dpa == 1) {
                $rules['narasi'] = 'required|string';
            }

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                DB::rollBack();
                return response()->json([
                    'message' => $validator->errors()->first(),
                    'errors' => $validator->errors(),
                ], 422);
            }

            $identifikasi->update([
                'dpa' => $request->dpa,
                'hasil_assesment' => $request->hasil_assesment,
                'disposisi_pimpinan' => $request->disposisi_pimpinan,
                'narasi' => $request->dpa == 1 ? $request->narasi : null,
            ]);

            DB::commit();

            return response()->json([
                'message' => 'Data Identifikasi Kebutuhan berhasil diperbarui.',
                'data' => $identifikasi
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
            $identifikasi = IdentifikasiKebutuhan::find($id);

            if (!$identifikasi) {
                return response()->json([
                    'message' => 'Data Identifikasi Kebutuhan tidak ditemukan.'
                ], 404);
            }

            $data = [
                'id' => $identifikasi->id,
                'tgl_identifikasi' => $identifikasi->created_at,
                'hasil_assesment' => $identifikasi->hasil_assesment,
                'dpa' => $identifikasi->dpa,
                'disposisi_pimpinan' => $identifikasi->disposisi_pimpinan,
                'narasi' => $identifikasi->narasi,
            ];

            return response()->json([
                'message' => 'Data ditemukan.',
                'data' => $data
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Terjadi kesalahan saat mengambil data',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function showByBukuTamuId($bukuTamuId)
    {
        try {
            $identifikasiKebutuhan = IdentifikasiKebutuhan::with('bukuTamu.MKebutuhanLayanan')
                ->where('buku_tamu_id', $bukuTamuId)
                ->first();
            if (!$identifikasiKebutuhan) {
                return response()->json([
                    'status' => 'error',
                    'message' => "Data Identifikasi Kebutuhan tidak ditemukan untuk buku_tamu_id: $bukuTamuId"
                ], 404);
            }

            $bukuTamu = $identifikasiKebutuhan->bukuTamu;
            $data = [
                'buku_tamu_id' => $bukuTamu->id,
                'id' => $identifikasiKebutuhan->id,
                'tgl_identifikasi' => $identifikasiKebutuhan->created_at,
                'hasil_assesment' => $identifikasiKebutuhan->hasil_assesment,
                'dpa' => $identifikasiKebutuhan->dpa,
                'narasi' => $identifikasiKebutuhan->narasi,
                'disposisi_pimpinan' => $identifikasiKebutuhan->disposisi_pimpinan,
            ];

            return response()->json([
                'status' => 'success',
                'data' => $data
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to fetch IdentifikasiKebutuhan details: ' . $e->getMessage()
            ], 500);
        }
    }
}
