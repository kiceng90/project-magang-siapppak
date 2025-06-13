<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\MJadwalKonselingDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class MJadwalKonselingDetailController extends Controller
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

            $jadwal_konseling = MJadwalKonselingDetail::query();

            $kategorimitra = $jadwal_konseling->orderBy($sortby, $order)->with('jadwal')->paginate($limit);

            $this->saveLog($kategorimitra);
            return $kategorimitra;
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
                'id_jadwal_konseling' => 'required|exists:App\Models\MJadwalKonseling,id,deleted_at,NULL',
                'start_time' => 'required|string|date_format:H:i|before:end_time',
                'end_time' => 'required|string|date_format:H:i|after:start_time',
                'id_kategori_konseling' => 'required|exists:App\Models\MKategoriKonseling,id,deleted_at,NULL',
                'is_active' => 'required|boolean'
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $this->responseCode = 422;
                $this->responseMessage = $validator->errors()->first();
                $this->responseData = $validator->errors();
                return response()->json($this->getResponse(), $this->responseCode);
            }

            $jadwal_konseling = MJadwalKonselingDetail::create([
                'id_jadwal_konseling' => $request->id_jadwal_konseling,
                'start_time' => $request->start_time,
                'end_time' => $request->end_time,
                'id_kategori_konseling' => $request->id_kategori_konseling,
                'is_active' => $request->is_active
            ]);

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
            $jadwal_konseling = MJadwalKonselingDetail::where('id', $id)->with('jadwal')->first();
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
            $jadwal_konseling = MJadwalKonselingDetail::find($id);
            if(!$jadwal_konseling){
                $this->responseCode = 404;
                $this->responseMessage = 'Data tidak di temukan';
                return response()->json($this->getResponse(), $this->responseCode);
            }

            $rules = [
                'id_jadwal_konseling' => 'required|exists:App\Models\MJadwalKonseling,id,deleted_at,NULL',
                'start_time' => 'required|string|date_format:H:i|before:end_time',
                'end_time' => 'required|string|date_format:H:i|after:start_time',
                'id_kategori_konseling' => 'required|exists:App\Models\MKategoriKonseling,id,deleted_at,NULL',
                'is_active' => 'required|boolean'
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $this->responseCode = 422;
                $this->responseMessage = $validator->errors()->first();
                $this->responseData = $validator->errors();
                return response()->json($this->getResponse(), $this->responseCode);
            }

            $jadwal_konseling->id_jadwal_konseling = $request->id_jadwal_konseling;
            $jadwal_konseling->start_time = $request->start_time;
            $jadwal_konseling->end_time = $request->end_time;
            $jadwal_konseling->id_kategori_konseling = $request->id_kategori_konseling;
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
            $jadwal_konseling = MJadwalKonselingDetail::find($id);
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
    public function switchStatus($id)
    {
        if(!$jadwal_konseling = MJadwalKonselingDetail::find(intval($id))){
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
