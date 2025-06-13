<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\DBalaiPuspagaRW;
use App\Models\DMahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\DBalaiPuspagaRWExport;


class DBalaiPuspagaRWController extends Controller
{
      
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
            $puspaga_rw = DBalaiPuspagaRW::query();

            $puspaga_rw->with("kelurahan.kecamatan.kabupaten");
            $puspaga_rw->with('wilayah');
            $puspaga_rw->with('konselor');

            if ($request->filled('search')) {
                $puspaga_rw->where(function ($q) use ($request) {
                    $s = $request->search;
                    $q->where('rw_name', 'ILIKE', '%' . $s . '%');
                    $q->orWhereHas('wilayah', function ($q) use ($s) {
                        $q->where('name', 'ILIKE', '%' . $s . '%');
                    });
                    $q->orWhereHas('kelurahan', function ($q) use ($s) {
                        $q->where('name', 'ILIKE', '%' . $s . '%');
                    });
                    $q->orWhereHas('kelurahan.kecamatan', function ($q) use ($s) {
                        $q->where('name', 'ILIKE', '%' . $s . '%');
                    });
                });
            }

            $jadwal_konseling = $puspaga_rw->orderBy($sortby, $order)->paginate($limit);

            $this->saveLog($jadwal_konseling);
            return $jadwal_konseling;
        } catch (\Exception $e) {
            $this->responseCode = 500;
            $this->responseMessage = $e->getMessage();
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
                'name' => 'required|string',
                'id_wilayah' => 'required|exists:App\Models\MWilayah,id,deleted_at,NULL',
                'id_kelurahan' => 'required|exists:App\Models\MKelurahan,id,deleted_at,NULL',
                'id_konselor' => 'required|exists:App\Models\MKonselor,id,deleted_at,NULL',
                'rw' => 'required|numeric',
                'address' => 'required|string',
                'rw_name' => 'required|string',
                'rw_phone' => 'required|string',
                'operational_day' => 'required|string',
                'operational_start_time' => 'required|string',
                'operational_end_time' => 'required|string',
                'inauguration_year' => 'required|numeric',
                'is_active' => 'required|boolean',
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $this->responseCode = 422;
                $this->responseMessage = $validator->errors()->first();
                $this->responseData = $validator->errors();
                return response()->json($this->getResponse(), $this->responseCode);
            }

            $balai_puspaga = DBalaiPuspagaRW::create([
                'name' => $request->name,
                'id_wilayah' => $request->id_wilayah,
                'id_kelurahan' => $request->id_kelurahan,
                'id_konselor' => $request->id_konselor,
                'rw' => $request->rw,
                'address' => $request->address,
                'rw_name' => $request->rw_name,
                'rw_phone' => $request->rw_phone,
                'operational_day' => $request->operational_day,
                'operational_start_time' => $request->operational_start_time,
                'operational_end_time' => $request->operational_end_time,
                'inauguration_year' => $request->inauguration_year,
                'is_active' => $request->is_active,
            ]);

            DB::commit();
            $this->responseCode = 201;
            $this->responseData = $balai_puspaga;
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
            $jadwal_konseling = DBalaiPuspagaRW::where('id', $id)->with('konselor', 'kelurahan.kecamatan.kabupaten')->first();
            if(!$jadwal_konseling){
                $this->responseCode = 404;
                $this->responseMessage = 'Data tidak di temukan';
                return response()->json($this->getResponse(), $this->responseCode);
            }

            $this->responseCode = 200;
            $this->responseData = $jadwal_konseling;
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
            $balai_puspaga = DBalaiPuspagaRW::find($id);
            if(!$balai_puspaga){
                $this->responseCode = 404;
                $this->responseMessage = 'Data tidak di temukan';
                return response()->json($this->getResponse(), $this->responseCode);
            }
            $rules = [
                'name' => 'required|string',
                'id_wilayah' => 'required|exists:App\Models\MWilayah,id,deleted_at,NULL',
                'id_kelurahan' => 'required|exists:App\Models\MKelurahan,id,deleted_at,NULL',
                'id_konselor' => 'required|exists:App\Models\MKonselor,id,deleted_at,NULL',
                'rw' => 'required|numeric',
                'address' => 'required|string',
                'rw_name' => 'required|string',
                'rw_phone' => 'required|string',
                'operational_day' => 'required|string',
                'operational_start_time' => 'required|string',
                'operational_end_time' => 'required|string',
                'inauguration_year' => 'required|numeric',
                'is_active' => 'required|boolean',
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $this->responseCode = 422;
                $this->responseMessage = $validator->errors()->first();
                $this->responseData = $validator->errors();
                return response()->json($this->getResponse(), $this->responseCode);
            }

            $balai_puspaga->name = $request->name;
            $balai_puspaga->id_wilayah = $request->id_wilayah;
            $balai_puspaga->id_kelurahan = $request->id_kelurahan;
            $balai_puspaga->id_konselor = $request->id_konselor;
            $balai_puspaga->rw = $request->rw;
            $balai_puspaga->address = $request->address;
            $balai_puspaga->rw_name = $request->rw_name;
            $balai_puspaga->rw_phone = $request->rw_phone;
            $balai_puspaga->operational_day = $request->operational_day;
            $balai_puspaga->operational_start_time = $request->operational_start_time;
            $balai_puspaga->operational_end_time = $request->operational_end_time;
            $balai_puspaga->inauguration_year = $request->inauguration_year;
            $balai_puspaga->is_active = $request->is_active;
            $balai_puspaga->save();

            DB::commit();
            $this->responseCode = 200;
            $this->responseData = $balai_puspaga;
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
            $balai_puspaga = DBalaiPuspagaRW::find($id);
            if(!$balai_puspaga){
                $this->responseCode = 404;
                $this->responseMessage = 'Data tidak di temukan';
                return response()->json($this->getResponse(), $this->responseCode);
            }

            $balai_puspaga->delete();

            $this->responseCode = 200;
            $this->responseMessage = 'Berhasil menghapus data';
            $this->responseData = $balai_puspaga;
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexPublic(Request $request)
{
    try {
        // Retrieve parameters from the request
        $limit = $request->limit ? intval($request->limit) : 10;
        $order = $request->order ? $request->order : 'DESC';
        $sortby = $request->sortby ? $request->sortby : 'id';
        $searchTerm = $request->search;

        // Start with a query on the DBalaiPuspagaRW model
        $puspaga_rw = DBalaiPuspagaRW::query();

        // Eager load relationships
        $puspaga_rw->with("kelurahan.kecamatan.kabupaten");
        $puspaga_rw->with('wilayah');
        $puspaga_rw->with('konselor');

        if ($searchTerm) {
            $puspaga_rw->where(function ($q) use ($searchTerm) {
                $q->whereHas('kelurahan', function ($q) use ($searchTerm) {
                    $q->where('name', 'ilike', '%' . $searchTerm . '%');
                });
                $q->orWhere('address', 'ilike', '%' . $searchTerm . '%');
                $q->orWhere('name', 'ilike', '%' . $searchTerm . '%');
                // Add more fields as needed
            });
        }

        // Order the results
        $puspaga_rw = $puspaga_rw->orderBy($sortby, $order)->paginate($limit);

        // Log the query results
        $this->saveLog($puspaga_rw);

        return $puspaga_rw;
    } catch (\Exception $e) {
        // Handle exceptions
        $this->responseCode = 500;
        $this->responseMessage = $e->getMessage();
        return response()->json($this->getResponse(), $this->responseCode);
    }
}
    public function switchStatus($id)
    {
        if(!$balaipuspaga = DBalaiPuspagaRW::find(intval($id))){
            $this->responseCode = 404;
            $this->responseMessage = 'Data tidak di temukan';
            return response()->json($this->getResponse(), $this->responseCode);
        }

        DB::transaction(function () use($balaipuspaga) {
            $balaipuspaga->is_active = !$balaipuspaga->is_active;
            $balaipuspaga->save();
        });
        
        $this->responseCode = 200;
        $this->responseMessage = boolval($balaipuspaga->is_active) ? 'Data telah diaktifkan' : 'Data telah dinonaktifkan';
        $this->responseData = $balaipuspaga;
        return response()->json($this->getResponse(), $this->responseCode);
    }

    public function lists(Request $request)
    {
        try {
            $limit = $request->limit ? intval($request->limit) : 10;
            
            $agama = DBalaiPuspagaRW::select('*');
            if($request->filled('search')){
                $agama->where(DB::raw('lower(name)'), 'like', '%' . strtolower($request->search) . '%');
            }
            if($request->filled('id_kelurahan')){
                $agama->where('id_kelurahan', $request->id_kelurahan);
            }
            $agama = $agama->where('is_active', true)->take($limit)->orderBy('name', 'ASC')->get();

            $this->responseCode = 200;
            $this->responseData = $agama;
            return response()->json($this->getResponse(), $this->responseCode);
        } catch (\Exception $e) {
            $this->responseCode = 500;
            $this->responseMessage = $e->getMessage();
            return response()->json($this->getResponse(), $this->responseCode);
        }
    }

    public function export(Request $req)
    {
        return Excel::download(new DBalaiPuspagaRWExport, 'Master Puspaga Balai RW.xlsx');    
    }

}
