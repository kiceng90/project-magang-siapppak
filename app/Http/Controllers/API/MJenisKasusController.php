<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\MJenisKasus;

class MJenisKasusController extends Controller
{
    public $jenis_kasus;

    public function __construct()
    {
        $this->jenis_kasus = MJenisKasus::select([
            'm_jenis_kasus.*',
            DB::raw('m_tipe_permasalahan.id AS id_tipe_permasalahan'),
            DB::raw('m_tipe_permasalahan.name AS tipe_permasalahan_name'),
            DB::raw('m_kategori_kasus.name AS kategori_kasus_name'),
        ])
            ->join('m_kategori_kasus', 'm_kategori_kasus.id', '=', 'm_jenis_kasus.id_kategori_kasus')
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

            $jenis_kasus = $this->jenis_kasus;
            if ($request->filled('search')) {
                $jenis_kasus->where(DB::raw('lower(m_jenis_kasus.name)'), 'like', '%' . strtolower($request->search) . '%')
                    ->orWhere(DB::raw('lower(m_tipe_permasalahan.name)'), 'like', '%' . strtolower($request->search) . '%')
                    ->orWhere(DB::raw('lower(m_kategori_kasus.name)'), 'like', '%' . strtolower($request->search) . '%');
            }
            if ($request->filled('id_tipe_permasalahan')) {
                $jenis_kasus->whereHas('kategoriKasus', function ($q) use ($request) {
                    $q->where('id_tipe_permasalahan', $request->id_tipe_permasalahan);
                });
            }
            if ($request->filled('id_kategori_kasus')) {
                $jenis_kasus->where('id_kategori_kasus', intval($request->id_kategori_kasus));
            }
            $jenis_kasus = $jenis_kasus->orderBy($sortby, $order)->paginate($limit);

            $this->saveLog($jenis_kasus);
            return $jenis_kasus;
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
                'id_kategori_kasus' => 'required|exists:App\Models\MKategoriKasus,id,deleted_at,NULL',
                'name' => 'required|string',
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $this->responseCode = 422;
                $this->responseMessage = $validator->errors()->first();
                $this->responseData = $validator->errors();
                return response()->json($this->getResponse(), $this->responseCode);
            }

            $jenis_kasus = MJenisKasus::create([
                'id_kategori_kasus' => $request->id_kategori_kasus,
                'name' => $request->name,
            ]);

            DB::commit();
            $this->responseCode = 201;
            $this->responseData = $this->jenis_kasus->where('m_jenis_kasus.id', $jenis_kasus->id)->first();
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
            $jenis_kasus = $this->jenis_kasus->where('m_jenis_kasus.id', $id)->first();
            if (!$jenis_kasus) {
                $this->responseCode = 404;
                $this->responseMessage = 'Data tidak di temukan';
                return response()->json($this->getResponse(), $this->responseCode);
            }

            $this->responseCode = 200;
            $this->responseData = $jenis_kasus;
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
            $jenis_kasus = MJenisKasus::find($id);
            if (!$jenis_kasus) {
                $this->responseCode = 404;
                $this->responseMessage = 'Data tidak di temukan';
                return response()->json($this->getResponse(), $this->responseCode);
            }

            $rules = [
                'id_kategori_kasus' => 'required|exists:App\Models\MKategoriKasus,id,deleted_at,NULL',
                'name' => 'required|string',
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $this->responseCode = 422;
                $this->responseMessage = $validator->errors()->first();
                $this->responseData = $validator->errors();
                return response()->json($this->getResponse(), $this->responseCode);
            }

            $jenis_kasus->id_kategori_kasus = $request->id_kategori_kasus;
            $jenis_kasus->name = $request->name;
            $jenis_kasus->save();

            DB::commit();
            $this->responseCode = 200;
            $this->responseData = $this->jenis_kasus->where('m_jenis_kasus.id', $id)->first();
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
            $jenis_kasus = $this->jenis_kasus->where('m_jenis_kasus.id', $id)->first();
            if (!$jenis_kasus) {
                $this->responseCode = 404;
                $this->responseMessage = 'Data tidak di temukan';
                return response()->json($this->getResponse(), $this->responseCode);
            }

            $jenis_kasus->delete();

            $this->responseCode = 200;
            $this->responseMessage = 'Berhasil menghapus data';
            $this->responseData = $jenis_kasus;
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

            $jenis_kasus = $this->jenis_kasus;
            if ($request->filled('id_kategori_kasus')) {
                $jenis_kasus->where('id_kategori_kasus', $request->id_kategori_kasus);
            }
            if ($request->filled('search')) {
                $jenis_kasus->where(DB::raw('lower(m_jenis_kasus.name)'), 'like', '%' . strtolower($request->search) . '%');
            }
            $jenis_kasus = $jenis_kasus->where('m_jenis_kasus.is_active', true)->take($limit)->orderBy('name', 'ASC')->get();

            $this->responseCode = 200;
            $this->responseData = $jenis_kasus;
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
            $jenis_kasus = MJenisKasus::find($id);
            if (!$jenis_kasus) {
                $this->responseCode = 404;
                $this->responseMessage = 'Data tidak di temukan';
                return response()->json($this->getResponse(), $this->responseCode);
            }

            DB::beginTransaction();

            $jenis_kasus->update([
                'is_active' => !$jenis_kasus->is_active
            ]);

            $this->responseCode = 200;
            $this->responseMessage = boolval($jenis_kasus->is_active) ? 'Jenis kasus telah diaktifkan' : 'Jenis kasus telah dinonaktifkan';
            $this->responseData = $this->jenis_kasus->where('m_jenis_kasus.id', $id)->first();
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

            $jenis_kasus = $this->jenis_kasus;

            $jenis_kasus = $jenis_kasus->where('m_jenis_kasus.is_active', true)->orderBy('name', 'ASC')->get();

            $this->responseCode = 200;
            $this->responseData = $jenis_kasus;
            return response()->json($this->getResponse(), $this->responseCode);
        } catch (\Exception $e) {
            $this->responseCode = 500;
            $this->responseMessage = $e->getMessage();
            return response()->json($this->getResponse(), $this->responseCode);
        }
    }
}
