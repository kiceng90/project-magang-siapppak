<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\MProgramKegiatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class MProgramKegiatanController extends Controller
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

            $programKegiatan = MProgramKegiatan::select('*');
            if ($request->filled('search')) {
                $programKegiatan->where(DB::raw('lower(name)'), 'like', '%' . strtolower($request->search) . '%');
            }

            $programKegiatan = $programKegiatan->orderBy($sortby, $order)->paginate($limit);

            $this->saveLog($programKegiatan);
            return $programKegiatan;
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
                'name' => 'required|iunique:m_program_kegiatan, name',
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $this->responseCode = 422;
                $this->responseMessage = $validator->errors()->first();
                $this->responseData = $validator->errors();
                return response()->json($this->getResponse(), $this->responseCode);
            }

            $programKegiatanData = MProgramKegiatan::create([
                'name' => ($request->name),
                // 'id_jenis_kegiatan' => ($request->id_jenis_kegiatan),
                // 'is_active' => ($request->is_active ?? true),
                // 'created_by' => ($request->created_by),
            ]);

            DB::commit();
            $this->responseCode = 201;
            $this->responseData = $programKegiatanData;
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
            $programKegiatan = MProgramKegiatan::find($id);
            if (!$programKegiatan) {
                $this->responseCode = 404;
                $this->responseMessage = 'Data tidak ditemukan';
                return response()->json($this->getResponse(), $this->responseCode);
            }

            $this->responseCode = 200;
            $this->responseData = $programKegiatan;
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
            $programKegiatan = MProgramKegiatan::find($id);

            if (!$programKegiatan) {
                $this->responseCode = 404;
                $this->responseMessage = 'Data tidak ditemukan';
                return response()->json($this->getResponse(), $this->responseCode);
            }

            $rules = [
                'name' => "required|string|unique:m_program_kegiatan,name," . $id
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                $this->responseCode = 422;
                $this->responseMessage = $validator->errors()->first();
                $this->responseData = $validator->errors();
                return response()->json($this->getResponse(), $this->responseCode);
            }

            // Update field satu per satu
            $programKegiatan->name = $request->name;

            // Jika ada field lain seperti updated_by atau is_active, tambahkan di sini

            $programKegiatan->save();

            DB::commit();
            $this->responseCode = 200;
            $this->responseData = $programKegiatan;
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
            $programKegiatan = MProgramKegiatan::find($id);
            if (!$programKegiatan) {
                $this->responseCode = 404;
                $this->responseMessage = 'Data tidak di temukan';
                return response()->json($this->getResponse(), $this->responseCode);
            }

            $programKegiatan->delete();

            $this->responseCode = 200;
            $this->responseMessage = 'Berhasil menghapus data';
            $this->responseData = $programKegiatan;
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
            $programKegiatan = MProgramKegiatan::find($id);
            if (!$programKegiatan) {
                $this->responseCode = 404;
                $this->responseMessage = 'Data tidak di temukan';
                return response()->json($this->getResponse(), $this->responseCode);
            }

            DB::beginTransaction();

            $programKegiatan->update([
                'is_active' => !$programKegiatan->is_active
            ]);

            $this->responseCode = 200;
            $this->responseMessage = boolval($programKegiatan->is_active) ? 'Program Kegiatan telah diaktifkan' : 'Program Kegiatan telah dinonaktifkan';
            $this->responseData = $programKegiatan;
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

            $programKegiatan = MProgramKegiatan::select('*');
            if ($request->filled('search')) {
                $programKegiatan->where(DB::raw('lower(name)'), 'like', '%' . strtolower($request->search) . '%');
            }
            $programKegiatan = $programKegiatan->where('m_program_kegiatan.is_active', true)->take($limit)->orderBy('name', 'ASC')->get();

            $this->responseCode = 200;
            $this->responseData = $programKegiatan;
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

            $programKegiatan = MProgramKegiatan::select('*');
            $programKegiatan = $programKegiatan->where('m_program_kegiatan.is_active', true)->orderBy('name', 'ASC')->get();

            $this->responseCode = 200;
            $this->responseData = $programKegiatan;
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
    public function export(Request $request)
    {
        // Jika kamu ingin tambahkan ekspor Excel, buat class Export sendiri
        // Misalnya: return Excel::download(new ProgramKegiatanExport, 'program-kegiatan.xlsx');

        return response()->json(['message' => 'Fitur export belum diimplementasikan'], 501);
    }
}