<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\MKategoriKasus;

class MKategoriKasusController extends Controller
{
    public $kategori_kasus;

    public function __construct()
    {
        $this->kategori_kasus = MKategoriKasus::select([
            'm_kategori_kasus.*', DB::raw('m_tipe_permasalahan.name AS tipe_permasalahan_name'),
        ])
            ->join('m_tipe_permasalahan', 'm_tipe_permasalahan.id', '=', 'm_kategori_kasus.id_tipe_permasalahan');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $limit = $request->limit ? intval($request->limit) : 10;
            $order = $request->order ? $request->order : 'DESC';
            $sortby = $request->sortby ? $request->sortby : 'id';

            $kategori_kasus = $this->kategori_kasus;
            if ($request->filled('search')) {
                $kategori_kasus->where(DB::raw('lower(m_kategori_kasus.name)'), 'like', '%' . strtolower($request->search) . '%')
                    ->orWhere(DB::raw('lower(m_tipe_permasalahan.name)'), 'like', '%' . strtolower($request->search) . '%');
            }
            if ($request->filled('id_tipe_permasalahan')) {
                $kategori_kasus->where('id_tipe_permasalahan', intval($request->id_tipe_permasalahan));
            }
            $kategori_kasus = $kategori_kasus->orderBy($sortby, $order)->paginate($limit);

            $this->saveLog($kategori_kasus);
            return $kategori_kasus;
        } catch (\Exception $e) {
            $this->responseCode = 500;
            $this->responseMessage = $e->getMessage() . ' ' . $e->getLine();
            return response()->json($this->getResponse(), $this->responseCode);
        }
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

            $rules = [
                'id_tipe_permasalahan' => 'required|exists:App\Models\MTipePermasalahan,id,deleted_at,NULL',
                'name' => 'required|string',
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $this->responseCode = 422;
                $this->responseMessage = $validator->errors()->first();
                $this->responseData = $validator->errors();
                return response()->json($this->getResponse(), $this->responseCode);
            }

            $kategori_kasus = MKategoriKasus::create([
                'id_tipe_permasalahan' => $request->id_tipe_permasalahan,
                'name' => $request->name,
            ]);

            DB::commit();
            $this->responseCode = 201;
            $this->responseData = $this->kategori_kasus->where('m_kategori_kasus.id', $kategori_kasus->id)->first();
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
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $id = intval($id);
            $kategori_kasus = $this->kategori_kasus->where('m_kategori_kasus.id', $id)->first();
            if (!$kategori_kasus) {
                $this->responseCode = 404;
                $this->responseMessage = 'Data tidak di temukan';
                return response()->json($this->getResponse(), $this->responseCode);
            }

            $this->responseCode = 200;
            $this->responseData = $kategori_kasus;
            return response()->json($this->getResponse(), $this->responseCode);
        } catch (\Exception $e) {
            $this->responseCode = 500;
            $this->responseMessage = $e->getMessage();
            return response()->json($this->getResponse(), $this->responseCode);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            $id = intval($id);
            $kategori_kasus = MKategoriKasus::find($id);
            if (!$kategori_kasus) {
                $this->responseCode = 404;
                $this->responseMessage = 'Data tidak di temukan';
                return response()->json($this->getResponse(), $this->responseCode);
            }

            $rules = [
                'id_tipe_permasalahan' => 'required|exists:App\Models\MTipePermasalahan,id,deleted_at,NULL',
                'name' => 'required|string',
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $this->responseCode = 422;
                $this->responseMessage = $validator->errors()->first();
                $this->responseData = $validator->errors();
                return response()->json($this->getResponse(), $this->responseCode);
            }

            $kategori_kasus->id_tipe_permasalahan = $request->id_tipe_permasalahan;
            $kategori_kasus->name = $request->name;
            $kategori_kasus->save();

            DB::commit();
            $this->responseCode = 200;
            $this->responseData = $this->kategori_kasus->where('m_kategori_kasus.id', $id)->first();
            return response()->json($this->getResponse(), $this->responseCode);
        } catch (\Exception $e) {
            $this->responseCode = 500;
            $this->responseMessage = $e->getMessage();
            DB::rollback();
            return response()->json($this->getResponse(), $this->responseCode);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            $id = intval($id);
            $kategori_kasus = $this->kategori_kasus->where('m_kategori_kasus.id', $id)->first();
            if (!$kategori_kasus) {
                $this->responseCode = 404;
                $this->responseMessage = 'Data tidak di temukan';
                return response()->json($this->getResponse(), $this->responseCode);
            }

            $kategori_kasus->delete();

            $this->responseCode = 200;
            $this->responseMessage = 'Berhasil menghapus data';
            $this->responseData = $kategori_kasus;
            DB::commit();
            return response()->json($this->getResponse(), $this->responseCode);
        } catch (\Exception $e) {
            $this->responseCode = 500;
            $this->responseMessage = $e->getMessage();
            DB::rollback();
            return response()->json($this->getResponse(), $this->responseCode);
        }
    }

    public function lists(Request $request)
    {
        try {
            $limit = $request->limit ? intval($request->limit) : 10;

            $kategori_kasus = $this->kategori_kasus;
            if ($request->filled('search')) {
                $kategori_kasus->where(DB::raw('lower(m_kategori_kasus.name)'), 'like', '%' . strtolower($request->search) . '%');
            }
            if ($request->filled('id_tipe_permasalahan')) {
                $kategori_kasus->where('id_tipe_permasalahan', $request->id_tipe_permasalahan);
            }
            $kategori_kasus = $kategori_kasus->where('m_kategori_kasus.is_active', true)->take($limit)->orderBy('m_kategori_kasus.name', 'ASC')->get();

            $this->responseCode = 200;
            $this->responseData = $kategori_kasus;
            return response()->json($this->getResponse(), $this->responseCode);
        } catch (\Exception $e) {
            $this->responseCode = 500;
            $this->responseMessage = $e->getMessage();
            return response()->json($this->getResponse(), $this->responseCode);
        }
    }

    public function switchStatus($id)
    {
        try {
            $id = intval($id);
            $kategori_kasus = MKategoriKasus::find($id);
            if (!$kategori_kasus) {
                $this->responseCode = 404;
                $this->responseMessage = 'Data tidak di temukan';
                return response()->json($this->getResponse(), $this->responseCode);
            }

            DB::beginTransaction();

            $kategori_kasus->update([
                'is_active' => !$kategori_kasus->is_active
            ]);

            $this->responseCode = 200;
            $this->responseMessage = boolval($kategori_kasus->is_active) ? 'Kategori kasus telah diaktifkan' : 'Kategori kasus telah dinonaktifkan';
            $this->responseData = $this->kategori_kasus->where('m_kategori_kasus.id', $id)->first();
            DB::commit();
            return response()->json($this->getResponse(), $this->responseCode);
        } catch (\Exception $e) {
            $this->responseCode = 500;
            $this->responseMessage = $e->getMessage();
            DB::rollback();
            return response()->json($this->getResponse(), $this->responseCode);
        }
    }

    public function listsPublic(Request $request)
    {
        try {
            $kategori_kasus = MKategoriKasus::select('*');
            $kategori_kasus = $kategori_kasus->where('m_kategori_kasus.is_active', true)->orderBy('m_kategori_kasus.name', 'ASC')->get();

            $this->responseCode = 200;
            $this->responseData = $kategori_kasus;
            return response()->json($this->getResponse(), $this->responseCode);
        } catch (\Exception $e) {
            $this->responseCode = 500;
            $this->responseMessage = $e->getMessage();
            return response()->json($this->getResponse(), $this->responseCode);
        }
    }
}
