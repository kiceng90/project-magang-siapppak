<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\MKedudukanDalamTimExport;
use App\Models\MKedudukanDalamTim;

use DB;
use Validator;

class MKedudukanDalamTimController extends Controller
{
    public function index(Request $req)
    {
        $limit = $req->limit ? intval($req->limit) : 10;
        $order = $req->order ? $req->order : 'DESC';
        $sortby = $req->sortby ? $req->sortby : 'id';

        $kedudukan = MKedudukanDalamTim::select('*');

        if($req->filled('search')){
            $kedudukan->where('name', 'ILIKE', '%'. $req->search .'%');
        }

        $data = $kedudukan->orderBy($sortby, $order)->paginate($limit);
        $this->saveLog($data);
        return $data;
    }

    public function store(Request $req)
    {
        $validator = Validator::make($req->all(), ['name' => 'required|string|iunique:m_kedudukan_dalam_tim,name']);
        if ($validator->fails()) {
            $this->responseCode = 422;
            $this->responseMessage = $validator->errors()->first();
            $this->responseData = $validator->errors();
            return response()->json($this->getResponse(), $this->responseCode);
        }

        DB::transaction(function () use($req) {
            $kedudukan = MKedudukanDalamTim::create([
                'name' => $req->name,
            ]);
        });
        
        $this->responseCode = 201;
        return response()->json($this->getResponse(), $this->responseCode);
    }

    public function show($id)
    {
        if(!$kedudukan = MKedudukanDalamTim::find(intval($id))){
            $this->responseCode = 404;
            $this->responseMessage = 'Data tidak di temukan';
            return response()->json($this->getResponse(), $this->responseCode);
        }

        $this->responseCode = 200;
        $this->responseData = $kedudukan;
        return response()->json($this->getResponse(), $this->responseCode);
    }

    public function update(Request $req, $id)
    {
        if(!$kedudukan = MKedudukanDalamTim::find(intval($id))){
            $this->responseCode = 404;
            $this->responseMessage = 'Data tidak di temukan';
            return response()->json($this->getResponse(), $this->responseCode);
        }

        $validator = Validator::make($req->all(), ['name' => 'required|string|iunique:m_kedudukan_dalam_tim,name,'. $id]);
        if ($validator->fails()) {
            $this->responseCode = 422;
            $this->responseMessage = $validator->errors()->first();
            $this->responseData = $validator->errors();
            return response()->json($this->getResponse(), $this->responseCode);
        }

        DB::transaction(function () use($kedudukan, $req) {
            $kedudukan->name = $req->name;
            $kedudukan->save();
        });
        
        $this->responseCode = 200;
        $this->responseData = $kedudukan;
        return response()->json($this->getResponse(), $this->responseCode);
    }

    public function switchStatus($id)
    {
        if(!$kedudukan = MKedudukanDalamTim::find(intval($id))){
            $this->responseCode = 404;
            $this->responseMessage = 'Data tidak di temukan';
            return response()->json($this->getResponse(), $this->responseCode);
        }

        DB::transaction(function () use($kedudukan) {
            $kedudukan->is_active = !$kedudukan->is_active;
            $kedudukan->save();
        });
        
        $this->responseCode = 200;
        $this->responseMessage = boolval($kedudukan->is_active) ? 'Data telah diaktifkan' : 'Data telah dinonaktifkan';
        $this->responseData = $kedudukan;
        return response()->json($this->getResponse(), $this->responseCode);
    }

    public function export(Request $req)
    {
        return Excel::download(new MKedudukanDalamTimExport, 'Master Jabatan Dalam SK.xlsx');    
    }

}
