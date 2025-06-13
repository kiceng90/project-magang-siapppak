<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\AbsensiKegiatan;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\AbsensiKegiatanExport; // Pastikan export class ini ada

class AbsensiKegiatanController extends Controller
{
    protected $responseCode = 200;
    protected $responseMessage = 'Success';
    protected $responseData = null;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $limit = $request->limit ? intval($request->limit) : 10;
            $order = $request->order ? $request->order : 'DESC';
            $sortby = $request->sortby ? $request->sortby : 'id';

            $query = AbsensiKegiatan::with(['kegiatan']);
            if ($request->filled('search')) {
                $query->where(DB::raw('lower(name)'), 'like', '%' . strtolower($request->search) . '%');
            }

            $data = $query->orderBy($sortby, $order)->paginate($limit);

            $this->responseData = $data;
            return response()->json($this->getResponse(), $this->responseCode);
        } catch (\Exception $e) {
            $this->responseCode = 500;
            $this->responseMessage = $e->getMessage();
            return response()->json($this->getResponse(), $this->responseCode);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            $rules = [
                'id_kegiatan' => 'required|exists:tambah_kegiatans,id',
                'name' => 'required|string|max:255',
                'nik' => 'required|digits:16|unique:absensi_kegiatans,nik',
                'alamat_email' => 'nullable|email',
                'alamat' => 'required|string',
                'kecamatan_ktp' => 'required|string',
                'kelurahan_ktp' => 'required|string',
                'tanggal_lahir' => 'required|date',
                'nomor_hp' => 'required|string',
                'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
                'pendidikan_terakhir' => 'required|string',
                'instansi' => 'required|string',
                'alamat_domisili' => 'required|string',
                'kecamatan_domisili' => 'required|string',
                'kelurahan_domisili' => 'required|string',
                'unggah_ktp' => 'nullable|string',
                'unggah_foto' => 'nullable|string',
                'tanda_tangan' => 'nullable|string',
                'rating_kegiatan' => 'nullable|integer|min:1|max:5',
                'kritik_saran' => 'nullable|string',
                'is_active' => 'boolean'
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $this->responseCode = 422;
                $this->responseMessage = $validator->errors()->first();
                $this->responseData = $validator->errors();
                return response()->json($this->getResponse(), $this->responseCode);
            }

            $absensi = AbsensiKegiatan::create($request->all());

            DB::commit();
            $this->responseCode = 201;
            $this->responseData = $absensi;
            $this->responseMessage = 'Data berhasil ditambahkan';
            return response()->json($this->getResponse(), $this->responseCode);
        } catch (\Exception $e) {
            DB::rollback();
            $this->responseCode = 500;
            $this->responseMessage = $e->getMessage();
            return response()->json($this->getResponse(), $this->responseCode);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $id = intval($id);
            $absensi = AbsensiKegiatan::with(['kegiatan'])->find($id);
            if (!$absensi) {
                $this->responseCode = 404;
                $this->responseMessage = 'Data tidak ditemukan';
                return response()->json($this->getResponse(), $this->responseCode);
            }

            $this->responseData = $absensi;
            return response()->json($this->getResponse(), $this->responseCode);
        } catch (\Exception $e) {
            $this->responseCode = 500;
            $this->responseMessage = $e->getMessage();
            return response()->json($this->getResponse(), $this->responseCode);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            $id = intval($id);
            $absensi = AbsensiKegiatan::find($id);
            if (!$absensi) {
                $this->responseCode = 404;
                $this->responseMessage = 'Data tidak ditemukan';
                return response()->json($this->getResponse(), $this->responseCode);
            }

            $rules = [
                'name' => 'sometimes|required|string|max:255',
                'nik' => "sometimes|required|digits:16|unique:absensi_kegiatans,nik,$id",
                'alamat_email' => 'nullable|email',
                'alamat' => 'sometimes|required|string',
                'kecamatan_ktp' => 'sometimes|required|string',
                'kelurahan_ktp' => 'sometimes|required|string',
                'tanggal_lahir' => 'sometimes|required|date',
                'nomor_hp' => 'sometimes|required|string',
                'jenis_kelamin' => 'sometimes|required|in:Laki-laki,Perempuan',
                'pendidikan_terakhir' => 'sometimes|required|string',
                'instansi' => 'sometimes|required|string',
                'alamat_domisili' => 'sometimes|required|string',
                'kecamatan_domisili' => 'sometimes|required|string',
                'kelurahan_domisili' => 'sometimes|required|string',
                'is_active' => 'boolean'
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $this->responseCode = 422;
                $this->responseMessage = $validator->errors()->first();
                $this->responseData = $validator->errors();
                return response()->json($this->getResponse(), $this->responseCode);
            }

            $absensi->update($request->all());

            DB::commit();
            $this->responseCode = 200;
            $this->responseData = $absensi;
            $this->responseMessage = 'Berhasil perbarui absensi kegiatan';
            return response()->json($this->getResponse(), $this->responseCode);
        } catch (\Exception $e) {
            DB::rollback();
            $this->responseCode = 500;
            $this->responseMessage = $e->getMessage();
            return response()->json($this->getResponse(), $this->responseCode);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            $id = intval($id);
            $absensi = AbsensiKegiatan::find($id);
            if (!$absensi) {
                $this->responseCode = 404;
                $this->responseMessage = 'Data tidak ditemukan';
                return response()->json($this->getResponse(), $this->responseCode);
            }

            $absensi->delete();

            DB::commit();
            $this->responseCode = 200;
            $this->responseMessage = 'Berhasil menghapus data';
            $this->responseData = $absensi;
            return response()->json($this->getResponse(), $this->responseCode);
        } catch (\Exception $e) {
            DB::rollback();
            $this->responseCode = 500;
            $this->responseMessage = $e->getMessage();
            return response()->json($this->getResponse(), $this->responseCode);
        }
    }

    /**
     * Switch status aktif/non-aktif.
     */
    public function switchStatus($id)
    {
        try {
            $id = intval($id);
            $absensi = AbsensiKegiatan::find($id);
            if (!$absensi) {
                $this->responseCode = 404;
                $this->responseMessage = 'Data tidak ditemukan';
                return response()->json($this->getResponse(), $this->responseCode);
            }

            DB::beginTransaction();

            $absensi->update([
                'is_active' => !$absensi->is_active
            ]);

            $this->responseCode = 200;
            $this->responseMessage = boolval($absensi->is_active) ? 'Absensi telah diaktifkan' : 'Absensi telah dinonaktifkan';
            $this->responseData = $absensi;

            DB::commit();
            return response()->json($this->getResponse(), $this->responseCode);
        } catch (\Exception $e) {
            DB::rollback();
            $this->responseCode = 500;
            $this->responseMessage = $e->getMessage();
            return response()->json($this->getResponse(), $this->responseCode);
        }
    }

    /**
     * Get active data for dropdowns with limit.
     */
    public function lists(Request $request)
    {
        try {
            $limit = $request->limit ? intval($request->limit) : 10;

            $absensi = AbsensiKegiatan::select('*');
            if ($request->filled('search')) {
                $absensi->where(DB::raw('lower(name)'), 'like', '%' . strtolower($request->search) . '%');
            }
            $absensi = $absensi->where('is_active', true)->take($limit)->orderBy('name', 'ASC')->get();

            $this->responseCode = 200;
            $this->responseData = $absensi;
            return response()->json($this->getResponse(), $this->responseCode);
        } catch (\Exception $e) {
            $this->responseCode = 500;
            $this->responseMessage = $e->getMessage();
            return response()->json($this->getResponse(), $this->responseCode);
        }
    }

    /**
     * Get all active data for public use.
     */
    public function listsPublic(Request $request)
    {
        try {
            $absensi = AbsensiKegiatan::select('*');
            $absensi = $absensi->where('is_active', true)->orderBy('name', 'ASC')->get();

            $this->responseCode = 200;
            $this->responseData = $absensi;
            return response()->json($this->getResponse(), $this->responseCode);
        } catch (\Exception $e) {
            $this->responseCode = 500;
            $this->responseMessage = $e->getMessage();
            return response()->json($this->getResponse(), $this->responseCode);
        }
    }

    /**
     * Export data to Excel.
     */
    /* public function export(Request $request)
    {
        return Excel::download(new AbsensiKegiatanExport, 'Absensi_Kegiatan.xlsx');
    } */

    /**
     * Helper method to generate standardized response.
     */
    /* protected function getResponse()
    {
        return [
            'code' => $this->responseCode,
            'message' => $this->responseMessage,
            'data' => $this->responseData,
        ];
    } */
}