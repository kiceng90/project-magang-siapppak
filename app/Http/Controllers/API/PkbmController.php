<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PkbmSheetExport;
use App\Exports\DatabaseExport;
use App\Imports\PkbmSheetImport;

use App\Http\Resources\DetailPuspagaRwResource;

use App\Models\Pkbm;
use App\Models\PkbmFile;
use App\Models\MKelurahan;
use App\Models\MKecamatan;

use Illuminate\Support\Facades\DB;
use PDF;
use Illuminate\Support\Facades\Validator;
use ZipArchive;
use Image;

class PkbmController extends Controller
{
    public function model()
    {
        return new Pkbm();
    }

    public function modelFile()
    {
        return new PkbmFile();
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
            'file_sk_existing' => 'exists:App\Models\PkbmFile,id,type,2',
        ];
    }

    private function select()
    {
        $data = $this->model()::select([
            'pkbm.*', DB::raw('f.id as foto'), 'f.path AS foto_path',
            DB::raw('kec_dom.id as kecamatan_domisili_id'), DB::raw('kec_dom.name as kecamatan_domisili_name'),
            DB::raw('kel_dom.id as kelurahan_domisili_id'), DB::raw('kel_dom.name as kelurahan_domisili_name'),
            DB::raw('kec_ktp.id as kecamatan_ktp_id'), DB::raw('kec_ktp.name as kecamatan_ktp_name'),
            DB::raw('kel_ktp.id as kelurahan_ktp_id'), DB::raw('kel_ktp.name as kelurahan_ktp_name'),
            DB::raw('m_jabatan_dalam_instansi.name AS jabatan_dalam_instansi_name'),
            DB::raw('m_kedudukan_dalam_tim.name AS kedudukan_dalam_tim_name'),
            'ktp.id AS ktp_link', 'ktp.path AS ktp_path',
            'm_kecamatan.name AS kecamatan_name',
            'creator.id AS creator_id', 'creator.name AS creator_name', 'creator.username AS creator_username',
        ])
            ->leftJoin('pkbm_file as f', function ($j) {
                $j->on('pkbm.id', '=', 'f.id_pkbm');
                $j->where('f.type', 1);
            })
            ->leftJoin('pkbm_file as ktp', function ($j) {
                $j->on('pkbm.id', '=', 'ktp.id_pkbm');
                $j->where('ktp.type', 3);
            })
            ->leftJoin('m_kelurahan as kel_dom', 'kel_dom.id', '=', 'pkbm.id_kelurahan_domisili')
            ->leftJoin('m_kecamatan as kec_dom', 'kec_dom.id', '=', 'kel_dom.id_kecamatan')
            ->leftJoin('m_kelurahan as kel_ktp', 'kel_ktp.id', '=', 'pkbm.id_kelurahan_ktp')
            ->leftJoin('m_kecamatan as kec_ktp', 'kec_ktp.id', '=', 'kel_ktp.id_kecamatan')
            ->leftJoin('m_jabatan_dalam_instansi', 'm_jabatan_dalam_instansi.id', '=', 'pkbm.id_jabatan_dalam_instansi')
            ->leftJoin('m_kedudukan_dalam_tim', 'm_kedudukan_dalam_tim.id', '=', 'pkbm.id_kedudukan_dalam_tim')
            ->leftJoin('m_kecamatan', 'm_kecamatan.id', '=', 'pkbm.id_kecamatan')
            ->leftJoin('m_user AS creator', 'creator.id', '=', 'pkbm.created_by');
        if (auth()->user()->id_role != config('env.role.admin')) {
            $data->where(function ($q) {
                $q->where('pkbm.id_kecamatan', auth()->user()->id_kecamatan);
                // $q->orWhere('pkbm.id_kecamatan', null);
            });
        }

        return $data;
    }

    public function index(Request $req)
    {
        $this->authorize('viewAny', Pkbm::class);

        try {
            $model = $this->select();

            $limit = $req->limit ? intval($req->limit) : 10;
            if ($limit > 100) $limit = 100;

            $order = Str::lower($req->order) == 'asc' ? 'asc' : 'desc';
            $sortby = $req->sortby ? $req->sortby : 'id';

            if ($req->filled('id_kecamatan')) {
                $model->where('pkbm.id_kecamatan', $req->id_kecamatan);
            }

            if ($req->filled('is_active')) {
                $model->where('pkbm.is_active', $req->id_kecamatan);
            }

            if ($req->filled('search')) {
                $model->where(function ($q) use ($req) {
                    $s = $req->search;
                    $q->where('pkbm.name', 'ILIKE', '%' . $s . '%');
                    $q->orWhere('pkbm.nik', 'ILIKE', '%' . $s . '%');
                    $q->orWhere('pkbm.sk_number', 'ILIKE', '%' . $s . '%');
                    // $q->orWhere('pkbm.rw', 'ILIKE', '%'. $s .'%');
                    $q->orWhere('m_jabatan_dalam_instansi.name', 'ILIKE', '%' . $s . '%');
                    $q->orWhere('m_kedudukan_dalam_tim.name', 'ILIKE', '%' . $s . '%');
                    $q->orWhere('cretor_by.name ', 'ILIKE', '%' . $s . '%');
                    // $q->orWhere('kec_dom.name', 'ILIKE', '%' . $s . '%');
                    // $q->orWhere('kel_dom.name', 'ILIKE', '%' . $s . '%');
                    // $q->orWhere('kec_ktp.name', 'ILIKE', '%'. $s .'%');
                    // $q->orWhere('kel_ktp.name', 'ILIKE', '%'. $s .'%');
                });
            }

            $model = $model->orderBy($sortby, $order)->paginate($limit);

            $this->saveLog($model);
            return $model;
        } catch (\Exception $e) {
            $this->responseCode = 500;
            $this->responseMessage = $e->getMessage() . ' ' . $e->getLine();
            return response()->json($this->getResponse(), $this->responseCode);
        }
    }

    public function store(Request $req)
    {
        $this->authorize('create', Pkbm::class);

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

                'id_kecamatan' => auth()->user()->id_kecamatan,
            ]);

            if ($req->hasFile('foto')) {
                $file = $req->foto;
                $changedName = time() . random_int(100, 999) . '.' . $file->getClientOriginalExtension();
                $is_image = substr($file->getClientMimeType(), 0, 5) == 'image' ?? false;

                $path = 'private/pkbm/' . $model->id . '/foto';
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
                $modelFile->id_pkbm = $model->id;
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

                $path = 'private/pkbm/' . $model->id . '/ktp';
                $file->storeAs($path, $changedName);

                $modelFile = $this->modelFile();
                $modelFile->id_pkbm = $model->id;
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

                    $path = 'private/pkbm/' . $model->id . '/file_sk';
                    $file->storeAs($path, $changedName);

                    $modelFile = $this->modelFile();
                    $modelFile->id_pkbm = $model->id;
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
        $model = $this->select()->where('pkbm.id', $id)->first();
        if (!$model) {
            $this->responseCode = 404;
            $this->responseMessage = 'Data tidak ditemukan';
            return response()->json($this->getResponse(), $this->responseCode);
        }

        $this->authorize('view', $model);

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

        $rules = $this->rules();
        $rules['nik'] .= ',' . $id;
        $validator = Validator::make($req->all(), $rules);
        if ($validator->fails()) {
            $this->responseCode = 422;
            $this->responseMessage = $validator->errors()->first();
            $this->responseData = $validator->errors();
            return response()->json($this->getResponse(), $this->responseCode);
        }

        try {
            DB::beginTransaction();

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

            if (!$model->id_kecamatan) {
                $model->id_kecamatan = auth()->user()->id_kecamatan;
            }

            $model->save();

            $deletedFile = $this->modelFile()::where('type', 2)->where('id_pkbm', $model->id);
            if ($req->file_sk_existing) {
                $deletedFile->whereNotIn('id', $req->file_sk_existing);
            }
            foreach ($deletedFile->get() as $d) {
                $d->forceDelete();
            }

            if ($req->hasFile('foto')) {
                $fotoOld = $this->modelFile()::where('type', 1)->where('id_pkbm', $model->id)->first();
                if ($fotoOld) {
                    $fotoOld->forceDelete();
                }

                $file = $req->foto;
                $changedName = time() . random_int(100, 999) . '.' . $file->getClientOriginalExtension();
                $is_image = substr($file->getClientMimeType(), 0, 5) == 'image' ?? false;

                $path = 'private/pkbm/' . $model->id . '/foto';
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
                $modelFile->id_pkbm = $model->id;
                $modelFile->type = 1;
                $modelFile->name = $file->getClientOriginalName();
                $modelFile->path = $path . '/' . $changedName;
                $modelFile->size = $file->getSize();
                $modelFile->ext = $file->getClientOriginalExtension();
                $modelFile->is_image = $is_image;
                $modelFile->save();
            }

            if ($req->hasFile('ktp')) {
                $ktpOld = $this->modelFile()::where('type', 3)->where('id_pkbm', $model->id)->first();
                if ($ktpOld) {
                    $ktpOld->forceDelete();
                }

                $file = $req->ktp;
                $changedName = time() . random_int(100, 999) . '.' . $file->getClientOriginalExtension();
                $is_image = substr($file->getClientMimeType(), 0, 5) == 'image' ?? false;

                $path = 'private/pkbm/' . $model->id . '/ktp';
                $file->storeAs($path, $changedName);

                $modelFile = $this->modelFile();
                $modelFile->id_pkbm = $model->id;
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

                    $path = 'private/pkbm/' . $model->id . '/file_sk';
                    $file->storeAs($path, $changedName);

                    $modelFile = $this->modelFile();
                    $modelFile->id_pkbm = $model->id;
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
            // if (auth()->user()->id_role == config('env.role.kecamatan')) {
            //     $idKecamatan = auth()->user()->id_kecamatan;
            //     $IDORchecker = Pkbm::where('id', $id)->where('id_kecamatan', $idKecamatan)->exists();

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
        try {
            $anggota = Pkbm::query();
            $kelurahan = MKelurahan::query();
            $kecamatan = MKecamatan::query();

            $user = auth()->user();
            if ($user->id_role == config('env.role.kecamatan')) {
                $anggota->where(function ($q) use ($user) {
                    $q->where('id_kecamatan', $user->id_kecamatan);
                    // $q->orWhereNull('id_kecamatan');
                });
                $kelurahan->whereHas('pkbm', function ($q) use ($user) {
                    $q->where(function ($q) use ($user) {
                        $q->where('id_kecamatan', $user->id_kecamatan);
                        // $q->orWhereNull('id_kecamatan');
                    });
                });
                $kecamatan->whereHas('kelurahan.pkbm', function ($q) use ($user) {
                    $q->where(function ($q) use ($user) {
                        $q->where('id_kecamatan', $user->id_kecamatan);
                        // $q->orWhereNull('id_kecamatan');
                    });
                });
            } else {
                $kelurahan->whereHas('pkbm');
                $kecamatan->whereHas('pkbm');
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
        return Excel::download(new PkbmSheetExport, 'PkbmFormatExport.xlsx');
    }

    public function import(Request $req)
    {
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

            Excel::import(new PkbmSheetImport, $req->file('file'));
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
        $model = $this->select()->where('pkbm.id', $id)->first();
        if (!$model) {
            $this->responseCode = 404;
            $this->responseMessage = 'Data tidak ditemukan';
            return response()->json($this->getResponse(), $this->responseCode);
        }

        $this->authorize('cetakPdf', $model);

        $pdf = PDF::loadView('pdf.cetakPKBM', ['data' => json_decode(json_encode($model))]);

        $this->saveLog();
        return $pdf->download('cetak_pkbm-' . $id . '.pdf');
    }

    public function downloadSK($id)
    {
        // if (auth()->user()->id_role == config('env.role.kecamatan')) {
        //     $idKecamatan = auth()->user()->id_kecamatan;
        //     $IDORchecker = Pkbm::where('id', $id)->where('id_kecamatan', $idKecamatan)->exists();

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
            $fileName = $zipFilePath . '/PKBM-' . $model->id . '.zip';
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
        $this->authorize('export', Pkbm::class);

        ini_set('memory_limit', -1);
        return Excel::download(new DatabaseExport((json_decode($this->select()->get())), 'exports.pkbm'), 'PKBM.xlsx');
    }
}
