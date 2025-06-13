<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\RealisasiIntervensi;
use App\Models\RealisasiIntervensiFile;
use App\Http\Resources\RealisasiIntervensiResource;
use App\Models\RencanaIntervensi;

class RealisasiIntervensiController extends Controller
{
    public function index($id_rencana)
    {
        try {
            $id_rencana = intval($id_rencana);
            $realisasi = RealisasiIntervensi::where('id_rencana_intervensi', $id_rencana)->orderBy('id', 'desc')->get();

            $this->responseCode = 200;
            $this->responseData = RealisasiIntervensiResource::collection($realisasi->load('realisasi_intervensi_file', 'createdBy'));
            return response()->json($this->getResponse(), $this->responseCode);
        } catch (\Exception $e) {
            $this->responseCode = 500;
            $this->responseMessage = $e->getMessage();
            return response()->json($this->getResponse(), $this->responseCode);
        }
    }

    public function store(Request $req, $id_rencana)
    {
        try {
            if (auth()->user()->id_role == config('env.role.opd')) {
                $idOpd = auth()->user()->id_opd;
                $IDORchecker = RencanaIntervensi::where('id', $id_rencana)
                    ->where('id_opd', $idOpd)->exists();

                if ($IDORchecker == false) {
                    $this->responseCode = 403;
                    $this->responseMessage = 'User tidak memiliki hak akses';
                    return response()->json($this->getResponse(), $this->responseCode);
                }
            }

            $id_rencana = intval($id_rencana);
            $rencana = RencanaIntervensi::find($id_rencana);
            if (!$rencana) {
                $this->responseCode = 404;
                $this->responseMessage = 'Data tidak ditemukan';
                return response()->json($this->getResponse(), $this->responseCode);
            }

            DB::beginTransaction();

            $rules = [
                'id' => 'nullable|exists:App\Models\RealisasiIntervensi,id,id_rencana_intervensi,' . $id_rencana,
                'nama' => 'required|string',
                'deskripsi' => 'required|string',
                'foto' => 'nullable|array',
                'foto.*' => 'mimes:png,jpg,jpeg',
                'foto_existing' => 'nullable|array',
                'foto_existing.*' => 'exists:App\Models\RealisasiIntervensiFile,id,deleted_at,NULL'
            ];
            $validator = Validator::make($req->all(), $rules);
            if ($validator->fails()) {
                $this->responseCode = 422;
                $this->responseMessage = $validator->errors()->first();
                $this->responseData = $validator->errors();
                return response()->json($this->getResponse(), $this->responseCode);
            }

            if ($req->id) {
                $realisasi = RealisasiIntervensi::find(intval($req->id));
            } else {
                $realisasi = new RealisasiIntervensi();
                $realisasi->id_rencana_intervensi = $id_rencana;
            }
            $realisasi->name = $req->nama;
            $realisasi->description = $req->deskripsi;
            $realisasi->save();

            $deletedFile = RealisasiIntervensiFile::where('id_realisasi_intervensi', $realisasi->id);
            if ($req->foto_existing) {
                $deletedFile->whereNotIn('id', $req->foto_existing);
            }
            foreach ($deletedFile->get() as $file) {
                $file->forceDelete();
            }

            if ($req->has('foto')) {
                foreach ($req->foto as $file) {
                    $changedName = time() . random_int(100, 999) . '.' . $file->getClientOriginalExtension();
                    $is_image = substr($file->getClientMimeType(), 0, 5) == 'image' ?? false;

                    $path = 'private/realisasi_intervensi/' . $realisasi->id;
                    $file->storeAs($path, $changedName);

                    $RealisasiIntervensiFile = new RealisasiIntervensiFile();
                    $RealisasiIntervensiFile->id_realisasi_intervensi = $realisasi->id;
                    $RealisasiIntervensiFile->name = $file->getClientOriginalName();
                    $RealisasiIntervensiFile->path = $path . '/' . $changedName;
                    $RealisasiIntervensiFile->size = $file->getSize();
                    $RealisasiIntervensiFile->ext = $file->getClientOriginalExtension();
                    $RealisasiIntervensiFile->is_image = $is_image;
                    $RealisasiIntervensiFile->save();
                }
            }

            DB::commit();
            $this->responseCode = 200;
            $this->responseData = new RealisasiIntervensiResource($realisasi);
            return response()->json($this->getResponse(), $this->responseCode);
        } catch (\Exception $e) {
            DB::rollback();
            $this->responseCode = 500;
            $this->responseMessage = $e->getMessage();
            return response()->json($this->getResponse(), $this->responseCode);
        }
    }

    public function submit($id_rencana)
    {
        try {
            if (auth()->user()->id_role == config('env.role.asisten')) {
                $this->responseCode = 403;
                $this->responseMessage = 'User tidak memiliki hak akses';
                return response()->json($this->getResponse(), $this->responseCode);
            }

            if (auth()->user()->id_role == config('env.role.opd')) {
                $idOpd = auth()->user()->id_opd;
                $IDORchecker = RencanaIntervensi::where('id', $id_rencana)
                    ->where('id_opd', $idOpd)->exists();

                if ($IDORchecker == false) {
                    $this->responseCode = 403;
                    $this->responseMessage = 'User tidak memiliki hak akses';
                    return response()->json($this->getResponse(), $this->responseCode);
                }
            }

            $id_rencana = intval($id_rencana);
            $rencana = RencanaIntervensi::find($id_rencana);
            if (!$rencana) {
                $this->responseCode = 404;
                $this->responseMessage = 'Data tidak ditemukan';
                return response()->json($this->getResponse(), $this->responseCode);
            }

            DB::beginTransaction();
            $rencana->realisasi_draft_status = false;
            $rencana->save();
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
}
