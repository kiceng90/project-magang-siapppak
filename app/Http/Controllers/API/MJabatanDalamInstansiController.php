<?php

namespace App\Http\Controllers\API;

use App\Exports\MJabatanDalamInstansiExport;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\MJabatanDalamInstansi;

use DB;
use Validator;

class MJabatanDalamInstansiController extends Controller
{
    public function index(Request $req)
    {
        $limit = $req->limit ? intval($req->limit) : 10;
        $order = $req->order ? $req->order : 'DESC';
        $sortby = $req->sortby ? $req->sortby : 'id';

        $jabatan = MJabatanDalamInstansi::select('*');

        if ($req->filled('search')) {
            $jabatan->where('name', 'ILIKE', '%' . $req->search . '%');
        }

        $data = $jabatan->orderBy($sortby, $order)->paginate($limit);
        $this->saveLog($data);
        return $data;
    }

    public function indexPublic(Request $req)
    {
        $limit = $req->limit ? intval($req->limit) : 0;
        $order = $req->order ? $req->order : 'ASC';
        $sortby = $req->sortby ? $req->sortby : 'id';

        $jabatan = MJabatanDalamInstansi::select('*');

        $data = $jabatan->orderBy($sortby, $order)->paginate($limit);
        $this->saveLog($data);
        return $data;
    }


    public function store(Request $req)
    {
        $validator = Validator::make($req->all(), ['name' => 'required|string|iunique:m_jabatan_dalam_instansi,name']);
        if ($validator->fails()) {
            $this->responseCode = 422;
            $this->responseMessage = $validator->errors()->first();
            $this->responseData = $validator->errors();
            return response()->json($this->getResponse(), $this->responseCode);
        }

        DB::transaction(function () use ($req) {
            $jabatan = MJabatanDalamInstansi::create([
                'name' => $req->name,
            ]);
        });

        $this->responseCode = 201;
        return response()->json($this->getResponse(), $this->responseCode);
    }

    public function show($id)
    {
        if (!$jabatan = MJabatanDalamInstansi::find(intval($id))) {
            $this->responseCode = 404;
            $this->responseMessage = 'Data tidak di temukan';
            return response()->json($this->getResponse(), $this->responseCode);
        }

        $this->responseCode = 200;
        $this->responseData = $jabatan;
        return response()->json($this->getResponse(), $this->responseCode);
    }

    public function update(Request $req, $id)
    {
        if (!$jabatan = MJabatanDalamInstansi::find(intval($id))) {
            $this->responseCode = 404;
            $this->responseMessage = 'Data tidak di temukan';
            return response()->json($this->getResponse(), $this->responseCode);
        }

        $validator = Validator::make($req->all(), ['name' => 'required|string|iunique:m_jabatan_dalam_instansi,name,' . $id]);
        if ($validator->fails()) {
            $this->responseCode = 422;
            $this->responseMessage = $validator->errors()->first();
            $this->responseData = $validator->errors();
            return response()->json($this->getResponse(), $this->responseCode);
        }

        DB::transaction(function () use ($jabatan, $req) {
            $jabatan->name = $req->name;
            $jabatan->save();
        });

        $this->responseCode = 200;
        $this->responseData = $jabatan;
        return response()->json($this->getResponse(), $this->responseCode);
    }

    public function switchStatus($id)
    {
        if (!$jabatan = MJabatanDalamInstansi::find(intval($id))) {
            $this->responseCode = 404;
            $this->responseMessage = 'Data tidak di temukan';
            return response()->json($this->getResponse(), $this->responseCode);
        }

        DB::transaction(function () use ($jabatan) {
            $jabatan->is_active = !$jabatan->is_active;
            $jabatan->save();
        });

        $this->responseCode = 200;
        $this->responseMessage = boolval($jabatan->is_active) ? 'Data telah diaktifkan' : 'Data telah dinonaktifkan';
        $this->responseData = $jabatan;
        return response()->json($this->getResponse(), $this->responseCode);
    }
    public function export(Request $req)
    {
        return Excel::download(new MJabatanDalamInstansiExport, 'Master Jabatan Dalam Instansi.xlsx');    
    }

}
