<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\MKecamatan;

class MKecamatanController extends Controller
{
    public $kecamatan;

    public function __construct()
    {
        $this->kecamatan = MKecamatan::select([
            'm_kecamatan.*', DB::raw('m_wilayah.name AS wilayah_name'),
            DB::raw('m_kabupaten.name AS kabupaten_name')
        ])
            ->join('m_wilayah', 'm_wilayah.id', '=', 'm_kecamatan.id_wilayah')
            ->join('m_kabupaten', 'm_kabupaten.id', '=', 'm_kecamatan.id_kabupaten');
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

            $kecamatan = $this->kecamatan;
            if ($request->filled('search')) {
                $kecamatan->where(DB::raw('lower(m_kecamatan.name)'), 'like', '%' . strtolower($request->search) . '%')
                    ->orWhere(DB::raw('lower(m_kabupaten.name)'), 'like', '%' . strtolower($request->search) . '%')
                    ->orWhere(DB::raw('lower(m_wilayah.name)'), 'like', '%' . strtolower($request->search) . '%');
            }
            if ($request->filled('id_kabupaten')) {
                $kecamatan->where('id_kabupaten', intval($request->id_kabupaten));
            }
            if ($request->filled('id_wilayah')) {
                $kecamatan->where('id_wilayah', intval($request->id_wilayah));
            }
            $kecamatan = $kecamatan->orderBy($sortby, $order)->paginate($limit);

            $this->saveLog($kecamatan);
            return $kecamatan;
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
                'id_kabupaten' => 'required|exists:App\Models\MKabupaten,id,deleted_at,NULL',
                'id_wilayah' => 'required|exists:App\Models\MWilayah,id,deleted_at,NULL',
                'name' => 'required|string|iunique:m_kecamatan,name',
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $this->responseCode = 422;
                $this->responseMessage = $validator->errors()->first();
                $this->responseData = $validator->errors();
                return response()->json($this->getResponse(), $this->responseCode);
            }

            $kecamatan = MKecamatan::create([
                'id_kabupaten' => $request->id_kabupaten,
                'id_wilayah' => $request->id_wilayah,
                'name' => ($request->name),
            ]);

            DB::commit();
            $this->responseCode = 201;
            $this->responseData = $this->kecamatan->where('m_kecamatan.id', $kecamatan->id)->first();
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
            $kecamatan = $this->kecamatan->where('m_kecamatan.id', $id)->first();
            if (!$kecamatan) {
                $this->responseCode = 404;
                $this->responseMessage = 'Data tidak di temukan';
                return response()->json($this->getResponse(), $this->responseCode);
            }

            $this->responseCode = 200;
            $this->responseData = $kecamatan;
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
            $kecamatan = MKecamatan::find($id);
            if (!$kecamatan) {
                $this->responseCode = 404;
                $this->responseMessage = 'Data tidak di temukan';
                return response()->json($this->getResponse(), $this->responseCode);
            }

            $rules = [
                'id_kabupaten' => 'required|exists:App\Models\MKabupaten,id,deleted_at,NULL',
                'id_wilayah' => 'required|exists:App\Models\MWilayah,id,deleted_at,NULL',
                'name' => 'required|string|iunique:m_kecamatan,name,' . $id,
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $this->responseCode = 422;
                $this->responseMessage = $validator->errors()->first();
                $this->responseData = $validator->errors();
                return response()->json($this->getResponse(), $this->responseCode);
            }

            $kecamatan->id_kabupaten = $request->id_kabupaten;
            $kecamatan->id_wilayah = $request->id_wilayah;
            $kecamatan->name = ($request->name);
            $kecamatan->save();

            DB::commit();
            $this->responseCode = 200;
            $this->responseData = $this->kecamatan->where('m_kecamatan.id', $id)->first();
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
            $kecamatan = $this->kecamatan->where('m_kecamatan.id', $id)->first();
            if (!$kecamatan) {
                $this->responseCode = 404;
                $this->responseMessage = 'Data tidak di temukan';
                return response()->json($this->getResponse(), $this->responseCode);
            }

            $kecamatan->delete();

            $this->responseCode = 200;
            $this->responseMessage = 'Berhasil menghapus data';
            $this->responseData = $kecamatan;
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

            $kecamatan = $this->kecamatan;
            if ($request->filled('search')) {
                $kecamatan->where(DB::raw('lower(m_kecamatan.name)'), 'like', '%' . strtolower($request->search) . '%');
            }
            if ($request->filled('id_kabupaten')) {
                $kecamatan->where('id_kabupaten', intval($request->id_kabupaten));
            }
            if ($request->filled('id_wilayah')) {
                $kecamatan->where('id_wilayah', intval($request->id_wilayah));
            }
            if ($request->filled('is_surabaya')) {
                if ($request->is_surabaya) {
                    $kecamatan->whereHas('kabupaten', function ($q) {
                        $q->where('name', 'ILIKE', '%surabaya%');
                    });
                }
            }
            $kecamatan = $kecamatan->where('m_kecamatan.is_active', true)->take($limit)->orderBy('m_kecamatan.name', 'ASC')->get();

            $this->responseCode = 200;
            $this->responseData = $kecamatan;
            return response()->json($this->getResponse(), $this->responseCode);
        } catch (\Exception $e) {
            $this->responseCode = 500;
            $this->responseMessage = $e->getMessage();
            return response()->json($this->getResponse(), $this->responseCode);
        }
    }

    public function listsMahasiswa(Request $request)
    {
        try {
            $limit = $request->limit ? intval($request->limit) : 10;

            $kecamatan = $this->kecamatan;
            if ($request->filled('search')) {
                $kecamatan->where(DB::raw('lower(m_kecamatan.name)'), 'like', '%' . strtolower($request->search) . '%');
            }
            if ($request->filled('id_kabupaten')) {
                $kecamatan->where('id_kabupaten', intval($request->id_kabupaten));
            }
            if ($request->filled('id_wilayah')) {
                $kecamatan->where('id_wilayah', intval($request->id_wilayah));
            }
            if ($request->filled('is_surabaya')) {
                if ($request->is_surabaya) {
                    $kecamatan->whereHas('kabupaten', function ($q) {
                        $q->where('name', 'ILIKE', '%surabaya%');
                    });
                }
            }
            $kecamatan = $kecamatan->where('m_kecamatan.is_active', true)->where('id_wilayah', '!=', 6)->take($limit)->orderBy('m_kecamatan.name', 'ASC')->get();

            $this->responseCode = 200;
            $this->responseData = $kecamatan;
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

            $kecamatan = MKecamatan::select('*');
            $kecamatan = $kecamatan->where('m_kecamatan.is_active', true)->orderBy('m_kecamatan.name', 'ASC')->get();

            $this->responseCode = 200;
            $this->responseData = $kecamatan;
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
            $kecamatan = MKecamatan::find($id);
            if (!$kecamatan) {
                $this->responseCode = 404;
                $this->responseMessage = 'Data tidak di temukan';
                return response()->json($this->getResponse(), $this->responseCode);
            }

            DB::beginTransaction();

            $kecamatan->update([
                'is_active' => !$kecamatan->is_active
            ]);

            $this->responseCode = 200;
            $this->responseMessage = boolval($kecamatan->is_active) ? 'Kecamatan telah diaktifkan' : 'Kecamatan telah dinonaktifkan';
            $this->responseData = $this->kecamatan->where('m_kecamatan.id', $id)->first();
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