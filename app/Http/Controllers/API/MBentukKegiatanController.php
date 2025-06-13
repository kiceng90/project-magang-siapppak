<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\MBentukKegiatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class MBentukKegiatanController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $limit = $request->limit ? intval($request->limit) : 10;
            $order = $request->order ? $request->order : 'DESC';
            $sortby = $request->sortby ? $request->sortby : 'id';

            $bentukKegiatan = MBentukKegiatan::select('*');
            if ($request->filled('search')) {
                $bentukKegiatan->where(DB::raw('lower(name)'), 'like', '%' . strtolower($request->search) . '%');
            }

            $bentukKegiatan = $bentukKegiatan->orderBy($sortby, $order)->paginate($limit);

            $this->saveLog($bentukKegiatan);
            return $bentukKegiatan;
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
                'name' => 'required|iunique:m_bentuk_keniatan, name',
                'id_jenis_kegiatan' => 'required|exists:m_jenis_kegiatan,id',
                // 'is_active' => 'boolean',
                // 'created_by' => 'nullable|integer',
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $this->responseCode = 422;
                $this->responseMessage = $validator->errors()->first();
                $this->responseData = $validator->errors();
                return response()->json($this->getResponse(), $this->responseCode);
            }

            $bentukKegiatanData = MBentukKegiatan::create([
                'name' => ($request->name),
                'id_jenis_kegiatan' => ($request->id_jenis_kegiatan),
                // 'is_active' => ($request->is_active ?? true),
                // 'created_by' => ($request->created_by),
            ]);

            DB::commit();
            $this->responseCode = 201;
            $this->responseData = $bentukKegiatanData;
            return response()->json($this->getResponse(), $this->responseCode);
        } catch (\Exception $e) {
            $this->responseCode = 500;
            $this->responseMessage = $e->getMessage();
            DB::rollback();
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
            $bentukKegiatan = MBentukKegiatan::find($id);
            if (!$bentukKegiatan) {
                $this->responseCode = 404;
                $this->responseMessage = 'Data tidak ditemukan';
                return response()->json($this->getResponse(), $this->responseCode);
            }

            $this->responseCode = 200;
            $this->responseData = $bentukKegiatan;
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
            $bentukKegiatan = MBentukKegiatan::find($id);

            if (!$bentukKegiatan) {
                $this->responseCode = 404;
                $this->responseMessage = 'Data tidak ditemukan';
                return response()->json($this->getResponse(), $this->responseCode);
            }

            $rules = [
                'name' => "required|string|unique:m_bentuk_kegiatan,name,$id",
                'id_jenis_kegiatan' => 'required|exists:m_jenis_kegiatan,id',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                $this->responseCode = 422;
                $this->responseMessage = $validator->errors()->first();
                $this->responseData = $validator->errors();
                return response()->json($this->getResponse(), $this->responseCode);
            }

            // Assign satu per satu field
            $bentukKegiatan->name = $request->name;
            $bentukKegiatan->id_jenis_kegiatan = $request->id_jenis_kegiatan;

            // Simpan perubahan
            $bentukKegiatan->save();

            DB::commit();
            $this->responseCode = 200;
            $this->responseData = $bentukKegiatan;
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
            $bentukKegiatan = MBentukKegiatan::find($id);
            if (!$bentukKegiatan) {
                $this->responseCode = 404;
                $this->responseMessage = 'Data tidak di temukan';
                return response()->json($this->getResponse(), $this->responseCode);
            }

            $bentukKegiatan->delete();

            $this->responseCode = 200;
            $this->responseMessage = 'Berhasil menghapus data';
            $this->responseData = $bentukKegiatan;
            DB::commit();
            return response()->json($this->getResponse(), $this->responseCode);
        } catch (\Exception $e) {
            $this->responseCode = 500;
            $this->responseMessage = $e->getMessage();
            DB::rollback();
            return response()->json($this->getResponse(), $this->responseCode);
        }
    }

    
    /**
     * Toggle active status.
     */
    public function switchStatus($id)
    {
        try {
            $id = intval($id);
            $bentukKegiatan = MBentukKegiatan::find($id);
            if (!$bentukKegiatan) {
                $this->responseCode = 404;
                $this->responseMessage = 'Data tidak di temukan';
                return response()->json($this->getResponse(), $this->responseCode);
            }

            DB::beginTransaction();

            $bentukKegiatan->update([
                'is_active' => !$bentukKegiatan->is_active
            ]);

            $this->responseCode = 200;
            $this->responseMessage = boolval($bentukKegiatan->is_active) ? 'Bentuk Kegiatan telah diaktifkan' : 'Bentuk Kegiatan telah dinonaktifkan';
            $this->responseData = $bentukKegiatan;
            DB::commit();
            return response()->json($this->getResponse(), $this->responseCode);
        } catch (\Exception $e) {
            $this->responseCode = 500;
            $this->responseMessage = $e->getMessage();
            DB::rollback();
            return response()->json($this->getResponse(), $this->responseCode);
        }
    }

    /**
     * Get list of active items for dropdown or autocomplete.
     */
    public function lists(Request $request)
    {
        try {
            $limit = $request->limit ? intval($request->limit) : 10;

            $bentukKegiatan = MBentukKegiatan::select('*');
            if ($request->filled('search')) {
                $bentukKegiatan->where(DB::raw('lower(name)'), 'like', '%' . strtolower($request->search) . '%');
            }
            $bentukKegiatan = $bentukKegiatan->where('m_bentuk_kegiatan.is_active', true)->take($limit)->orderBy('name', 'ASC')->get();

            $this->responseCode = 200;
            $this->responseData = $bentukKegiatan;
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

            $bentukKegiatan = MBentukKegiatan::select('*');
            $bentukKegiatan = $bentukKegiatan->where('m_bentuk_kegiatan.is_active', true)->orderBy('name', 'ASC')->get();

            $this->responseCode = 200;
            $this->responseData = $bentukKegiatan;
            return response()->json($this->getResponse(), $this->responseCode);
        } catch (\Exception $e) {
            $this->responseCode = 500;
            $this->responseMessage = $e->getMessage();
            return response()->json($this->getResponse(), $this->responseCode);
        }
    }
}