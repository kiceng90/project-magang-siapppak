<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;
use File;

use App\Models\DaftarKlien;
use App\Models\Pengaduan;
use App\Models\PengaduanFile;
use App\Models\Penjangkauan;
use App\Models\PenjangkauanFile;
use App\Models\PenjangkauanKonselor;
use App\Models\Klien;
use App\Models\KlienHistory;
use App\Models\KeluargaKlien;
use App\Models\SaudaraKlien;
use App\Models\RencanaIntervensi;
use App\Models\RencanaIntervensiFile;
use App\Models\TimelinePengaduan;

use App\Http\Resources\PenjangkauanResource;
use App\Http\Resources\KlienResource;
use App\Http\Resources\KlienHistoryResource;
use App\Http\Resources\DaftarKlienResource;
use App\Http\Resources\KeluargaKlienResource;
use App\Http\Resources\SaudaraKlienResource;
use App\Http\Resources\RencanaIntervensiResource;
use Facade\FlareClient\Stacktrace\File as StacktraceFile;
use Illuminate\Support\Facades\File as FacadesFile;
use WordTemplate;
use Illuminate\Validation\Rule;

class PenjangkauanController extends Controller
{
    public function show($id)
    {
        try {
            if (auth()->user()->id_role == config('env.role.opd')) {
                $idOpd = auth()->user()->id_opd;
                $IDORchecker = Penjangkauan::whereHas('rencanaIntervensi', function ($q) use ($idOpd) {
                    $q->where('rencana_intervensi.id_opd', $idOpd);
                })->where('id', $id)->exists();

                if ($IDORchecker == false) {
                    $this->responseCode = 403;
                    $this->responseMessage = 'User tidak memiliki hak akses';
                    return response()->json($this->getResponse(), $this->responseCode);
                }
            }

            $penjangkauan = Penjangkauan::with([
                'jenis_kasus', 'lokasi_kejadian', 'penjangkauan_konselor', 'penjangkauan_konselor.konselor',
            ])->find($id);

            if (!empty($penjangkauan)) {
                $this->responseCode = 200;
                $this->responseMessage = 'Data berhasil ditampilkan';
                $this->responseData = new PenjangkauanResource($penjangkauan);
            } else {
                $this->responseCode = 404;
                $this->responseMessage = 'Data tidak ditemukan';
            }

            return response()->json($this->getResponse(), $this->responseCode);
        } catch (\Exception $e) {
            $this->responseCode = 500;
            $this->responseMessage = $e->getMessage();
            return response()->json($this->getResponse(), $this->responseCode);
        }
    }

    public function get_klien($id_penjangkauan)
    {
        try {

            if (auth()->user()->id_role == config('env.role.opd')) {
                $idOpd = auth()->user()->id_opd;
                $IDORchecker = Penjangkauan::whereHas('rencanaIntervensi', function ($q) use ($idOpd) {
                    $q->where('rencana_intervensi.id_opd', $idOpd);
                })->where('id', $id_penjangkauan)->exists();

                if ($IDORchecker == false) {
                    $this->responseCode = 403;
                    $this->responseMessage = 'User tidak memiliki hak akses';
                    return response()->json($this->getResponse(), $this->responseCode);
                }
            }

            $penjangkauan = Penjangkauan::with('pengaduan')->find($id_penjangkauan);

            if (!empty($penjangkauan)) {

                $m_klien = null;
                $klien = null;

                $klien = Klien::with([
                    'klien_history',
                    'klien_history.kabupaten_tinggal',
                    'klien_history.kelurahan_tinggal',
                    'klien_history.kelurahan_tinggal.kecamatan',
                    'klien_history.kelurahan_tinggal.kecamatan.kabupaten',
                    'klien_history.kelurahan_kk',
                    'klien_history.kelurahan_kk.kecamatan',
                    'klien_history.kelurahan_kk.kecamatan.kabupaten',
                    'klien_history.kabupaten_lahir',
                    'klien_history.agama',
                    'klien_history.pekerjaan',
                    'klien_history.status_pernikahan',
                    'klien_history.pendidikan_terakhir',
                    'klien_history.jurusan',
                ])
                    ->where('id_penjangkauan', $penjangkauan->id)
                    ->first();

                if (empty($klien)) {
                    $m_klien = DaftarKLien::with([
                        'kabupaten_tinggal',
                        'kelurahan_tinggal',
                        'kelurahan_tinggal.kecamatan',
                        'kelurahan_tinggal.kecamatan.kabupaten',
                        'latest_klien_history',
                        'latest_klien_history.kelurahan_tinggal',
                        'latest_klien_history.kelurahan_tinggal.kecamatan',
                        'latest_klien_history.kelurahan_tinggal.kecamatan.kabupaten',
                        'latest_klien_history.kelurahan_kk',
                        'latest_klien_history.kelurahan_kk.kecamatan',
                        'latest_klien_history.kelurahan_kk.kecamatan.kabupaten',
                        'latest_klien_history.kabupaten_lahir',
                        'latest_klien_history.agama',
                        'latest_klien_history.pekerjaan',
                        'latest_klien_history.status_pernikahan',
                        'latest_klien_history.pendidikan_terakhir',
                        'latest_klien_history.jurusan',
                    ])
                        ->find($penjangkauan->pengaduan->id_klien);

                    $this->responseData['klien'] = null;
                    $this->responseData['m_klien'] = new DaftarKlienResource($m_klien);
                } else {
                    $this->responseData['klien'] = new KlienResource($klien);
                    $this->responseData['m_klien'] = null;
                }

                $this->responseCode = 200;
                $this->responseMessage = 'Data berhasil ditampilkan';
            } else {
                $this->responseCode = 404;
                $this->responseMessage = 'Data Penjangkauan tidak ditemukan';
            }

            return response()->json($this->getResponse(), $this->responseCode);
        } catch (\Exception $e) {
            $this->responseCode = 500;
            $this->responseMessage = $e->getMessage();
            return response()->json($this->getResponse(), $this->responseCode);
        }
    }

    public function get_keluarga_klien(Request $req, $id_penjangkauan)
    {
        try {

            if (auth()->user()->id_role == config('env.role.opd')) {
                $idOpd = auth()->user()->id_opd;
                $IDORchecker = Penjangkauan::whereHas('rencanaIntervensi', function ($q) use ($idOpd) {
                    $q->where('rencana_intervensi.id_opd', $idOpd);
                })->where('id', $id_penjangkauan)->exists();

                if ($IDORchecker == false) {
                    $this->responseCode = 403;
                    $this->responseMessage = 'User tidak memiliki hak akses';
                    return response()->json($this->getResponse(), $this->responseCode);
                }
            }

            $penjangkauan = Penjangkauan::with('pengaduan')->find($id_penjangkauan);

            if (!empty($penjangkauan)) {

                $keluargaKlien = KeluargaKlien::with([
                    'hubungan',
                    'kelurahan_tinggal',
                    'kelurahan_tinggal.kecamatan',
                    'kelurahan_tinggal.kecamatan.kabupaten',
                    'kelurahan_kk',
                    'kelurahan_kk.kecamatan',
                    'kelurahan_kk.kecamatan.kabupaten',
                    'kabupaten_lahir',
                    'agama',
                    'pekerjaan',
                    'status_pernikahan',
                    'pendidikan_terakhir',
                    'jurusan',
                    // 'highest_class',
                    // 'school_name',
                    
                ])
                    ->where('id_penjangkauan', $penjangkauan->id)->get();

                $saudaraKlien = SaudaraKlien::where('id_penjangkauan', $penjangkauan->id)->orderBy('child_order', "ASC")->get();

                $this->responseData['keluarga_klien'] = KeluargaKlienResource::collection($keluargaKlien);
                $this->responseData['saudara_klien'] = SaudaraKlienResource::collection($saudaraKlien);
                $this->responseCode = 200;
                $this->responseMessage = 'Data berhasil ditampilkan';
            } else {
                $this->responseCode = 404;
                $this->responseMessage = 'Data Penjangkauan tidak ditemukan';
            }

            return response()->json($this->getResponse(), $this->responseCode);
        } catch (\Exception $e) {
            $this->responseCode = 500;
            $this->responseMessage = $e->getMessage();
            return response()->json($this->getResponse(), $this->responseCode);
        }
    }

    public function get_rencana_intervensi(Request $req, $id_penjangkauan)
    {
        try {
            $penjangkauan = Penjangkauan::with('pengaduan')->find($id_penjangkauan);

            if (!empty($penjangkauan)) {

                $rencanaIntervensi = RencanaIntervensi::with([
                    'kebutuhan',
                    'opd',
                    'intervensi',
                    'rencana_intervensi_file',
                    'realisasiIntervensi.realisasi_intervensi_file',
                    'realisasiIntervensi.createdBy'
                ])
                    ->where('id_penjangkauan', $penjangkauan->id);

                if (auth()->user()->id_role == config('env.role.opd')) {
                    $rencanaIntervensi = $rencanaIntervensi->where('id_opd', auth()->user()->id_opd);
                    $kebutuhanIntervensi = $rencanaIntervensi->get();
                    $rencanaIntervensi = $rencanaIntervensi->first();

                    if ($req->filled('object')) {
                        $this->responseData['kebutuhan_intervensi'] = $rencanaIntervensi ? RencanaIntervensiResource::collection($kebutuhanIntervensi) : null;
                    } else {
                        $this->responseData['rencana_intervensi'] = $rencanaIntervensi ?  RencanaIntervensiResource::collection($kebutuhanIntervensi) : null;
                    }
                } else {
                    $rencanaIntervensi = $rencanaIntervensi->get();

                    $this->responseData['rencana_intervensi'] = RencanaIntervensiResource::collection($rencanaIntervensi);
                }


                $this->responseCode = 200;
                $this->responseMessage = 'Data berhasil ditampilkan';
            } else {
                $this->responseCode = 404;
                $this->responseMessage = 'Data Penjangkauan tidak ditemukan';
            }

            return response()->json($this->getResponse(), $this->responseCode);
        } catch (\Exception $e) {
            $this->responseCode = 500;
            $this->responseMessage = $e->getMessage();
            return response()->json($this->getResponse(), $this->responseCode);
        }
    }



    /*....SUBKORD.....*/
    public function store_plan(Request $req)
    {
        try {
            DB::beginTransaction();

            $rules = [
                'id_pengaduan' => 'required|exists:App\Models\Pengaduan,id,deleted_at,NULL',
                'tanggal_penjangkauan' => 'required|date_format:d-m-Y',
                'waktu_penjangkauan' => 'required|date_format:H:i',
                'tempat' => 'required|string',
                'alamat' => 'required|string',
                'id_konselor' => 'required|array|min:1',
            ];

            $validator = Validator::make($req->all(), $rules);
            if ($validator->fails()) {
                $this->responseCode = 422;
                $this->responseMessage = $validator->errors()->first();
                $this->responseData = $validator->errors();
                return response()->json($this->getResponse(), $this->responseCode);
            } else {

                $pengaduan = Pengaduan::find($req->id_pengaduan);
                if (!empty($pengaduan)) {

                    $penjangkauan = new Penjangkauan;
                    $penjangkauan->id_pengaduan = $pengaduan->id;
                    $penjangkauan->date = Carbon::parse($req->tanggal_penjangkauan . $req->waktu_penjangkauan)->format('Y-m-d H:i');
                    $penjangkauan->location = $req->tempat;
                    $penjangkauan->address = $req->alamat;
                    $penjangkauan->save();

                    foreach ($req->id_konselor as $value) {
                        $penjangkauanKonselor = new PenjangkauanKonselor;
                        $penjangkauanKonselor->id_penjangkauan = $penjangkauan->id;
                        $penjangkauanKonselor->id_konselor = $value;
                        $penjangkauanKonselor->save();
                    }

                    $pengaduan->id_status = 4;
                    $pengaduan->save();

                    $timeline = TimelinePengaduan::create([
                        'id_pengaduan' => $pengaduan->id,
                        'id_status' => $pengaduan->id_status,
                        'name' => 'Menunggu Verifikasi Kabid',
                        'description' => 'Subkord telah menunjuk konselor dan meneruskan pengaduan ke kabid',
                    ]);

                    DB::commit();
                    $this->responseCode = 201;
                    $this->responseMessage = 'Data berhasil disimpan';
                } else {
                    $this->responseCode = 400;
                    $this->responseMessage = 'Data Pengaduan tidak ditemukan';
                }
            }

            return response()->json($this->getResponse(), $this->responseCode);
        } catch (\Exception $e) {
            DB::rollback();
            $this->responseCode = 500;
            $this->responseMessage = $e->getMessage() . ' ' . $e->getLine();
            return response()->json($this->getResponse(), $this->responseCode);
        }
    }



    /*....KONSELOR.....*/
    public function store_result(Request $req, $id)
    {
        try {
            DB::beginTransaction();

            $rules = [
                'tipe_kasus' => 'required_if:pendampingan,1|numeric|between:1,2',
                'id_jenis_kasus' => 'required_if:pendampingan,1|exists:App\Models\MJenisKasus,id,deleted_at,NULL',
                'id_lokasi_kejadian' => 'required_if:pendampingan,1|exists:App\Models\MLokasiKejadian,id,deleted_at,NULL',
                'tanggal_kejadian' => 'required_if:pendampingan,1|date_format:d-m-Y',
                'waktu_kejadian' => 'required_if:pendampingan,1|date_format:H:i',
                'deskripsi_kejadian' => 'required_if:pendampingan,1|string',
                'tipe_simpan' => 'required|numeric|between:1,2',

                'pendampingan' => 'required_if:tipe_simpan,2|boolean',
                'surat_pernyataan_tidak_bersedia_didampingi' => 'nullable|mimes:png,jpg,jpeg,pdf',
                'berita_acara_pendampingan' => 'nullable|array',
                'berita_acara_pendampingan.*' => 'mimes:png,jpg,jpeg,pdf',
                'berita_acara_pendampingan_exsisting' => 'nullable|array',
                'berita_acara_pendampingan_exsisting.*' => 'exists:App\Models\PenjangkauanFile,id,type,2',
                'surat_pernyataan_klien' => 'nullable|mimes:png,jpg,jpeg,pdf',
                'surat_pernyataan_selesai_pendampingan' => 'nullable|mimes:png,jpg,jpeg,pdf',

                'saksi1' => 'nullable|string',
                'saksi2' => 'nullable|string',
                'nama_wali' => 'nullable|string',
                'nomor_telepon_wali' => 'nullable|string',
                'hasil_pendampingan' => 'nullable|string',
            ];

            $validator = Validator::make($req->all(), $rules);
            if ($validator->fails()) {
                $this->responseCode = 422;
                $this->responseMessage = $validator->errors()->first();
                $this->responseData = $validator->errors();
                return response()->json($this->getResponse(), $this->responseCode);
            } else {

                $penjangkauan = Penjangkauan::find($id);
                if (!empty($penjangkauan)) {

                    // if($req->tipe_simpan == 2 && !$req->pendampingan){
                    //     $req->merge([
                    //         'tipe_kasus' => null,
                    //         'id_jenis_kasus' => null,
                    //         'id_lokasi_kejadian' => null,
                    //         'tanggal_kejadian' => null,
                    //         'waktu_kejadian' => null,
                    //         'deskripsi_kejadian' => null,
                    //         'saksi1' => null,
                    //         'saksi2' => null,
                    //         'hasil_pendampingan' => null,
                    //     ]);
                    // }

                    $forDoc = $req->only([
                        'saksi1', 'saksi2', 'nama_wali',
                        'nomor_telepon_wali', 'hasil_pendampingan',
                    ]);

                    $penjangkauan->case_type = $req->tipe_kasus;
                    $penjangkauan->case_date = $req->tipe_simpan == 2 && !$req->pendampingan ? null : Carbon::parse($req->tanggal_kejadian . $req->waktu_kejadian)->format('Y-m-d H:i');
                    $penjangkauan->id_jenis_kasus = $req->id_jenis_kasus;
                    $penjangkauan->id_lokasi_kejadian = $req->id_lokasi_kejadian;
                    $penjangkauan->case_description = $req->deskripsi_kejadian;

                    foreach ($forDoc as $key => $value) {
                        if ($value) {
                            $penjangkauan->$key = $value;
                        }
                    }

                    if ($req->tipe_simpan == 2) {
                        $penjangkauan->draft_status = false;
                        $penjangkauan->pendampingan = $req->pendampingan ? true : false;

                        if ($req->pendampingan) {
                            if ($deletedFile = $penjangkauan->surat_pernyataan_tidak_bersedia_didampingi) {
                                $deletedFile->forceDelete();
                            }
                            if ($req->berita_acara_pendampingan) {
                                $deletedFileID = $req->berita_acara_pendampingan_exsisting;
                                if (!empty($deletedFileID)) {
                                    $deletedFile = PenjangkauanFile::whereNotIn('id', $deletedFileID)->get();
                                } else {
                                    $deletedFile = $penjangkauan->berita_acara_pendampingan;
                                }
                                foreach ($deletedFile as $d) {
                                    $d->forceDelete();
                                }

                                foreach ($req->berita_acara_pendampingan as $file) {
                                    $changedName = time() . random_int(100, 999) . '.' . $file->getClientOriginalExtension();
                                    $is_image = substr($file->getClientMimeType(), 0, 5) == 'image' ?? false;

                                    $path = 'private/penjangkauan/' . $penjangkauan->id;
                                    $file->storeAs($path, $changedName);

                                    $modelFile = new PenjangkauanFile();
                                    $modelFile->id_penjangkauan = $penjangkauan->id;
                                    $modelFile->type = 2;
                                    $modelFile->name = $file->getClientOriginalName();
                                    $modelFile->path = $path . '/' . $changedName;
                                    $modelFile->size = $file->getSize();
                                    $modelFile->ext = $file->getClientOriginalExtension();
                                    $modelFile->is_image = $is_image;
                                    $modelFile->save();
                                }
                            }

                            if ($req->hasFile('surat_pernyataan_klien')) {
                                if ($deletedFile = $penjangkauan->surat_pernyataan_klien) {
                                    $deletedFile->forceDelete();
                                }

                                $file = $req->surat_pernyataan_klien;

                                $changedName = time() . random_int(100, 999) . '.' . $file->getClientOriginalExtension();
                                $is_image = substr($file->getClientMimeType(), 0, 5) == 'image' ?? false;

                                $path = 'private/penjangkauan/' . $penjangkauan->id;
                                $file->storeAs($path, $changedName);

                                $modelFile = new PenjangkauanFile();
                                $modelFile->id_penjangkauan = $penjangkauan->id;
                                $modelFile->type = 3;
                                $modelFile->name = $file->getClientOriginalName();
                                $modelFile->path = $path . '/' . $changedName;
                                $modelFile->size = $file->getSize();
                                $modelFile->ext = $file->getClientOriginalExtension();
                                $modelFile->is_image = $is_image;
                                $modelFile->save();
                            }

                            if ($req->hasFile('surat_pernyataan_selesai_pendampingan')) {
                                if ($deletedFile = $penjangkauan->surat_pernyataan_selesai_pendampingan) {
                                    $deletedFile->forceDelete();
                                }

                                $file = $req->surat_pernyataan_selesai_pendampingan;

                                $changedName = time() . random_int(100, 999) . '.' . $file->getClientOriginalExtension();
                                $is_image = substr($file->getClientMimeType(), 0, 5) == 'image' ?? false;

                                $path = 'private/penjangkauan/' . $penjangkauan->id;
                                $file->storeAs($path, $changedName);

                                $modelFile = new PenjangkauanFile();
                                $modelFile->id_penjangkauan = $penjangkauan->id;
                                $modelFile->type = 4;
                                $modelFile->name = $file->getClientOriginalName();
                                $modelFile->path = $path . '/' . $changedName;
                                $modelFile->size = $file->getSize();
                                $modelFile->ext = $file->getClientOriginalExtension();
                                $modelFile->is_image = $is_image;
                                $modelFile->save();
                            }
                        } else {
                            $deletedFile = PenjangkauanFile::where('id_penjangkauan', $penjangkauan->id)->where('type', '!=', 1);
                            foreach ($deletedFile->get() as $f) {
                                $f->forceDelete();
                            }

                            if ($req->hasFile('surat_pernyataan_tidak_bersedia_didampingi')) {
                                if ($deletedFile = $penjangkauan->surat_pernyataan_tidak_bersedia_didampingi) {
                                    $deletedFile->forceDelete();
                                }

                                $file = $req->surat_pernyataan_tidak_bersedia_didampingi;

                                $changedName = time() . random_int(100, 999) . '.' . $file->getClientOriginalExtension();
                                $is_image = substr($file->getClientMimeType(), 0, 5) == 'image' ?? false;

                                $path = 'private/penjangkauan/' . $penjangkauan->id;
                                $file->storeAs($path, $changedName);

                                $modelFile = new PenjangkauanFile();
                                $modelFile->id_penjangkauan = $penjangkauan->id;
                                $modelFile->type = 1;
                                $modelFile->name = $file->getClientOriginalName();
                                $modelFile->path = $path . '/' . $changedName;
                                $modelFile->size = $file->getSize();
                                $modelFile->ext = $file->getClientOriginalExtension();
                                $modelFile->is_image = $is_image;
                                $modelFile->save();
                            }
                        }

                        $pengaduan = Pengaduan::find($penjangkauan->id_pengaduan);
                        $pengaduan->id_status = 7;
                        $pengaduan->save();

                        $timeline = TimelinePengaduan::create([
                            'id_pengaduan' => $pengaduan->id,
                            'id_status' => $pengaduan->id_status,
                            'name' => 'Menunggu Verifikasi Subkord',
                            'description' => 'Hasil penjangkauan telah diteruskan ke subkord untuk di verifikasi',
                        ]);
                    }
                    $penjangkauan->save();

                    DB::commit();
                    $this->responseCode = 201;
                    $this->responseMessage = 'Data berhasil disimpan';
                } else {
                    $this->responseCode = 400;
                    $this->responseMessage = 'Data Penjangkauan tidak ditemukan';
                }
            }

            return response()->json($this->getResponse(), $this->responseCode);
        } catch (\Exception $e) {
            DB::rollback();
            $this->responseCode = 500;
            $this->responseMessage = $e->getMessage() . ' ' . $e->getLine();
            return response()->json($this->getResponse(), $this->responseCode);
        }
    }

    public function store_klien(Request $req, $id_penjangkauan)
    {
        try {
            DB::beginTransaction();
            $id_penjangkauan = intval($id_penjangkauan);
            $req->request->add(['id_penjangkauan' => $id_penjangkauan]);
            $rules = [
                'id_penjangkauan' => 'required|exists:App\Models\Penjangkauan,id,deleted_at,NULL',
                'nama' => 'required_if:tipe_simpan,2|string',
                'inisial' => 'required_if:tipe_simpan,2|string',
                'nik' => 'nullable|numeric',
                // 'nomor_identitas' => 'required|string',
                'warga_surabaya' => 'required_if:tipe_simpan,2|numeric|between:1,2',
                'telepon' => 'required_if:tipe_simpan,2|string',
                'alamat_domisili' => 'required_if:tipe_simpan,2|string',
                'id_kelurahan_tinggal' => 'required_if:tipe_simpan,2|exists:App\Models\MKelurahan,id,deleted_at,NULL',
                'no_kk' => 'required_if:tipe_simpan,2|numeric',
                'alamat_kk' => 'required_if:tipe_simpan,2|string',
                'id_kelurahan_kk' => 'required_if:tipe_simpan,2|exists:App\Models\MKelurahan,id,deleted_at,NULL',
                'id_kabupaten_lahir' => 'required_if:tipe_simpan,2|exists:App\Models\MKabupaten,id,deleted_at,NULL',
                'tanggal_lahir' => 'required_if:tipe_simpan,2|date_format:d-m-Y',
                'kategori_klien' => 'required_if:tipe_simpan,2|numeric|between:1,2',
                'jenis_klien' => 'required_if:tipe_simpan,2|numeric|between:1,2',
                'jenis_kelamin' => 'required_if:tipe_simpan,2|numeric|between:1,2',
                'tipe_bpjs' => 'required_if:tipe_simpan,2|numeric|between:1,4',
                'id_agama' => 'required_if:tipe_simpan,2|exists:App\Models\MAgama,id,deleted_at,NULL',
                'id_pekerjaan' => 'required_if:tipe_simpan,2|exists:App\Models\MPekerjaan,id,deleted_at,NULL',
                'id_status_pernikahan' => 'required_if:tipe_simpan,2|exists:App\Models\MStatusPernikahan,id,deleted_at,NULL',
                // 'penghasilan' => 'required',

                'id_pendidikan_terakhir' => 'required_if:tipe_simpan,2|exists:App\Models\MPendidikanTerakhir,id,deleted_at,NULL',
                'kelas' => 'nullable|numeric',
                'nama_sekolah' => 'required_if:tipe_simpan,2|string',
                'id_jurusan' => 'nullable|exists:App\Models\MJurusan,id,deleted_at,NULL',
                'tahun_lulus' => 'nullable|date_format:Y',
                'tipe_simpan' => 'required|numeric|between:1,2',
            ];

            $validator = Validator::make($req->all(), $rules);
            if ($validator->fails()) {
                $this->responseCode = 422;
                $this->responseMessage = $validator->errors()->first();
                $this->responseData = $validator->errors();
                return response()->json($this->getResponse(), $this->responseCode);
            } else {

                $penjangkauan = Penjangkauan::with('pengaduan')->find($id_penjangkauan);
                $DaftarKlien = DaftarKlien::whereHas('pengaduan', function ($q) use ($penjangkauan) {
                    $q->where('id', $penjangkauan->id_pengaduan);
                })->first();
                if (!$klienHistory = $DaftarKlien->latest_klien_history) {
                    $klienHistory = new KlienHistory;
                } else {
                    $klienHistory->stopUserstamping();
                }

                if (!empty($penjangkauan)) {

                    if ($req->id_penjangkauan_klien !== null) {
                        $penjangkauanKlien = Klien::find($req->id_penjangkauan_klien);
                        // $klienHistory = KlienHistory::find($penjangkauanKlien->id_klien_history);

                        if (in_array(auth()->user()->id_role, [config('env.role.subkord'), config('env.role.kabid')])) {
                            $DaftarKlien->stopUserstamping();
                            $penjangkauanKlien->stopUserstamping();
                            // $klienHistory->stopUserstamping();
                        }
                    } else {
                        $penjangkauanKlien = new Klien;
                        $penjangkauanKlien->id_penjangkauan =  $penjangkauan->id;
                        // $klienHistory = new KlienHistory;
                    }

                    $penjangkauanKlien->name = $req->nama;
                    $DaftarKlien->name = $req->nama;

                    $penjangkauanKlien->initial_name = $req->inisial;
                    $DaftarKlien->initial_name = $req->inisial;

                    $penjangkauanKlien->is_has_nik = $req->nik ? true : false;
                    $DaftarKlien->is_has_nik = $req->nik ? true : false;

                    $identity_number = $penjangkauanKlien->is_has_nik ? null :
                        DaftarKlien::IdentityNumber(
                            strtotime($DaftarKlien->created_at),
                            $req->jenis_kelamin ?? 0,
                            $req->tanggal_lahir ? date('dmY', strtotime($req->tanggal_lahir)) : 0
                        );

                    $penjangkauanKlien->identity_number = $penjangkauanKlien->is_has_nik ? null : $identity_number;
                    $DaftarKlien->identity_number = $penjangkauanKlien->identity_number;

                    $penjangkauanKlien->nik_number = $penjangkauanKlien->is_has_nik ? $req->nik : null;
                    $DaftarKlien->nik_number = $penjangkauanKlien->nik_number;

                    $penjangkauanKlien->phone_number = $req->telepon;
                    $DaftarKlien->phone_number = $req->telepon;

                    $penjangkauanKlien->is_surabaya_resident = $req->warga_surabaya == 1 ? true : false;
                    $DaftarKlien->is_surabaya_resident = $req->warga_surabaya == 1 ? true : false;
                    // $penjangkauanKlien->id_kelurahan_tinggal = $req->id_kelurahan_tinggal;
                    // $penjangkauanKlien->id_kabupaten_tinggal =   $req->id_kelurahan_tinggal !== null ? null : $req->id_kabupaten_tinggal;
                    // $penjangkauanKlien->residence_address = $req->alamat_domisili;

                    $klienHistory->id_daftar_klien = $penjangkauan->pengaduan->id_klien;
                    $klienHistory->id_kelurahan_tinggal = $req->id_kelurahan_tinggal;
                    $DaftarKlien->id_kelurahan_tinggal = $req->id_kelurahan_tinggal;

                    $klienHistory->id_kabupaten_tinggal = !$penjangkauanKlien->is_surabaya_resident ? $req->id_kabupaten_tinggal : null;
                    $DaftarKlien->id_kabupaten_tinggal = $klienHistory->id_kabupaten_tinggal;

                    $klienHistory->residence_address = $req->alamat_domisili;
                    $DaftarKlien->residence_address = $req->alamat_domisili;
                    $DaftarKlien->save();

                    $klienHistory->kk_number = $req->no_kk;
                    $klienHistory->kk_address = $req->alamat_kk;
                    $klienHistory->id_kelurahan_kk = $req->id_kelurahan_kk;
                    $klienHistory->id_kabupaten_lahir = $req->id_kabupaten_lahir;
                    $klienHistory->birth_date = Carbon::parse($req->tanggal_lahir)->format('Y-m-d');
                    $klienHistory->age_category = $req->kategori_klien;
                    $klienHistory->physical_category = $req->jenis_klien;
                    $klienHistory->bpjs_category = $req->tipe_bpjs;
                    $klienHistory->gender = $req->jenis_kelamin;
                    $klienHistory->id_agama = $req->id_agama;
                    $klienHistory->id_pekerjaan = $req->id_pekerjaan;
                    $klienHistory->monthly_income = $req->penghasilan;
                    $klienHistory->id_status_pernikahan = $req->id_status_pernikahan;
                    $klienHistory->id_pendidikan_terakhir = $req->id_pendidikan_terakhir;
                    $klienHistory->id_jurusan = $req->id_jurusan;
                    $klienHistory->highest_class = $req->kelas;
                    $klienHistory->graduation_year = $req->tahun_lulus;
                    $klienHistory->school_name = $req->nama_sekolah;
                    $klienHistory->save();

                    $penjangkauanKlien->id_klien_history = $klienHistory->id;
                    $penjangkauanKlien->save();

                    if ($req->tipe_simpan == 2) {
                        $penjangkauan->klien_draft_status = false;
                    } else {
                        $penjangkauan->klien_draft_status = true;
                    }
                    $penjangkauan->save();

                    DB::commit();
                    $this->responseCode = 201;
                    $this->responseMessage = 'Data berhasil disimpan';
                } else {
                    $this->responseCode = 400;
                    $this->responseMessage = 'Data Penjangkauan tidak ditemukan';
                }
            }

            return response()->json($this->getResponse(), $this->responseCode);
        } catch (\Exception $e) {
            DB::rollback();
            $this->responseCode = 500;
            $this->responseMessage = $e->getMessage() . ' ' . $e->getLine();
            return response()->json($this->getResponse(), $this->responseCode);
        }
    }

    public function store_keluarga_klien(Request $req, $id_penjangkauan)
    {
        try {
            DB::beginTransaction();

            $id_penjangkauan = intval($id_penjangkauan);
            $req->request->add(['id_penjangkauan' => $id_penjangkauan]);

            $rules = [
                'id_penjangkauan' => 'required|exists:App\Models\Penjangkauan,id,deleted_at,NULL',
                'keluarga' => 'required|array|min:1',
                'keluarga.*.id_hubungan' => 'required_if:tipe_simpan,2|exists:App\Models\MHubungan,id,deleted_at,NULL',
                'keluarga.*.nama' => 'required_if:tipe_simpan,2|string',
                'keluarga.*.telepon' => 'required_if:tipe_simpan,2|string',
                'keluarga.*.id_status_pernikahan' => 'required_if:tipe_simpan,2|exists:App\Models\MStatusPernikahan,id,deleted_at,NULL',
                'keluarga.*.id_agama' => 'nullable|exists:App\Models\MAgama,id,deleted_at,NULL',
                'keluarga.*.id_kabupaten_lahir' => 'nullable|exists:App\Models\MKabupaten,id,deleted_at,NULL',
                'keluarga.*.tanggal_lahir' => 'nullable|date_format:d-m-Y',
                'keluarga.*.nik' => 'nullable|numeric',
                'keluarga.*.no_kk' => 'nullable|numeric',
                'keluarga.*.alamat_kk' => 'nullable|string',
                'keluarga.*.id_kelurahan_kk' => 'nullable|exists:App\Models\MKelurahan,id,deleted_at,NULL',
                'keluarga.*.alamat_domisili' => 'nullable|string',
                'keluarga.*.id_kelurahan_tinggal' => 'nullable|exists:App\Models\MKelurahan,id,deleted_at,NULL',
                'keluarga.*.id_pekerjaan' => 'nullable|exists:App\Models\MPekerjaan,id,deleted_at,NULL',
                'keluarga.*.sifat_pekerjaan' => 'nullable|string',
                'keluarga.*.tipe_bpjs' => 'required_if:tipe_simpan,2|numeric|between:1,4',
                // 'keluarga.*.id_pendidikan_terakhir' => 'required_if:tipe_simpan,2|exists:App\Models\MPendidikanTerakhir,id,deleted_at,NULL',
                'keluarga.*.id_pendidikan_terakhir' => 'required_if:tipe_simpan,2|exists:App\Models\MPendidikanTerakhir,id,deleted_at,NULL',
                'keluarga.*.id_jurusan' => 'nullable|exists:App\Models\MJurusan,id,deleted_at,NULL',
                'keluarga.*.kelas' => 'nullable',
                'keluarga.*.tahun_lulus' => 'nullable|date_format:Y',
                'keluarga.*.nama_sekolah' => 'nullable|string',

                'saudara' => 'nullable|array',
                'saudara.*.nama' => 'required|string',
                'saudara.*.anak_ke' => 'required|numeric',

                'tipe_simpan' => 'required|numeric|between:1,2',
            ];

            $validator = Validator::make($req->all(), $rules);
            if ($validator->fails()) {
                $this->responseCode = 422;
                $this->responseMessage = $validator->errors()->first();
                $this->responseData = $validator->errors();
                return response()->json($this->getResponse(), $this->responseCode);
            } else {

                $penjangkauan = Penjangkauan::with('pengaduan')->find($id_penjangkauan);

                if (!empty($penjangkauan)) {
                    $updated_by = KeluargaKlien::where('id_penjangkauan', $id_penjangkauan)->orderBy('updated_at', 'DESC')->pluck('updated_by')->first();
                    $saved_keluarga_ids = [];
                    foreach ($req->keluarga as $k) {
                        if (isset($k['id']) && $k['id'] !== null) {
                            $keluargaKlien = KeluargaKlien::find($k['id']);
                            if (in_array(auth()->user()->id_role, [config('env.role.subkord'), config('env.role.kabid')])) {
                                $keluargaKlien->stopUserstamping();
                            }
                        } else {
                            $keluargaKlien = new KeluargaKlien;
                            $keluargaKlien->id_penjangkauan =  $penjangkauan->id;
                            if (in_array(auth()->user()->id_role, [config('env.role.subkord'), config('env.role.kabid')])) {
                                $keluargaKlien->stopUserstamping();
                                $keluargaKlien->created_by = $updated_by;
                                $keluargaKlien->updated_by = $updated_by;
                            }
                        }

                        $keluargaKlien->name = $k['nama'] ?? null;
                        $keluargaKlien->id_hubungan = $k['id_hubungan'] ?? null;
                        $keluargaKlien->phone_number = $k['telepon'] ?? null;
                        $keluargaKlien->id_status_pernikahan = $k['id_status_pernikahan'] ?? null;
                        $keluargaKlien->id_agama = $k['id_agama'] ?? null;
                        $keluargaKlien->id_kabupaten_lahir = $k['id_kabupaten_lahir'] ?? null;
                        $keluargaKlien->birth_date = isset($k['tanggal_lahir']) ? Carbon::parse($k['tanggal_lahir'])->format('Y-m-d') : null;
                        $keluargaKlien->nik_number = $k['nik'] ?? null;
                        $keluargaKlien->kk_number = $k['no_kk'] ?? null;
                        $keluargaKlien->kk_address = $k['alamat_kk'] ?? null;
                        $keluargaKlien->id_kelurahan_kk = $k['id_kelurahan_kk'] ?? null;
                        $keluargaKlien->residence_address = $k['alamat_domisili'] ?? null;
                        $keluargaKlien->id_kelurahan_tinggal = $k['id_kelurahan_tinggal'] ?? null;
                        $keluargaKlien->id_pekerjaan = $k['id_pekerjaan'] ?? null;
                        $keluargaKlien->monthly_income = $k['penghasilan'] ?? null;
                        $keluargaKlien->work_type = $k['sifat_pekerjaan'] ?? null;
                        $keluargaKlien->bpjs_category = $k['tipe_bpjs'] ?? null;
                        $keluargaKlien->id_pendidikan_terakhir = $k['id_pendidikan_terakhir'] ?? null;
                        $keluargaKlien->id_jurusan = $k['id_jurusan'] ?? null;
                        $keluargaKlien->highest_class = $k['kelas'] ?? null;
                        $keluargaKlien->graduation_year = $k['tahun_lulus'] ?? null;
                        $keluargaKlien->school_name = $k['nama_sekolah'] ?? null;

    
                        $keluargaKlien->save();

                        array_push($saved_keluarga_ids, $keluargaKlien->id);
                    }

                    $unusedDataKeluarga = KeluargaKlien::where('id_penjangkauan', $penjangkauan->id)->whereNotIn('id', $saved_keluarga_ids)->forceDelete();

                    $saved_saudara_ids = [];
                    if ($req->saudara) {
                        foreach ($req->saudara as $s) {
                            if (isset($s['id']) && $s['id'] !== null) {
                                $saudaraKlien = SaudaraKlien::find($s['id']);
                                if (in_array(auth()->user()->id_role, [config('env.role.subkord'), config('env.role.kabid')])) {
                                    $saudaraKlien->stopUserstamping();
                                }
                            } else {
                                $saudaraKlien = new SaudaraKlien;
                                $saudaraKlien->id_penjangkauan =  $penjangkauan->id;
                            }

                            $saudaraKlien->name = $s['nama'];
                            $saudaraKlien->child_order = $s['anak_ke'];
                            $saudaraKlien->save();

                            array_push($saved_saudara_ids, $saudaraKlien->id);
                        }
                    }

                    $unusedDataSaudara = SaudaraKlien::where('id_penjangkauan', $penjangkauan->id)->whereNotIn('id', $saved_saudara_ids)->forceDelete();

                    if ($req->tipe_simpan == 2) {
                        $penjangkauan->keluarga_klien_draft_status = false;
                    } else {
                        $penjangkauan->keluarga_klien_draft_status = true;
                    }
                    $penjangkauan->save();

                    DB::commit();
                    $this->responseCode = 201;
                    $this->responseMessage = 'Data berhasil disimpan';
                } else {
                    $this->responseCode = 400;
                    $this->responseMessage = 'Data Penjangkauan tidak ditemukan';
                }
            }

            return response()->json($this->getResponse(), $this->responseCode);
        } catch (\Exception $e) {
            DB::rollback();
            $this->responseCode = 500;
            $this->responseMessage = $e->getMessage() . ' ' . $e->getLine();
            return response()->json($this->getResponse(), $this->responseCode);
        }
    }

    public function store_rencana_intervensi(Request $req, $id_penjangkauan)
    {
        try {

            DB::beginTransaction();

            $id_penjangkauan = intval($id_penjangkauan);
            $req->request->add(['id_penjangkauan' => $id_penjangkauan]);

            $rules = [
                'id_penjangkauan' => 'required|exists:App\Models\Penjangkauan,id,deleted_at,NULL',
                'rencana_intervensi' => 'sometimes|array|min:1',
                'rencana_intervensi.*.id' => 'nullable|exists:App\Models\RencanaIntervensi,id,deleted_at,NULL',
                'rencana_intervensi.*.id_kebutuhan' => 'required_if:tipe_simpan,2|exists:App\Models\MKebutuhan,id,deleted_at,NULL',
                'rencana_intervensi.*.id_opd' => [
                    'required_if:tipe_simpan,2',
                    'exists:App\Models\MOpd,id,deleted_at,NULL',
                    // 'distinct',
                    // Rule::unique('rencana_intervensi')->where(function ($query) use($id_penjangkauan) {
                    //     return $query->where('id_penjangkauan', $id_penjangkauan);
                    // }),
                ],
                'rencana_intervensi.*.id_intervensi' => 'required_if:tipe_simpan,2|exists:App\Models\MIntervensi,id,deleted_at,NULL',
                // 'rencana_intervensi.*.deskripsi' => 'required_if:tipe_simpan,2|string',
                // 'rencana_intervensi.*.file' => 'nullable|array|min:1',

                // 'rencana_intervensi.*.file.*' => 'mimes:png,jpg,jpeg,pdf',
                'rencana_intervensi.*.id' => 'nullable|exists:App\Models\RencanaIntervensi,id,deleted_at,NULL',
                // 'rencana_intervensi.*.file_exsisting' => 'nullable|array',
                // 'rencana_intervensi.*.file_exsisting.*' => 'exists:App\Models\RencanaIntervensiFile,id,deleted_at,NULL',

                'tipe_simpan' => 'required|numeric|between:1,2',
            ];

            $validator = Validator::make($req->all(), $rules);
            if ($validator->fails()) {
                $this->responseCode = 422;
                $this->responseMessage = $validator->errors()->first();
                $this->responseData = $validator->errors();
                return response()->json($this->getResponse(), $this->responseCode);
            } else {
                $penjangkauan = Penjangkauan::with('pengaduan')->find($id_penjangkauan);
                if (!empty($penjangkauan)) {

                    $updated_by = RencanaIntervensi::where('id_penjangkauan', $id_penjangkauan)->orderBy('updated_at', 'DESC')->pluck('updated_by')->first();
                    $saved_ids = [];
                    if ($req->filled('rencana_intervensi')) {
                        foreach ($req->rencana_intervensi as $r) {
                            if (isset($r['id']) && $r['id'] !== null) {
                                $rencanaIntervensi = RencanaIntervensi::find($r['id']);

                                if (isset($r['file_exsisting']) && count($r['file_exsisting'])) {
                                    $deletedFile = RencanaIntervensiFile::whereNotIn('id', $r['file_exsisting'])->get();
                                    foreach ($deletedFile as $file) {
                                        $file->forceDelete();
                                    }
                                }

                                if (in_array(auth()->user()->id_role, [config('env.role.subkord'), config('env.role.kabid')])) {
                                    $rencanaIntervensi->stopUserstamping();
                                }
                            } else {
                                $rencanaIntervensi = new RencanaIntervensi;
                                $rencanaIntervensi->id_penjangkauan =  $penjangkauan->id;
                                if (in_array(auth()->user()->id_role, [config('env.role.subkord'), config('env.role.kabid')])) {
                                    $rencanaIntervensi->stopUserstamping();
                                    $rencanaIntervensi->created_by = $updated_by;
                                    $rencanaIntervensi->updated_by = $updated_by;
                                }
                            }

                            $rencanaIntervensi->id_kebutuhan = $r['id_kebutuhan'] ?? null;
                            $rencanaIntervensi->id_opd = $r['id_opd'] ?? null;
                            $rencanaIntervensi->id_intervensi = $r['id_intervensi'] ?? null;
                            $rencanaIntervensi->description = $r['deskripsi'] ?? null;
                            $rencanaIntervensi->save();

                            array_push($saved_ids, $rencanaIntervensi->id);

                            if (isset($r['file'])) {
                                foreach ($r['file'] as $file) {
                                    $changedName = time() . random_int(100, 999) . '.' . $file->getClientOriginalExtension();
                                    $is_image = false;
                                    if (substr($file->getClientMimeType(), 0, 5) == 'image') {
                                        $is_image = true;
                                    }

                                    $path = 'private/rencana_intervensi/' . $rencanaIntervensi->id;
                                    $file->storeAs($path, $changedName);

                                    $rencanaIntervensiFile = new RencanaIntervensiFile;
                                    $rencanaIntervensiFile->id_rencana_intervensi = $rencanaIntervensi->id;
                                    $rencanaIntervensiFile->name = $file->getClientOriginalName();
                                    $rencanaIntervensiFile->path = $path . '/' . $changedName;
                                    $rencanaIntervensiFile->size = $file->getSize();
                                    $rencanaIntervensiFile->ext = $file->getClientOriginalExtension();
                                    $rencanaIntervensiFile->is_image = $is_image;
                                    $rencanaIntervensiFile->save();
                                }
                            }
                        }
                    }


                    $unusedData = RencanaIntervensi::where('id_penjangkauan', $penjangkauan->id)->whereNotIn('id', $saved_ids)->get();

                    foreach ($unusedData as $ud) {
                        $unusedFile = RencanaIntervensiFile::where('id_rencana_intervensi', $ud->id)->get();
                        foreach ($unusedFile as $uf) {
                            // $path = storage_path('app/'.$uf->path);
                            // if(File::exists($path)) {
                            //     File::delete($path);
                            // }
                            $uf->forceDelete();
                        }
                        $ud->forceDelete();
                    }

                    if (empty($saved_ids)) {
                        $penjangkauan = Penjangkauan::find($id_penjangkauan);
                        if (!empty($penjangkauan)) {
                            $penjangkauan->rencana_intervensi_draft_status = null;
                            $penjangkauan->save();
                        }
                    } elseif ($req->tipe_simpan == 2) {
                        $penjangkauan->rencana_intervensi_draft_status = false;
                    } else {
                        $penjangkauan->rencana_intervensi_draft_status = true;
                    }
                    $penjangkauan->save();

                    DB::commit();
                    $this->responseCode = 201;
                    $this->responseMessage = 'Data berhasil disimpan';
                } else {
                    $this->responseCode = 400;
                    $this->responseMessage = 'Data Penjangkauan tidak ditemukan';
                }
            }

            return response()->json($this->getResponse(), $this->responseCode);
        } catch (\Exception $e) {
            DB::rollback();
            $this->responseCode = 500;
            $this->responseMessage = $e->getMessage() . ' ' . $e->getLine();
            return response()->json($this->getResponse(), $this->responseCode);
        }
    }

    public function delete_rencana_intervensi_file(Request $req, $id_penjangkauan)
    {
        try {
            DB::beginTransaction();

            $rules = [
                'id_file' => 'required',
            ];

            $validator = Validator::make($req->all(), $rules);
            if ($validator->fails()) {
                $this->responseCode = 422;
                $this->responseMessage = $validator->errors()->first();
                $this->responseData = $validator->errors();
                return response()->json($this->getResponse(), $this->responseCode);
            } else {
                $penjangkauan = Penjangkauan::find($id_penjangkauan);
                if (!empty($penjangkauan)) {

                    $rencanaIntervensiFile = RencanaIntervensiFile::find($req->id_file);
                    if (!empty($rencanaIntervensiFile)) {
                        $path = storage_path('app/' . $rencanaIntervensiFile->path);
                        if (FIle::exists($path)) {
                            File::delete($path);
                        }
                        $rencanaIntervensiFile->delete();

                        DB::commit();
                        $this->responseCode = 201;
                        $this->responseMessage = 'File berhasil dihapus';
                    } else {
                        $this->responseCode = 400;
                        $this->responseMessage = 'File tidak ditemukan';
                    }
                } else {
                    $this->responseCode = 400;
                    $this->responseMessage = 'Data Penjangkauan tidak ditemukan';
                }
            }

            return response()->json($this->getResponse(), $this->responseCode);
        } catch (\Exception $e) {
            DB::rollback();
            $this->responseCode = 500;
            $this->responseMessage = $e->getMessage() . ' ' . $e->getLine();
            return response()->json($this->getResponse(), $this->responseCode);
        }
    }

    public function formatDokumen(Request $req, $id_penjangkauan, $nama_file)
    {
        try {
            $id = intval($id_penjangkauan);
            $penjangkauan = Penjangkauan::find($id);
            if (!$penjangkauan) {
                $this->responseCode = 404;
                $this->responseMessage = 'Data tidak di temukan';
                return response()->json($this->getResponse(), $this->responseCode);
            }

            $file = public_path('template_doc/' . $nama_file . '.rtf');
            if (!file_exists($file)) {
                $this->responseCode = 404;
                return response()->json($this->getResponse(), $this->responseCode);
            }

            return WordTemplate::export($file, $this->dataForDoc($penjangkauan, $req), $nama_file . '-' . $id . '.doc');
        } catch (\Exception $e) {
            DB::rollback();
            $this->responseCode = 500;
            $this->responseMessage = $e->getMessage() . ' ' . $e->getLine();
        }
        return response()->json($this->getResponse(), $this->responseCode);
    }

    public function dataForDoc($penjangkauan, $req = null)
    {
        $klien = $penjangkauan->klien;
        if (!$klien) {
            $daftarKlien = $penjangkauan->pengaduan->klien;
        }

        $petugas = $penjangkauan->konselor;


        if (count($req->all())) {
            foreach ($req->all() as $key => $value) {
                $penjangkauan->$key = $value;
            }
            $penjangkauan->save();
        }

        $arr = [
            '[NAMA]' => $klien->name ?? $daftarKlien->name,
            '[TTL]' => $klien ? $klien->klien_history->kabupaten_lahir->name . ', ' . Carbon::parse($klien->klien_history->birth_date)->translatedFormat('d F Y') : '',
            '[GENDER]' => $klien ? $klien->klien_history->gender == 1 ? 'Laki-laki' : 'Perempuan' : '',
            '[PENDIDIKAN]' => $klien->klien_history->pendidikan_terakhir->name ?? '',
            '[PEKERJAAN]' => $klien->klien_history->pekerjaan->name ?? '',
            '[ALAMAT_DOM]' => $klien->klien_history->residence_address ?? '',
            '[KEL_DOM]' => $klien->klien_history->kelurahan_tinggal->name ?? '',
            '[KEC_DOM]' => $klien->klien_history->kelurahan_tinggal->kecamatan->name ?? '',
            '[ALAMAT_KK]' => $klien->klien_history->kk_address ?? '',
            '[KEL_KK]' => $klien->klien_history->kelurahan_kk->name ?? '',
            '[KEC_KK]' => $klien->klien_history->kelurahan_kk->kecamatan->name ?? '',
            '[NO_KLIEN]' => $klien->phone_number ?? ($daftarKlien->phone_number ?? '............................'),
            '[NO_WALI_KLIEN]' => $penjangkauan->nomor_telepon_wali ?? '.......................',
            '[NAMA_WALI]' => $penjangkauan->nama_wali ?? '....................................',
            '[NOW]' => Carbon::now()->translatedFormat('d F Y'),

            '[HARI]' => Carbon::parse($penjangkauan->date)->translatedFormat('l'),
            '[TANGGAL]' => date('d', strtotime($penjangkauan->date)),
            '[BULAN]' => Carbon::parse($penjangkauan->date)->translatedFormat('F'),
            '[TAHUN]' => date('Y', strtotime($penjangkauan->date)),
            '[TEMPAT]' => $penjangkauan->location ?? '....................',

            '[PETUGAS_1]' => count($petugas) ? $petugas[0]->name : '....................................',
            '[PETUGAS_2]' => count($petugas) > 1 ? $petugas[1]->name : '....................................',
            '[SAKSI_1]' => $penjangkauan->saksi1 ?? '....................................',
            '[SAKSI_2]' => $penjangkauan->saksi2 ?? '....................................',
            '[HASIL_BERITA]' => $penjangkauan->hasil_pendampingan ?? '............................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................',
        ];

        return $arr;
    }
}
