<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\PenangananAwal;
use App\Models\PenangananAwalFile;
use App\Models\Pengaduan;
use App\Http\Resources\PenangananAwalResource;
use App\Models\TimelinePengaduan;

class PenangananAwalController extends Controller
{
    public function store(Request $req, $id)
    {
        try {
            DB::beginTransaction();

            $id = intval($id);
            $pengaduan = Pengaduan::find($id);
            if(!$pengaduan){
                $this->responseCode = 404;
                $this->responseMessage = 'Data tidak ditemukan';
                return response()->json($this->getResponse(), $this->responseCode);
            }
            if($pengaduan->penangananAwal){
                $this->responseCode = 400;
                $this->responseMessage = 'Data ini sudah pernah di tangani';
                return response()->json($this->getResponse(), $this->responseCode);
            }

            $rules = [
                'type' => 'required|numeric|in:0,1',
                'waktu' => 'required|date',
                'keterangan' => 'required|string',
                'dokumen' => 'required|array|min:1',
                'dokumen.*' => 'mimes:png,jpg,jpeg,pdf',
            ];
            $validator = Validator::make($req->all(), $rules);
            if ($validator->fails()) {
                $this->responseCode = 422;
                $this->responseMessage = $validator->errors()->first();
                $this->responseData = $validator->errors();
                return response()->json($this->getResponse(), $this->responseCode);
            }

            $pengaduan->id_status = $req->type ? 3 : 2;
            $pengaduan->save();

            $penanganan = PenangananAwal::create([
                'id_pengaduan' => $pengaduan->id,
                'type' => $req->type,
                'date' => $req->waktu,
                'result' => $req->keterangan,
            ]);

            foreach($req->dokumen as $file){
                $changedName = time() . random_int(100, 999). '.' .$file->getClientOriginalExtension();
                $is_image = false;
                if (substr($file->getClientMimeType(), 0, 5) == 'image') {
                    $is_image = true;
                }

                $path = 'private/penanganan_awal/' . $penanganan->id;
                $file->storeAs($path, $changedName);

                $PenangananAwalFile = new PenangananAwalFile();
                $PenangananAwalFile->id_penanganan_awal = $penanganan->id;
                $PenangananAwalFile->name = $file->getClientOriginalName();
                $PenangananAwalFile->path = $path . '/' . $changedName;
                $PenangananAwalFile->size = $file->getSize();
                $PenangananAwalFile->ext = $file->getClientOriginalExtension();
                $PenangananAwalFile->is_image = $is_image;
                $PenangananAwalFile->save();
            }

            $timeline = TimelinePengaduan::create([
                'id_pengaduan' => $pengaduan->id,
                'id_status' => $pengaduan->id_status,
                'name' => $pengaduan->id_status == 3 ? 'Menunggu Verifikasi Subkord' : 'Dirujuk',
                'description' => $pengaduan->id_status == 3 ? 'Pengaduan telah diterima dan diteruskan ke subkord' : 'Pengaduan telah di rujuk oleh hotline',
            ]);

            DB::commit();
            $this->responseCode = 201;
            return response()->json($this->getResponse(), $this->responseCode);
        } catch (\Exception $e) {
            DB::rollback();
            $this->responseCode = 500;
            $this->responseMessage = $e->getMessage();
            return response()->json($this->getResponse(), $this->responseCode);
        }
    }

    public function show($id_pengaduan)
    {
        try {
            $id = intval($id_pengaduan);
            $pengaduan = Pengaduan::find($id);
            if(!$pengaduan || !$pengaduan->penangananAwal){
                $this->responseCode = 404;
                $this->responseMessage = 'Data tidak ditemukan';
                return response()->json($this->getResponse(), $this->responseCode);
            }

            $this->responseCode = 200;
            $this->responseData = new PenangananAwalResource($pengaduan->penangananAwal);
            return response()->json($this->getResponse(), $this->responseCode);
        } catch (\Exception $e) {
            $this->responseCode = 500;
            $this->responseMessage = $e->getMessage();
            return response()->json($this->getResponse(), $this->responseCode);
        }
    }

    public function update(Request $req, $id_pengaduan)
    {
        $id = intval($id_pengaduan);
        $pengaduan = Pengaduan::find($id);
        if(!$pengaduan || !$penanganan = $pengaduan->penangananAwal){
            $this->responseCode = 404;
            $this->responseMessage = 'Data tidak ditemukan';
            return response()->json($this->getResponse(), $this->responseCode);
        }

        $rules = [
            'type' => 'nullable|numeric|in:0,1',
            'waktu' => 'required|date',
            'keterangan' => 'required|string',
            'dokumen' => 'nullable|array',
            'dokumen.*' => 'mimes:png,jpg,jpeg,pdf',
            'dokumen_existing' => 'nullable|array',
            'dokumen_existing.*' => 'exists:App\Models\PenangananAwalFile,id,id_penanganan_awal,'. $penanganan->id,
        ];

        if(!$req->has('dokumen_existing')){
            $rules['dokumen'] .= '|required|min:1';
        }

        $validator = Validator::make($req->all(), $rules);
        if ($validator->fails()) {
            $this->responseCode = 422;
            $this->responseMessage = $validator->errors()->first();
            $this->responseData = $validator->errors();
            return response()->json($this->getResponse(), $this->responseCode);
        }

        DB::transaction(function () use($penanganan, $req) {
            $penanganan->type = $req->filled('type') ? $req->type: $penanganan->type;
            $penanganan->date = $req->waktu;
            $penanganan->result = $req->keterangan;
            $penanganan->save();

            $penangananFile = PenangananAwalFile::where('id_penanganan_awal', $penanganan->id);
            if($req->has('dokumen_existing')){
                $penangananFile->whereNotIn('id', $req->dokumen_existing);
            }
            foreach($penangananFile->get() as $f){
                $f->forceDelete();
            }

            if($req->has('dokumen')){
                foreach($req->dokumen as $file){
                    $changedName = time() . random_int(100, 999). '.' .$file->getClientOriginalExtension();
    
                    $path = 'private/penanganan_awal/' . $penanganan->id;
                    $file->storeAs($path, $changedName);
    
                    $PenangananAwalFile = new PenangananAwalFile();
                    $PenangananAwalFile->id_penanganan_awal = $penanganan->id;
                    $PenangananAwalFile->name = $file->getClientOriginalName();
                    $PenangananAwalFile->path = $path . '/' . $changedName;
                    $PenangananAwalFile->size = $file->getSize();
                    $PenangananAwalFile->ext = $file->getClientOriginalExtension();
                    $PenangananAwalFile->is_image = substr($file->getClientMimeType(), 0, 5) == 'image' ?? false;
                    $PenangananAwalFile->save();
                }
            }
        });

        
        $this->responseCode = 200;
        return response()->json($this->getResponse(), $this->responseCode);
    }
}
