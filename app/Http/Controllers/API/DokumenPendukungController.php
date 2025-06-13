<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\Penjangkauan;
use App\Models\DokumenPendukung;
use Illuminate\Support\Facades\File;
use App\Http\Resources\DokumenPendukungResource;

class DokumenPendukungController extends Controller
{
    public function store(Request $req, $id_penjangkauan)
    {
        try {
            DB::beginTransaction();

            $id_penjangkauan = intval($id_penjangkauan);
            $req->request->add(['id_penjangkauan' => $id_penjangkauan]);

            $rules = [
                'id_penjangkauan' => 'required|exists:App\Models\Penjangkauan,id,deleted_at,NULL',

                'foto_klien' => 'nullable|array',
                'foto_klien.*' => 'mimes:png,jpg,jpeg|max_mb:2',
                'foto_klien_existing' => 'nullable|array',
                'foto_klien_existing.*' => 'exists:App\Models\DokumenPendukung,id,id_penjangkauan,'. $id_penjangkauan,

                'foto_tempat_tinggal_klien' => 'nullable|array',
                'foto_tempat_tinggal_klien.*' => 'mimes:png,jpg,jpeg|max_mb:2',
                'foto_tempat_tinggal_klien_existing' => 'nullable|array',
                'foto_tempat_tinggal_klien_existing.*' => 'exists:App\Models\DokumenPendukung,id,id_penjangkauan,'. $id_penjangkauan,

                'foto_pendampingan_awal_klien' => 'nullable|array',
                'foto_pendampingan_awal_klien.*' => 'mimes:png,jpg,jpeg|max_mb:2',
                'foto_pendampingan_awal_klien_existing' => 'nullable|array',
                'foto_pendampingan_awal_klien_existing.*' => 'exists:App\Models\DokumenPendukung,id,id_penjangkauan,'. $id_penjangkauan,

                'foto_pendampingan_lanjutan_klien' => 'nullable|array',
                'foto_pendampingan_lanjutan_klien.*' => 'mimes:png,jpg,jpeg|max_mb:2',
                'foto_pendampingan_lanjutan_klien_existing' => 'nullable|array',
                'foto_pendampingan_lanjutan_klien_existing.*' => 'exists:App\Models\DokumenPendukung,id,id_penjangkauan,'. $id_penjangkauan,

                'foto_pendampingan_monitoring_klien' => 'nullable|array',
                'foto_pendampingan_monitoring_klien.*' => 'mimes:png,jpg,jpeg|max_mb:2',
                'foto_pendampingan_monitoring_klien_existing' => 'nullable|array',
                'foto_pendampingan_monitoring_klien_existing.*' => 'exists:App\Models\DokumenPendukung,id,id_penjangkauan,'. $id_penjangkauan,

                'foto_identitas_klien' => 'nullable|array',
                'foto_identitas_klien.*' => 'mimes:png,jpg,jpeg|max_mb:2',
                'foto_identitas_klien_existing' => 'nullable|array',
                'foto_identitas_klien_existing.*' => 'exists:App\Models\DokumenPendukung,id,id_penjangkauan,'. $id_penjangkauan,
            
                'surat' => 'nullable|array',
                'surat.*' => 'mimes:pdf|max_mb:2',
                'surat_existing' => 'nullable|array',
                'surat_existing.*' => 'exists:App\Models\DokumenPendukung,id,id_penjangkauan,'. $id_penjangkauan
            ];
            $validator = Validator::make($req->all(), $rules);
            if ($validator->fails()) {
                $this->responseCode = 422;
                $this->responseMessage = $validator->errors()->first();
                $this->responseData = $validator->errors();
                return response()->json($this->getResponse(), $this->responseCode);
            }

            $data = [];
            $unDeletedID = [];

            if($req->has('foto_klien')){
                $index = count($data);
                $data[$index] = [
                    'file' => $req->foto_klien,
                    'type' => 1,
                ];
            }
            if($req->has('foto_klien_existing')){
                $unDeletedID = array_merge($unDeletedID, $req->foto_klien_existing);
            }

            if($req->has('foto_tempat_tinggal_klien')){
                $index = count($data);
                $data[$index] = [
                    'file' => $req->foto_tempat_tinggal_klien,
                    'type' => 2,
                ];
            }
            if($req->has('foto_tempat_tinggal_klien_existing')){
                $unDeletedID = array_merge($unDeletedID, $req->foto_tempat_tinggal_klien_existing);
            }

            if($req->has('foto_pendampingan_awal_klien')){
                $index = count($data);
                $data[$index] = [
                    'file' => $req->foto_pendampingan_awal_klien,
                    'type' => 3,
                ];
            }
            if($req->has('foto_pendampingan_awal_klien_existing')){
                $unDeletedID = array_merge($unDeletedID, $req->foto_pendampingan_awal_klien_existing);
            }

            if($req->has('foto_pendampingan_lanjutan_klien')){
                $index = count($data);
                $data[$index] = [
                    'file' => $req->foto_pendampingan_lanjutan_klien,
                    'type' => 4,
                ];
            }
            if($req->has('foto_pendampingan_lanjutan_klien_existing')){
                $unDeletedID = array_merge($unDeletedID, $req->foto_pendampingan_lanjutan_klien_existing);
            }

            if($req->has('foto_pendampingan_monitoring_klien')){
                $index = count($data);
                $data[$index] = [
                    'file' => $req->foto_pendampingan_monitoring_klien,
                    'type' => 5,
                ];
            }
            if($req->has('foto_pendampingan_monitoring_klien_existing')){
                $unDeletedID = array_merge($unDeletedID, $req->foto_pendampingan_monitoring_klien_existing);
            }

            if($req->has('foto_identitas_klien')){
                $index = count($data);
                $data[$index] = [
                    'file' => $req->foto_identitas_klien,
                    'type' => 6,
                ];
            }
            if($req->has('foto_identitas_klien_existing')){
                $unDeletedID = array_merge($unDeletedID, $req->foto_identitas_klien_existing);
            }

            if($req->has('surat')){
                $data[] = [
                    'file' => $req->surat,
                    'type' => 7,
                ];
            }
            if($req->has('surat_existing')){
                $unDeletedID = array_merge($unDeletedID, $req->surat_existing);
            }

            $deletedDokumen = DokumenPendukung::where('id_penjangkauan', $id_penjangkauan);
            if(count($unDeletedID)){
                $deletedDokumen->whereNotIn('id', $unDeletedID);
            }

            $updated_by = DokumenPendukung::where('id_penjangkauan', $id_penjangkauan)->orderBy('updated_at', 'DESC')->pluck('updated_by')->first();
            foreach($deletedDokumen->get() as $dokumen){
                $dokumen->forceDelete();
            }

            foreach($data as $item){
                $files = $item['file'];

                foreach($files as $file){
                    $changedName = time() . random_int(100, 999). '.' .$file->getClientOriginalExtension();
                    $is_image = false;
                    if (substr($file->getClientMimeType(), 0, 5) == 'image') {
                        $is_image = true;
                    }
    
                    $path = 'private/dokumen_pendukung/' . $id_penjangkauan . '/' . $item['type'];
                    $file->storeAs($path, $changedName);
    
                    $DokumenPendukung = new DokumenPendukung();
                    $DokumenPendukung->document_type = $item['type'];
                    $DokumenPendukung->id_penjangkauan = $id_penjangkauan;
                    $DokumenPendukung->name = $file->getClientOriginalName();
                    $DokumenPendukung->path = $path . '/' . $changedName;
                    $DokumenPendukung->size = $file->getSize();
                    $DokumenPendukung->ext = $file->getClientOriginalExtension();
                    $DokumenPendukung->is_image = $is_image;

                    if(in_array(auth()->user()->id_role, [config('env.role.subkord'), config('env.role.kabid')])){
                        $DokumenPendukung->stopUserstamping();
                        $DokumenPendukung->created_by = $updated_by;
                        $DokumenPendukung->updated_by = $updated_by;
                    }

                    $DokumenPendukung->save();
                }
            }

            $penjangkauan = Penjangkauan::find($id_penjangkauan);
            if($req->is_publish){
                $penjangkauan->dokumen_pendukung_draft_status = false;
            }else{
                $penjangkauan->dokumen_pendukung_draft_status = true;
            }
            $penjangkauan->save();
            
            DB::commit();
            $this->responseCode = 200;
            return response()->json($this->getResponse(), $this->responseCode);
        } catch (\Exception $e) {
            DB::rollback();
            $this->responseCode = 500;
            $this->responseMessage = $e->getMessage(). ' ' .$e->getLine();
            return response()->json($this->getResponse(), $this->responseCode);
        }
    }

    public function show($id_penjangkauan)
    {
        try {
            $dokumen = DokumenPendukung::where('id_penjangkauan', intval($id_penjangkauan))->get();
            if(empty($dokumen)){
                $this->responseCode = 404;
                $this->responseMessage = 'Data tidak ditemukan';
                return response()->json($this->getResponse(), $this->responseCode);
            }

            $this->responseCode = 200;
            $this->responseData = new DokumenPendukungResource(Penjangkauan::find(intval($id_penjangkauan)));
            return response()->json($this->getResponse(), $this->responseCode);
        } catch (\Exception $e) {
            $this->responseCode = 500;
            $this->responseMessage = $e->getMessage();
            return response()->json($this->getResponse(), $this->responseCode);
        }
    }
}
