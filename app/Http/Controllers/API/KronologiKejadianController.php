<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\Penjangkauan;
use App\Models\KronologiKejadian;

class KronologiKejadianController extends Controller
{
    public function store(Request $req, $id_penjangkauan)
    {
        try {
            DB::beginTransaction();

            $id_penjangkauan = intval($id_penjangkauan);
            $req->request->add(['id_penjangkauan' => $id_penjangkauan]);

            $rules = [
                'id_penjangkauan' => 'required|exists:App\Models\Penjangkauan,id,deleted_at,NULL',
                'description' => 'required|string',
            ];
            $validator = Validator::make($req->all(), $rules);
            if ($validator->fails()) {
                $this->responseCode = 422;
                $this->responseMessage = $validator->errors()->first();
                $this->responseData = $validator->errors();
                return response()->json($this->getResponse(), $this->responseCode);
            }

            $kronologi = KronologiKejadian::where('id_penjangkauan', $id_penjangkauan)->first();
            if(!$kronologi){
                $kronologi = new KronologiKejadian();
                $kronologi->id_penjangkauan = $id_penjangkauan;
            }else{
                if(in_array(auth()->user()->id_role, [config('env.role.subkord'), config('env.role.kabid')])){
                    $kronologi->stopUserstamping();
                }
            }

            $kronologi->description = $req->description;
            $kronologi->save();

            $penjangkauan = Penjangkauan::find($id_penjangkauan);
            if($req->is_publish){
                $penjangkauan->kronologi_kejadian_draft_status = false;
            }else{
                $penjangkauan->kronologi_kejadian_draft_status = true;
            }
            $penjangkauan->save();

            DB::commit();
            $this->responseCode = 200;
            return response()->json($this->getResponse(), $this->responseCode);
        } catch (\Exception $e) {
            DB::rollback();
            $this->responseCode = 500;
            $this->responseMessage = $e->getMessage();
            return response()->json($this->getResponse(), $this->responseCode);
        }
    }

    public function show($id_penjangkauan)
    {
        try {
            $kronologi = KronologiKejadian::where('id_penjangkauan', intval($id_penjangkauan))->first();
            if(!$kronologi){
                $this->responseCode = 404;
                $this->responseMessage = 'Data tidak ditemukan';
                return response()->json($this->getResponse(), $this->responseCode);
            }

            $this->responseCode = 200;
            $this->responseData = $kronologi;
            return response()->json($this->getResponse(), $this->responseCode);
        } catch (\Exception $e) {
            $this->responseCode = 500;
            $this->responseMessage = $e->getMessage();
            return response()->json($this->getResponse(), $this->responseCode);
        }
    }
}
