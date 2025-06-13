<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\Penjangkauan;
use App\Models\LangkahDilakukan;
use App\Models\LangkahDilakukanFile;
use Illuminate\Support\Facades\File;
use App\Models\MPelayanan;
use App\Http\Resources\LangkahDilakukanResource;
use App\Models\RencanaIntervensi;
use App\Models\RencanaIntervensiFile;
use App\Models\MIntervensi;
use App\Models\MKebutuhan;
use Illuminate\Validation\Rule;

class LangkahDilakukanController extends Controller
{
    public function store(Request $req, $id_penjangkauan)
    {
        try {
            DB::beginTransaction();

            $id_penjangkauan = intval($id_penjangkauan);
            $req->request->add(['id_penjangkauan' => $id_penjangkauan]);
            $rules = [
                'id_penjangkauan' => 'required|exists:App\Models\Penjangkauan,id,deleted_at,NULL',
                'penanganan' => 'required|array|min:1',
                'penanganan.*.id' => 'nullable|exists:App\Models\LangkahDilakukan,id,deleted_at,NULL',
                'penanganan.*.tipe_penanganan' => 'required|in:1,2,3',
                'penanganan.*.tanggal_pelayanan' => 'required_if:is_publish,1|date',
                'penanganan.*.id_pelayanan' => [
                    // 'required_unless:penanganan.*.tipe_penanganan,3',
                    'exists:App\Models\MPelayanan,id,deleted_at,NULL'
                ],
                'penanganan.*.deskripsi' => 'string',
                'penanganan.*.dokumen' => 'nullable|array',
                'penanganan.*.dokumen.*' => 'mimes:png,jpg,jpeg,pdf',
                'penanganan.*.dokumen_existing' => 'nullable|array',
                'penanganan.*.dokumen_existing.*' => 'exists:App\Models\LangkahDilakukanFile,id,deleted_at,NULL',

                'penanganan.*.id_opd' => [
                    'nullable',
                    // 'required_if:is_publish,1',
                    // 'required_if:penanganan.*.tipe_penanganan,3',
                    'exists:App\Models\MOpd,id,deleted_at,NULL',
                    // function ($attribute, $value, $fail) use ($req, $id_penjangkauan){
                    //     $request = $req->penanganan[explode('.', $attribute)[1]];
                    //     if($request['tipe_penanganan'] == 3){
                    //         // Check If intervensi exists
                    //         if (
                    //             RencanaIntervensi::where('id_penjangkauan', $id_penjangkauan)
                    //             ->where('id_opd', $value)
                    //             ->exists()
                    //         ) {
                    //             $fail('opd yang dipilih sudah pernah dimasukkan');
                    //         }
                    //     }
                    // }
                ],
                'penanganan.*.id_intervensi' => [
                    'nullable',
                    // 'required_if:is_publish,1',
                    // 'required_if:penanganan.*.tipe_penanganan,3',
                    'exists:App\Models\MIntervensi,id',
                    function ($attribute, $value, $fail) use ($req) {
                        $request = $req->penanganan[explode('.', $attribute)[1]];
                        if($request['tipe_penanganan'] == 3){
                            if($id_opd = isset($request['id_opd']) ? $request['id_opd'] : null){
                                // Check If intervensi exists
                                if (!MIntervensi::where('id', $value)->where('id_opd', $id_opd)->exists()) {
                                    $fail('pelayanan intervensi tidak valid');
                                }
                            }
                        }
                    }
                ],
                'penanganan.*.id_kebutuhan' => 'exists:App\Models\MKebutuhan,id,deleted_at,NULL',

                'penanganan.*.shelter_type' => 'required_if:penanganan.*.id_pelayanan,5|in:1,2,3,4',
            ];
            
            $validator = Validator::make($req->all(), $rules);
            if ($validator->fails()) {
                $this->responseCode = 422;
                $this->responseMessage = $validator->errors()->first();
                $this->responseData = $validator->errors();
                return response()->json($this->getResponse(), $this->responseCode);
            }

            $undeletedID = [
                'langkah' => [],
            ];
            $penjangkauan = Penjangkauan::find($id_penjangkauan);
            $updated_by = LangkahDilakukan::where('id_penjangkauan', $id_penjangkauan)->orderBy('updated_at', 'DESC')->pluck('updated_by')->first();

            foreach($req->penanganan as $penanganan){
                if($penanganan['tipe_penanganan'] != 3){
                    if(isset($penanganan['id']) && $penanganan['id']){
                        $id = intval($penanganan['id']);
                        $langkah = LangkahDilakukan::where('id_penjangkauan', $id_penjangkauan)->whereId($id)->update([
                            'service_type' => $penanganan['tipe_penanganan'],
                            'service_date' => $penanganan['tanggal_pelayanan'] ?? null,
                            'id_pelayanan' => $penanganan['id_pelayanan'] ?? null,
                            'description' => $penanganan['deskripsi'] ?? null,
                            'shelter_type' => ($penanganan['id_pelayanan'] ?? null) == 5 ? ($penanganan['shelter_type'] ?? null) : null,
                            'updated_by' => in_array(auth()->user()->id_role, [config('env.role.subkord'), config('env.role.kabid')]) ? $updated_by : auth()->id(),
                            'updated_at' => date('Y-m-d H:i:s'),
                        ]);

                        $deletedFile = LangkahDilakukanFile::where('id_langkah_dilakukan', $id);
                        if(isset($penanganan['dokumen_existing'])){
                            $deletedFile->whereNotIn('id', $penanganan['dokumen_existing']);
                        }
                        foreach($deletedFile->get() as $file){
                            $file->forceDelete();
                        }
                        
                        $langkah = LangkahDilakukan::find($id);
                    }else{
                        // $langkah = LangkahDilakukan::create([
                        //     'id_penjangkauan' => $id_penjangkauan,
                        //     'service_type' => $penanganan['tipe_penanganan'],
                        //     'service_date' => $penanganan['tanggal_pelayanan'] ?? null,
                        //     'id_pelayanan' => $penanganan['id_pelayanan'] ?? null,
                        //     'description' => $penanganan['deskripsi'] ?? null,
                        //     'shelter_type' => ($penanganan['id_pelayanan'] ?? null) == 5 ? ($penanganan['shelter_type'] ?? null) : null,
                        // ]);
                        $langkah = new LangkahDilakukan;
                        if(in_array(auth()->user()->id_role, [config('env.role.subkord'), config('env.role.kabid')])){
                            $langkah->stopUserstamping();
                            $langkah->created_by = $updated_by;
                            $langkah->updated_by = $updated_by;
                        }
                        $langkah->id_penjangkauan = $id_penjangkauan;
                        $langkah->service_type = $penanganan['tipe_penanganan'];
                        $langkah->service_date = $penanganan['tanggal_pelayanan'] ?? null;
                        $langkah->id_pelayanan = $penanganan['id_pelayanan'] ?? null;
                        $langkah->description = $penanganan['deskripsi'] ?? null;
                        $langkah->shelter_type = ($penanganan['id_pelayanan'] ?? null) == 5 ? ($penanganan['shelter_type'] ?? null) : null;
                        $langkah->save();
                    }

                    $undeletedID['langkah'][] = $langkah->id;
                }

                if($penanganan['tipe_penanganan'] == 3){
                    if(!$req->is_publish){
                        $penjangkauan->rencana_intervensi_draft_status = true;
                    }

                    if(isset($penanganan['id']) && $penanganan['id']){
                        $id = intval($penanganan['id']);
                        $rencanaIntervensi = RencanaIntervensi::find($id);
                        $deletedFile = RencanaIntervensiFile::where('id_rencana_intervensi', $id);
                        if(isset($penanganan['dokumen_existing'])){
                            $deletedFile->whereNotIn('id', $penanganan['dokumen_existing']);
                        }
                        foreach($deletedFile->get() as $file){
                            $file->forceDelete();
                        }
                    }else{
                        $rencanaIntervensi = new RencanaIntervensi();
                        $rencanaIntervensi->id_penjangkauan =  $id_penjangkauan;
                    }

                    $rencanaIntervensi->service_date = $penanganan['tanggal_pelayanan'] ?? null;
                    $rencanaIntervensi->id_kebutuhan = $penanganan['id_kebutuhan'] ?? null;
                    $rencanaIntervensi->id_opd = $penanganan['id_opd'] ?? null;
                    $rencanaIntervensi->id_intervensi = $penanganan['id_intervensi'] ?? null;
                    $rencanaIntervensi->description = $penanganan['deskripsi'] ?? null;
                    $rencanaIntervensi->save();
                }
                
                if(isset($penanganan['dokumen'])){
                    foreach($penanganan['dokumen'] as $file){
                        $changedName = time() . random_int(100, 999). '.' .$file->getClientOriginalExtension();
                        $is_image = false;
                        if (substr($file->getClientMimeType(), 0, 5) == 'image') {
                            $is_image = true;
                        }

                        if($penanganan['tipe_penanganan'] != 3){
                            $path = 'private/langkah_dilakukan/' . $langkah->id;
                            $modelFile = new LangkahDilakukanFile();
                            $modelFile->id_langkah_dilakukan = $langkah->id;
                        }
                        if($penanganan['tipe_penanganan'] == 3){
                            $path = 'private/rencana_intervensi/' . $rencanaIntervensi->id;
                            $modelFile = new RencanaIntervensiFile();
                            $modelFile->id_rencana_intervensi = $rencanaIntervensi->id;
                        }

                        $file->storeAs($path, $changedName);

                        $modelFile->name = $file->getClientOriginalName();
                        $modelFile->path = $path . '/' . $changedName;
                        $modelFile->size = $file->getSize();
                        $modelFile->ext = $file->getClientOriginalExtension();
                        $modelFile->is_image = $is_image;
                        $modelFile->save();
                    }
                }
            }
            
            $deletedLangkah = LangkahDilakukan::select('id')->where('id_penjangkauan', $id_penjangkauan);

            if(count($undeletedID['langkah'])){
                $deletedLangkah->whereNotIn('id', $undeletedID['langkah']);
            }

            foreach($deletedLangkah->get() as $langkah){
                if(File::exists(storage_path('app/private/langkah_dilakukan/'. $langkah->id))){
                    File::deleteDirectory(storage_path('app/private/langkah_dilakukan/'. $langkah->id));
                }
                $langkah->forceDelete();
            }

            if($req->is_publish){
                $penjangkauan->langkah_dilakukan_draft_status = false;
            }else{
                $penjangkauan->langkah_dilakukan_draft_status = true;
            }
            $penjangkauan->save();

            DB::commit();
            $this->responseCode = 200;
            return response()->json($this->getResponse(), $this->responseCode);
        } catch (\Exception $e) {
            DB::rollback();
            $this->responseCode = 500;
            $this->responseMessage = $e->getMessage(). ' ' . $e->getLine();
            return response()->json($this->getResponse(), $this->responseCode);
        }
    }

    public function index($id_penjangkauan)
    {
        try {
            $langkah = LangkahDilakukan::where('id_penjangkauan', intval($id_penjangkauan))->orderBy('created_at', 'DESC')->get();
            if(empty($langkah)){
                $this->responseCode = 404;
                $this->responseMessage = 'Data tidak ditemukan';
                return response()->json($this->getResponse(), $this->responseCode);
            }

            $this->responseCode = 200;
            $this->responseData = LangkahDilakukanResource::collection($langkah);
            return response()->json($this->getResponse(), $this->responseCode);
        } catch (\Exception $e) {
            $this->responseCode = 500;
            $this->responseMessage = $e->getMessage();
            return response()->json($this->getResponse(), $this->responseCode);
        }
    }
    
    public function listKebutuhan(Request $req)
    {
        try {
            $limit = $req->limit ? intval($req->limit) : 10;
            
            $kebutuhan = MKebutuhan::select('*');
            if($req->filled('search')){
                $kebutuhan->where(DB::raw('lower(name)'), 'like', '%' . strtolower($req->search) . '%');
            }
            $kebutuhan = $kebutuhan->where('is_active', true)->take($limit)->get();

            $this->responseCode = 200;
            $this->responseData = $kebutuhan;
            return response()->json($this->getResponse(), $this->responseCode);
        } catch (\Exception $e) {
            $this->responseCode = 500;
            $this->responseMessage = $e->getMessage();
            return response()->json($this->getResponse(), $this->responseCode);
        }
    }
    
    public function update(Request $req, $id)
    {
        try {
            $id = intval($id);
            $req->request->add(['id' => $id]);
            
            DB::beginTransaction();

            $rules = [
                'id' => 'required|exists:App\Models\LangkahDilakukan,id,deleted_at,NULL',
                'tanggal_pelayanan' => 'required|date',
                'id_pelayanan' => 'required|exists:App\Models\MPelayanan,id,deleted_at,NULL',
                'deskripsi' => 'required|string',
                'dokumen' => 'nullable|array',
                'dokumen.*' => 'mimes:png,jpg,jpeg,pdf',
                'dokumen_existing' => 'nullable|array',
                'dokumen_existing.*' => 'exists:App\Models\LangkahDilakukanFile,id,deleted_at,NULL',
                'shelter_type' => 'required_if:id_pelayanan,5|in:1,2,3,4',
            ];
            $validator = Validator::make($req->all(), $rules);
            if ($validator->fails()) {
                $this->responseCode = 422;
                $this->responseMessage = $validator->errors()->first();
                $this->responseData = $validator->errors();
                return response()->json($this->getResponse(), $this->responseCode);
            }

            $langkah = LangkahDilakukan::where('id', $id)->update([
                'service_date' => $req->tanggal_pelayanan,
                'id_pelayanan' => $req->id_pelayanan,
                'description' => $req->deskripsi,
                'shelter_type' => $req->id_pelayanan == 5 ? $req->shelter_type : null,
                'updated_by' => auth()->id(),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);

            $deletedFile = LangkahDilakukanFile::where('id_langkah_dilakukan', $id);
            if($req->dokumen_existing){
                $deletedFile->whereNotIn('id', $req->dokumen_existing);
            }
            foreach($deletedFile->get() as $file){
                $file->forceDelete();
            }

            if($req->dokumen){
                foreach($req->dokumen as $file){
                    $changedName = time() . random_int(100, 999). '.' .$file->getClientOriginalExtension();
                    $is_image = false;
                    if (substr($file->getClientMimeType(), 0, 5) == 'image') {
                        $is_image = true;
                    }
    
                    $path = 'private/langkah_dilakukan/' . $id;
                    $modelFile = new LangkahDilakukanFile();
                    $modelFile->id_langkah_dilakukan = $id;
    
                    $file->storeAs($path, $changedName);
    
                    $modelFile->name = $file->getClientOriginalName();
                    $modelFile->path = $path . '/' . $changedName;
                    $modelFile->size = $file->getSize();
                    $modelFile->ext = $file->getClientOriginalExtension();
                    $modelFile->is_image = $is_image;
                    $modelFile->save();
                }
            }

            DB::commit();
            $this->responseCode = 200;
            $this->responseData = new LangkahDilakukanResource(LangkahDilakukan::find($id));
            return response()->json($this->getResponse(), $this->responseCode);
        } catch (\Exception $e) {
            DB::rollback();
            $this->responseCode = 500;
            $this->responseMessage = $e->getMessage();
            return response()->json($this->getResponse(), $this->responseCode);
        }
    }

    public function show($id)
    {
        try {
            $id = intval($id);
            $langkah = LangkahDilakukan::find($id);
            if(!$langkah){
                $this->responseCode = 404;
                $this->responseMessage = 'Data tidak ditemukan';
                return response()->json($this->getResponse(), $this->responseCode);
            }

            $this->responseCode = 200;
            $this->responseData = new LangkahDilakukanResource($langkah);
            return response()->json($this->getResponse(), $this->responseCode);
        } catch (\Exception $e) {
            $this->responseCode = 500;
            $this->responseMessage = $e->getMessage();
            return response()->json($this->getResponse(), $this->responseCode);
        }
    }

    public function storeOne(Request $req, $id)
    {
        $id = intval($id);
        $req->merge(['id_daftar_klien' => $id]);
        $rules = [
            'id_daftar_klien' => 'required|exists:App\Models\DaftarKlien,id,deleted_at,NULL',
            'tipe_penanganan' => 'required|in:1,2,3',
            'tanggal_pelayanan' => 'required|date',
            'id_pelayanan' => 'required_if:tipe_penanganan,1|nullable|required_if:tipe_penanganan,2|exists:App\Models\MPelayanan,id,deleted_at,NULL',
            'shelter_type' => 'nullable|in:1,2,3,4',
            'deskripsi' => 'required|string',

            'id_kebutuhan' => 'required_if:tipe_penanganan,3|nullable|exists:App\Models\MKebutuhan,id,deleted_at,NULL',
            'id_opd' => 'required_if:tipe_penanganan,3|nullable|exists:App\Models\MOpd,id,deleted_at,NULL',
            'id_intervensi' => 'required_if:tipe_penanganan,3|nullable|exists:App\Models\MIntervensi,id,id_opd,'. $req->id_opd,

            'dokumen' => 'nullable|array',
            'dokumen.*' => 'mimes:png,jpg,jpeg,pdf',
        ];
        $validator = Validator::make($req->all(), $rules);
        if ($validator->fails()) {
            $this->responseCode = 422;
            $this->responseMessage = $validator->errors()->first();
            $this->responseData = $validator->errors();
            return response()->json($this->getResponse(), $this->responseCode);
        }

        DB::transaction(function () use($req, $id) {
            if($req->tipe_penanganan != 3){
                $langkah = LangkahDilakukan::create([
                    'service_type' => $req->tipe_penanganan,
                    'service_date' => $req->tanggal_pelayanan ?? null,
                    'id_pelayanan' => $req->id_pelayanan ?? null,
                    'description' => $req->deskripsi ?? null,
                    'shelter_type' => ($req->id_pelayanan ?? null) == 5 ? ($req->shelter_type ?? null) : null,
                    'id_daftar_klien' => $id,
                ]);
            }
    
            if($req->tipe_penanganan == 3){
                $rencanaIntervensi = new RencanaIntervensi();
                $rencanaIntervensi->service_date = $req->tanggal_pelayanan ?? null;
                $rencanaIntervensi->id_kebutuhan = $req->id_kebutuhan ?? null;
                $rencanaIntervensi->id_opd = $req->id_opd ?? null;
                $rencanaIntervensi->id_intervensi = $req->id_intervensi ?? null;
                $rencanaIntervensi->description = $req->deskripsi ?? null;
                $rencanaIntervensi->save();
            }

            if(isset($req->dokumen)){
                foreach($req->dokumen as $file){
                    $changedName = time() . random_int(100, 999). '.' .$file->getClientOriginalExtension();
    
                    if($req->tipe_penanganan != 3){
                        $path = 'private/langkah_dilakukan/' . $langkah->id;
                        $modelFile = new LangkahDilakukanFile();
                        $modelFile->id_langkah_dilakukan = $langkah->id;
                    }
                    if($req->tipe_penanganan == 3){
                        $path = 'private/rencana_intervensi/' . $rencanaIntervensi->id;
                        $modelFile = new RencanaIntervensiFile();
                        $modelFile->id_rencana_intervensi = $rencanaIntervensi->id;
                    }
    
                    $file->storeAs($path, $changedName);
                    $modelFile->name = $file->getClientOriginalName();
                    $modelFile->path = $path . '/' . $changedName;
                    $modelFile->size = $file->getSize();
                    $modelFile->ext = $file->getClientOriginalExtension();
                    $modelFile->is_image = substr($file->getClientMimeType(), 0, 5) == 'image' ?? false;
                    $modelFile->save();
                }
            }
        });

        $this->responseCode = 200;
        return response()->json($this->getResponse(), $this->responseCode);
    }
}
