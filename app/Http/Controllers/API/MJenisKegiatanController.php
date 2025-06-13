<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\MJenisKegiatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class MJenisKegiatanController extends Controller
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

            $jenisKegiatan = MJenisKegiatan::select('*');
            if ($request->filled('search')) {
                $jenisKegiatan->where(DB::raw('lower(name)'), 'like', '%' . strtolower($request->search) . '%');
            }

            $jenisKegiatan = $jenisKegiatan->orderBy($sortby, $order)->paginate($limit);

            $this->saveLog($jenisKegiatan);
            return $jenisKegiatan;
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
                'name' => 'required|iunique:m_jenis_kegiatan, name',
                'id_program_kegiatan' => 'required|exists:m_program_kegiatan,id',
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

            $jenisKegiatanData = MJenisKegiatan::create([
                'name' => ($request->name),
                'id_program_kegiatan' => ($request->id_program_kegiatan),
                // 'is_active' => ($request->is_active ?? true),
                // 'created_by' => ($request->created_by),
            ]);

            DB::commit();
            $this->responseCode = 201;
            $this->responseData = $jenisKegiatanData;
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
            $jenisKegiatan = MJenisKegiatan::find($id);
            if (!$jenisKegiatan) {
                $this->responseCode = 404;
                $this->responseMessage = 'Data tidak ditemukan';
                return response()->json($this->getResponse(), $this->responseCode);
            }

            $this->responseCode = 200;
            $this->responseData = $jenisKegiatan;
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
            $jenisKegiatan = MJenisKegiatan::find($id);

            if (!$jenisKegiatan) {
                $this->responseCode = 404;
                $this->responseMessage = 'Data tidak ditemukan';
                return response()->json($this->getResponse(), $this->responseCode);
            }

            $rules = [
                'name' => "required|string|unique:m_jenis_kegiatan,name,$id",
                'id_program_kegiatan' => 'required|exists:m_program_kegiatan,id',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                $this->responseCode = 422;
                $this->responseMessage = $validator->errors()->first();
                $this->responseData = $validator->errors();
                return response()->json($this->getResponse(), $this->responseCode);
            }

            // Assign satu per satu field
            $jenisKegiatan->name = $request->name;
            $jenisKegiatan->id_program_kegiatan = $request->id_program_kegiatan;

            // Simpan perubahan
            $jenisKegiatan->save();

            DB::commit();
            $this->responseCode = 200;
            $this->responseData = $jenisKegiatan;
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
            $jenisKegiatan = MJenisKegiatan::find($id);
            if (!$jenisKegiatan) {
                $this->responseCode = 404;
                $this->responseMessage = 'Data tidak di temukan';
                return response()->json($this->getResponse(), $this->responseCode);
            }

            $jenisKegiatan->delete();

            $this->responseCode = 200;
            $this->responseMessage = 'Berhasil menghapus data';
            $this->responseData = $jenisKegiatan;
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
            $jenisKegiatan = MJenisKegiatan::find($id);
            if (!$jenisKegiatan) {
                $this->responseCode = 404;
                $this->responseMessage = 'Data tidak di temukan';
                return response()->json($this->getResponse(), $this->responseCode);
            }

            DB::beginTransaction();

            $jenisKegiatan->update([
                'is_active' => !$jenisKegiatan->is_active
            ]);

            $this->responseCode = 200;
            $this->responseMessage = boolval($jenisKegiatan->is_active) ? 'Jenis Kegiatan telah diaktifkan' : 'Jenis Kegiatan telah dinonaktifkan';
            $this->responseData = $jenisKegiatan;
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

            $jenisKegiatan = MJenisKegiatan::select('*');
            if ($request->filled('search')) {
                $jenisKegiatan->where(DB::raw('lower(name)'), 'like', '%' . strtolower($request->search) . '%');
            }
            $jenisKegiatan = $jenisKegiatan->where('m_jenis_kegiatan.is_active', true)->take($limit)->orderBy('name', 'ASC')->get();

            $this->responseCode = 200;
            $this->responseData = $jenisKegiatan;
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

            $jenisKegiatan = MJenisKegiatan::select('*');
            $jenisKegiatan = $jenisKegiatan->where('m_jenis_kegiatan.is_active', true)->orderBy('name', 'ASC')->get();

            $this->responseCode = 200;
            $this->responseData = $jenisKegiatan;
            return response()->json($this->getResponse(), $this->responseCode);
        } catch (\Exception $e) {
            $this->responseCode = 500;
            $this->responseMessage = $e->getMessage();
            return response()->json($this->getResponse(), $this->responseCode);
        }
    }
}