<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\MJadwalKonseling;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Helpers\DayEnum;
use App\Models\MJadwalKonselingDetail;
use App\Models\MKonselor;
use App\Models\PsikologVolunteer;
use Illuminate\Pagination\LengthAwarePaginator;

class MJadwalKonselingController extends Controller
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

            $jadwal_konseling = collect();

            $jadwal_konseling_konselor = MKonselor::query()->has('jadwal')->select("id", "name", "phone_number");
            if ($request->filled('id_kategori_konseling')) {
                $jadwal_konseling_konselor->whereHas('jadwal.jadwalDetail', function ($query) use ($request) {
                    $query->whereIn('id_kategori_konseling', $request->id_kategori_konseling);
                });
            }
            $jadwal_konseling_konselor->with('jadwal:*', 'jadwal.jadwalDetail:*');
            $jadwal_konseling_konselor = $jadwal_konseling_konselor->get();
            $jadwal_konseling->push($jadwal_konseling_konselor);

            $jadwal_konseling_psikolog = PsikologVolunteer::query()->has('jadwal')->select("id", "name", "no_hp AS phone_number");
            if ($request->filled('id_kategori_konseling')) {
                $jadwal_konseling_psikolog->whereHas('jadwal.jadwalDetail', function ($query) use ($request) {
                    $query->whereIn('id_kategori_konseling', $request->id_kategori_konseling);
                });
            }
            $jadwal_konseling_psikolog->with('jadwal.jadwalDetail');
            $jadwal_konseling_psikolog = $jadwal_konseling_psikolog->get();
            $jadwal_konseling->push($jadwal_konseling_psikolog);
            // $jadwal_konseling = collect($jadwal_konseling_konselor->merge($jadwal_konseling_psikolog))->{'sortBy'.$order}($sortby);

            // $totaldata = $jadwal_konseling->count();
            // $data = $totaldata > 0 ? array_values($jadwal_konseling->forPage($request->page, $limit)->all()) : [];

            $jadwal_konseling = $jadwal_konseling->collapse();
            
            $page = $request->get('page', 1);
            $offset = ($page - 1) * $limit;
            $data = $jadwal_konseling->slice($offset, $limit);
            $totaldata = $jadwal_konseling->count();
            $result = new LengthAwarePaginator($data, $totaldata, $limit, $page, [
                'path' => $request->url(),
                'query' => $request->query(),
            ]);

            $this->saveLog($result);
            return $result;
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
                'id_konselor' => 'required_without:id_psikolog_volunteer|exists:App\Models\MKonselor,id,deleted_at,NULL',
                'id_psikolog_volunteer' => 'required_without:id_konselor|exists:App\Models\PsikologVolunteer,id,deleted_at,NULL',
                'day' => 'required|numeric',
                'is_active' => 'required|boolean',
                'detail' => 'required|array|min:1',
                'detail.*.start_time' => 'required|string|date_format:H:i|before:end_time',
                'detail.*.end_time' => 'required|string|date_format:H:i|after:start_time',
                'detail.*.id_kategori_konseling' => 'required|exists:App\Models\MKategoriKonseling,id,deleted_at,NULL'
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $this->responseCode = 422;
                $this->responseMessage = $validator->errors()->first();
                $this->responseData = $validator->errors();
                return response()->json($this->getResponse(), $this->responseCode);
            }

            $jadwal_konseling = MJadwalKonseling::create([
                'id_konselor' => $request->id_konselor,
                'id_psikolog_volunteer' => $request->id_psikolog_volunteer,
                'day' => $request->day,
                'is_active' => $request->is_active
            ]);

            foreach ($request->detail as $key => $detail) {
                $jadwal_konseling_detail[$key] = MJadwalKonselingDetail::create([
                    'id_jadwal_konseling' => $jadwal_konseling->id,
                    'start_time' => $detail['start_time'],
                    'end_time' => $detail['end_time'],
                    'id_kategori_konseling' => $detail['id_kategori_konseling'],
                    'is_active' => $request->is_active
                ]);
            }

            $jadwal_konseling->detail = $jadwal_konseling_detail;

            DB::commit();
            $this->responseCode = 201;
            $this->responseData = $jadwal_konseling;
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
            $jadwal_konseling = MJadwalKonseling::where('id', $id)->with('jadwalDetail')->with('konselor')->first();
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
            $jadwal_konseling = MJadwalKonseling::find($id);
            if(!$jadwal_konseling){
                $this->responseCode = 404;
                $this->responseMessage = 'Data tidak di temukan';
                return response()->json($this->getResponse(), $this->responseCode);
            }

            $rules = [
                'id_konselor' => 'required_without:id_psikolog_volunteer|exists:App\Models\MKonselor,id,deleted_at,NULL',
                'id_psikolog_volunteer' => 'required_without:id_konselor|exists:App\Models\PsikologVolunteer,id,deleted_at,NULL',
                'day' => 'required|numeric',
                'is_active' => 'required|boolean'
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $this->responseCode = 422;
                $this->responseMessage = $validator->errors()->first();
                $this->responseData = $validator->errors();
                return response()->json($this->getResponse(), $this->responseCode);
            }

            $jadwal_konseling->id_konselor = $request->id_konselor;
            $jadwal_konseling->id_psikolog_volunteer = $request->id_psikolog_volunteer;
            $jadwal_konseling->day = $request->day;
            $jadwal_konseling->is_active = $request->is_active;
            $jadwal_konseling->save();

            DB::commit();
            $this->responseCode = 200;
            $this->responseData = $jadwal_konseling;
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
            $jadwal_konseling = MJadwalKonseling::find($id);
            if(!$jadwal_konseling){
                $this->responseCode = 404;
                $this->responseMessage = 'Data tidak di temukan';
                return response()->json($this->getResponse(), $this->responseCode);
            }

            $jadwal_konseling->delete();

            $this->responseCode = 200;
            $this->responseMessage = 'Berhasil menghapus data';
            $this->responseData = $jadwal_konseling;
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
            $limit = $request->limit ? intval($request->limit) : 10;
            $order = $request->order ? $request->order : 'DESC';
            $sortby = $request->sortby ? $request->sortby : 'id';

            $jadwal_konseling = MKonselor::query()->has('jadwalActive');
            if($request->filled('id_kategori_konseling')){
                $jadwal_konseling->whereHas('jadwalActive.jadwalDetailActive', function($query) use($request) {
                    $query->whereIn('id_kategori_konseling',$request->id_kategori_konseling);
                });
            }
            $jadwal_konseling->with('jadwalActive.jadwalDetail');
            $jadwal_konseling = $jadwal_konseling->orderBy($sortby, $order)->paginate($limit);

            $this->saveLog($jadwal_konseling);
            return $jadwal_konseling;
        } catch (\Exception $e) {
            $this->responseCode = 500;
            $this->responseMessage = $e->getMessage();
            return response()->json($this->getResponse(), $this->responseCode);
        }
    }
    public function switchStatus($id)
    {
        if(!$jadwal_konseling = MJadwalKonseling::find(intval($id))){
            $this->responseCode = 404;
            $this->responseMessage = 'Data tidak di temukan';
            return response()->json($this->getResponse(), $this->responseCode);
        }

        DB::transaction(function () use($jadwal_konseling) {
            $jadwal_konseling->is_active = !$jadwal_konseling->is_active;
            $jadwal_konseling->save();
        });
        
        $this->responseCode = 200;
        $this->responseMessage = boolval($jadwal_konseling->is_active) ? 'Data telah diaktifkan' : 'Data telah dinonaktifkan';
        $this->responseData = $jadwal_konseling;
        return response()->json($this->getResponse(), $this->responseCode);
    }
}
