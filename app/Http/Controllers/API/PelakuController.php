<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\Pelaku;
use App\Models\Penjangkauan;
use App\Http\Resources\PelakuResource;

class PelakuController extends Controller
{
    public function store(Request $req, $id_penjangkauan)
    {
        try {
            DB::beginTransaction();

            $id_penjangkauan = intval($id_penjangkauan);
            $req->request->add(['id_penjangkauan' => $id_penjangkauan]);
            $rules = [
                // identitas pelaku
                'id_penjangkauan' => 'required|exists:App\Models\Penjangkauan,id,deleted_at,NULL',
                'nama' => 'required_if:is_publish,1|string',
                'jenis_kelamin' => 'required_if:is_publish,1|in:1,2',
                'kewarganegaraan' => 'required_if:is_publish,1|in:1,2',
                'id_hubungan' => 'required_if:is_publish,1|exists:App\Models\MHubungan,id,deleted_at,NULL',
                'id_kabupaten_lahir' => 'nullable|exists:App\Models\MKabupaten,id,deleted_at,NULL',
                'tanggal_lahir' => 'nullable|date',
                'nomor_telepon' => 'nullable|string',
                'nomor_nik' => 'nullable|numeric',
                'nomor_kk' => 'nullable|numeric',
                'alamat_domisili' => 'nullable|string',
                'id_kelurahan_domisili' => 'nullable|exists:App\Models\MKelurahan,id,deleted_at,NULL',
                'alamat_kk' => 'nullable|string',
                'id_kelurahan_kk' => 'nullable|exists:App\Models\MKelurahan,id,deleted_at,NULL',
                'id_agama' => 'nullable|exists:App\Models\MAgama,id,deleted_at,NULL',
                'id_pekerjaan' => 'nullable|exists:App\Models\MPekerjaan,id,deleted_at,NULL',
                'id_status_pernikahan' => 'nullable|exists:App\Models\MStatusPernikahan,id,deleted_at,NULL',
                
                // pendidikan terkahir
                'id_pendidikan' => 'nullable|exists:App\Models\MPendidikanTerakhir,id,deleted_at,NULL',
                'id_jurusan' => 'nullable|exists:App\Models\MJurusan,id,deleted_at,NULL',
                'kelas' => 'nullable|numeric',
                'tahun_lulus' => 'nullable|numeric',
                'nama_sekolah' => 'nullable|string',
            ];
            $validator = Validator::make($req->all(), $rules);
            if ($validator->fails()) {
                $this->responseCode = 422;
                $this->responseMessage = $validator->errors()->first();
                $this->responseData = $validator->errors();
                return response()->json($this->getResponse(), $this->responseCode);
            }

            $words = explode(" ", $req->nama);
            $initial = "";

            foreach ($words as $w) {
                $initial .= mb_substr($w, 0, 1);
            }
            $pelaku = Pelaku::where('id_penjangkauan', $id_penjangkauan)->first();
            if(!$pelaku){
                $pelaku = new Pelaku();
                $pelaku->id_penjangkauan = $id_penjangkauan;
            }else{
                if(in_array(auth()->user()->id_role, [config('env.role.subkord'), config('env.role.kabid')])){
                    $pelaku->stopUserstamping();
                }
            }

            $pelaku->name                  = $req->nama;
            $pelaku->initials_name         = strtoupper($initial);
            $pelaku->gender                = $req->jenis_kelamin;
            $pelaku->citizenship           = $req->kewarganegaraan;
            $pelaku->id_hubungan           = $req->id_hubungan;
            $pelaku->id_kabupaten_lahir    = $req->id_kabupaten_lahir;
            $pelaku->birth_date            = $req->tanggal_lahir;
            $pelaku->phone_number          = $req->nomor_telepon;
            $pelaku->nik_number            = $req->nomor_nik;
            $pelaku->kk_number             = $req->nomor_kk;
            $pelaku->residence_address     = $req->alamat_domisili;
            $pelaku->id_kelurahan_tinggal  = $req->id_kelurahan_domisili;
            $pelaku->kk_address            = $req->alamat_kk;
            $pelaku->id_kelurahan_kk       = $req->id_kelurahan_kk;
            $pelaku->id_agama              = $req->id_agama;
            $pelaku->id_pekerjaan          = $req->id_pekerjaan;
            $pelaku->id_status_pernikahan  = $req->id_status_pernikahan;

            // pendidikan terakhir
            $pelaku->id_pendidikan_terakhir= $req->id_pendidikan;
            $pelaku->id_jurusan            = $req->id_jurusan;
            $pelaku->highest_class         = $req->kelas;
            $pelaku->graduation_year       = $req->tahun_lulus;
            $pelaku->school_name           = $req->nama_sekolah;
            $pelaku->save();

            $penjangkauan = Penjangkauan::find($id_penjangkauan);
            if($req->is_publish){
                $penjangkauan->pelaku_draft_status = false;
            }else{
                $penjangkauan->pelaku_draft_status = true;
            }
            $penjangkauan->save();

            DB::commit();
            $this->responseCode = 200;
            $this->responseData = $pelaku;
            return response()->json($this->getResponse(), $this->responseCode);
        } catch (\Exception $e) {
            $this->responseCode = 500;
            $this->responseMessage = $e->getMessage();
            DB::rollback();
            return response()->json($this->getResponse(), $this->responseCode);
        }
    }

    public function show($id_penjangkauan)
    {
        try {
            $pelaku = Pelaku::where('id_penjangkauan', intval($id_penjangkauan))->first();
            if(!$pelaku){
                $this->responseData = null;
            }else{
                $this->responseData = new PelakuResource($pelaku);
            }
            $this->responseCode = 200;
        } catch (\Exception $e) {
            $this->responseCode = 500;
            $this->responseMessage = $e->getMessage();
        }
        return response()->json($this->getResponse(), $this->responseCode);
    }
}
