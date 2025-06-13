<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\MJasaPelayanan;

class MJasaPelayananController extends Controller
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

            $jasa = MJasaPelayanan::select('*');
            if($request->filled('search')){
                $jasa->where(DB::raw('lower(name)'), 'like', '%' . strtolower($request->search) . '%');
            }
            $jasa = $jasa->orderBy($sortby, $order)->paginate($limit);

            $this->saveLog($jasa);
            return $jasa;
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
    // public function store(Request $request)
    // {
    //     try {
    //         DB::beginTransaction();

    //         $rules = [
    //             'name' => 'required|string|iunique:m_jasa_pelayanan,name',
    //         ];
    //         $validator = Validator::make($request->all(), $rules);
    //         if ($validator->fails()) {
    //             $this->responseCode = 422;
    //             $this->responseMessage = $validator->errors()->first();
    //             $this->responseData = $validator->errors();
    //             return response()->json($this->getResponse(), $this->responseCode);
    //         }

    //         $jasa = MJasaPelayanan::create([
    //             'name' => $request->name,
    //         ]);

    //         DB::commit();
    //         $this->responseCode = 201;
    //         $this->responseData = $jasa;
    //         return response()->json($this->getResponse(), $this->responseCode);
    //     } catch (\Exception $e) {
    //         $this->responseCode = 500;
    //         $this->responseMessage = $e->getMessage();
    //         DB::rollback();
    //         return response()->json($this->getResponse(), $this->responseCode);
    //     }
    // }


public function store(Request $request)
{
    try {
        DB::beginTransaction();

        $rules = [
            'name' => 'required|string|unique:m_jasa_pelayanan,name',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $this->responseCode = 422;
            $this->responseMessage = $validator->errors()->first();
            $this->responseData = $validator->errors();
            return response()->json($this->getResponse(), $this->responseCode);
        }

        $jasa = new MJasaPelayanan();
        $jasa->name = $request->name;
        $jasa->save();

        DB::commit();
        
        $this->responseCode = 201;
        $this->responseData = $jasa;
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
            $jasa = MJasaPelayanan::find($id);
            if(!$jasa){
                $this->responseCode = 404;
                $this->responseMessage = 'Data tidak di temukan';
                return response()->json($this->getResponse(), $this->responseCode);
            }

            $this->responseCode = 200;
            $this->responseData = $jasa;
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
            $jasa = MJasaPelayanan::find($id);
            if(!$jasa){
                $this->responseCode = 404;
                $this->responseMessage = 'Data tidak di temukan';
                return response()->json($this->getResponse(), $this->responseCode);
            }

            $rules = ['name' => 'required|string|iunique:m_jasa_pelayanan,name,'. $id];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $this->responseCode = 422;
                $this->responseMessage = $validator->errors()->first();
                $this->responseData = $validator->errors();
                return response()->json($this->getResponse(), $this->responseCode);
            }

            $jasa->name = $request->name;
            $jasa->save();
            dd($jasa);

            DB::commit();
            $this->responseCode = 200;
            $this->responseData = $jasa;
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
            $jasa = MJasaPelayanan::find($id);
            if(!$jasa){
                $this->responseCode = 404;
                $this->responseMessage = 'Data tidak di temukan';
                return response()->json($this->getResponse(), $this->responseCode);
            }

            $jasa->delete();

            $this->responseCode = 200;
            $this->responseMessage = 'Berhasil menghapus data';
            $this->responseData = $jasa;
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
            
            $jasa = MJasaPelayanan::select('*');
            if($request->filled('search')){
                $jasa->where(DB::raw('lower(name)'), 'like', '%' . strtolower($request->search) . '%');
            }
            $jasa = $jasa->where('m_jasa_pelayanan.is_active', true)->take($limit)->orderBy('name', 'ASC')->get();

            $this->responseCode = 200;
            $this->responseData = $jasa;
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
            $jasa = MJasaPelayanan::select('*');
            $jasa = $jasa->where('m_jasa_pelayanan.is_active', true)->orderBy('name', 'ASC')->get();

            $this->responseCode = 200;
            $this->responseData = $jasa;
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
            $jasa = MJasaPelayanan::find($id);
            if(!$jasa){
                $this->responseCode = 404;
                $this->responseMessage = 'Data tidak di temukan';
                return response()->json($this->getResponse(), $this->responseCode);
            }

            DB::beginTransaction();

            $jasa->update([
                'is_active' => !$jasa->is_active
            ]);

            $this->responseCode = 200;
            $this->responseMessage = boolval($jasa->is_active) ? 'Jasa Pelayanan telah diaktifkan' : 'Jasa Pelayanan telah dinonaktifkan';
            $this->responseData = $jasa;
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