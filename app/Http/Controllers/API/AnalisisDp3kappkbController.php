<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\AnalisisDp3kappkb;
use App\Models\AnalisisDp3kappkbFile;
use App\Models\Penjangkauan;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\AnalisKebutuhanKlienResource;
use App\Models\MPelayanan;
use Illuminate\Support\Facades\File;

class AnalisisDp3kappkbController extends Controller
{
    public function store(Request $req, $id_penjangkauan)
    {
        DB::beginTransaction();

        $id_penjangkauan = intval($id_penjangkauan);
        $req->request->add(['id_penjangkauan' => $id_penjangkauan]);

        $rules = [
            'id_penjangkauan' => 'required|exists:App\Models\Penjangkauan,id,deleted_at,NULL',
            'pelayanan' => 'required|array|min:1',
            'pelayanan.*.id' => 'nullable|exists:App\Models\AnalisisDp3kappkb,id,id_penjangkauan,'. $id_penjangkauan,
            'pelayanan.*.id_pelayanan' => 'required_if:is_publish,1|exists:App\Models\MPelayanan,id,deleted_at,NULL',
            'pelayanan.*.deskripsi_pelayanan' => 'required_if:is_publish,1|string',
            'pelayanan.*.dokumen' => 'nullable|array',
            'pelayanan.*.dokumen.*' => 'mimes:png,jpg,jpeg,pdf',
            'pelayanan.*.dokumen_existing' => 'nullable|array',
            'pelayanan.*.dokumen_existing.*' => 'exists:App\Models\AnalisisDp3kappkbFile,id,deleted_at,NULL',

            'pelayanan.*.shelter_type' => 'required_if:pelayanan.*.id_pelayanan,5|in:1,2,3,4',
        ];
        $validator = Validator::make($req->all(), $rules);
        if ($validator->fails()) {
            $this->responseCode = 422;
            $this->responseMessage = $validator->errors()->first();
            $this->responseData = $validator->errors();
            return response()->json($this->getResponse(), $this->responseCode);
        }

        $undeletedID = [];
        $updated_by = AnalisisDp3kappkb::where('id_penjangkauan', $id_penjangkauan)->orderBy('updated_at', 'DESC')->pluck('updated_by')->first();
        foreach($req->pelayanan as $pelayanan){
            if(isset($pelayanan['id'])){
                $id = intval($pelayanan['id']);
                $analis = AnalisisDp3kappkb::where('id_penjangkauan', $id_penjangkauan)->whereId($id)->update([
                    'id_pelayanan' => $pelayanan['id_pelayanan'] ?? null,
                    'description' => $pelayanan['deskripsi_pelayanan'] ?? null,
                    'shelter_type' => $pelayanan['id_pelayanan'] == 5 ? $pelayanan['shelter_type'] : null,
                    'updated_by' => in_array(auth()->user()->id_role, [config('env.role.subkord'), config('env.role.kabid')]) ? $updated_by : auth()->id(),
                    'updated_at' => date('Y-m-d H:i:s'),
                ]);

                $deletedFile = AnalisisDp3kappkbFile::where('id_analisis_dp3kappkb', $id);
                if(isset($pelayanan['dokumen_existing'])){
                    $deletedFile->whereNotIn('id', $pelayanan['dokumen_existing']);
                }
                foreach($deletedFile->get() as $file){
                    $file->forceDelete();
                }
                
                $analis = AnalisisDp3kappkb::find($id);
            }else{
                $analis = new AnalisisDp3kappkb;
                if(in_array(auth()->user()->id_role, [config('env.role.subkord'), config('env.role.kabid')])){
                    $analis->stopUserstamping();
                    $analis->created_by = $updated_by;
                    $analis->updated_by = $updated_by;
                }
                $analis->id_penjangkauan = $id_penjangkauan;
                $analis->id_pelayanan = $pelayanan['id_pelayanan'] ?? null;
                $analis->description = $pelayanan['deskripsi_pelayanan'] ?? null;
                $analis->shelter_type = ($pelayanan['id_pelayanan'] ?? null) == 5 ? $pelayanan['shelter_type'] : null;
                $analis->save();
            }

            if(isset($pelayanan['dokumen'])){
                foreach($pelayanan['dokumen'] as $file){
                    $changedName = time() . random_int(100, 999). '.' .$file->getClientOriginalExtension();
                    $is_image = false;
                    if (substr($file->getClientMimeType(), 0, 5) == 'image') {
                        $is_image = true;
                    }

                    $path = 'private/analis_kebutuhan_klien/' . $analis->id;
                    $file->storeAs($path, $changedName);

                    $AnalisisDp3kappkbFile = new AnalisisDp3kappkbFile();
                    $AnalisisDp3kappkbFile->id_analisis_dp3kappkb = $analis->id;
                    $AnalisisDp3kappkbFile->name = $file->getClientOriginalName();
                    $AnalisisDp3kappkbFile->path = $path . '/' . $changedName;
                    $AnalisisDp3kappkbFile->size = $file->getSize();
                    $AnalisisDp3kappkbFile->ext = $file->getClientOriginalExtension();
                    $AnalisisDp3kappkbFile->is_image = $is_image;
                    $AnalisisDp3kappkbFile->save();
                }
            }
            
            $undeletedID[] = $analis->id;
        }

        
        $deletedAnalis = AnalisisDp3kappkb::where('id_penjangkauan', $id_penjangkauan);
        if(count($undeletedID)){
            $deletedAnalis->whereNotIn('id', $undeletedID);
        }
        foreach($deletedAnalis->get() as $analis){
            if(File::exists(storage_path('app/private/analis_kebutuhan_klien/'. $analis->id))){
                File::deleteDirectory(storage_path('app/private/analis_kebutuhan_klien/'. $analis->id));
            }
            $analis->forceDelete();
        }

        $penjangkauan = Penjangkauan::find($id_penjangkauan);
        if($req->is_publish){
            $penjangkauan->analisis_dp3kappkb_draft_status = false;
        }else{
            $penjangkauan->analisis_dp3kappkb_draft_status = true;
        }
        $penjangkauan->save();

        DB::commit();
        $this->responseCode = 200;
        return response()->json($this->getResponse(), $this->responseCode);
    }

    public function index($id_penjangkauan)
    {
        try {
            $analis = AnalisisDp3kappkb::where('id_penjangkauan', intval($id_penjangkauan))->get();
            if(empty($analis)){
                $this->responseCode = 404;
                $this->responseMessage = 'Data tidak ditemukan';
                return response()->json($this->getResponse(), $this->responseCode);
            }

            $this->responseCode = 200;
            $this->responseData = AnalisKebutuhanKlienResource::collection($analis);
            return response()->json($this->getResponse(), $this->responseCode);
        } catch (\Exception $e) {
            $this->responseCode = 500;
            $this->responseMessage = $e->getMessage();
            return response()->json($this->getResponse(), $this->responseCode);
        }
    }

    public function listPelayanan(Request $req)
    {
        try {
            $limit = $req->limit ? intval($req->limit) : 10;
            
            $pelayanan = MPelayanan::select('*');
            if($req->filled('search')){
                $pelayanan->where(DB::raw('lower(name)'), 'like', '%' . strtolower($req->search) . '%');
            }
            $pelayanan = $pelayanan->where('is_active', true)->take($limit)->get();

            $this->responseCode = 200;
            $this->responseData = $pelayanan;
            return response()->json($this->getResponse(), $this->responseCode);
        } catch (\Exception $e) {
            $this->responseCode = 500;
            $this->responseMessage = $e->getMessage();
            return response()->json($this->getResponse(), $this->responseCode);
        }
    }
}
