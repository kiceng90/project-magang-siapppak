<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\Penjangkauan;
use App\Models\KondisiKlien;

class KondisiKlienController extends Controller
{
    public function store(Request $req, $id_penjangkauan)
    {
        try {
            DB::beginTransaction();

            $id_penjangkauan = intval($id_penjangkauan);
            $req->request->add(['id_penjangkauan' => $id_penjangkauan]);

            $rules = [
                'id_penjangkauan' => 'required|exists:App\Models\Penjangkauan,id,deleted_at,NULL',
                'kondisi_fisik' => 'nullable|string',
                'kondisi_psikologis' => 'nullable|string',
                'kondisi_sosial' => 'nullable|string',
                'kondisi_spiritual' => 'nullable|string',
            ];
            $validator = Validator::make($req->all(), $rules);
            if ($validator->fails()) {
                $this->responseCode = 422;
                $this->responseMessage = $validator->errors()->first();
                $this->responseData = $validator->errors();
                return response()->json($this->getResponse(), $this->responseCode);
            }

            $kondisi = KondisiKlien::where('id_penjangkauan', $id_penjangkauan)->first();
            if(!$kondisi){
                $kondisi = new KondisiKlien();
                $kondisi->id_penjangkauan = $id_penjangkauan;
            }else{
                if(in_array(auth()->user()->id_role, [config('env.role.subkord'), config('env.role.kabid')])){
                    $kondisi->stopUserstamping();
                }
            }

            $kondisi->physical_description = $req->kondisi_fisik;
            $kondisi->psycological_description = $req->kondisi_psikologis;
            $kondisi->social_description = $req->kondisi_sosial;
            $kondisi->spiritual_description = $req->kondisi_spiritual;
            $kondisi->save();

            $penjangkauan = Penjangkauan::find($id_penjangkauan);
            if($req->is_publish){
                $penjangkauan->kondisi_klien_draft_status = false;
            }else{
                $penjangkauan->kondisi_klien_draft_status = true;
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
            $kondisi = KondisiKlien::where('id_penjangkauan', intval($id_penjangkauan))->first();
            if(!$kondisi){
                $this->responseCode = 404;
                $this->responseMessage = 'Data tidak ditemukan';
                return response()->json($this->getResponse(), $this->responseCode);
            }

            $this->responseCode = 200;
            $this->responseData = $kondisi;
            return response()->json($this->getResponse(), $this->responseCode);
        } catch (\Exception $e) {
            $this->responseCode = 500;
            $this->responseMessage = $e->getMessage();
            return response()->json($this->getResponse(), $this->responseCode);
        }
    }
}
