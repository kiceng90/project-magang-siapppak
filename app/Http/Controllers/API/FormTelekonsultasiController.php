<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\form_telekonsultasi;
use App\Models\FormTelekonsultasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class FormTelekonsultasiController extends Controller
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
                'nomor_telepon' => 'required|string',
                'jadwal_konsultasi' => 'required|date_format:Y-m-d H:i:s',
                'keluhan' => 'required|string',
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                DB::rollBack();
                return response()->json([
                    'message' => $validator->errors()->first(),
                    'errors' => $validator->errors(),
                ], 422);
            }

            $formTelekonsultasi = FormTelekonsultasi::create([
                'buku_tamu_kebutuhan_layanan_id' => $request->buku_tamu_kebutuhan_layanan_id,
                'nomor_telepon' => $request->nomor_telepon,
                'jadwal_konsultasi' => $request->jadwal_konsultasi,
                'keluhan' => $request->keluhan,
                'created_by' => auth()->id(), // Assuming you're using authentication
            ]);

            // Update is_filled menjadi true pada tabel buku_tamu_kebutuhan_layanan
            DB::table('buku_tamu_kebutuhan_layanan')
                ->where('id', $request->buku_tamu_kebutuhan_layanan_id)
                ->update(['is_filled' => true, 'updated_by' => auth()->id()]);

            DB::commit();

            return response()->json([
                'message' => 'Data Form Telekonsultasi berhasil disimpan.',
                'data' => $formTelekonsultasi
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
                'nomor_telepon' => 'sometimes|string',
                'jadwal_konsultasi' => 'sometimes|date_format:Y-m-d H:i:s',
                'keluhan' => 'sometimes|string',
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                DB::rollBack();
                return response()->json([
                    'message' => $validator->errors()->first(),
                    'errors' => $validator->errors(),
                ], 422);
            }

            // Cari data yang akan diperbarui
            $formTelekonsultasi = FormTelekonsultasi::findOrFail($id);

            // Update data
            $formTelekonsultasi->update([
                'nomor_telepon' => $request->nomor_telepon,
                'jadwal_konsultasi' => $request->jadwal_konsultasi,
                'keluhan' => $request->keluhan,
                'updated_by' => auth()->id(),
            ]);

            DB::commit();

            return response()->json([
                'message' => 'Data Form Telekonsultasi berhasil diperbarui.',
                'data' => $formTelekonsultasi
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
            // Ambil data Form Telekonsultasi berdasarkan ID
            $formTelekonsultasi = FormTelekonsultasi::findOrFail($id);

            return response()->json([
                'message' => 'Data Form Telekonsultasi berhasil diambil.',
                'data' => $formTelekonsultasi
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Data tidak ditemukan',
                'error' => $e->getMessage()
            ], 404);
        }
    }

    public function getFormTelekonsultasiByBukuTamu($bukuTamuId)
    {
        try {
            // Ambil data Form Singkat berdasarkan buku_tamu_id
            $formTelekonsultasi = DB::table('form_telekonsultasis')
                ->join('buku_tamu_kebutuhan_layanan', 'form_telekonsultasis.buku_tamu_kebutuhan_layanan_id', '=', 'buku_tamu_kebutuhan_layanan.id')
                ->where('buku_tamu_kebutuhan_layanan.buku_tamu_id', $bukuTamuId)
                ->select('form_telekonsultasis.id', 'form_telekonsultasis.nomor_telepon', 'form_telekonsultasis.jadwal_konsultasi', 'form_telekonsultasis.keluhan', 'form_telekonsultasis.buku_tamu_kebutuhan_layanan_id')
                ->get();

            if ($formTelekonsultasi->isEmpty()) {
                return response()->json([
                    'status' => 'error',
                    'message' => "Data Form Singkat tidak ditemukan untuk buku_tamu_id: $bukuTamuId"
                ], 404);
            }

            // Format data response
            $data = $formTelekonsultasi->map(function ($formTelekonsultasi) {
                return [
                    'id' => $formTelekonsultasi->id,
                    'nomor_telepon' => $formTelekonsultasi->nomor_telepon,
                    'jadwal_konsultasi' => $formTelekonsultasi->jadwal_konsultasi,
                    'keluhan' => $formTelekonsultasi->keluhan,
                    'buku_tamu_kebutuhan_layanan_id' => $formTelekonsultasi->buku_tamu_kebutuhan_layanan_id,
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
