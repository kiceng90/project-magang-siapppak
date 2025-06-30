<?php

namespace App\Http\Controllers\API;

use App\Exports\BukuTamuExport;
use App\Exports\LaporanBukuTamuExport;
use App\Exports\RekapBulananBukuTamuExport;
use App\Exports\RekapTahunanBukuTamuExport;
use App\Http\Controllers\Controller;
use App\Models\BukuTamu;
use App\Models\IdentifikasiKebutuhan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\File;
use Maatwebsite\Excel\Facades\Excel;
use PDF;
use PDFMerger;
use FPDF;

class BukuTamuController extends Controller
{
    public function cetakPdf($id)
    {
        try {
            $bukuTamu = BukuTamu::with(['identifikasiKebutuhan', 'mKebutuhanLayanan'])->find($id);

            if (!$bukuTamu) {
                return response()->json([
                    'status' => 'error',
                    'message' => "Data Buku Tamu tidak ditemukan untuk ID: $id"
                ], 404);
            }

            $identifikasiKebutuhan = $bukuTamu->identifikasiKebutuhan;
            $identifikasiTerbaru = $identifikasiKebutuhan->sortByDesc('created_at')->first();

            $data = [
                'bukuTamu' => $bukuTamu,
                'identifikasiKebutuhan' => $identifikasiKebutuhan, // Semua identifikasi kebutuhan
                'identifikasiTerbaru' => $identifikasiTerbaru, // Data identifikasi terbaru
                'tanggalSekarang' => Carbon::now()->locale('id')->isoFormat('DD MMMM YYYY')
            ];

            request()->request->add(['full_link' => false]);
            $pdf = PDF::loadView('pdf.cetakBukuTamu', $data);

            $folderPath = storage_path('app/public/cetak_buku_tamu/' . $id);

            if (!File::exists($folderPath)) {
                File::makeDirectory($folderPath, 0777, true, true);
            }

            $pdfPath = $folderPath . '/buku_tamu_' . $id . '.pdf';
            $pdf->save($pdfPath);

            $this->saveLog('Cetak PDF Buku Tamu', 'ID: ' . $id);

            return response()->download($pdfPath, 'buku_tamu_' . $id . '.pdf', [
                'Content-Type' => 'application/pdf',
            ]);
        } catch (\Exception $e) {
            $this->responseCode = 500;
            $this->responseMessage = 'Gagal mencetak PDF: ' . $e->getMessage();
            return response()->json($this->getResponse(), $this->responseCode);
        }
    }

    public function penerimaanPdf($id)
    {
        $id = intval($id);
        $bukuTamu = BukuTamu::findOrFail($id);

        if (!$bukuTamu) {
            $this->responseCode = 404;
            $this->responseMessage = 'Data buku tamu tidak ditemukan';
            return response()->json($this->getResponse(), $this->responseCode);
        }

        try {
            $data = [
                'bukuTamu' => $bukuTamu,
                'tanggalSekarang' => Carbon::now()->locale('id')->isoFormat('DD MMMM YYYY')
            ];

            request()->request->add(['full_link' => false]);
            $pdf = PDF::loadView('pdf.cetakPenerimaan', $data);

            // Gunakan folder hanya berdasarkan ID buku tamu
            $folderPath = storage_path('app/public/cetak_penerimaan/' . $id);

            if (!File::exists($folderPath)) {
                File::makeDirectory($folderPath, 0777, true, true);
            }

            // Simpan PDF berdasarkan ID buku tamu
            $pdfPath = $folderPath . '/cetak_penerimaan' . $id . '.pdf';
            $pdf->save($pdfPath);

            $this->saveLog('Cetak PDF Buku Tamu', 'ID: ' . $id);

            return response()->download($pdfPath, 'cetak_penerimaan' . $id . '.pdf', [
                'Content-Type' => 'application/pdf',
            ]);
        } catch (\Exception $e) {
            $this->responseCode = 500;
            $this->responseMessage = 'Gagal mencetak PDF: ' . $e->getMessage();
            return response()->json($this->getResponse(), $this->responseCode);
        }
    }

    public function identifikasiPdf($id)
    {
        try {
            $bukuTamu = BukuTamu::with(['identifikasiKebutuhan', 'mKebutuhanLayanan'])->find($id);

            if (!$bukuTamu) {
                return response()->json([
                    'status' => 'error',
                    'message' => "Data Buku Tamu tidak ditemukan untuk ID: $id"
                ], 404);
            }

            $identifikasiKebutuhan = $bukuTamu->identifikasiKebutuhan;

            if ($identifikasiKebutuhan->isEmpty()) {
                return response()->json([
                    'status' => 'error',
                    'message' => "Data Identifikasi Kebutuhan tidak ditemukan untuk buku_tamu_id: $id"
                ], 404);
            }

            $identifikasiTerbaru = $identifikasiKebutuhan->sortByDesc('created_at')->first();

            $data = [
                'bukuTamu' => $bukuTamu,
                'identifikasiKebutuhan' => $identifikasiKebutuhan, // Semua identifikasi kebutuhan
                'identifikasiTerbaru' => $identifikasiTerbaru, // Data identifikasi terbaru
                'tanggalSekarang' => Carbon::now()->locale('id')->isoFormat('DD MMMM YYYY')
            ];

            request()->request->add(['full_link' => false]);
            $pdf = PDF::loadView('pdf.cetakIdentifikasi', $data);

            // Simpan PDF dalam folder berdasarkan ID buku tamu
            $folderPath = storage_path("app/public/cetak_identifikasi/$id");
            if (!File::exists($folderPath)) {
                File::makeDirectory($folderPath, 0777, true, true);
            }

            $pdfPath = "$folderPath/cetak_identifikasi$id.pdf";
            $pdf->save($pdfPath);

            $this->saveLog('Cetak PDF Buku Tamu', 'ID: ' . $id);

            return response()->download($pdfPath, "cetak_identifikasi$id.pdf", [
                'Content-Type' => 'application/pdf',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal mencetak PDF: ' . $e->getMessage()
            ], 500);
        }
    }

    public function formPdf($id)
    {
        try {
            // Retrieve layanan data based on buku_tamu_kebutuhan_layanan.id
            $layanan = DB::table('buku_tamu_kebutuhan_layanan')
                ->join('m_kebutuhan_layanan', 'buku_tamu_kebutuhan_layanan.m_kebutuhan_layanan_id', '=', 'm_kebutuhan_layanan.id')
                ->leftJoin('buku_tamu', 'buku_tamu_kebutuhan_layanan.buku_tamu_id', '=', 'buku_tamu.id')
                ->leftJoin('form_singkats', 'buku_tamu_kebutuhan_layanan.id', '=', 'form_singkats.buku_tamu_kebutuhan_layanan_id')
                ->leftJoin('form_rujukans', 'buku_tamu_kebutuhan_layanan.id', '=', 'form_rujukans.buku_tamu_kebutuhan_layanan_id')
                ->leftJoin('form_telekonsultasis', 'buku_tamu_kebutuhan_layanan.id', '=', 'form_telekonsultasis.buku_tamu_kebutuhan_layanan_id')
                ->where('buku_tamu_kebutuhan_layanan.id', $id)
                ->select(
                    'buku_tamu.id as buku_tamu_id',
                    'buku_tamu.nomor_pendaftaran as nomor_pendaftaran',
                    'buku_tamu.created_at as tgl_penerimaan',
                    'buku_tamu.nama as nama',
                    'buku_tamu.nik as nik',
                    'buku_tamu.tempat_lahir as tempat_lahir',
                    'buku_tamu.tanggal_lahir as tanggal_lahir',
                    'buku_tamu.usia as usia',
                    'buku_tamu.agama as agama',
                    'buku_tamu.kewarganegaraan as kewarganegaraan',
                    'buku_tamu.status_perkawinan as status_perkawinan',
                    'buku_tamu.alamat_ktp as alamat_ktp',
                    'buku_tamu.rt_ktp as rt_ktp',
                    'buku_tamu.rw_ktp as rw_ktp',
                    'buku_tamu.kel_desa_ktp as kel_desa_ktp',
                    'buku_tamu.kecamatan_ktp as kecamatan_ktp',
                    'buku_tamu.kota_kabupaten_ktp as kota_kabupaten_ktp',
                    'buku_tamu.provinsi as provinsi',
                    'buku_tamu.disposisi as disposisi',
                    'buku_tamu_kebutuhan_layanan.id as kebutuhan_layanan_id',
                    'm_kebutuhan_layanan.id as layanan_id',
                    'm_kebutuhan_layanan.name',
                    'buku_tamu_kebutuhan_layanan.is_filled',
                    'form_singkats.id as singkat_id',
                    'form_singkats.keterangan as singkat_keterangan',
                    'form_rujukans.id as rujukan_id',
                    'form_rujukans.tujuan_rujukan as rujukan_tujuan',
                    'form_telekonsultasis.id as telekonsultasi_id',
                    'form_telekonsultasis.nomor_telepon as telekonsultasi_nomor',
                    'form_telekonsultasis.jadwal_konsultasi as telekonsultasi_jadwal',
                    'form_telekonsultasis.keluhan as telekonsultasi_keluhan'
                )
                ->first();

            if (!$layanan) {
                return response()->json([
                    'status' => 'error',
                    'message' => "Data Layanan tidak ditemukan untuk ID: $id"
                ], 404);
            }

            // Kirimkan kedua variabel: layanan dan bukuTamu
            $data = [
                'layanan' => $layanan,
                'bukuTamu' => (object)[
                    'id' => $layanan->buku_tamu_id,
                    'nomor_pendaftaran' => $layanan->nomor_pendaftaran,
                    'nama' => $layanan->nama,
                    'nik' => $layanan->nik,
                    'tempat_lahir' => $layanan->tempat_lahir,
                    'tanggal_lahir' => $layanan->tanggal_lahir,
                    'agama' => $layanan->agama,
                    'kewarganegaraan' => $layanan->kewarganegaraan,
                    'status_perkawinan' => $layanan->status_perkawinan,
                    'created_at' => $layanan->tgl_penerimaan
                ],
                'layananList' => [$layanan], // Tetap sediakan ini jika diperlukan
                'tanggalSekarang' => Carbon::now()->locale('id')->isoFormat('DD MMMM YYYY')
            ];

            request()->request->add(['full_link' => false]);
            $pdf = PDF::loadView('pdf.cetakForm', $data);

            // Get the buku_tamu_id to use for the folder structure
            $bukuTamuId = $layanan->buku_tamu_id;
            $folderPath = storage_path("app/public/cetak_form/$bukuTamuId");

            if (!File::exists($folderPath)) {
                File::makeDirectory($folderPath, 0777, true, true);
            }

            $pdfPath = "$folderPath/cetak_form_layanan_$id.pdf";
            $pdf->save($pdfPath);
            $this->saveLog('Cetak PDF Layanan', 'ID: ' . $id);

            return response()->download($pdfPath, "layanan_$id.pdf", [
                'Content-Type' => 'application/pdf',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal mencetak PDF: ' . $e->getMessage()
            ], 500);
        }
    }

    public function getJam($tanggal)
    {
        if (!$tanggal) return '';
        return Carbon::parse($tanggal)->locale('id')->isoFormat('HH.mm');
    }

    public function getHari($tanggal)
    {
        if (!$tanggal) return '';
        $hari = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        $date = Carbon::parse($tanggal);
        return $hari[$date->dayOfWeek];
    }

    public function getTanggal($tanggal)
    {
        if (!$tanggal) return '';
        return Carbon::parse($tanggal)->locale('id')->isoFormat('DD MMMM YYYY');
    }

    public function getLayananByKebutuhanLayanan($kebutuhanLayananId)
    {
        $layanan = DB::table('buku_tamu_kebutuhan_layanan')
            ->join('m_kebutuhan_layanan', 'buku_tamu_kebutuhan_layanan.m_kebutuhan_layanan_id', '=', 'm_kebutuhan_layanan.id')
            ->leftJoin('buku_tamu', 'buku_tamu_kebutuhan_layanan.buku_tamu_id', '=', 'buku_tamu.id')
            ->leftJoin('form_singkats', 'buku_tamu_kebutuhan_layanan.id', '=', 'form_singkats.buku_tamu_kebutuhan_layanan_id')
            ->leftJoin('form_rujukans', 'buku_tamu_kebutuhan_layanan.id', '=', 'form_rujukans.buku_tamu_kebutuhan_layanan_id')
            ->leftJoin('form_telekonsultasis', 'buku_tamu_kebutuhan_layanan.id', '=', 'form_telekonsultasis.buku_tamu_kebutuhan_layanan_id')
            ->where('buku_tamu_kebutuhan_layanan.id', $kebutuhanLayananId)
            ->select(
                'buku_tamu.id as buku_tamu_id',
                'buku_tamu.nomor_pendaftaran as nomor_pendaftaran',
                'buku_tamu.created_at as tgl_penerimaan',
                'buku_tamu.nama as nama',
                'buku_tamu.nik as nik',
                'buku_tamu.tempat_lahir as tempat_lahir',
                'buku_tamu.tanggal_lahir as tanggal_lahir',
                'buku_tamu.agama as agama',
                'buku_tamu.kewarganegaraan as kewarganegaraan',
                'buku_tamu.status_perkawinan as status_perkawinan',
                'buku_tamu.alamat_ktp as alamat_ktp',
                'buku_tamu.rt_ktp as rt_ktp',
                'buku_tamu.rw_ktp as rw_ktp',
                'buku_tamu.kel_desa_ktp as kel_desa_ktp',
                'buku_tamu.kecamatan_ktp as kecamatan_ktp',
                'buku_tamu.kota_kabupaten_ktp as kota_kabupaten_ktp',
                'buku_tamu.provinsi as provinsi',
                'buku_tamu_kebutuhan_layanan.id as kebutuhan_layanan_id',
                'm_kebutuhan_layanan.id as layanan_id',
                'm_kebutuhan_layanan.name',
                'buku_tamu_kebutuhan_layanan.is_filled',
                'form_singkats.id as singkat_id',
                'form_singkats.keterangan as singkat_keterangan',
                'form_rujukans.id as rujukan_id',
                'form_rujukans.tujuan_rujukan as rujukan_tujuan',
                'form_telekonsultasis.id as telekonsultasi_id',
                'form_telekonsultasis.nomor_telepon as telekonsultasi_nomor',
                'form_telekonsultasis.jadwal_konsultasi as telekonsultasi_jadwal',
                'form_telekonsultasis.keluhan as telekonsultasi_keluhan'
            )
            ->first();

        return response()->json($layanan);
    }

    public function getLayananByBukuTamu($bukuTamuId)
    {
        $layanan = DB::table('buku_tamu_kebutuhan_layanan')
            ->join('m_kebutuhan_layanan', 'buku_tamu_kebutuhan_layanan.m_kebutuhan_layanan_id', '=', 'm_kebutuhan_layanan.id')
            ->leftJoin('form_singkats', 'buku_tamu_kebutuhan_layanan.id', '=', 'form_singkats.buku_tamu_kebutuhan_layanan_id')
            ->leftJoin('form_rujukans', 'buku_tamu_kebutuhan_layanan.id', '=', 'form_rujukans.buku_tamu_kebutuhan_layanan_id')
            ->leftJoin('form_telekonsultasis', 'buku_tamu_kebutuhan_layanan.id', '=', 'form_telekonsultasis.buku_tamu_kebutuhan_layanan_id')
            ->where('buku_tamu_kebutuhan_layanan.buku_tamu_id', $bukuTamuId)
            ->select(
                'buku_tamu_kebutuhan_layanan.id as kebutuhan_layanan_id',
                'm_kebutuhan_layanan.id as layanan_id',
                'm_kebutuhan_layanan.name',
                'buku_tamu_kebutuhan_layanan.is_filled',
                // Tambahan data dari form
                'form_singkats.id as singkat_id',
                'form_singkats.keterangan as singkat_keterangan',
                'form_rujukans.id as rujukan_id',
                'form_rujukans.tujuan_rujukan as rujukan_tujuan',
                'form_telekonsultasis.id as telekonsultasi_id',
                'form_telekonsultasis.nomor_telepon as telekonsultasi_nomor',
                'form_telekonsultasis.jadwal_konsultasi as telekonsultasi_jadwal',
                'form_telekonsultasis.keluhan as telekonsultasi_keluhan'
            )
            ->get();

        return response()->json($layanan);
    }

    public function index(Request $request)
    {
        try {
            $limit = $request->limit ? intval($request->limit) : 10;
            $order = $request->order ? $request->order : 'DESC';
            $sortby = $request->sortby ? $request->sortby : 'id';

            $bukuTamu = BukuTamu::with('MkebutuhanLayanan')
                ->select('buku_tamu.*', DB::raw("
                CASE 
                    WHEN NOT EXISTS (
                        SELECT 1 FROM buku_tamu_kebutuhan_layanan 
                        WHERE buku_tamu_kebutuhan_layanan.buku_tamu_id = buku_tamu.id
                        AND is_filled = false
                    ) THEN 'terkonfirmasi'
                    ELSE 'identifikasi'
                END AS status
            "))
                ->when($request->filled('search'), function ($query) use ($request) {
                    $search = strtolower($request->search);
                    $query->where(function ($q) use ($search) {
                        $q->where(DB::raw('lower(nama)'), 'like', '%' . $search . '%')
                            ->orWhere(DB::raw('lower(nik)'), 'like', '%' . $search . '%');
                    });
                })
                ->when($request->filled('status'), function ($query) use ($request) {
                    if ($request->status == 'terkonfirmasi') {
                        $query->whereNotExists(function ($subquery) {
                            $subquery->select(DB::raw(1))
                                ->from('buku_tamu_kebutuhan_layanan')
                                ->whereRaw('buku_tamu_kebutuhan_layanan.buku_tamu_id = buku_tamu.id')
                                ->where('is_filled', false);
                        });
                    } elseif ($request->status == 'identifikasi') {
                        $query->whereExists(function ($subquery) {
                            $subquery->select(DB::raw(1))
                                ->from('buku_tamu_kebutuhan_layanan')
                                ->whereRaw('buku_tamu_kebutuhan_layanan.buku_tamu_id = buku_tamu.id')
                                ->where('is_filled', false);
                        });
                    }
                })
                ->when($request->filled('start_date') && $request->filled('end_date'), function ($query) use ($request) {
                    $query->whereBetween('created_at', [$request->start_date, $request->end_date]);
                })
                ->orderBy($sortby, $order)
                ->paginate($limit);

            $this->saveLog($bukuTamu);

            return response()->json($bukuTamu);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function rekapTahunan(Request $request)
    {
        return Excel::download(new RekapTahunanBukuTamuExport($request->id_layanan, $request->tahun_awal, $request->tahun_akhir), 'rekap_tahunan_buku_tamu.xlsx');
    }

    public function rekapBulanan(Request $request)
    {
        return Excel::download(new RekapBulananBukuTamuExport($request->id_layanan, $request->bulan_awal, $request->bulan_akhir), 'rekap_bulanan_buku_tamu.xlsx');
    }

    public function laporanPuspaga(Request $req)
    {
        ini_set('max_execution_time', 600);

        $rules = [
            'type' => 'required|in:laporanPuspaga',
            'periode' => 'nullable|in:1,2,3,4',
            'start_date' => 'nullable|date_format:Y-m-d H:i:s|required_if:periode,4',
            'end_date' => 'nullable|date_format:Y-m-d H:i:s|required_if:periode,4',
            'id_layanan' => 'nullable|integer|exists:m_kebutuhan_layanan,id', // Ubah dari kebutuhan_layanan_id menjadi id_layanan
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

        $query = BukuTamu::with(['mKebutuhanLayanan']);

        switch ($req->periode) {
            case 1:
                $start_date = Carbon::now()->startOfMonth()->format('Y-m-d H:i:s');
                $end_date = Carbon::now()->endOfMonth()->format('Y-m-d H:i:s');
                $query->whereBetween('created_at', [$start_date, $end_date]);
                break;

            case 2:
                $start_date = Carbon::now()->subMonths(2)->startOfMonth()->format('Y-m-d H:i:s');
                $end_date = Carbon::now()->endOfMonth()->format('Y-m-d H:i:s');
                $query->whereBetween('created_at', [$start_date, $end_date]);
                break;

            case 3:
                $start_date = Carbon::now()->startOfYear()->format('Y-m-d H:i:s');
                $end_date = Carbon::now()->endOfYear()->format('Y-m-d H:i:s');
                $query->whereBetween('created_at', [$start_date, $end_date]);
                break;

            case 4:
                $start_date = $req->start_date
                    ? Carbon::parse($req->start_date)->format('Y-m-d H:i:s')
                    : Carbon::now()->format('Y-m-d H:i:s');
                $end_date = $req->end_date
                    ? Carbon::parse($req->end_date)->format('Y-m-d H:i:s')
                    : Carbon::now()->format('Y-m-d H:i:s');
                $query->whereBetween('created_at', [$start_date, $end_date]);
                break;

            default:
                break;
        }

        if ($req->id_layanan) {
            $query->whereHas('mKebutuhanLayanan', function ($q) use ($req) {
                $q->where('m_kebutuhan_layanan_id', $req->id_layanan);
            });
        }

        if ($req->search) {
            $query->where(function ($q) use ($req) {
                $q->where('nama', 'LIKE', '%' . $req->search . '%')
                    ->orWhere('nik', 'LIKE', '%' . $req->search . '%')
                    ->orWhere('alamat_ktp', 'LIKE', '%' . $req->search . '%')
                    ->orWhere('kecamatan_ktp', 'LIKE', '%' . $req->search . '%')
                    ->orWhere('kel_desa_ktp', 'LIKE', '%' . $req->search . '%');
            });
        }

        $data = $query->orderBy('created_at', 'DESC')->get();

        if ($req->is_download) {
            return Excel::download(new LaporanBukuTamuExport(
                $req->id_layanan,
                $req->search,
                $req->periode,
                $req->start_date,
                $req->end_date
            ), 'LaporanBukuTamu_' . date('Y-m-d') . '.xlsx');
        }

        return response()->json([
            'code' => 200,
            'message' => 'Data berhasil diambil',
            'data' => $data,
        ], 200);
    }

    public function export()
    {
        try {
            return Excel::download(new BukuTamuExport, 'Buku_Tamu.xlsx');
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Terjadi kesalahan saat mengekspor data',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            $rules = [
                'ktp_id' => 'string|',
                'nik' => 'required|string|',
                'nama' => 'required|string',
                'tempat_lahir' => 'required|string',
                'tanggal_lahir' => 'required|date',
                'usia' => 'nullable|integer|min:0',
                'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
                'alamat_ktp' => 'required|string',
                'rt_ktp' => 'required|string',
                'rw_ktp' => 'required|string',
                'kel_desa_ktp' => 'required|string',
                'kecamatan_ktp' => 'required|string',
                'kota_kabupaten_ktp' => 'required|string',
                'provinsi' => 'required|string',
                'agama' => 'required|string',
                'status_perkawinan' => 'required|string',
                'kewarganegaraan' => 'required|string',
                'm_kebutuhan_layanan_id' => 'required|array',
                'm_kebutuhan_layanan_id.*' => 'exists:m_kebutuhan_layanan,id',
                'foto_ktp' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                DB::rollBack();
                return response()->json([
                    'message' => $validator->errors()->first(),
                    'errors' => $validator->errors(),
                ], 422);
            }

            $usia = Carbon::parse($request->tanggal_lahir)->age;
            $disposisi = stripos($request->kota_kabupaten_ktp, 'surabaya') !== false;

            $bukuTamu = BukuTamu::create([
                'ktp_id' => $request->ktp_id,
                'nik' => $request->nik,
                'nama' => $request->nama,
                'tempat_lahir' => $request->tempat_lahir,
                'tanggal_lahir' => $request->tanggal_lahir,
                'usia' => $usia,
                'jenis_kelamin' => $request->jenis_kelamin,
                'alamat_ktp' => $request->alamat_ktp,
                'rt_ktp' => $request->rt_ktp,
                'rw_ktp' => $request->rw_ktp,
                'kel_desa_ktp' => $request->kel_desa_ktp,
                'kecamatan_ktp' => $request->kecamatan_ktp,
                'kota_kabupaten_ktp' => $request->kota_kabupaten_ktp,
                'provinsi' => $request->provinsi,
                'agama' => $request->agama,
                'status_perkawinan' => $request->status_perkawinan,
                'kewarganegaraan' => $request->kewarganegaraan,
                'disposisi' => $disposisi,
            ]);

            if ($request->hasFile('foto_ktp')) {
                $file = $request->foto_ktp;
                $changedName = time() . random_int(100, 999) . '.' . $file->getClientOriginalExtension();
                $is_image = substr($file->getClientMimeType(), 0, 5) == 'image' ?? false;

                $path = 'public/buku/' . $bukuTamu->id . '/foto_ktp';
                $file->storeAs($path, $changedName);

                $canvas = Image::canvas(600, 600, '#ffffff');
                $img = Image::make($file->getRealPath());
                $height = $img->height();
                $width = $img->width();
                $img->resize($width > $height ? 600 : null, $height >= $width ? 600 : null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
                $canvas->insert($img, 'center');
                $canvas->save(storage_path('app/' . $path . '/' . $changedName));

                $bukuTamu->foto_ktp = $path . '/' . $changedName;
            }


            $bukuTamu->MKebutuhanLayanan()->sync($request->m_kebutuhan_layanan_id);

            $dayMonth = date('dm', strtotime($bukuTamu->created_at));
            $tahun = date('Y', strtotime($bukuTamu->created_at));
            $bukuTamu->nomor_pendaftaran = "PUSPAGA/{$dayMonth}/{$bukuTamu->id}/{$tahun}";
            $bukuTamu->save();

            DB::commit();

            return response()->json([
                'message' => 'Data pengunjung berhasil disimpan.',
                'data' => $bukuTamu
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
                'nik' => 'sometimes|string',
                'nama' => 'sometimes|string',
                'tempat_lahir' => 'sometimes|string',
                'tanggal_lahir' => 'sometimes|date',
                'jenis_kelamin' => 'sometimes|in:Laki-laki,Perempuan',
                'alamat_ktp' => 'sometimes|string',
                'rt_ktp' => 'sometimes|string',
                'rw_ktp' => 'sometimes|string',
                'kel_desa_ktp' => 'sometimes|string',
                'kecamatan_ktp' => 'sometimes|string',
                'kota_kabupaten_ktp' => 'sometimes|string',
                'provinsi' => 'sometimes|string',
                'agama' => 'sometimes|string',
                'status_perkawinan' => 'sometimes|string',
                'kewarganegaraan' => 'sometimes|string',
                'm_kebutuhan_layanan_id' => 'sometimes|array',
                'm_kebutuhan_layanan_id.*' => 'exists:m_kebutuhan_layanan,id',
                'foto_ktp' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            ];


            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                DB::rollBack();
                return response()->json([
                    'message' => $validator->errors()->first(),
                    'errors' => $validator->errors(),
                ], 422);
            }

            $bukuTamu = BukuTamu::findOrFail($id);

            if ($request->has('tanggal_lahir')) {
                $usia = Carbon::parse($request->tanggal_lahir)->age;
                $request->merge(['usia' => $usia]);
            }

            $data = $request->only([
                'nik',
                'nama',
                'tempat_lahir',
                'tanggal_lahir',
                'jenis_kelamin',
                'alamat_ktp',
                'rt_ktp',
                'rw_ktp',
                'kel_desa_ktp',
                'kecamatan_ktp',
                'kota_kabupaten_ktp',
                'provinsi',
                'agama',
                'status_perkawinan',
                'kewarganegaraan',
            ]);

            if ($request->has('tanggal_lahir')) {
                $data['usia'] = $request->usia;
            }

            // Menambahkan logika disposisi jika kota/kabupaten diperbarui
            if ($request->has('kota_kabupaten_ktp')) {
                $data['disposisi'] = stripos($request->kota_kabupaten_ktp, 'surabaya') !== false;
            }

            $bukuTamu->update($data);

            if ($request->hasFile('foto_ktp')) {
                if ($bukuTamu->foto_ktp) {
                    Storage::delete($bukuTamu->foto_ktp);
                }

                $file = $request->foto_ktp;
                $changedName = time() . random_int(100, 999) . '.' . $file->getClientOriginalExtension();
                $is_image = substr($file->getClientMimeType(), 0, 5) == 'image' ?? false;

                $path = 'public/buku/' . $bukuTamu->id . '/foto_ktp';
                $file->storeAs($path, $changedName);

                $canvas = Image::canvas(600, 600, '#ffffff');
                $img = Image::make($file->getRealPath());
                $height = $img->height();
                $width = $img->width();
                $img->resize($width > $height ? 600 : null, $height >= $width ? 600 : null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
                $canvas->insert($img, 'center');
                $canvas->save(storage_path('app/' . $path . '/' . $changedName));

                $bukuTamu->foto_ktp = $path . '/' . $changedName;
                $bukuTamu->save();
            }

            // Perbarui relasi many-to-many dengan kebutuhan layanan
            if ($request->has('m_kebutuhan_layanan_id')) {
                $bukuTamu->MKebutuhanLayanan()->sync($request->m_kebutuhan_layanan_id);
            }

            $dayMonth = date('dm', strtotime($bukuTamu->created_at)); // Contoh: 2103 kalau created_at = 2025-03-21
            $tahun = date('Y', strtotime($bukuTamu->created_at));
            $bukuTamu->nomor_pendaftaran = "PUSPAGA/{$dayMonth}/{$bukuTamu->id}/{$tahun}";
            $bukuTamu->save();

            DB::commit();

            return response()->json([
                'message' => 'Data pengunjung berhasil diperbarui.',
                'data' => $bukuTamu
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
            $bukuTamu = BukuTamu::with('MKebutuhanLayanan')->findOrFail($id);

            $foto_ktp_url = null;
            if ($bukuTamu->foto_ktp) {
                $foto_ktp_url = str_replace('public/', '', $bukuTamu->foto_ktp);
            }

            $m_kebutuhan_layanan_id = $bukuTamu->MKebutuhanLayanan->pluck('id')->toArray();

            $data = [
                'tgl_penerimaan' => $bukuTamu->created_at,
                'nomor_pendaftaran' => $bukuTamu->nomor_pendaftaran,
                'nama' => $bukuTamu->nama,
                'nik' => $bukuTamu->nik,
                'tempat_lahir' => $bukuTamu->tempat_lahir,
                'tanggal_lahir' => $bukuTamu->tanggal_lahir,
                'usia' => $bukuTamu->usia,
                'alamat_ktp' => $bukuTamu->alamat_ktp,
                'rt_ktp' => $bukuTamu->rt_ktp,
                'rw_ktp' => $bukuTamu->rw_ktp,
                'kel_desa_ktp' => $bukuTamu->kel_desa_ktp,
                'kecamatan_ktp' => $bukuTamu->kecamatan_ktp,
                'kota_kabupaten_ktp' => $bukuTamu->kota_kabupaten_ktp,
                'provinsi' => $bukuTamu->provinsi,
                'agama' => $bukuTamu->agama,
                'status_perkawinan' => $bukuTamu->status_perkawinan,
                'kewarganegaraan' => $bukuTamu->kewarganegaraan,
                'jenis_kelamin' => $bukuTamu->jenis_kelamin,
                'disposisi' => $bukuTamu->disposisi,
                'm_kebutuhan_layanan_id' => $m_kebutuhan_layanan_id, // Sekarang ini berisi array ID
                'kebutuhan_layanan' => $bukuTamu->MKebutuhanLayanan, // Opsional: Kirim juga objek lengkap
                'foto_ktp_url' => $foto_ktp_url,
            ];

            return response()->json([
                'status' => 'success',
                'data' => $data
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to fetch BukuTamu details: ' . $e->getMessage()
            ], 500);
        }
    }
}
