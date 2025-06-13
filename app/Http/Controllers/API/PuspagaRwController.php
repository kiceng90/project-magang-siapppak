<?php

namespace App\Http\Controllers\API;

use App\Enums\PuspagaRwFileTypeEnum;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\PuspagaRwFile;
use App\Models\PuspagaRw;
use App\Http\Resources\DetailPuspagaRwResource;
use App\Models\MKelurahan;
use App\Models\MKecamatan;
use App\Imports\PuspagaRwImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PuspagaRwFormatExport;
use App\Exports\DatabaseExport;
use PDF;
use ZipArchive;
use Image;

class PuspagaRwController extends Controller
{
    private function rules()
    {
        return [
            'nama_lengkap' => 'required|string',
            'nik' => 'required|numeric|digits:16|unique:App\Models\PuspagaRw,nik',
            'nomor_sk' => 'required|string',
            'tanggal_sk' => 'required|date',
            'rw' => 'required|numeric',

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

            // 'jabatan_instansi' => 'required|string',
            // 'jabatan_sk' => 'required|string',

            'foto' => 'nullable|mimes:png,jpg,jpeg',
            'ktp' => 'nullable|mimes:png,jpg,jpeg|max_mb:5',
            'file_sk' => 'nullable|array',
            'file_sk.*' => 'mimes:png,jpg,jpeg,pdf|max_mb:10',
            'file_sk_existing' => 'nullable|array',
            'file_sk_existing' => 'exists:App\Models\PuspagaRwFile,id,type,2',

            'id_kelurahan' => 'nullable|exists:App\Models\MKelurahan,id',
        ];
    }

    private function select()
    {
        $data = PuspagaRw::select([
            'puspaga_rw.*', DB::raw('f.id as foto'), 'f.path AS foto_path',
            DB::raw('kec_dom.id as kecamatan_domisili_id'), DB::raw('kec_dom.name as kecamatan_domisili_name'),
            DB::raw('kel_dom.id as kelurahan_domisili_id'), DB::raw('kel_dom.name as kelurahan_domisili_name'),
            DB::raw('kec_ktp.id as kecamatan_ktp_id'), DB::raw('kec_ktp.name as kecamatan_ktp_name'),
            DB::raw('kel_ktp.id as kelurahan_ktp_id'), DB::raw('kel_ktp.name as kelurahan_ktp_name'),
            'puspaga_rw.rw', 'puspaga_rw.is_active', DB::raw('m_jabatan_dalam_instansi.name AS jabatan_dalam_instansi_name'),
            DB::raw('m_kedudukan_dalam_tim.name AS kedudukan_dalam_tim_name'),
            'ktp.id AS ktp_link', 'ktp.path AS ktp_path',
            'm_kecamatan.name AS kecamatan_name',
            'm_kelurahan.name AS kelurahan_name',
            'creator.id AS creator_id', 'creator.name AS creator_name', 'creator.username AS creator_username',
        ])
            ->leftJoin('puspaga_rw_file as f', function ($j) {
                $j->on('puspaga_rw.id', '=', 'f.id_puspaga_rw');
                $j->where('f.type', PuspagaRwFileTypeEnum::FOTO);
            })
            ->leftJoin('puspaga_rw_file as ttd', function ($j) {
                $j->on('puspaga_rw.id', '=', 'ttd.id_puspaga_rw');
                $j->where('ttd.type', PuspagaRwFileTypeEnum::TTD);
            })
            ->leftJoin('puspaga_rw_file as ktp', function ($j) {
                $j->on('puspaga_rw.id', '=', 'ktp.id_puspaga_rw');
                $j->where('ktp.type', PuspagaRwFileTypeEnum::KTP);
            })
            ->leftJoin('m_kelurahan as kel_dom', 'kel_dom.id', '=', 'puspaga_rw.id_kelurahan_domisili')
            ->leftJoin('m_kecamatan as kec_dom', 'kec_dom.id', '=', 'kel_dom.id_kecamatan')
            ->leftJoin('m_kelurahan as kel_ktp', 'kel_ktp.id', '=', 'puspaga_rw.id_kelurahan_ktp')
            ->leftJoin('m_kecamatan as kec_ktp', 'kec_ktp.id', '=', 'kel_ktp.id_kecamatan')
            ->leftJoin('m_jabatan_dalam_instansi', 'm_jabatan_dalam_instansi.id', '=', 'puspaga_rw.id_jabatan_dalam_instansi')
            ->leftJoin('m_kedudukan_dalam_tim', 'm_kedudukan_dalam_tim.id', '=', 'puspaga_rw.id_kedudukan_dalam_tim')
            ->leftJoin('m_kecamatan', 'm_kecamatan.id', '=', 'puspaga_rw.id_kecamatan')
            ->leftJoin('m_kelurahan', 'm_kelurahan.id', '=', 'puspaga_rw.id_kelurahan')
            ->leftJoin('m_user AS creator', 'creator.id', '=', 'puspaga_rw.created_by');
        if (auth()->user()->id_role != config('env.role.admin')) {
            $data->where(function ($q) {
                $q->where('puspaga_rw.id_kecamatan', auth()->user()->id_kecamatan);
                // $q->orWhere('puspaga_rw.id_kecamatan', null);
            });
        }

        return $data;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $req)
    {
        try {
            $puspaga = $this->select();

            $limit = $req->limit ? intval($req->limit) : 10;
            $order = $req->order ? $req->order : 'DESC';
            $sortby = $req->sortby ? $req->sortby : 'id';

            if ($req->filled('id_kelurahan')) {
                $puspaga->where('puspaga_rw.id_kelurahan_domisili', $req->id_kelurahan);
            } else if ($req->filled('id_kecamatan')) {
                $puspaga->where('kec_dom.id', $req->id_kecamatan);
            }

            if ($req->filled('rw')) {
                $puspaga->where('puspaga_rw.rw', $req->rw);
            }

            if ($req->filled('search')) {
                $puspaga->where(function ($q) use ($req) {
                    $s = $req->search;
                    $q->where('puspaga_rw.name', 'ILIKE', '%' . $s . '%');
                    $q->orWhere('puspaga_rw.nik', 'ILIKE', '%' . $s . '%');
                    $q->orWhere('puspaga_rw.sk_number', 'ILIKE', '%' . $s . '%');
                    $q->orWhere('puspaga_rw.rw', 'ILIKE', '%' . $s . '%');
                    $q->orWhere('m_jabatan_dalam_instansi.name', 'ILIKE', '%' . $s . '%');
                    $q->orWhere('m_kedudukan_dalam_tim.name', 'ILIKE', '%' . $s . '%');
                    $q->orWhere('kec_dom.name', 'ILIKE', '%' . $s . '%');
                    $q->orWhere('kel_dom.name', 'ILIKE', '%' . $s . '%');
                });
            }

            $puspaga = $puspaga->orderBy($sortby, $order)->paginate($limit);

            $this->saveLog($puspaga);
            return $puspaga;
        } catch (\Exception $e) {
            $this->responseCode = 500;
            $this->responseMessage = $e->getMessage() . ' ' . $e->getLine();
            return response()->json($this->getResponse(), $this->responseCode);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $req)
    {
        try {
            DB::beginTransaction();

            $validator = Validator::make($req->all(), $this->rules());
            if ($validator->fails()) {
                $this->responseCode = 422;
                $this->responseMessage = $validator->errors()->first();
                $this->responseData = $validator->errors();
                return response()->json($this->getResponse(), $this->responseCode);
            }

            $puspaga = PuspagaRw::create([
                'name' => $req->nama_lengkap,
                'nik' => $req->nik,
                'sk_number' => $req->nomor_sk,
                'sk_date' => $req->tanggal_sk,
                // 'instansi_position' => $req->jabatan_instansi,
                // 'sk_position' => $req->jabatan_sk,
                // 'id_kelurahan' => $req->id_kelurahan,
                'rw' => $req->rw,

                'id_jabatan_dalam_instansi' => $req->id_jabatan_dalam_instansi,
                'no_bank' => $req->no_bank,
                'id_kedudukan_dalam_tim' => $req->id_kedudukan_dalam_tim,
                'penerima_jasa_pelayanan' => $req->sub_jasa_pelayanan,
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
                'id_kelurahan' => $req->id_kelurahan,
            ]);

            if ($req->hasFile('foto')) {
                $file = $req->foto;
                $changedName = time() . random_int(100, 999) . '.' . $file->getClientOriginalExtension();
                $is_image = substr($file->getClientMimeType(), 0, 5) == 'image' ?? false;

                $path = 'private/puspaga_rw/' . $puspaga->id . '/foto';
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

                $modelFile = new PuspagaRwFile();
                $modelFile->id_puspaga_rw = $puspaga->id;
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

                $path = 'private/puspaga_rw/' . $puspaga->id . '/ktp';
                $file->storeAs($path, $changedName);

                $modelFile = new PuspagaRwFile();
                $modelFile->id_puspaga_rw = $puspaga->id;
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

                    $path = 'private/puspaga_rw/' . $puspaga->id . '/file_sk';
                    $file->storeAs($path, $changedName);

                    $modelFile = new PuspagaRwFile();
                    $modelFile->id_puspaga_rw = $puspaga->id;
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $id = intval($id);
            $puspaga = $this->select()->where('puspaga_rw.id', $id)->first();
            if (!$puspaga) {
                $this->responseCode = 404;
                $this->responseMessage = 'Data tidak ditemukan';
                return response()->json($this->getResponse(), $this->responseCode);
            }

            $this->responseCode = 200;
            $this->responseData = new DetailPuspagaRwResource($puspaga);
            return response()->json($this->getResponse(), $this->responseCode);
        } catch (\Exception $e) {
            $this->responseCode = 500;
            $this->responseMessage = $e->getMessage() . ' ' . $e->getLine();
            return response()->json($this->getResponse(), $this->responseCode);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $req, $id)
    {
        try {
            $id = intval($id);
            $puspaga = PuspagaRw::find($id);
            if (!$puspaga) {
                $this->responseCode = 404;
                $this->responseMessage = 'Data tidak ditemukan';
                return response()->json($this->getResponse(), $this->responseCode);
            }

            DB::beginTransaction();

            $rules = $this->rules();
            $rules['nik'] .= ',' . $id;
            // $rules['nomor_sk'] .= ','.$id;
            $validator = Validator::make($req->all(), $rules);
            if ($validator->fails()) {
                $this->responseCode = 422;
                $this->responseMessage = $validator->errors()->first();
                $this->responseData = $validator->errors();
                return response()->json($this->getResponse(), $this->responseCode);
            }

            $puspaga->name = $req->nama_lengkap;
            $puspaga->nik = $req->nik;
            $puspaga->sk_number = $req->nomor_sk;
            $puspaga->sk_date = $req->tanggal_sk;

            // $puspaga->instansi_position = $req->jabatan_instansi;
            // $puspaga->sk_position = $req->jabatan_sk;
            // $puspaga->id_kelurahan = $req->id_kelurahan;

            $puspaga->rw = $req->rw;

            $puspaga->id_jabatan_dalam_instansi = $req->id_jabatan_dalam_instansi;
            $puspaga->id_kedudukan_dalam_tim = $req->id_kedudukan_dalam_tim;
            $puspaga->penerima_jasa_pelayanan = $req->sub_jasa_pelayanan;
            $puspaga->id_jasa_pelayanan = $req->jasa_pelayanan;
            $puspaga->id_kelurahan_domisili = $req->id_kelurahan_domisili;
            $puspaga->alamat_domisili = $req->alamat_domisili;
            $puspaga->rt_domisili = $req->rt_domisili;
            $puspaga->rw_domisili = $req->rw_domisili;
            $puspaga->id_kelurahan_ktp = $req->id_kelurahan_ktp;
            $puspaga->alamat_ktp = $req->alamat_ktp;
            $puspaga->rt_ktp = $req->rt_ktp;
            $puspaga->rw_ktp = $req->rw_ktp;
            $puspaga->no_hp = $req->no_hp;
            $puspaga->email = $req->email;

            if (!$puspaga->id_kecamatan) {
                $puspaga->id_kecamatan = auth()->user()->id_kecamatan;
            }
            $puspaga->id_kelurahan = $req->id_kelurahan;

            $puspaga->save();

            $deletedFile = PuspagaRwFile::where('type', PuspagaRwFileTypeEnum::SK)->where('id_puspaga_rw', $puspaga->id);
            if ($req->file_sk_existing) {
                $deletedFile->whereNotIn('id', $req->file_sk_existing);
            }
            foreach ($deletedFile->get() as $d) {
                $d->forceDelete();
            }

            if ($req->hasFile('foto')) {
                $fotoOld = PuspagaRwFile::where('type', PuspagaRwFileTypeEnum::FOTO)->where('id_puspaga_rw', $puspaga->id)->first();
                if ($fotoOld) {
                    $fotoOld->forceDelete();
                }

                $file = $req->foto;
                $changedName = time() . random_int(100, 999) . '.' . $file->getClientOriginalExtension();
                $is_image = substr($file->getClientMimeType(), 0, 5) == 'image' ?? false;

                $path = 'private/puspaga_rw/' . $puspaga->id . '/foto';
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

                $modelFile = new PuspagaRwFile();
                $modelFile->id_puspaga_rw = $puspaga->id;
                $modelFile->type = 1;
                $modelFile->name = $file->getClientOriginalName();
                $modelFile->path = $path . '/' . $changedName;
                $modelFile->size = $file->getSize();
                $modelFile->ext = $file->getClientOriginalExtension();
                $modelFile->is_image = $is_image;
                $modelFile->save();
            }

            if ($req->hasFile('ktp')) {
                $ktpOld = PuspagaRwFile::where('type', PuspagaRwFileTypeEnum::KTP)->where('id_puspaga_rw', $puspaga->id)->first();
                if ($ktpOld) {
                    $ktpOld->forceDelete();
                }

                $file = $req->ktp;
                $changedName = time() . random_int(100, 999) . '.' . $file->getClientOriginalExtension();
                $is_image = substr($file->getClientMimeType(), 0, 5) == 'image' ?? false;

                $path = 'private/puspaga_rw/' . $puspaga->id . '/ktp';
                $file->storeAs($path, $changedName);

                $modelFile = new PuspagaRwFile();
                $modelFile->id_puspaga_rw = $puspaga->id;
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

                    $path = 'private/puspaga_rw/' . $puspaga->id . '/file_sk';
                    $file->storeAs($path, $changedName);

                    $modelFile = new PuspagaRwFile();
                    $modelFile->id_puspaga_rw = $puspaga->id;
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
        try {
            if (auth()->user()->id_role == config('env.role.kecamatan')) {
                $idKecamatan = auth()->user()->id_kecamatan;
                $IDORchecker = PuspagaRw::where('id', $id)->where('id_kecamatan', $idKecamatan)->exists();

                if ($IDORchecker == false) {
                    $this->responseCode = 403;
                    $this->responseMessage = 'User tidak memiliki hak akses';
                    return response()->json($this->getResponse(), $this->responseCode);
                }
            }

            $puspaga = PuspagaRw::find($id);
            if (!$puspaga) {
                $this->responseCode = 404;
                $this->responseMessage = 'Data tidak ditemukan';
                return response()->json($this->getResponse(), $this->responseCode);
            }

            $puspaga->update([
                'is_active' => !$puspaga->is_active,
            ]);

            DB::commit();
            $this->responseCode = 200;
            $this->responseMessage = boolval($puspaga->is_active) ? 'Data telah diaktifkan' : 'Data telah dinonaktifkan';
            return response()->json($this->getResponse(), $this->responseCode);
        } catch (\Exception $e) {
            DB::rollback();
            $this->responseCode = 500;
            $this->responseMessage = $e->getMessage() . ' ' . $e->getLine();
            return response()->json($this->getResponse(), $this->responseCode);
        }
    }

    public function listRw(Request $req)
    {
        try {
            $limit = $req->limit ? intval($req->limit) : 10;

            $rw = PuspagaRw::select('rw')->distinct();
            if ($req->filled('search')) {
                $rw->where('rw', 'ILIKE', '%' . $req->search . '%');
            }

            $rw = $rw->take($limit)->pluck('rw');
            $this->responseCode = 200;
            $this->responseData = $rw;
            return response()->json($this->getResponse(), $this->responseCode);
        } catch (\Exception $e) {
            $this->responseCode = 500;
            $this->responseMessage = $e->getMessage() . ' ' . $e->getLine();
            return response()->json($this->getResponse(), $this->responseCode);
        }
    }

    public function summary()
    {
        try {
            $anggota = PuspagaRw::query();
            $puspaga = PuspagaRw::select('rw');
            $kelurahan = MKelurahan::query();
            $kecamatan = MKecamatan::query();

            $user = auth()->user();
            if ($user->id_role == config('env.role.kecamatan')) {
                $anggota->where(function ($q) use ($user) {
                    $q->where('id_kecamatan', $user->id_kecamatan);
                    // $q->orWhereNull('id_kecamatan');
                });
                $puspaga->where(function ($q) use ($user) {
                    $q->where('id_kecamatan', $user->id_kecamatan);
                    // $q->orWhereNull('id_kecamatan');
                });
                $kelurahan->whereHas('puspagaRw', function ($q) use ($user) {
                    $q->where(function ($q) use ($user) {
                        $q->where('id_kecamatan', $user->id_kecamatan);
                        // $q->orWhereNull('id_kecamatan');
                    });
                });
                $kecamatan->whereHas('kelurahan.puspagaRw', function ($q) use ($user) {
                    $q->where(function ($q) use ($user) {
                        $q->where('id_kecamatan', $user->id_kecamatan);
                        // $q->orWhereNull('id_kecamatan');
                    });
                });
            } else {
                $kelurahan->whereHas('puspagaRwLembaga');
                $kecamatan->whereHas('puspagaRw');
            }

            $data = [
                'anggota' => $anggota->count(),
                'puspaga' => $puspaga->distinct()->get()->count(),
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

            Excel::import(new PuspagaRwImport, $req->file('file'));
            $this->responseCode = 200;
            return response()->json($this->getResponse(), $this->responseCode);
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $this->responseCode = 422;
            $this->responseMessage = 'Error validation';
            $this->responseData = $e->failures();
            return response()->json($this->getResponse(), $this->responseCode);
        } catch (\Exception $e) {
            $this->responseCode = 500;
            $this->responseMessage = $e->getMessage() . ' ' . $e->getLine();
            return response()->json($this->getResponse(), $this->responseCode);
        }
    }

    public function downloadFormat()
    {
        try {
            return Excel::download(new PuspagaRwFormatExport, 'PuspagaRwFormatExport.xlsx');
        } catch (\Exception $e) {
            $this->responseCode = 500;
            $this->responseMessage = $e->getMessage() . ' ' . $e->getLine();
            return response()->json($this->getResponse(), $this->responseCode);
        }
    }

    public function cetakPdf($id)
    {
        $id = intval($id);
        $model = $this->select()->where('puspaga_rw.id', $id)->first();
        if (!$model) {
            $this->responseCode = 404;
            $this->responseMessage = 'Data tidak ditemukan';
            return response()->json($this->getResponse(), $this->responseCode);
        }

        $pdf = PDF::loadView('pdf.cetakPuspagaRW', ['data' => json_decode(json_encode($model))]);

        $this->saveLog();
        return $pdf->download('cetak_pupaga_rw-' . $id . '.pdf');
    }

    public function downloadSK($id)
    {
        if (auth()->user()->id_role == config('env.role.kecamatan')) {
            $idKecamatan = auth()->user()->id_kecamatan;
            $IDORchecker = PuspagaRw::where('id', $id)->where('id_kecamatan', $idKecamatan)->exists();

            if ($IDORchecker == false) {
                $this->responseCode = 403;
                $this->responseMessage = 'User tidak memiliki hak akses';
                return response()->json($this->getResponse(), $this->responseCode);
            }
        }

        $id = intval($id);
        $model = PuspagaRw::find($id);
        if (!$model) {
            $this->responseCode = 404;
            $this->responseMessage = 'Data tidak ditemukan';
            return response()->json($this->getResponse(), $this->responseCode);
        }

        if (count($model->fileSK)) {
            $zipFilePath = storage_path('app/private/download_zip');
            if (!is_dir($zipFilePath)) {
                mkdir($zipFilePath, 0777);
            }

            $zip = new ZipArchive();
            $fileName = $zipFilePath . '/Puspaga_RW-' . $model->id . '.zip';
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
        ini_set('memory_limit', -1);
        return Excel::download(new DatabaseExport(json_decode($this->select()->get()), 'exports.pupagaRW'), 'PuspagaRW.xlsx');
    }
    public function listPublic(Request $req)
    {
        try {
            $limit = $req->limit ? intval($req->limit) : 10;

            $rw = PuspagaRw::select('*');
            if ($req->filled('search')) {
                $rw->where('rw', 'ILIKE', '%' . $req->search . '%');
            }
            if ($req->filled('nik')) {
                $rw->where('nik', 'ILIKE', '%' . $req->nik . '%');
            }

            $rw = $rw->take($limit)->get();
            $this->responseCode = 200;
            $this->responseData = $rw;
            return response()->json($this->getResponse(), $this->responseCode);
        } catch (\Exception $e) {
            $this->responseCode = 500;
            $this->responseMessage = $e->getMessage() . ' ' . $e->getLine();
            return response()->json($this->getResponse(), $this->responseCode);
        }
    }
}