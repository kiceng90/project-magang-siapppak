<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\MKelurahan;

class MKelurahanController extends Controller
{
    public $kelurahan;

    public function __construct()
    {
        $this->kelurahan = MKelurahan::select([
            'm_kelurahan.*', DB::raw('m_kecamatan.name AS kecamatan_name'),
            DB::raw('m_wilayah.id AS id_wilayah'), DB::raw('m_wilayah.name AS wilayah_name'),
        ])
            ->join('m_kecamatan', 'm_kecamatan.id', '=', 'm_kelurahan.id_kecamatan')
            ->join('m_wilayah', 'm_wilayah.id', '=', 'm_kecamatan.id_wilayah');
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

            $kelurahan = $this->kelurahan;
            if ($request->filled('search')) {
                $kelurahan->where(DB::raw('lower(m_kelurahan.name)'), 'like', '%' . strtolower($request->search) . '%')
                    ->orWhere(DB::raw('lower(m_kecamatan.name)'), 'like', '%' . strtolower($request->search) . '%')
                    ->orWhere(DB::raw('lower(m_wilayah.name)'), 'like', '%' . strtolower($request->search) . '%');
            }
            if ($request->filled('id_kecamatan')) {
                $kelurahan->where('id_kecamatan', intval($request->id_kecamatan));
            }
            if ($request->filled('id_wilayah')) {
                $kelurahan->whereHas('kecamatan', function ($q) use ($request) {
                    $q->where('id_wilayah', $request->id_wilayah);
                });
            }
            $kelurahan = $kelurahan->orderBy($sortby, $order)->paginate($limit);

            $this->saveLog($kelurahan);
            return $kelurahan;
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
                'id_kecamatan' => 'required|exists:App\Models\MKecamatan,id,deleted_at,NULL',
                'name' => 'required|string|iunique:m_kelurahan,name',
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $this->responseCode = 422;
                $this->responseMessage = $validator->errors()->first();
                $this->responseData = $validator->errors();
                return response()->json($this->getResponse(), $this->responseCode);
            }

            $kelurahan = MKelurahan::create([
                'id_kecamatan' => $request->id_kecamatan,
                'name' => ($request->name),
            ]);

            DB::commit();
            $this->responseCode = 201;
            $this->responseData = $this->kelurahan->where('m_kelurahan.id', $kelurahan->id)->first();
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
            $kelurahan = $this->kelurahan->where('m_kelurahan.id', $id)->first();
            if (!$kelurahan) {
                $this->responseCode = 404;
                $this->responseMessage = 'Data tidak di temukan';
                return response()->json($this->getResponse(), $this->responseCode);
            }

            $this->responseCode = 200;
            $this->responseData = $kelurahan;
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
            $kelurahan = MKelurahan::find($id);
            if (!$kelurahan) {
                $this->responseCode = 404;
                $this->responseMessage = 'Data tidak di temukan';
                return response()->json($this->getResponse(), $this->responseCode);
            }

            $rules = [
                'id_kecamatan' => 'required|exists:App\Models\MKecamatan,id,deleted_at,NULL',
                'name' => 'required|string|iunique:m_kelurahan,name,' . $id,
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $this->responseCode = 422;
                $this->responseMessage = $validator->errors()->first();
                $this->responseData = $validator->errors();
                return response()->json($this->getResponse(), $this->responseCode);
            }

            $kelurahan->id_kecamatan = $request->id_kecamatan;
            $kelurahan->name = ($request->name);
            $kelurahan->save();

            DB::commit();
            $this->responseCode = 200;
            $this->responseData = $this->kelurahan->where('m_kelurahan.id', $id)->first();
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
            $kelurahan = $this->kelurahan->where('m_kelurahan.id', $id)->first();
            if (!$kelurahan) {
                $this->responseCode = 404;
                $this->responseMessage = 'Data tidak di temukan';
                return response()->json($this->getResponse(), $this->responseCode);
            }

            $kelurahan->delete();

            $this->responseCode = 200;
            $this->responseMessage = 'Berhasil menghapus data';
            $this->responseData = $kelurahan;
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

            $kelurahan = $this->kelurahan;
            if ($request->filled('search')) {
                $kelurahan->where(DB::raw('lower(m_kelurahan.name)'), 'like', '%' . strtolower($request->search) . '%');
            }
            if ($request->filled('id_kecamatan')) {
                $kelurahan->where('id_kecamatan', intval($request->id_kecamatan));
            }
            $kelurahan = $kelurahan->where('m_kelurahan.is_active', true)->take($limit)->orderBy('m_kelurahan.name', 'ASC')->get();

            $this->responseCode = 200;
            $this->responseData = $kelurahan;
            return response()->json($this->getResponse(), $this->responseCode);
        } catch (\Exception $e) {
            $this->responseCode = 500;
            $this->responseMessage = $e->getMessage();
            return response()->json($this->getResponse(), $this->responseCode);
        }
    }

    public function listsPublic(Request $request)
    {
        try {

            $kelurahan = MKelurahan::select('*');
            $kelurahan = $kelurahan->where('m_kelurahan.is_active', true)->orderBy('m_kelurahan.name', 'ASC')->get();

            $this->responseCode = 200;
            $this->responseData = $kelurahan;
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
            $kelurahan = MKelurahan::find($id);
            if (!$kelurahan) {
                $this->responseCode = 404;
                $this->responseMessage = 'Data tidak di temukan';
                return response()->json($this->getResponse(), $this->responseCode);
            }

            DB::beginTransaction();

            $kelurahan->update([
                'is_active' => !$kelurahan->is_active
            ]);

            $this->responseCode = 200;
            $this->responseMessage = boolval($kelurahan->is_active) ? 'Kelurahan telah diaktifkan' : 'Kelurahan telah dinonaktifkan';
            $this->responseData = $this->kelurahan->where('m_kelurahan.id', $id)->first();
            DB::commit();
            return response()->json($this->getResponse(), $this->responseCode);
        } catch (\Exception $e) {
            $this->responseCode = 500;
            $this->responseMessage = $e->getMessage();
            DB::rollback();
            return response()->json($this->getResponse(), $this->responseCode);
        }
    }
}
