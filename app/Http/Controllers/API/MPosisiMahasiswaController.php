<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\MPosisiMahasiswa;

class MPosisiMahasiswaController extends Controller
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

            $posisi = MPosisiMahasiswa::select('*');
            if($request->filled('search')){
                $posisi->where(DB::raw('lower(name)'), 'like', '%' . strtolower($request->search) . '%');
            }
            $posisi = $posisi->orderBy($sortby, $order)->paginate($limit);

            $this->saveLog($posisi);
            return $posisi;
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
    //             'name' => 'required|string|iunique:m_posisi_mahasiswa,name',
    //         ];
    //         $validator = Validator::make($request->all(), $rules);
    //         if ($validator->fails()) {
    //             $this->responseCode = 422;
    //             $this->responseMessage = $validator->errors()->first();
    //             $this->responseData = $validator->errors();
    //             return response()->json($this->getResponse(), $this->responseCode);
    //         }

    //         $posisi = MPosisiMahasiswa::create([
    //             'name' => $request->name,
    //         ]);

    //         DB::commit();
    //         $this->responseCode = 201;
    //         $this->responseData = $posisi;
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
            'name' => 'required|string|unique:m_posisi_mahasiswa,name',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $this->responseCode = 422;
            $this->responseMessage = $validator->errors()->first();
            $this->responseData = $validator->errors();
            return response()->json($this->getResponse(), $this->responseCode);
        }

        $posisi = new MPosisiMahasiswa();
        $posisi->name = $request->name;
        $posisi->save();

        DB::commit();
        
        $this->responseCode = 201;
        $this->responseData = $posisi;
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
            $posisi = MPosisiMahasiswa::find($id);
            if(!$posisi){
                $this->responseCode = 404;
                $this->responseMessage = 'Data tidak di temukan';
                return response()->json($this->getResponse(), $this->responseCode);
            }

            $this->responseCode = 200;
            $this->responseData = $posisi;
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
            $posisi = MPosisiMahasiswa::find($id);
            if(!$posisi){
                $this->responseCode = 404;
                $this->responseMessage = 'Data tidak di temukan';
                return response()->json($this->getResponse(), $this->responseCode);
            }

            $rules = ['name' => 'required|string|iunique:m_posisi_mahasiswa,name,'. $id];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $this->responseCode = 422;
                $this->responseMessage = $validator->errors()->first();
                $this->responseData = $validator->errors();
                return response()->json($this->getResponse(), $this->responseCode);
            }

            $posisi->name = $request->name;
            $posisi->save();
            dd($posisi);

            DB::commit();
            $this->responseCode = 200;
            $this->responseData = $posisi;
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
            $posisi = MPosisiMahasiswa::find($id);
            if(!$posisi){
                $this->responseCode = 404;
                $this->responseMessage = 'Data tidak di temukan';
                return response()->json($this->getResponse(), $this->responseCode);
            }

            $posisi->delete();

            $this->responseCode = 200;
            $this->responseMessage = 'Berhasil menghapus data';
            $this->responseData = $posisi;
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
            
            $posisi = MPosisiMahasiswa::select('*');
            if($request->filled('search')){
                $posisi->where(DB::raw('lower(name)'), 'like', '%' . strtolower($request->search) . '%');
            }
            $posisi = $posisi->where('m_posisi_mahasiswa.is_active', true)->take($limit)->orderBy('name', 'ASC')->get();

            $this->responseCode = 200;
            $this->responseData = $posisi;
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
            $posisi = MPosisiMahasiswa::select('*');
            $posisi = $posisi->where('m_posisi_mahasiswa.is_active', true)->orderBy('name', 'ASC')->get();

            $this->responseCode = 200;
            $this->responseData = $posisi;
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
            $posisi = MPosisiMahasiswa::find($id);
            if(!$posisi){
                $this->responseCode = 404;
                $this->responseMessage = 'Data tidak di temukan';
                return response()->json($this->getResponse(), $this->responseCode);
            }

            DB::beginTransaction();

            $posisi->update([
                'is_active' => !$posisi->is_active
            ]);

            $this->responseCode = 200;
            $this->responseMessage = boolval($posisi->is_active) ? 'posisi mahasiswa telah diaktifkan' : 'posisi mahasiswa telah dinonaktifkan';
            $this->responseData = $posisi;
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