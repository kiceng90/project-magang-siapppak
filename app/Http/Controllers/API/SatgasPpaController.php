<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

use App\Models\SatgasPpa;
use App\Models\MKelurahan;
use App\Models\MKecamatan;
use App\Models\SatgasPpaFile;
use App\Models\User;

use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PkbmSheetExport;
use App\Imports\SatgasPpaSheetImport;
use App\Exports\DatabaseExport;

use App\Http\Resources\DetailPuspagaRwResource;

use DB;
use PDF;
use Validator;
use ZipArchive;
use Image;

class SatgasPpaController extends Controller
{
    public function model()
    {
        return new SatgasPpa();
    }

    public function modelFile()
    {
        return new SatgasPpaFile();
    }

    private function rules()
    {
        return [
            'nama_lengkap' => 'nullable|string',
            'nik' => 'nullable|numeric|digits:16',
            'nomor_sk' => 'nullable|string',
            'tanggal_sk' => 'nullable|date',

            'id_jabatan_dalam_instansi' => 'nullable|exists:App\Models\MJabatanDalamInstansi,id,deleted_at,NULL',
            'no_bank' => 'nullable|numeric',
            'id_kedudukan_dalam_tim' => 'nullable|exists:App\Models\MKedudukanDalamTim,id,deleted_at,NULL',
            'penerima_jasa_pelayanan' => 'nullable|string',
            'id_jasa_pelayanan' => 'nullable|string',
            'id_kelurahan_domisili' => 'nullable|exists:App\Models\MKelurahan,id,deleted_at,NULL',
            'alamat_domisili' => 'nullable|string',
            'rt_domisili' => 'nullable|numeric',
            'rw_domisili' => 'nullable|numeric',
            'id_kelurahan_ktp' => 'nullable|exists:App\Models\MKelurahan,id,deleted_at,NULL',
            'alamat_ktp' => 'nullable|string',
            'rt_ktp' => 'nullable|numeric',
            'rw_ktp' => 'nullable|numeric',
            'no_hp' => 'nullable|numeric',
            'email' => 'nullable|email',

            'foto' => 'nullable|mimes:png,jpg,jpeg',
            'ktp' => 'nullable|mimes:png,jpg,jpeg|max_mb:5',
            'file_sk' => 'nullable|array',
            'file_sk.*' => 'mimes:png,jpg,jpeg,pdf|max_mb:10',
            'file_sk_existing' => 'nullable|array',
            'file_sk_existing' => 'exists:App\Models\SatgasPpaFile,id,type,2',
        ];
    }

    private function select()
    {
        $data = $this->model()::select([
            'satgas_ppa.*', DB::raw('f.id as foto'), 'f.path AS foto_path',
            DB::raw('kec_dom.id as kecamatan_domisili_id'), DB::raw('kec_dom.name as kecamatan_domisili_name'),
            DB::raw('kel_dom.id as kelurahan_domisili_id'), DB::raw('kel_dom.name as kelurahan_domisili_name'),
            DB::raw('kec_ktp.id as kecamatan_ktp_id'), DB::raw('kec_ktp.name as kecamatan_ktp_name'),
            DB::raw('kel_ktp.id as kelurahan_ktp_id'), DB::raw('kel_ktp.name as kelurahan_ktp_name'),
            DB::raw('m_jabatan_dalam_instansi.name AS jabatan_dalam_instansi_name'),
            DB::raw('m_kedudukan_dalam_tim.name AS kedudukan_dalam_tim_name'),
            'ktp.id AS ktp_link', 'ktp.path AS ktp_path',
            'm_kelurahan.name AS kelurahan_name',
            'creator.id AS creator_id', 'creator.name AS creator_name', 'creator.username AS creator_username',
        ])
            ->leftJoin('satgas_ppa_file as f', function ($j) {
                $j->on('satgas_ppa.id', '=', 'f.id_satgas_ppa');
                $j->where('f.type', 1);
            })
            ->leftJoin('satgas_ppa_file as ktp', function ($j) {
                $j->on('satgas_ppa.id', '=', 'ktp.id_satgas_ppa');
                $j->where('ktp.type', 3);
            })
            ->leftJoin('m_kelurahan as kel_dom', 'kel_dom.id', '=', 'satgas_ppa.id_kelurahan_domisili')
            ->leftJoin('m_kecamatan as kec_dom', 'kec_dom.id', '=', 'kel_dom.id_kecamatan')
            ->leftJoin('m_kelurahan as kel_ktp', 'kel_ktp.id', '=', 'satgas_ppa.id_kelurahan_ktp')
            ->leftJoin('m_kecamatan as kec_ktp', 'kec_ktp.id', '=', 'kel_ktp.id_kecamatan')
            ->leftJoin('m_jabatan_dalam_instansi', 'm_jabatan_dalam_instansi.id', '=', 'satgas_ppa.id_jabatan_dalam_instansi')
            ->leftJoin('m_kedudukan_dalam_tim', 'm_kedudukan_dalam_tim.id', '=', 'satgas_ppa.id_kedudukan_dalam_tim')
            ->leftJoin('m_kelurahan', 'm_kelurahan.id', '=', 'satgas_ppa.id_kelurahan')
            ->leftJoin('m_user AS creator', 'creator.id', '=', 'satgas_ppa.created_by');

        if (auth()->user()->id_role != config('env.role.admin')) {
            $data->where(function ($q) {
                $q->where('satgas_ppa.id_kelurahan', auth()->user()->id_kelurahan);
                // $q->orWhere('satgas_ppa.id_kelurahan', null);
            });
        }

        return $data;
    }

    public function index(Request $req)
    {
        $model = $this->select();

        $limit = $req->limit ? intval($req->limit) : 10;
        if ($limit > 100) $limit = 100;

        $order = Str::lower($req->order) == 'asc' ? 'asc' : 'desc';
        $sortby = $req->sortby ? $req->sortby : 'id';

        if ($req->filled('id_kelurahan')) {
            $model->where('satgas_ppa.id_kelurahan', $req->id_kelurahan);
        }

        if ($req->filled('search')) {
            $model->where(function ($q) use ($req) {
                $s = $req->search;
                $q->where('satgas_ppa.name', 'ILIKE', '%' . $s . '%');
                $q->orWhere('satgas_ppa.nik', 'ILIKE', '%' . $s . '%');
                $q->orWhere('satgas_ppa.sk_number', 'ILIKE', '%' . $s . '%');
                // $q->orWhere('satgas_ppa.rw', 'ILIKE', '%'. $s .'%');
                $q->orWhere('m_jabatan_dalam_instansi.name', 'ILIKE', '%' . $s . '%');
                $q->orWhere('m_kedudukan_dalam_tim.name', 'ILIKE', '%' . $s . '%');
                $q->orWhere('kec_dom.name', 'ILIKE', '%' . $s . '%');
                $q->orWhere('kel_dom.name', 'ILIKE', '%' . $s . '%');
                // $q->orWhere('kec_ktp.name', 'ILIKE', '%'. $s .'%');
                // $q->orWhere('kel_ktp.name', 'ILIKE', '%'. $s .'%');
            });
        }

        $model = $model->orderBy($sortby, $order)->paginate($limit);

        $this->saveLog($model);
        return $model;
    }

    public function store(Request $req)
    {
        $this->authorize('create', SatgasPpa::class);

        try {
            DB::beginTransaction();

            $validator = Validator::make($req->all(), $this->rules());
            if ($validator->fails()) {
                $this->responseCode = 422;
                $this->responseMessage = $validator->errors()->first();
                $this->responseData = $validator->errors();
                return response()->json($this->getResponse(), $this->responseCode);
            }

            $model = $this->model()::create([
                'name' => $req->nama_lengkap,
                'nik' => $req->nik,
                'sk_number' => $req->nomor_sk,
                'sk_date' => $req->tanggal_sk,

                'id_jabatan_dalam_instansi' => $req->id_jabatan_dalam_instansi,
                'no_bank' => $req->no_bank,
                'id_kedudukan_dalam_tim' => $req->id_kedudukan_dalam_tim,
                'penerima_jasa_pelayanan' => $req->penerima_jaspel,
                'id_jasa_pelayanan' => $req->jasa_pelayanan,
                'id_kelurahan_domisili' => $req->id_kelurahan_domisili,
                'alamat_domisili' => $req->alamat_domisili,
                'rt_domisili' => $req->rt_domisili,
                'rw_domisili' => $req->rw_domisili,
                'id_kelurahan_ktp' => $req->id_kelurahan_ktp,
                'alamat_ktp' => $req->alamat_ktp,
                'rt_ktp' => $req->rt_ktp,
                'rw_ktp' => $req->rw_ktp,
                'no_hp' => $req->no_hp,
                'email' => $req->email,

                'id_kelurahan' => auth()->user()->id_kelurahan,
            ]);

            if ($req->hasFile('foto')) {
                $file = $req->foto;
                $changedName = time() . random_int(100, 999) . '.' . $file->getClientOriginalExtension();
                $is_image = substr($file->getClientMimeType(), 0, 5) == 'image' ?? false;

                $path = 'private/satgas_ppa/' . $model->id . '/foto';
                $file->storeAs($path, $changedName);

                $canvas = Image::canvas(400, 600, '#ffffff');
                $img = Image::make($file->getRealPath());
                $height = $img->height();
                $width = $img->width();
                $img->resize($width > $height ? 400 : null, $height >= $width ? 600 : null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
                $canvas->insert($img, 'center');
                $canvas->save(storage_path('app/' . $path . '/' . $changedName));

                $modelFile = $this->modelFile();
                $modelFile->id_satgas_ppa = $model->id;
                $modelFile->type = 1;
                $modelFile->name = $file->getClientOriginalName();
                $modelFile->path = $path . '/' . $changedName;
                $modelFile->size = $file->getSize();
                $modelFile->ext = $file->getClientOriginalExtension();
                $modelFile->is_image = $is_image;
                $modelFile->save();
            }
            if ($req->hasFile('ktp')) {
                $file = $req->ktp;
                $changedName = time() . random_int(100, 999) . '.' . $file->getClientOriginalExtension();
                $is_image = substr($file->getClientMimeType(), 0, 5) == 'image' ?? false;

                $path = 'private/satgas_ppa/' . $model->id . '/ktp';
                $file->storeAs($path, $changedName);

                $modelFile = $this->modelFile();
                $modelFile->id_satgas_ppa = $model->id;
                $modelFile->type = 3;
                $modelFile->name = $file->getClientOriginalName();
                $modelFile->path = $path . '/' . $changedName;
                $modelFile->size = $file->getSize();
                $modelFile->ext = $file->getClientOriginalExtension();
                $modelFile->is_image = $is_image;
                $modelFile->save();
            }
            if ($req->file_sk) {
                foreach ($req->file_sk as $file) {
                    $changedName = time() . random_int(100, 999) . '.' . $file->getClientOriginalExtension();
                    $is_image = substr($file->getClientMimeType(), 0, 5) == 'image' ?? false;

                    $path = 'private/satgas_ppa/' . $model->id . '/file_sk';
                    $file->storeAs($path, $changedName);

                    $modelFile = $this->modelFile();
                    $modelFile->id_satgas_ppa = $model->id;
                    $modelFile->type = 2;
                    $modelFile->name = $file->getClientOriginalName();
                    $modelFile->path = $path . '/' . $changedName;
                    $modelFile->size = $file->getSize();
                    $modelFile->ext = $file->getClientOriginalExtension();
                    $modelFile->is_image = $is_image;
                    $modelFile->save();
                }
            }

            DB::commit();
            $this->responseCode = 201;
            return response()->json($this->getResponse(), $this->responseCode);
        } catch (\Exception $e) {
            DB::rollback();
            $this->responseCode = 500;
            $this->responseMessage = $e->getMessage() . ' ' . $e->getLine();
            return response()->json($this->getResponse(), $this->responseCode);
        }
    }

    public function show($id)
    {
        $id = intval($id);
        $model = $this->select()->where('satgas_ppa.id', $id)->first();
        if (!$model) {
            $this->responseCode = 404;
            $this->responseMessage = 'Data tidak ditemukan';
            return response()->json($this->getResponse(), $this->responseCode);
        }

        try {
            $this->responseCode = 200;
            $this->responseData = new DetailPuspagaRwResource($model);
            return response()->json($this->getResponse(), $this->responseCode);
        } catch (\Exception $e) {
            $this->responseCode = 500;
            $this->responseMessage = $e->getMessage() . ' ' . $e->getLine();
            return response()->json($this->getResponse(), $this->responseCode);
        }
    }

    public function update(Request $req, $id)
    {
        $id = intval($id);
        $model = $this->model()::find($id);
        if (!$model) {
            $this->responseCode = 404;
            $this->responseMessage = 'Data tidak ditemukan';
            return response()->json($this->getResponse(), $this->responseCode);
        }

        $this->authorize('update', $model);

        try {

            DB::beginTransaction();

            $rules = $this->rules();
            $rules['nik'] .= ',' . $id;
            $validator = Validator::make($req->all(), $rules);
            if ($validator->fails()) {
                $this->responseCode = 422;
                $this->responseMessage = $validator->errors()->first();
                $this->responseData = $validator->errors();
                return response()->json($this->getResponse(), $this->responseCode);
            }

            $model->name = $req->nama_lengkap;
            $model->nik = $req->nik;
            $model->sk_number = $req->nomor_sk;
            $model->sk_date = $req->tanggal_sk;

            $model->id_jabatan_dalam_instansi = $req->id_jabatan_dalam_instansi;
            $model->id_kedudukan_dalam_tim = $req->id_kedudukan_dalam_tim;
            $model->no_bank = $req->no_bank;
            $model->penerima_jasa_pelayanan = $req->penerima_jaspel;
            $model->id_jasa_pelayanan = $req->jasa_pelayanan;
            $model->id_kelurahan_domisili = $req->id_kelurahan_domisili;
            $model->alamat_domisili = $req->alamat_domisili;
            $model->rt_domisili = $req->rt_domisili;
            $model->rw_domisili = $req->rw_domisili;
            $model->id_kelurahan_ktp = $req->id_kelurahan_ktp;
            $model->alamat_ktp = $req->alamat_ktp;
            $model->rt_ktp = $req->rt_ktp;
            $model->rw_ktp = $req->rw_ktp;
            $model->no_hp = $req->no_hp;
            $model->email = $req->email;

            if (!$model->id_kelurahan) {
                $model->id_kelurahan = auth()->user()->id_kelurahan;
            }

            $model->save();

            $deletedFile = $this->modelFile()::where('type', 2)->where('id_satgas_ppa', $model->id);
            if ($req->file_sk_existing) {
                $deletedFile->whereNotIn('id', $req->file_sk_existing);
            }
            foreach ($deletedFile->get() as $d) {
                $d->forceDelete();
            }

            if ($req->hasFile('foto')) {
                $fotoOld = $this->modelFile()::where('type', 1)->where('id_satgas_ppa', $model->id)->first();
                if ($fotoOld) {
                    $fotoOld->forceDelete();
                }

                $file = $req->foto;
                $changedName = time() . random_int(100, 999) . '.' . $file->getClientOriginalExtension();
                $is_image = substr($file->getClientMimeType(), 0, 5) == 'image' ?? false;

                $path = 'private/satgas_ppa/' . $model->id . '/foto';
                $file->storeAs($path, $changedName);

                $canvas = Image::canvas(400, 600, '#ffffff');
                $img = Image::make($file->getRealPath());
                $height = $img->height();
                $width = $img->width();
                $img->resize($width > $height ? 400 : null, $height >= $width ? 600 : null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
                $canvas->insert($img, 'center');
                $canvas->save(storage_path('app/' . $path . '/' . $changedName));

                $modelFile = $this->modelFile();
                $modelFile->id_satgas_ppa = $model->id;
                $modelFile->type = 1;
                $modelFile->name = $file->getClientOriginalName();
                $modelFile->path = $path . '/' . $changedName;
                $modelFile->size = $file->getSize();
                $modelFile->ext = $file->getClientOriginalExtension();
                $modelFile->is_image = $is_image;
                $modelFile->save();
            }

            if ($req->hasFile('ktp')) {
                $ktpOld = $this->modelFile()::where('type', 3)->where('id_satgas_ppa', $model->id)->first();
                if ($ktpOld) {
                    $ktpOld->forceDelete();
                }

                $file = $req->ktp;
                $changedName = time() . random_int(100, 999) . '.' . $file->getClientOriginalExtension();
                $is_image = substr($file->getClientMimeType(), 0, 5) == 'image' ?? false;

                $path = 'private/satgas_ppa/' . $model->id . '/ktp';
                $file->storeAs($path, $changedName);

                $modelFile = $this->modelFile();
                $modelFile->id_satgas_ppa = $model->id;
                $modelFile->type = 3;
                $modelFile->name = $file->getClientOriginalName();
                $modelFile->path = $path . '/' . $changedName;
                $modelFile->size = $file->getSize();
                $modelFile->ext = $file->getClientOriginalExtension();
                $modelFile->is_image = $is_image;
                $modelFile->save();
            }

            if ($req->file_sk) {
                foreach ($req->file_sk as $file) {
                    $changedName = time() . random_int(100, 999) . '.' . $file->getClientOriginalExtension();
                    $is_image = substr($file->getClientMimeType(), 0, 5) == 'image' ?? false;

                    $path = 'private/satgas_ppa/' . $model->id . '/file_sk';
                    $file->storeAs($path, $changedName);

                    $modelFile = $this->modelFile();
                    $modelFile->id_satgas_ppa = $model->id;
                    $modelFile->type = 2;
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
            return response()->json($this->getResponse(), $this->responseCode);
        } catch (\Exception $e) {
            DB::rollback();
            $this->responseCode = 500;
            $this->responseMessage = $e->getMessage() . ' ' . $e->getLine();
            return response()->json($this->getResponse(), $this->responseCode);
        }
    }

    public function switchStatus($id)
    {
        $model = $this->model()::find($id);
        if (!$model) {
            $this->responseCode = 404;
            $this->responseMessage = 'Data tidak ditemukan';
            return response()->json($this->getResponse(), $this->responseCode);
        }

        $this->authorize('update', $model);

        try {
            // if (auth()->user()->id_role == config('env.role.kelurahan')) {
            //     $idKelurahan = auth()->user()->id_kelurahan;
            //     $IDORchecker = SatgasPpa::where('id', $id)->where('id_kelurahan', $idKelurahan)->exists();

            //     if ($IDORchecker == false) {
            //         $this->responseCode = 403;
            //         $this->responseMessage = 'User tidak memiliki hak akses';
            //         return response()->json($this->getResponse(), $this->responseCode);
            //     }
            // }

            $model->update([
                'is_active' => !$model->is_active,
            ]);

            DB::commit();
            $this->responseCode = 200;
            $this->responseMessage = boolval($model->is_active) ? 'Data telah diaktifkan' : 'Data telah dinonaktifkan';
            return response()->json($this->getResponse(), $this->responseCode);
        } catch (\Exception $e) {
            DB::rollback();
            $this->responseCode = 500;
            $this->responseMessage = $e->getMessage() . ' ' . $e->getLine();
            return response()->json($this->getResponse(), $this->responseCode);
        }
    }

    public function summary()
    {
        $this->authorize('summary', SatgasPpa::class);

        try {
            $anggota = SatgasPpa::query();
            $kelurahan = MKelurahan::query();
            $kecamatan = MKecamatan::query();

            $user = auth()->user();
            if ($user->id_role == config('env.role.kelurahan')) {
                $anggota->where(function ($q) use ($user) {
                    $q->where('id_kelurahan', $user->id_kelurahan);
                    // $q->orWhereNull('id_kelurahan');
                });
                $kelurahan->whereHas('satgasPpa', function ($q) use ($user) {
                    $q->where(function ($q) use ($user) {
                        $q->where('id_kelurahan', $user->id_kelurahan);
                        // $q->orWhereNull('id_kelurahan');
                    });
                });
                $kecamatan->whereHas('kelurahan.satgasPpa', function ($q) use ($user) {
                    $q->where(function ($q) use ($user) {
                        $q->where('id_kelurahan', $user->id_kelurahan);
                        // $q->orWhereNull('id_kelurahan');
                    });
                });
            } else {
                $kelurahan->whereHas('satgasPpaCreator');
                $kecamatan->whereHas('kelurahan.satgasPpaCreator');
            }

            $data = [
                'anggota' => $anggota->count(),
                'kelurahan' => $kelurahan->count(),
                'kecamatan' => $kecamatan->count(),
            ];

            $this->responseCode = 200;
            $this->responseData = $data;
            return response()->json($this->getResponse(), $this->responseCode);
        } catch (\Exception $e) {
            $this->responseCode = 500;
            $this->responseMessage = $e->getMessage() . ' ' . $e->getLine();
            return response()->json($this->getResponse(), $this->responseCode);
        }
    }

    public function downloadFormat()
    {
        $this->authorize('import', SatgasPpa::class);

        return Excel::download(new PkbmSheetExport, 'SatgasPpaFormatExport.xlsx');
    }

    public function import(Request $req)
    {
        $this->authorize('import', SatgasPpa::class);

        try {
            $rules = [
                'file' => 'required|mimes:xls,xlsx',
            ];
            $validator = Validator::make($req->all(), $rules);
            if ($validator->fails()) {
                $this->responseCode = 422;
                $this->responseMessage = $validator->errors()->first();
                $this->responseData = $validator->errors();
                return response()->json($this->getResponse(), $this->responseCode);
            }

            Excel::import(new SatgasPpaSheetImport, $req->file('file'));
            $this->responseCode = 200;
            return response()->json($this->getResponse(), $this->responseCode);
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $this->responseCode = 422;
            $this->responseMessage = 'Error validation';
            $this->responseData = $e->failures();
            return response()->json($this->getResponse(), $this->responseCode);
        }
    }

    public function cetakPdf($id)
    {
        $id = intval($id);
        $model = $this->select()->where('satgas_ppa.id', $id)->first();
        if (!$model) {
            $this->responseCode = 404;
            $this->responseMessage = 'Data tidak ditemukan';
            return response()->json($this->getResponse(), $this->responseCode);
        }

        $this->authorize('cetakPdf', $model);

        $pdf = PDF::loadView('pdf.cetakSatgasPPA', ['data' => json_decode(json_encode($model))]);

        $this->saveLog();
        return $pdf->download('cetak_satgas_ppa-' . $id . '.pdf');
    }

    public function downloadSK($id)
    {
        // if (auth()->user()->id_role == config('env.role.kelurahan')) {
        //     $idKelurahan = auth()->user()->id_kelurahan;
        //     $IDORchecker = SatgasPpa::where('id', $id)->where('id_kelurahan', $idKelurahan)->exists();

        //     if ($IDORchecker == false) {
        //         $this->responseCode = 403;
        //         $this->responseMessage = 'User tidak memiliki hak akses';
        //         return response()->json($this->getResponse(), $this->responseCode);
        //     }
        // }

        $id = intval($id);
        $model = $this->model()::find($id);
        if (!$model) {
            $this->responseCode = 404;
            $this->responseMessage = 'Data tidak ditemukan';
            return response()->json($this->getResponse(), $this->responseCode);
        }

        $this->authorize('downloadSK', $model);

        if (count($model->fileSK)) {
            $zipFilePath = storage_path('app/private/download_zip');
            if (!is_dir($zipFilePath)) {
                mkdir($zipFilePath, 0777);
            }

            $zip = new ZipArchive();
            $fileName = $zipFilePath . '/Satgas_PPA-' . $model->id . '.zip';
            if ($zip->open($fileName, ZipArchive::CREATE | ZipArchive::OVERWRITE) == TRUE) {
                foreach ($model->fileSK as $file) {
                    $pathFile = storage_path('app/' . $file->path);
                    if (file_exists($pathFile)) {
                        $zip->addFile($pathFile, $file->name);
                    }
                }
                $zip->close();
            }

            return response()
                ->download($fileName)
                ->deleteFileAfterSend(true);
        }

        $this->responseCode = 400;
        $this->responseMessage = 'File kosong silahkan hubungi administrator';
        return response()->json($this->getResponse(), $this->responseCode);
    }

    public function export(Request $req)
    {
        $this->authorize('export', SatgasPpa::class);

        ini_set('memory_limit', -1);
        
        return Excel::download(new DatabaseExport((json_decode($this->select()->get())), 'exports.satgasPPA'), 'SatgasPPA.xlsx');
    }
}