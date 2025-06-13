<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\MKegiatanPuspaga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class MKegiatanPuspagaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $limit = $request->limit ? intval($request->limit) : 10;
            $order = $request->order ?? 'DESC';
            $sortby = $request->sortby ?? 'id';

            $kegiatan = MKegiatanPuspaga::select('*');

            if ($request->filled('search')) {
                $kegiatan->where(DB::raw('lower(judul_kegiatan)'), 'like', '%' . strtolower($request->search) . '%');
            }

            $data = $kegiatan->orderBy($sortby, $order)->paginate($limit);

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
                'id_program_kegiatan' => 'required|exists:m_program_kegiatan,id',
                'id_jenis_kegiatan' => 'required|exists:m_jenis_kegiatan,id',
                'id_bentuk_kegiatan' => 'required|exists:m_bentuk_kegiatan,id',
                'tanggal_kegiatan' => 'required|date',
                'jam_kegiatan' => 'required|date_format:H:i',
                'jenis_kelas' => 'required|in:online,offline',
                'link_kelas' => 'nullable|required_if:jenis_kelas,online|string',
                'judul_kegiatan' => 'required|string|max:255',
                'sasaran_kegiatan' => 'required|string',
                'tempat_kegiatan' => 'nullable|required_if:jenis_kelas,offline|string',
                'narasumber' => 'required|string|max:255',
                'is_active' => 'boolean'
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                $this->responseCode = 422;
                $this->responseMessage = $validator->errors()->first();
                $this->responseData = $validator->errors();
                return response()->json($this->getResponse(), $this->responseCode);
            }

            $kegiatan = new MKegiatanPuspaga();
            $kegiatan->id_program_kegiatan = $request->id_program_kegiatan;
            $kegiatan->id_jenis_kegiatan = $request->id_jenis_kegiatan;
            $kegiatan->id_bentuk_kegiatan = $request->id_bentuk_kegiatan;
            $kegiatan->tanggal_kegiatan = $request->tanggal_kegiatan;
            $kegiatan->jam_kegiatan = $request->jam_kegiatan;
            $kegiatan->jenis_kelas = $request->jenis_kelas;
            $kegiatan->link_kelas = $request->link_kelas;
            $kegiatan->judul_kegiatan = $request->judul_kegiatan;
            $kegiatan->sasaran_kegiatan = $request->sasaran_kegiatan;
            $kegiatan->tempat_kegiatan = $request->tempat_kegiatan;
            $kegiatan->narasumber = $request->narasumber;
            $kegiatan->is_active = $request->is_active ?? true;
            $kegiatan->created_by = $request->created_by;
            $kegiatan->save();

            DB::commit();
            $this->responseData = $kegiatan;
            $this->responseMessage = 'Data kegiatan berhasil ditambahkan';
            return response()->json($this->getResponse(), 201);
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
            $kegiatan = MKegiatanPuspaga::find($id);

            if (!$kegiatan) {
                $this->responseCode = 404;
                $this->responseMessage = 'Data tidak ditemukan';
                return response()->json($this->getResponse(), $this->responseCode);
            }

            $this->responseData = $kegiatan;
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
            $kegiatan = MKegiatanPuspaga::find($id);

            if (!$kegiatan) {
                $this->responseCode = 404;
                $this->responseMessage = 'Data tidak ditemukan';
                return response()->json($this->getResponse(), $this->responseCode);
            }

            $rules = [
                'id_program_kegiatan' => 'sometimes|required|exists:m_program_kegiatan,id',
                'id_jenis_kegiatan' => 'sometimes|required|exists:m_jenis_kegiatan,id',
                'id_bentuk_kegiatan' => 'sometimes|required|exists:m_bentuk_kegiatan,id',
                'tanggal_kegiatan' => 'sometimes|required|date',
                'jam_kegiatan' => 'sometimes|required|date_format:H:i',
                'jenis_kelas' => 'sometimes|required|in:online,offline',
                'link_kelas' => 'nullable|required_if:jenis_kelas,online|string',
                'judul_kegiatan' => 'sometimes|required|string|max:255',
                'sasaran_kegiatan' => 'sometimes|required|string',
                'tempat_kegiatan' => 'nullable|required_if:jenis_kelas,offline|string',
                'narasumber' => 'sometimes|required|string|max:255',
                'is_active' => 'boolean'
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                $this->responseCode = 422;
                $this->responseMessage = $validator->errors()->first();
                $this->responseData = $validator->errors();
                return response()->json($this->getResponse(), $this->responseCode);
            }

            $kegiatan->id_program_kegiatan = $request->id_program_kegiatan ?? $kegiatan->id_program_kegiatan;
            $kegiatan->id_jenis_kegiatan = $request->id_jenis_kegiatan ?? $kegiatan->id_jenis_kegiatan;
            $kegiatan->id_bentuk_kegiatan = $request->id_bentuk_kegiatan ?? $kegiatan->id_bentuk_kegiatan;
            $kegiatan->tanggal_kegiatan = $request->tanggal_kegiatan ?? $kegiatan->tanggal_kegiatan;
            $kegiatan->jam_kegiatan = $request->jam_kegiatan ?? $kegiatan->jam_kegiatan;
            $kegiatan->jenis_kelas = $request->jenis_kelas ?? $kegiatan->jenis_kelas;
            $kegiatan->link_kelas = $request->link_kelas ?? $kegiatan->link_kelas;
            $kegiatan->judul_kegiatan = $request->judul_kegiatan ?? $kegiatan->judul_kegiatan;
            $kegiatan->sasaran_kegiatan = $request->sasaran_kegiatan ?? $kegiatan->sasaran_kegiatan;
            $kegiatan->tempat_kegiatan = $request->tempat_kegiatan ?? $kegiatan->tempat_kegiatan;
            $kegiatan->narasumber = $request->narasumber ?? $kegiatan->narasumber;
            $kegiatan->is_active = $request->is_active ?? $kegiatan->is_active;
            $kegiatan->updated_by = $request->updated_by;
            $kegiatan->save();

            DB::commit();
            $this->responseData = $kegiatan;
            $this->responseMessage = 'Data kegiatan berhasil diperbarui';
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
            $kegiatan = MKegiatanPuspaga::find($id);

            if (!$kegiatan) {
                $this->responseCode = 404;
                $this->responseMessage = 'Data tidak ditemukan';
                return response()->json($this->getResponse(), $this->responseCode);
            }

            $kegiatan->delete();

            $this->responseCode = 200;
            $this->responseMessage = 'Data kegiatan berhasil dihapus';
            $this->responseData = $kegiatan;
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
     * Switch status aktif/non-aktif.
     */
    public function switchStatus($id)
    {
        try {
            DB::beginTransaction();
            $id = intval($id);
            $kegiatan = MKegiatanPuspaga::find($id);

            if (!$kegiatan) {
                $this->responseCode = 404;
                $this->responseMessage = 'Data tidak ditemukan';
                return response()->json($this->getResponse(), $this->responseCode);
            }

            $kegiatan->is_active = !$kegiatan->is_active;
            $kegiatan->save();

            $this->responseCode = 200;
            $this->responseMessage = $kegiatan->is_active ? 'Data telah diaktifkan' : 'Data telah dinonaktifkan';
            $this->responseData = $kegiatan;
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
     * Ambil semua data untuk dropdown.
     */
    public function lists(Request $request)
    {
        try {
            $limit = $request->limit ? intval($request->limit) : 10;

            $kegiatan = MKegiatanPuspaga::select('id', 'judul_kegiatan as nama')
                ->where('is_active', true)
                ->when($request->filled('search'), function ($q) use ($request) {
                    $q->where(DB::raw('lower(judul_kegiatan)'), 'like', '%' . strtolower($request->search) . '%');
                })
                ->take($limit)
                ->orderBy('judul_kegiatan', 'ASC')
                ->get();

            $this->responseData = $kegiatan;
            return response()->json($this->getResponse(), $this->responseCode);
        } catch (\Exception $e) {
            $this->responseCode = 500;
            $this->responseMessage = $e->getMessage();
            return response()->json($this->getResponse(), $this->responseCode);
        }
    }

    /**
     * Ambil semua data bentuk kegiatan aktif untuk penggunaan publik.
     */
    public function listsPublic(Request $request)
    {
        try {
            $kegiatan = MKegiatanPuspaga::select('*')
                ->where('is_active', true)
                ->orderBy('judul_kegiatan', 'ASC')
                ->get();

            $this->responseData = $kegiatan;
            return response()->json($this->getResponse(), $this->responseCode);
        } catch (\Exception $e) {
            $this->responseCode = 500;
            $this->responseMessage = $e->getMessage();
            return response()->json($this->getResponse(), $this->responseCode);
        }
    }
}
