<?php

namespace App\Http\Controllers\API;

use App\Enums\JenisMahasiswaStatusEnum;
use App\Http\Controllers\Controller;
use App\Models\MJenisMahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class MJenisMahasiswaController extends Controller
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

            $jenismahasiswa = MJenisMahasiswa::select('*');
            if($request->filled('search')){
                $jenismahasiswa->where(DB::raw('lower(name)'), 'like', '%' . strtolower($request->search) . '%');
            }
            $jenismahasiswa = $jenismahasiswa->orderBy($sortby, $order)->paginate($limit);

            $this->saveLog($jenismahasiswa);
            return $jenismahasiswa;
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
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $this->responseCode = 422;
                $this->responseMessage = $validator->errors()->first();
                $this->responseData = $validator->errors();
                return response()->json($this->getResponse(), $this->responseCode);
            }

            $jenismahasiswa = MJenisMahasiswa::create([
                'name' => ($request->name)
            ]);

            DB::commit();
            $this->responseCode = 201;
            $this->responseData = $jenismahasiswa;
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
            $jenismahasiswa = MJenisMahasiswa::find($id);
            if(!$jenismahasiswa){
                $this->responseCode = 404;
                $this->responseMessage = 'Data tidak di temukan';
                return response()->json($this->getResponse(), $this->responseCode);
            }

            $this->responseCode = 200;
            $this->responseData = $jenismahasiswa;
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
            $jenismahasiswa = MJenisMahasiswa::find($id);
            if(!$jenismahasiswa){
                $this->responseCode = 404;
                $this->responseMessage = 'Data tidak di temukan';
                return response()->json($this->getResponse(), $this->responseCode);
            }

            $rules = [
                'name' => 'required|string'
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $this->responseCode = 422;
                $this->responseMessage = $validator->errors()->first();
                $this->responseData = $validator->errors();
                return response()->json($this->getResponse(), $this->responseCode);
            }

            $jenismahasiswa->name = ($request->name);
            $jenismahasiswa->status = $request->status;
            $jenismahasiswa->save();

            DB::commit();
            $this->responseCode = 200;
            $this->responseData = $jenismahasiswa;
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
            $jenismahasiswa = MJenisMahasiswa::find($id);
            if(!$jenismahasiswa){
                $this->responseCode = 404;
                $this->responseMessage = 'Data tidak di temukan';
                return response()->json($this->getResponse(), $this->responseCode);
            }

            $jenismahasiswa->delete();

            $this->responseCode = 200;
            $this->responseMessage = 'Berhasil menghapus data';
            $this->responseData = $jenismahasiswa;
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
            
            $jenismahasiswa = MJenisMahasiswa::select('*');
            if($request->filled('search')){
                $jenismahasiswa->where(DB::raw('lower(name)'), 'like', '%' . strtolower($request->search) . '%');
            }
            $jenismahasiswa = $jenismahasiswa->orderBy('name', 'ASC')->get();

            $this->responseCode = 200;
            $this->responseData = $jenismahasiswa;
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
            $jenismahasiswa = MJenisMahasiswa::find($id);
            if(!$jenismahasiswa){
                $this->responseCode = 404;
                $this->responseMessage = 'Data tidak di temukan';
                return response()->json($this->getResponse(), $this->responseCode);
            }

            DB::beginTransaction();

            $jenismahasiswa->update([
                'is_active' => !$jenismahasiswa->is_active
            ]);

            $this->responseCode = 200;
            $this->responseMessage = boolval($jenismahasiswa->is_active) ? 'Jenis mahasiswa telah diaktifkan' : 'Jenis mahasiswa telah dinonaktifkan';
            $this->responseData = $jenismahasiswa;
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