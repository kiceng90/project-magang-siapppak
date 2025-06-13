<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\MInstansiPendidikanExport;
use App\Exports\MInstansiPendidikaSheetExport;
use App\Models\MInstansiPendidikan;

use DB;
use Validator;

class MInstansiPendidikanController extends Controller
{
    public function index(Request $req)
    {
        $limit = $req->limit ? intval($req->limit) : 10;
        $order = $req->order ? $req->order : 'DESC';
        $sortby = $req->sortby ? $req->sortby : 'id';

        $instansi = MInstansiPendidikan::select('*');

        if($req->filled('search')){
            $instansi->where('name', 'ILIKE', '%'. $req->search .'%');
        }

        $data = $instansi->orderBy($sortby, $order)->paginate($limit);
        $this->saveLog($data);
        return $data;
    }

    public function store(Request $req)
    {
        $validator = Validator::make($req->all(), ['name' => 'required|string|iunique:m_instansi_pendidikan,name']);
        if ($validator->fails()) {
            $this->responseCode = 422;
            $this->responseMessage = $validator->errors()->first();
            $this->responseData = $validator->errors();
            return response()->json($this->getResponse(), $this->responseCode);
        }

        DB::transaction(function () use($req) {
            $instansi = MInstansiPendidikan::create([
                'name' => $req->name,
            ]);
        });
        
        $this->responseCode = 201;
        return response()->json($this->getResponse(), $this->responseCode);
    }

    public function show($id)
    {
        if(!$instansi = MInstansiPendidikan::find(intval($id))){
            $this->responseCode = 404;
            $this->responseMessage = 'Data tidak di temukan';
            return response()->json($this->getResponse(), $this->responseCode);
        }

        $this->responseCode = 200;
        $this->responseData = $instansi;
        return response()->json($this->getResponse(), $this->responseCode);
    }

    public function update(Request $req, $id)
    {
        if(!$instansi = MInstansiPendidikan::find(intval($id))){
            $this->responseCode = 404;
            $this->responseMessage = 'Data tidak di temukan';
            return response()->json($this->getResponse(), $this->responseCode);
        }

        $validator = Validator::make($req->all(), ['name' => 'required|string|iunique:m_instansi_pendidikan,name,'. $id]);
        if ($validator->fails()) {
            $this->responseCode = 422;
            $this->responseMessage = $validator->errors()->first();
            $this->responseData = $validator->errors();
            return response()->json($this->getResponse(), $this->responseCode);
        }

        DB::transaction(function () use($instansi, $req) {
            $instansi->name = $req->name;
            $instansi->save();
        });
        
        $this->responseCode = 200;
        $this->responseData = $instansi;
        return response()->json($this->getResponse(), $this->responseCode);
    }

    public function switchStatus($id)
    {
        if(!$instansi = MInstansiPendidikan::find(intval($id))){
            $this->responseCode = 404;
            $this->responseMessage = 'Data tidak di temukan';
            return response()->json($this->getResponse(), $this->responseCode);
        }

        DB::transaction(function () use($instansi) {
            $instansi->is_active = !$instansi->is_active;
            $instansi->save();
        });
        
        $this->responseCode = 200;
        $this->responseMessage = boolval($instansi->is_active) ? 'Data telah diaktifkan' : 'Data telah dinonaktifkan';
        $this->responseData = $instansi;
        return response()->json($this->getResponse(), $this->responseCode);
    }

    public function export(Request $req)
    {
        return Excel::download(new MInstansiPendidikanExport, 'Master Instansi Pendidikan.xlsx');    
    }

}
