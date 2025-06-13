<?php

namespace App\Http\Controllers\API;

use App\Enums\LaporanKegiatanCreatorType;
use App\Enums\LaporanKegiatanFileSourceEnum;
use App\Enums\LaporanKegiatanFileTypeEnum;
use App\Enums\LaporanKegiatanKonselingTypeEnum;
use App\Enums\LaporanKegiatanSosialisasiTypeEnum;
use App\Enums\LaporanKegiatanStatus;
use App\Enums\PuspagaRwFileTypeEnum;
use App\Exports\CekExport;
use App\Exports\FasilitatorExport;
use App\Exports\DatabaseExport;
use App\Helpers\HelperPublic;
use App\Http\Controllers\Controller;
use App\Models\DMahasiswa;
use App\Models\LaporanKegiatan;
use App\Models\LaporanKegiatanFile;
use App\Models\LaporanKegiatanKonseling;
use App\Models\LaporanKegiatanPiket;
use App\Models\LaporanKegiatanPublikasiKIE;
use App\Models\LaporanKegiatanRapat;
use App\Models\LaporanKegiatanSosialisasi;
use App\Models\MahasiswaBalaiPuspagaRW;
use App\Models\PuspagaRw;
use App\Models\PuspagaRwFile;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\File\File as SymfonyFile;
use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use App\Models\MKecamatan;
use App\Models\MKelurahan;

class LaporanKegiatanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $limit = $request->limit ? intval($request->limit) : 10;
            $order = $request->order ? $request->order : 'DESC';
            $sortby = $request->sortby ? $request->sortby : 'id';
            $role_filter = $request->role_filter ? $request->role_filter : 'all';

            $start_date = $request->start_date;
            $end_date = $request->end_date;

            $laporan_master = LaporanKegiatan::query();
            if ($role_filter == 'mahasiswa') {
                $laporan_master->where('creator_type', LaporanKegiatanCreatorType::MAHASISWA);
                // if (Auth::user()->id_role == config('env.role.mahasiswa') && Auth::user()->mahasiswa) $laporan_master->where('id_creator', Auth::user()->mahasiswa->puspaga_rw->id);
                if (Auth::user()->id_role == config('env.role.mahasiswa') && Auth::user()->mahasiswa && Auth::user()->mahasiswa->puspaga_rw) {
                    $laporan_master->where('id_creator', Auth::user()->mahasiswa->puspaga_rw->id);
                }
                $laporan_master->with('mahasiswa', function ($query) {
                    $query->with(
                        'sample_mahasiswa.jenis_mahasiswa',
                        'sample_mahasiswa.pendidikan_terakhir',
                        'sample_mahasiswa.instansi_pendidikan',
                        'sample_mahasiswa.jurusan',
                        'balai_puspaga.kelurahan.kecamatan.kabupaten',
                        'konselor'
                    );
                });
            }
            if ($role_filter == 'fasilitator') {
                $laporan_master->where('creator_type', LaporanKegiatanCreatorType::FASILITATOR);
                if (Auth::user()->id_role == config('env.role.fasilitator')) $laporan_master->where('id_creator', Auth::user()->id_fasilitator);
                $laporan_master->with('fasilitator', function ($query) {
                    $query->with(
                        'ttd',
                        'jabatan',
                        'kelurahan.kecamatan.kabupaten',
                        'kelurahan_domisili.kecamatan'
                    );
                });
            }
            if ($request->filled('search')) {
                $laporan_master->where(function ($q) use ($request) {
                    $s = $request->search;
                    $q->orWhereHas('mahasiswa.sample_mahasiswa', function ($q) use ($s) {
                        $q->where('name', 'ILIKE', '%' . $s . '%');
                    });
                    $q->orWhereHas('mahasiswa.sample_mahasiswa', function ($q) use ($s) {
                        $q->where('nik', 'ILIKE', '%' . $s . '%');
                    });
                });
            }
            if ($request->filled('id_jenis_mahasiswa')) {
                $laporan_master->where(function ($q) use ($request) {
                    $s = $request->id_jenis_mahasiswa;
                    $q->orWhereHas('mahasiswa.sample_mahasiswa.jenis_mahasiswa', function ($q) use ($s) {
                        $q->where('id', 'ILIKE', '%' . $s . '%');
                    });
                });
            }
            if ($request->filled('id_kecamatan')) {
                $laporan_master->where(function ($q) use ($request) {
                    $s = $request->id_kecamatan;
                    $q->orWhereHas('mahasiswa.balai_puspaga.kelurahan.kecamatan', function ($q) use ($s) {
                        $q->where('id', 'ILIKE', '%' . $s . '%');
                    });
                });
            }
            if ($request->filled('id_kelurahan')) {
                $laporan_master->where(function ($q) use ($request) {
                    $s = $request->id_kelurahan;
                    $q->orWhereHas('mahasiswa.balai_puspaga.kelurahan', function ($q) use ($s) {
                        $q->where('id', 'ILIKE', '%' . $s . '%');
                    });
                });
            }
            if ($request->filled('id_balai_puspaga_rw')) {
                $laporan_master->where(function ($q) use ($request) {
                    $s = $request->id_balai_puspaga_rw;
                    $q->orWhereHas('mahasiswa.balai_puspaga', function ($q) use ($s) {
                        $q->where('id', 'ILIKE', '%' . $s . '%');
                    });
                });
            }
            if ($start_date && $end_date) {
                $laporan_master->whereBetween('date', [$start_date, $end_date]);
            }

            $laporan_master->with('laporan_konseling', function ($query) {
                $query->with('kelurahan.kecamatan')
                    ->with('file_foto')
                    ->with('file_materi');
            });
            $laporan_master->with('laporan_rapat', function ($query) {
                $query->with('kelurahan.kecamatan')
                    ->with('file_foto')
                    ->with('file_materi');
            });
            $laporan_master->with('laporan_sosialisasi', function ($query) {
                $query->with('kelurahan.kecamatan')
                    ->with('file_foto')
                    ->with('file_materi');
            });
            $laporan_master->with('laporan_piket', function ($query) {
                $query->with('kelurahan.kecamatan')
                    ->with('file_foto');
            });
            $laporan_master->with('laporan_kegiatan_publikasi_k_i_e', function ($query) {
                $query->with('file_foto');
            });
            $result = $laporan_master->orderBy($sortby, $order)->paginate($limit);
            return response()->json($result);
        } catch (\Exception $e) {
            $this->responseCode = 500;
            $this->responseMessage = $e->getMessage();
            return response()->json($this->getResponse(), $this->responseCode);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $rules = [
                // Basic Rules
                'id_mahasiswa_balai_puspaga_rw' => 'required_without:id_puspaga_rw|exists:App\Models\MahasiswaBalaiPuspagaRW,id,deleted_at,NULL',
                'id_puspaga_rw' => 'required_without:id_mahasiswa_balai_puspaga_rw|exists:App\Models\PuspagaRw,id,deleted_at,NULL',
                'laporan' => 'required|array|min:1',
                'laporan.*.kegiatan_type' => ['required', Rule::in(['konseling', 'rapat', 'sosialisasi', 'piket', 'publikasi_kie'])],
                //'date' => 'required|date',
                'date' => 'required|date|after_or_equal:' . \Carbon\Carbon::now()->subDays(7)->toDateString(),


                // Common Rules
                // 'laporan.*.date' => 'required|date',
                // 'laporan.*.name' => 'required|string',
                'laporan.*.description' => 'required|string',
                'laporan.*.url_video' => 'nullable',
                'laporan.*.link_konten' => 'nullable',

                // Kegiatan Konseling dan Rapat Rules only
                'laporan.*.id_kelurahan' => 'required_if:laporan.*.kegiatan_type,rapat,konseling|exists:App\Models\MKelurahan,id,deleted_at,NULL',
                'laporan.*.total_participant' => 'required_if:laporan.*.kegiatan_type,rapat,sosialisasi|numeric|min:1',

                // Kegiatan Konseling Rules
                'laporan.*.nik' => 'required_if:laporan.*.kegiatan_type,konseling|digits:16|numeric',
                'laporan.*.phone' => 'required_if:laporan.*.kegiatan_type,konseling|string',
                'laporan.*.is_surabaya_citizen' => 'required_if:laporan.*.kegiatan_type,konseling|boolean',
                'laporan.*.address' => 'required_if:laporan.*.kegiatan_type,konseling|string',
                'laporan.*.konseling_type' => ['required_if:laporan.*.kegiatan_type,konseling', Rule::in(LaporanKegiatanKonselingTypeEnum::getValues())],
                'laporan.*.description' => ['required_if:laporan.*.kegiatan_type,konseling'],
                'laporan.*.solution' => ['required_if:laporan.*.kegiatan_type,konseling'],
                'laporan.*.id_m_kategori_kasus' => 'required_if:laporan.*.kegiatan_type,konseling|exists:App\Models\MKategoriKasus,id,deleted_at,NULL',

                // Kegiatan Rapat Rules
                'laporan.*.resume' => 'required_if:laporan.*.kegiatan_type,rapat|string',

                // Kegiatan Sosialisasi Rules
                'laporan.*.organization' => 'required_if:laporan.*.kegiatan_type,sosialisasi|string',
                // 'laporan.*.sosialisasi_type' => ['required_if:laporan.*.kegiatan_type,sosialisasi', Rule::in(LaporanKegiatanSosialisasiTypeEnum::getValues())],

                // Files
                'laporan.*.files' => 'nullable|array',
                'laporan.*.files.*.file' => 'mimes:png,jpg,jpeg,pdf,ppt,pptx',
                'laporan.*.files.*.type' => ['required_with:laporan.*.files.*.file', Rule::in(LaporanKegiatanFileTypeEnum::getValues())],

            ];
            if (Auth::user()->id_role == config('env.role.fasilitator')) {
                $id = 0;
                $puspaga_rw = PuspagaRw::where('id', Auth::user()->id_fasilitator)->first();
                if ($puspaga_rw) {
                    $id = $puspaga_rw->id;
                }
                $request->merge(['id_puspaga_rw' => $id]);
                // Check if Ttd exists
                $ttd = PuspagaRwFile::where('type', PuspagaRwFileTypeEnum::TTD)->where('id_puspaga_rw', $puspaga_rw->id)->first();
                if (!$ttd) {
                    $rules['file_ttd'] = 'required|string';
                } else {
                    $request->request->remove('file_ttd');
                }
            }
            if (Auth::user()->id_role == config('env.role.mahasiswa')) {
                $id = 0;
                $mahasiswa = DMahasiswa::where('id_user', Auth::id())->first();
                if ($mahasiswa) {
                    $balai = MahasiswaBalaiPuspagaRW::where('id_mahasiswa', $mahasiswa->id)->first();
                    if ($balai) {
                        $id = $balai->id;
                    }
                }
                $request->merge(['id_mahasiswa_balai_puspaga_rw' => $id]);
            }

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $this->responseCode = 422;
                // $this->responseMessage = $validator->errors()->first();
                $this->responseMessage = $validator->errors()->first();
                $this->responseData = $validator->errors();
                return response()->json($this->getResponse(), $this->responseCode);
            }
            // Save new Ttd File
            if ($request->has('file_ttd')) {
                $puspaga_rw = PuspagaRw::where('id', Auth::user()->id_fasilitator)->first();
                $base64File = $request->file_ttd;

                $fileData = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $base64File));

                $tmpFilePath = sys_get_temp_dir() . '/' . Str::uuid()->toString();
                file_put_contents($tmpFilePath, $fileData);

                $tmpfile = new SymfonyFile($tmpFilePath);

                $file = new UploadedFile(
                    $tmpfile->getPathname(),
                    $tmpfile->getFilename(),
                    $tmpfile->getMimeType(),
                    0,
                    true // Mark it as test, since the file isn't from real HTTP POST.
                );

                $changedName = time() . random_int(100, 999) . '.png';
                $is_image = substr($file->getClientMimeType(), 0, 5) == 'image' ?? false;

                $path = 'private/puspaga_rw/' . $puspaga_rw->id . '/ttd';
                $file->storeAs($path, $changedName);


                $modelFile = new PuspagaRwFile();
                $modelFile->id_puspaga_rw = $puspaga_rw->id;
                $modelFile->type = PuspagaRwFileTypeEnum::TTD;
                $modelFile->name = $file->getClientOriginalName();
                $modelFile->path = $path . '/' . $changedName;
                $modelFile->size = $file->getSize();
                $modelFile->ext = $file->getClientOriginalExtension();
                $modelFile->is_image = $is_image;
                $modelFile->save();
            }

            $laporan_master = new LaporanKegiatan();
            if (!empty($request->id_mahasiswa_balai_puspaga_rw)) {
                $laporan_master->id_creator =  $request->id_mahasiswa_balai_puspaga_rw;
                $laporan_master->creator_type = LaporanKegiatanCreatorType::MAHASISWA;
            }
            if (!empty($request->id_puspaga_rw)) {
                $laporan_master->id_creator =  $request->id_puspaga_rw;
                $laporan_master->creator_type = LaporanKegiatanCreatorType::FASILITATOR;
            }
            $laporan_master->status = LaporanKegiatanStatus::UNVERIFIED;
            $laporan_master->date = $request->date;
            $laporan_master->save();

            $datalaporan = [];
            foreach ($request->laporan as $laporan) {
                $isian = [];
                // if(!empty($request->id_mahasiswa_balai_puspaga_rw)){
                //     $isian['id_mahasiswa_balai_puspaga_rw'] = $request->id_mahasiswa_balai_puspaga_rw;
                // }
                // if(!empty($request->id_puspaga_rw)){
                //     $isian['id_puspaga_rw'] = $request->id_puspaga_rw;
                // }
                $data = null;
                $isian['id_laporan_kegiatan'] = $laporan_master->id;
                if ($laporan['kegiatan_type'] == 'konseling') {
                    $isian['type'] = $laporan['konseling_type'];
                    // $isian['date'] = $laporan['date'];
                    $isian['name'] = $laporan['name'];
                    $isian['nik'] = $laporan['nik'];
                    $isian['phone'] = $laporan['phone'];
                    $isian['is_surabaya_citizen'] = $laporan['is_surabaya_citizen'];
                    $isian['address'] = $laporan['address'];
                    $isian['id_kelurahan'] = $laporan['id_kelurahan'];
                    $isian['description'] = $laporan['description'];
                    $isian['solution'] = $laporan['solution'];
                    $isian['id_m_kategori_kasus'] = $laporan['id_m_kategori_kasus'];
                    // $isian['status'] = LaporanKegiatanStatus::UNVERIFIED; // Unverified by default
                    $data = LaporanKegiatanKonseling::create($isian);
                }
                if ($laporan['kegiatan_type'] == 'rapat') {
                    // $isian['date'] = $laporan['date'];
                    $isian['type'] = $laporan['rapat_type'];
                    $isian['name'] = $laporan['name'];
                    $isian['id_kelurahan'] = $laporan['id_kelurahan'];
                    $isian['description'] = $laporan['description'];
                    $isian['total_participant'] = $laporan['total_participant'];
                    $isian['resume'] = $laporan['resume'];
                    $isian['url_video'] = (!empty($laporan['url_video'])) ? $laporan['url_video'] : null;
                    // $isian['status'] = LaporanKegiatanStatus::UNVERIFIED;
                    $data = LaporanKegiatanRapat::create($isian);
                }
                if ($laporan['kegiatan_type'] == 'sosialisasi') {
                    // $isian['date'] = $laporan['date'];
                    $isian['type'] = $laporan['sosialisasi_type'];
                    $isian['sasaran'] = $laporan['sasaran'];
                    $isian['lokasi'] = $laporan['lokasi'];
                    $isian['name'] = $laporan['name'];
                    $isian['description'] = $laporan['description'];
                    $isian['total_participant'] = $laporan['total_participant'];
                    $isian['organization'] = $laporan['organization'];
                    $isian['url_video'] = (!empty($laporan['url_video'])) ? $laporan['url_video'] : null;
                    // $isian['status'] = LaporanKegiatanStatus::UNVERIFIED;
                    $data = LaporanKegiatanSosialisasi::create($isian);
                }
                if ($laporan['kegiatan_type'] == 'piket') {
                    $isian['id_kelurahan'] = $laporan['id_kelurahan'];
                    $isian['rw'] = $laporan['rw'];
                    $isian['opening_time'] = $laporan['opening_time'];
                    $isian['closing_time'] = $laporan['closing_time'];
                    $isian['description'] = $laporan['description'];
                    $data = LaporanKegiatanPiket::create($isian);
                }
                if ($laporan['kegiatan_type'] == 'publikasi_kie') {
                    $isian['jenis_konten'] = $laporan['jenis_konten'];
                    $isian['deskripsi_kegiatan'] = $laporan['deskripsi_kegiatan'];
                    $isian['jenis_kegiatan'] = $laporan['jenis_kegiatan'];
                    $isian['tema_konten'] = $laporan['tema_konten'];
                    $isian['judul_konten'] = $laporan['judul_konten'];
                    $isian['deskripsi_konten'] = $laporan['deskripsi_konten'];
                    $isian['link_konten'] = $laporan['link_konten'];
                    $data = LaporanKegiatanPublikasiKIE::create($isian);
                }
                // Handle file
                if (!empty($laporan['files'])) {
                    foreach ($laporan['files'] as $key => $files) {
                        $file = $files['file'];
                        $changedName = time() . random_int(100, 999) . '.' . $file->getClientOriginalExtension();
                        $is_image = substr($file->getClientMimeType(), 0, 5) == 'image' ?? false;

                        $path = 'private/laporan_kegiatan_mahasiswa/' . $laporan['kegiatan_type'] . '/' . $data->id;
                        $file->storeAs($path, $changedName);

                        $modelFile = new LaporanKegiatanFile();
                        $modelFile->id_source = $data->id;
                        $modelFile->name = $file->getClientOriginalName();
                        $modelFile->path = $path . '/' . $changedName;
                        $modelFile->size = $file->getSize();
                        $modelFile->ext = $file->getClientOriginalExtension();
                        $modelFile->is_image = $is_image;
                        $modelFile->type = $files['type'];
                        $modelFile->source = LaporanKegiatanFileSourceEnum::fromName(strtoupper($laporan['kegiatan_type']));
                        $modelFile->save();
                    }
                }
            }

            DB::commit();
            $this->responseCode = 200;
            $this->responseData = $datalaporan;
            return response()->json($this->getResponse(), $this->responseCode);
        } catch (\Exception $e) {
            $this->responseCode = 500;
            $this->responseMessage = $e->getMessage();
            DB::rollback();
            return response()->json($this->getResponse(), $this->responseCode);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        try {
            $id = intval($id);
            $laporan = LaporanKegiatan::where('id', $id)->first();
            if (!$laporan) {
                $this->responseCode = 404;
                $this->responseMessage = 'Data tidak di temukan';
                return response()->json($this->getResponse(), $this->responseCode);
            }
            $laporan->append('creator');
            $this->responseCode = 200;
            $this->responseData = $laporan;
            return response()->json($this->getResponse(), $this->responseCode);
        } catch (\Exception $e) {
            $this->responseCode = 500;
            $this->responseMessage = $e->getMessage();
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
    public function update(Request $request)
    {

        try {
            DB::beginTransaction();

            $rules = [
                'laporan' => 'required|array|min:1',
                'laporan.*.kegiatan_type' => ['required', Rule::in(['konseling', 'rapat', 'sosialisasi', 'piket', 'publikasi_kie'])],
                'laporan.*.id_source' => ['required', function ($attr, $value, $fail) use ($request) {
                    $laporan = $request->laporan[explode('.', $attr)[1]];
                    $model = null;
                    if ($laporan['kegiatan_type'] == 'konseling') {
                        $model = LaporanKegiatanKonseling::where('id', $value);
                    } elseif ($laporan['kegiatan_type'] == 'rapat') {
                        $model = LaporanKegiatanRapat::where('id', $value);
                    } elseif ($laporan['kegiatan_type'] == 'sosialisasi') {
                        $model = LaporanKegiatanSosialisasi::where('id', $value);
                    } elseif ($laporan['kegiatan_type'] == 'piket') {
                        $model = LaporanKegiatanPiket::where('id', $value);
                    }
                    if ($model == null) {
                        $fail('Tipe Kegiatan tidak Valid');
                    } else {
                        if (!$model->exists()) {
                            $fail('Id ' . $laporan['kegiatan_type'] . ' (laporan.' . explode('.', $attr)[1] . '.id_source) tidak Valid');
                        }
                    }
                }],

                // Common Rules
                // 'laporan.*.date' => 'required|date',
                // 'laporan.*.name' => 'required|string',
                'laporan.*.description' => 'required|string',
                'laporan.*.url_video' => 'nullable',
                'laporan.*.id_kelurahan' => 'required_if:laporan.*.kegiatan_type,rapat,konseling|exists:App\Models\MKelurahan,id,deleted_at,NULL',
                // Kegiatan sosialisasi and Rapat only
                'laporan.*.total_participant' => 'required_if:laporan.*.kegiatan_type,rapat,sosialisasi|numeric|min:1',

                // Kegiatan Konseling Rules
                'laporan.*.nik' => 'required_if:laporan.*.kegiatan_type,konseling|digits:16|string',
                'laporan.*.phone' => 'required_if:laporan.*.kegiatan_type,konseling|string',
                'laporan.*.is_surabaya_citizen' => 'required_if:laporan.*.kegiatan_type,konseling|boolean',
                'laporan.*.address' => 'required_if:laporan.*.kegiatan_type,konseling|string',
                'laporan.*.konseling_type' => ['required_if:laporan.*.kegiatan_type,konseling', Rule::in(LaporanKegiatanKonselingTypeEnum::getValues())],
                'laporan.*.solution' => ['required_if:laporan.*.kegiatan_type,konseling'],
                'laporan.*.id_m_kategori_kasus' => 'required_if:laporan.*.kegiatan_type,konseling|exists:App\Models\MKategoriKasus,id,deleted_at,NULL',

                // Kegiatan Rapat Rules
                'laporan.*.resume' => 'required_if:laporan.*.kegiatan_type,rapat|string',

                // Kegiatan Sosialisasi Rules
                'laporan.*.organization' => 'required_if:laporan.*.kegiatan_type,sosialisasi|string',
                // 'laporan.*.sosialisasi_type' => ['required_if:laporan.*.kegiatan_type,sosialisasi', Rule::in(LaporanKegiatanSosialisasiTypeEnum::getValues())],

                // Files
                'laporan.*.files' => 'nullable|array',
                'laporan.*.files.*.file' => 'mimes:png,jpg,jpeg,pdf,ppt,pptx',
                // Fill file_old_id if want to replace existing file into laporan, leave it as null if want to add new file
                'laporan.*.files.*.file_old_id' => 'nullable|exists:App\Models\LaporanKegiatanFile,id,deleted_at,null',
                'laporan.*.files.*.type' => ['required_with:laporan.*.files.*.file', Rule::in(LaporanKegiatanFileTypeEnum::getValues())],

            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $this->responseCode = 422;
                $this->responseMessage = $validator->errors()->first();
                $this->responseData = $validator->errors();
                return response()->json($this->getResponse(), $this->responseCode);
            }
            $datalaporan = [];
            foreach ($request->laporan as $laporan) {
                $isian = [];
                $data = null;
                if ($laporan['kegiatan_type'] == 'konseling') {
                    $isian['type'] = $laporan['konseling_type'];
                    // $isian['date'] = $laporan['date'];
                    $isian['name'] = $laporan['name'];
                    $isian['nik'] = $laporan['nik'];
                    $isian['phone'] = $laporan['phone'];
                    $isian['is_surabaya_citizen'] = $laporan['is_surabaya_citizen'];
                    $isian['address'] = $laporan['address'];
                    $isian['id_kelurahan'] = $laporan['id_kelurahan'];
                    $isian['description'] = $laporan['description'];
                    $isian['solution'] = $laporan['solution'];
                    $isian['id_m_kategori_kasus'] = $laporan['id_m_kategori_kasus'];
                    LaporanKegiatanKonseling::where('id', $laporan['id_source'])->update($isian);
                    $data = LaporanKegiatanKonseling::find($laporan['id_source']);
                }
                if ($laporan['kegiatan_type'] == 'rapat') {
                    // $isian['date'] = $laporan['date'];
                    $isian['type'] = $laporan['rapat_type'];
                    $isian['name'] = $laporan['name'];
                    $isian['id_kelurahan'] = $laporan['id_kelurahan'];
                    $isian['description'] = $laporan['description'];
                    $isian['total_participant'] = $laporan['total_participant'];
                    $isian['resume'] = $laporan['resume'];
                    $isian['url_video'] = (!empty($laporan['url_video'])) ? $laporan['url_video'] : null;
                    LaporanKegiatanRapat::where('id', $laporan['id_source'])->update($isian);
                    $data = LaporanKegiatanRapat::find($laporan['id_source']);
                }
                if ($laporan['kegiatan_type'] == 'sosialisasi') {
                    // $isian['date'] = $laporan['date'];
                    $isian['type'] = $laporan['sosialisasi_type'];
                    $isian['sasaran'] = $laporan['sasaran'];
                    $isian['lokasi'] = $laporan['lokasi'];
                    $isian['name'] = $laporan['name'];
                    $isian['description'] = $laporan['description'];
                    $isian['total_participant'] = $laporan['total_participant'];
                    $isian['organization'] = $laporan['organization'];
                    $isian['url_video'] = (!empty($laporan['url_video'])) ? $laporan['url_video'] : null;
                    LaporanKegiatanSosialisasi::where('id', $laporan['id_source'])->update($isian);
                    $data = LaporanKegiatanSosialisasi::find($laporan['id_source']);
                }
                if ($laporan['kegiatan_type'] == 'piket') {
                    $isian['id_kelurahan'] = $laporan['id_kelurahan'];
                    $isian['rw'] = $laporan['rw'];
                    $isian['opening_time'] = $laporan['opening_time'];
                    $isian['closing_time'] = $laporan['closing_time'];
                    $isian['description'] = $laporan['description'];
                    LaporanKegiatanPiket::where('id', $laporan['id_source'])->update($isian);
                    $data = LaporanKegiatanPiket::find($laporan['id_source']);
                }
                if ($laporan['kegiatan_type'] == 'publikasi_kie') {
                    $isian['jenis_konten'] = $laporan['jenis_konten'];
                    $isian['deskripsi_kegiatan'] = $laporan['deskripsi_kegiatan'];
                    $isian['jenis_kegiatan'] = $laporan['jenis_kegiatan'];
                    $isian['tema_konten'] = $laporan['tema_konten'];
                    $isian['judul_konten'] = $laporan['judul_konten'];
                    $isian['deskripsi_konten'] = $laporan['deskripsi_konten'];
                    $isian['link_konten'] = $laporan['link_konten'];
                    LaporanKegiatanPublikasiKIE::where('id', $laporan['id_source'])->update($isian);
                    $data = LaporanKegiatanPublikasiKIE::create($isian);
                }
                array_push($datalaporan, $data);
                // Handle file
                if (!empty($laporan['files'])) {
                    foreach ($laporan['files'] as $key => $files) {
                        $file = $files['file'];
                        $changedName = time() . random_int(100, 999) . '.' . $file->getClientOriginalExtension();
                        $is_image = substr($file->getClientMimeType(), 0, 5) == 'image' ?? false;

                        $path = 'private/laporan_kegiatan_mahasiswa/' . $laporan['kegiatan_type'] . '/' . $datalaporan[$key]->id;
                        $file->storeAs($path, $changedName);

                        $modelFile = null;
                        if (!empty($files['file_old_id'])) {
                            // Delete old file
                            $modelFile = LaporanKegiatanFile::find($files['file_old_id']);
                            // $modelFile->forceDelete();
                            // $modelFile = new LaporanKegiatanFile();
                        } else {
                            $modelFile = new LaporanKegiatanFile();
                        }

                        $modelFile->id_source = $datalaporan[$key]->id;
                        $modelFile->name = $file->getClientOriginalName();
                        $modelFile->path = $path . '/' . $changedName;
                        $modelFile->size = $file->getSize();
                        $modelFile->ext = $file->getClientOriginalExtension();
                        $modelFile->is_image = $is_image;
                        $modelFile->type = $files['type'];
                        $modelFile->source = LaporanKegiatanFileSourceEnum::fromName(strtoupper($laporan['kegiatan_type']));
                        $modelFile->save();
                    }
                }
            }
            DB::commit();
            $this->responseCode = 200;
            $this->responseData = $datalaporan;
            return response()->json($this->getResponse(), $this->responseCode);
        } catch (\Exception $e) {
            $this->responseCode = 500;
            $this->responseMessage = $e->getMessage();
            DB::rollback();
            return response()->json($this->getResponse(), $this->responseCode);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Verif all laporan based on mahasiswa
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function verifAll(Request $request)
    {
        try {
            $rules = [
                'id_creator' => ['required', 'numeric', function ($attr, $value, $fail) use ($request) {
                    $model = null;
                    if ($request->creator_type == LaporanKegiatanCreatorType::MAHASISWA) {
                        $model = MahasiswaBalaiPuspagaRW::where('id', $value);
                    } elseif ($request->creator_type == LaporanKegiatanCreatorType::FASILITATOR) {
                        $model = PuspagaRw::where('id', $value);
                    }
                    if ($model == null) {
                        $fail('id_creator tidak Valid 1');
                    } else {
                        if (!$model->exists()) {
                            $fail('id_creator tidak Valid 2');
                        }
                    }
                }],
                'creator_type' => ['required', 'numeric', Rule::in(LaporanKegiatanCreatorType::getValues())],
                'date' => 'required|date'
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $this->responseCode = 422;
                $this->responseMessage = $validator->errors()->first();
                $this->responseData = $validator->errors();
                return response()->json($this->getResponse(), $this->responseCode);
            }

            DB::beginTransaction();

            $laporan_masters = LaporanKegiatan::where('id_creator', $request->id_creator)
                ->where('creator_type', $request->creator_type)
                ->where('date', $request->date)
                ->get();
            foreach ($laporan_masters as &$laporan) {
                if (Auth::user()->id_role == config('env.role.konselor')) {
                    $laporan->status = LaporanKegiatanStatus::VERIFIED_KONSELOR;
                }
                if (Auth::user()->id_role == config('env.role.subkord')) {
                    $laporan->status = LaporanKegiatanStatus::VERIFIED_SUBKOORD;
                }
                $laporan->save();
            }

            DB::commit();
            $this->responseCode = 200;
            $this->responseMessage = 'Laporan telah diverifikasi';
            $this->responseData = $laporan_masters;
            return response()->json($this->getResponse(), $this->responseCode);
        } catch (\Exception $e) {
            $this->responseCode = 500;
            $this->responseMessage = $e->getMessage();
            DB::rollback();
            return response()->json($this->getResponse(), $this->responseCode);
        }
    }

    /**
     * Verif certain laporan based on id given
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function verif(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            $id = intval($id);
            $data = LaporanKegiatan::where('id', $id)->first();
            if (!$data) {
                $this->responseCode = 404;
                $this->responseMessage = 'Data tidak di temukan';
                return response()->json($this->getResponse(), $this->responseCode);
            }

            if (Auth::user()->id_role == config('env.role.konselor')) {
                $data->status = LaporanKegiatanStatus::VERIFIED_KONSELOR;
            }
            if (Auth::user()->id_role == config('env.role.subkord')) {
                $data->status = LaporanKegiatanStatus::VERIFIED_SUBKOORD;
            }
            $data->save();
            DB::commit();
            $this->responseCode = 200;
            $this->responseMessage = 'Laporan telah diverifikasi';
            $this->responseData = $data;
            return response()->json($this->getResponse(), $this->responseCode);
        } catch (\Exception $e) {
            $this->responseCode = 500;
            $this->responseMessage = $e->getMessage();
            DB::rollback();
            return response()->json($this->getResponse(), $this->responseCode);
        }
    }

    public function export(Request $request)
    {
        ini_set('max_execution_time', 1000);

        $role_filter = ($request->filled('role_filter')) ? $request->role_filter : null;
        $tanggalAwal = ($request->filled('start_date')) ? $request->start_date : null;
        $tanggalAkhir = ($request->filled('end_date')) ? $request->end_date : null;

        if ($role_filter == 'mahasiswa') {
            $laporan_master = LaporanKegiatan::query();
            if (!empty($tanggalAwal) && !empty($tanggalAkhir)) {
                $laporan_master->whereBetween('date', [date('Y-m-d H:i:s', strtotime($tanggalAwal)), date('Y-m-d H:i:s', strtotime($tanggalAkhir))]);
            }
            $laporan_master->where('creator_type', LaporanKegiatanCreatorType::MAHASISWA)->with([
                'mahasiswa.detail_mahasiswa' => function ($query) {
                    $query->with(
                        'kabupaten_lahir',
                        'pendidikan_terakhir',
                        'jenis_mahasiswa',
                        'jurusan',
                        'instansi_pendidikan',
                        'kelurahan_domisili.kecamatan.kabupaten',
                        'kelurahan_kk.kecamatan.kabupaten'
                    );
                },
                'mahasiswa.balai_puspaga.kelurahan.kecamatan.kabupaten',
                'mahasiswa.konselor',
                'laporan_piket.kelurahan.kecamatan',
                'laporan_rapat.kelurahan.kecamatan',
                'laporan_konseling.kategoriKasus',
                'laporan_konseling.kelurahan.kecamatan',
                'laporan_sosialisasi.kelurahan.kecamatan',
            ])->orderBy('id_creator', 'ASC')->orderBy('date', 'ASC');

            if ($request->filled('id_jenis_mahasiswa')) {
                $laporan_master->whereHas('mahasiswa.detail_mahasiswa.jenis_mahasiswa', function ($q) use ($request) {
                    $q->where('id_jenis_mahasiswa', $request->id_jenis_mahasiswa);
                });
            }
            if ($request->filled('id_kecamatan')) {
                $laporan_master->whereHas('mahasiswa.balai_puspaga.kelurahan.kecamatan', function ($q) use ($request) {
                    $q->where('id_kecamatan', $request->id_kecamatan);
                });
            }

            if ($request->filled('id_kelurahan')) {
                $laporan_master->whereHas('mahasiswa.balai_puspaga.kelurahan', function ($q) use ($request) {
                    $q->where('id_kelurahan', $request->id_kelurahan);
                });
            }
            $result = [];
            foreach ($laporan_master->get() as $laporan) {
                $result[$laporan->id_creator]['identitas_mahasiswa']['nama_lengkap'] = $laporan->mahasiswa->detail_mahasiswa->name;
                $result[$laporan->id_creator]['identitas_mahasiswa']['nik'] = $laporan->mahasiswa->detail_mahasiswa->nik;
                $result[$laporan->id_creator]['identitas_mahasiswa']['no_wa'] = $laporan->mahasiswa->detail_mahasiswa->phone;
                $result[$laporan->id_creator]['identitas_mahasiswa']['status'] = $laporan->mahasiswa->detail_mahasiswa->pendidikan_terakhir->name;
                $result[$laporan->id_creator]['identitas_mahasiswa']['jenis'] = $laporan->mahasiswa->detail_mahasiswa->jenis_mahasiswa->name;
                $result[$laporan->id_creator]['identitas_mahasiswa']['jurusan'] = $laporan->mahasiswa->detail_mahasiswa->jurusan->name;
                $result[$laporan->id_creator]['identitas_mahasiswa']['semester'] = $laporan->mahasiswa->detail_mahasiswa->semester;
                $result[$laporan->id_creator]['identitas_mahasiswa']['univ'] = $laporan->mahasiswa->detail_mahasiswa->instansi_pendidikan->name;
                $result[$laporan->id_creator]['identitas_mahasiswa']['domicile_address'] = $laporan->mahasiswa->detail_mahasiswa->domicile_address;
                $result[$laporan->id_creator]['identitas_mahasiswa']['domicile_rt'] = $laporan->mahasiswa->detail_mahasiswa->domicile_rt;
                $result[$laporan->id_creator]['identitas_mahasiswa']['domicile_rw'] = $laporan->mahasiswa->detail_mahasiswa->domicile_rw;
                $result[$laporan->id_creator]['identitas_mahasiswa']['domicile_kelurahan'] = $laporan->mahasiswa->detail_mahasiswa->kelurahan_domisili->name;
                $result[$laporan->id_creator]['identitas_mahasiswa']['domicile_kecamatan'] = $laporan->mahasiswa->detail_mahasiswa->kelurahan_domisili->kecamatan->name;
                $result[$laporan->id_creator]['identitas_mahasiswa']['domicile_kota'] = $laporan->mahasiswa->detail_mahasiswa->kelurahan_domisili->kecamatan->kabupaten->name;
                $result[$laporan->id_creator]['identitas_mahasiswa']['balai_puspaga_kecamatan'] = $laporan->mahasiswa->balai_puspaga->kelurahan->kecamatan->name;
                $result[$laporan->id_creator]['identitas_mahasiswa']['balai_puspaga_kelurahan'] = $laporan->mahasiswa->balai_puspaga->kelurahan->name;
                $result[$laporan->id_creator]['identitas_mahasiswa']['balai_puspaga_rw'] = $laporan->mahasiswa->balai_puspaga->rw;
                $result[$laporan->id_creator]['identitas_mahasiswa']['konselor'] = $laporan->mahasiswa->balai_puspaga->konselor->name;
                $result[$laporan->id_creator]['laporan'][$laporan->id]['tanggal_kegiatan'] = $laporan->tanggal_kegiatan;
                $result[$laporan->id_creator]['laporan'][$laporan->id]['publikasi_kie'] = $laporan->laporan_kegiatan_publikasi_k_i_e;
                $result[$laporan->id_creator]['laporan'][$laporan->id]['rapat'] = $laporan->laporan_rapat;
                $result[$laporan->id_creator]['laporan'][$laporan->id]['piket'] = $laporan->laporan_piket;
                $result[$laporan->id_creator]['laporan'][$laporan->id]['konseling'] = $laporan->laporan_konseling;
                $result[$laporan->id_creator]['laporan'][$laporan->id]['sosialisasi'] = $laporan->laporan_sosialisasi;
            }
            $result = collect(json_decode(json_encode($result), false));
            ini_set('memory_limit', -1);

            $multiple = [
                'publikasi_kie' => $result,
                'konseling' => $result,
                'sosialisasi' => $result,
                'rapat' => $result,
                'piket' => $result
            ];

            return Excel::download(new CekExport($multiple, 'exports.laporanKegiatanMhsV1'), 'Laporan Kegiatan Mahasiswa V1.xlsx');
        }
        if ($role_filter == 'fasilitator') {
            $laporan_master = LaporanKegiatan::query();
            if (!empty($tanggal)) {
                $laporan_master->whereDate('date', $tanggal);
            }
            $laporan_master->where('creator_type', LaporanKegiatanCreatorType::FASILITATOR)->with([
                'fasilitator.kelurahan.kecamatan',
                'fasilitator.kelurahan_domisili.kecamatan',
                'fasilitator.kecamatan',
                'fasilitator.jabatan',
                'laporan_rapat.kelurahan.kecamatan',
                'laporan_konseling.kategoriKasus',
                'laporan_konseling.kelurahan.kecamatan',
                'laporan_sosialisasi.kelurahan.kecamatan',
                'laporan_piket.kelurahan.kecamatan',
            ])->orderBy('id_creator', 'ASC')->orderBy('date', 'ASC');
            $result = [];
            foreach ($laporan_master->get() as $laporan) {
                $result[$laporan->id_creator]['identitas_fasilitator']['nama_lengkap'] = $laporan->fasilitator->name;
                $result[$laporan->id_creator]['identitas_fasilitator']['nik'] = $laporan->fasilitator->nik;
                $result[$laporan->id_creator]['identitas_fasilitator']['jabatan'] = $laporan->fasilitator->jabatan->name;
                $result[$laporan->id_creator]['identitas_fasilitator']['no_wa'] = $laporan->fasilitator->no_hp;
                $result[$laporan->id_creator]['identitas_fasilitator']['domicile_address'] = $laporan->fasilitator->alamat_domisili;
                $result[$laporan->id_creator]['identitas_fasilitator']['domicile_rt'] = $laporan->fasilitator->rt_domisili;
                $result[$laporan->id_creator]['identitas_fasilitator']['domicile_rw'] = $laporan->fasilitator->rw_domisili;
                $result[$laporan->id_creator]['identitas_fasilitator']['domicile_kelurahan'] = $laporan->fasilitator->kelurahan_domisili->name;
                $result[$laporan->id_creator]['identitas_fasilitator']['domicile_kecamatan'] = $laporan->fasilitator->kelurahan_domisili->kecamatan->name;
                $result[$laporan->id_creator]['identitas_fasilitator']['puspaga_kelurahan'] = $laporan->fasilitator->kelurahan->name;
                $result[$laporan->id_creator]['identitas_fasilitator']['puspaga_kecamatan'] = $laporan->fasilitator->kecamatan->name;
                $result[$laporan->id_creator]['identitas_fasilitator']['puspaga_rw'] = $laporan->fasilitator->rw;
                $result[$laporan->id_creator]['identitas_fasilitator']['monev'] = '-';
                $result[$laporan->id_creator]['laporan'][$laporan->id]['tanggal_kegiatan'] = $laporan->tanggal_kegiatan;
                $result[$laporan->id_creator]['laporan'][$laporan->id]['publikasi_kie'] = $laporan->laporan_kegiatan_publikasi_k_i_e;
                $result[$laporan->id_creator]['laporan'][$laporan->id]['rapat'] = $laporan->laporan_rapat;
                $result[$laporan->id_creator]['laporan'][$laporan->id]['konseling'] = $laporan->laporan_konseling;
                $result[$laporan->id_creator]['laporan'][$laporan->id]['sosialisasi'] = $laporan->laporan_sosialisasi;
                $result[$laporan->id_creator]['laporan'][$laporan->id]['piket'] = $laporan->laporan_piket;
            }
            $result = collect(json_decode(json_encode($result), false));
            ini_set('memory_limit', -1);

            $multiple = [
                'publikasi_kie' => $result,
                'konseling' => $result,
                'sosialisasi' => $result,
                'rapat' => $result,
                'piket' => $result
            ];
            
            return Excel::download(new FasilitatorExport($multiple), 'Laporan Kegiatan Fasilitator V1.xlsx');
        }
    }

    public function exportById(Request $request, $id)
    {
        $rules = [
            'role_filter' => 'required|in:mahasiswa,fasilitator'
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $this->responseCode = 422;
            $this->responseMessage = $validator->errors()->first();
            $this->responseData = $validator->errors();
            return response()->json($this->getResponse(), $this->responseCode);
        }

        $id = intval($id);
        $tanggal = ($request->filled('tanggal_filter')) ? $request->tanggal_filter : null;

        if ($request->role_filter == 'mahasiswa') {
            $laporan = LaporanKegiatan::where('id', $id)->where('creator_type', LaporanKegiatanCreatorType::MAHASISWA)->first();
            if (!$laporan) {
                $this->responseCode = 404;
                $this->responseMessage = 'Data tidak di temukan';
                return response()->json($this->getResponse(), $this->responseCode);
            }
            $laporan_master = LaporanKegiatan::where('id', $id);
            if (!empty($tanggal)) {
                $laporan_master->whereDate('date', $tanggal);
            }
            $laporan_master->where('creator_type', LaporanKegiatanCreatorType::MAHASISWA)->with([
                'mahasiswa.detail_mahasiswa' => function ($query) {
                    $query->with(
                        'kabupaten_lahir',
                        'pendidikan_terakhir',
                        'jenis_mahasiswa',
                        'jurusan',
                        'instansi_pendidikan',
                        'kelurahan_domisili.kecamatan.kabupaten',
                        'kelurahan_kk.kecamatan.kabupaten'
                    );
                },
                'mahasiswa.balai_puspaga.kelurahan.kecamatan.kabupaten',
                'mahasiswa.konselor',
                'laporan_rapat.kelurahan.kecamatan',
                'laporan_konseling.kategoriKasus',
                'laporan_konseling.kelurahan.kecamatan',
                'laporan_sosialisasi.kelurahan.kecamatan',
            ])->orderBy('id_creator', 'ASC')->orderBy('date', 'ASC');
            $result = [];
            foreach ($laporan_master->get() as $laporan) {
                $result[$laporan->id_creator]['identitas_mahasiswa']['nama_lengkap'] = $laporan->mahasiswa->detail_mahasiswa->name;
                $result[$laporan->id_creator]['identitas_mahasiswa']['nik'] = $laporan->mahasiswa->detail_mahasiswa->nik;
                $result[$laporan->id_creator]['identitas_mahasiswa']['no_wa'] = $laporan->mahasiswa->detail_mahasiswa->phone;
                $result[$laporan->id_creator]['identitas_mahasiswa']['status'] = $laporan->mahasiswa->detail_mahasiswa->pendidikan_terakhir->name;
                $result[$laporan->id_creator]['identitas_mahasiswa']['jenis'] = $laporan->mahasiswa->detail_mahasiswa->jenis_mahasiswa->name;
                $result[$laporan->id_creator]['identitas_mahasiswa']['jurusan'] = $laporan->mahasiswa->detail_mahasiswa->jurusan->name;
                $result[$laporan->id_creator]['identitas_mahasiswa']['semester'] = $laporan->mahasiswa->detail_mahasiswa->semester;
                $result[$laporan->id_creator]['identitas_mahasiswa']['univ'] = $laporan->mahasiswa->detail_mahasiswa->instansi_pendidikan->name;
                $result[$laporan->id_creator]['identitas_mahasiswa']['domicile_address'] = $laporan->mahasiswa->detail_mahasiswa->domicile_address;
                $result[$laporan->id_creator]['identitas_mahasiswa']['domicile_rt'] = $laporan->mahasiswa->detail_mahasiswa->domicile_rt;
                $result[$laporan->id_creator]['identitas_mahasiswa']['domicile_rw'] = $laporan->mahasiswa->detail_mahasiswa->domicile_rw;
                $result[$laporan->id_creator]['identitas_mahasiswa']['domicile_kelurahan'] = $laporan->mahasiswa->detail_mahasiswa->kelurahan_domisili->name;
                $result[$laporan->id_creator]['identitas_mahasiswa']['domicile_kecamatan'] = $laporan->mahasiswa->detail_mahasiswa->kelurahan_domisili->kecamatan->name;
                $result[$laporan->id_creator]['identitas_mahasiswa']['domicile_kota'] = $laporan->mahasiswa->detail_mahasiswa->kelurahan_domisili->kecamatan->kabupaten->name;
                $result[$laporan->id_creator]['identitas_mahasiswa']['balai_puspaga_kecamatan'] = $laporan->mahasiswa->balai_puspaga->kelurahan->kecamatan->name;
                $result[$laporan->id_creator]['identitas_mahasiswa']['balai_puspaga_kelurahan'] = $laporan->mahasiswa->balai_puspaga->kelurahan->name;
                $result[$laporan->id_creator]['identitas_mahasiswa']['balai_puspaga_rw'] = $laporan->mahasiswa->balai_puspaga->rw;
                $result[$laporan->id_creator]['identitas_mahasiswa']['konselor'] = $laporan->mahasiswa->balai_puspaga->konselor->name;
                $result[$laporan->id_creator]['tanggal_kegiatan'] = $laporan->tanggal_kegiatan;
                $result[$laporan->id_creator]['laporan'][$laporan->id]['rapat'] = $laporan->laporan_rapat;
                $result[$laporan->id_creator]['laporan'][$laporan->id]['konseling'] = $laporan->laporan_konseling;
                $result[$laporan->id_creator]['laporan'][$laporan->id]['sosialisasi'] = $laporan->laporan_sosialisasi;
            }
            $result = collect(json_decode(json_encode($result), false));
            ini_set('memory_limit', -1);
            return Excel::download(new DatabaseExport($result, 'exports.laporanKegiatanMhsV2'), 'Laporan Kegiatan Mahasiswa V2.xlsx');
        } elseif ($request->role_filter == 'fasilitator') {
            $laporan = LaporanKegiatan::where('id', $id)->where('creator_type', LaporanKegiatanCreatorType::FASILITATOR)->first();
            if (!$laporan) {
                $this->responseCode = 404;
                $this->responseMessage = 'Data tidak di temukan';
                return response()->json($this->getResponse(), $this->responseCode);
            }
            $laporan_master = LaporanKegiatan::where('id', $id);
            if (!empty($tanggal)) {
                $laporan_master->whereDate('date', $tanggal);
            }
            $laporan_master->where('creator_type', LaporanKegiatanCreatorType::FASILITATOR)->with([
                'fasilitator.kelurahan.kecamatan',
                'fasilitator.kelurahan_domisili.kecamatan',
                'fasilitator.kecamatan',
                'fasilitator.jabatan',
                'laporan_rapat.kelurahan.kecamatan',
                'laporan_konseling.kategoriKasus',
                'laporan_konseling.kelurahan.kecamatan',
                'laporan_sosialisasi.kelurahan.kecamatan',
                'laporan_piket.kelurahan.kecamatan',
            ])->orderBy('id_creator', 'ASC')->orderBy('date', 'ASC');
            $result = [];
            foreach ($laporan_master->get() as $laporan) {
                $result[$laporan->id_creator]['identitas_fasilitator']['nama_lengkap'] = $laporan->fasilitator->name;
                $result[$laporan->id_creator]['identitas_fasilitator']['nik'] = $laporan->fasilitator->nik;
                $result[$laporan->id_creator]['identitas_fasilitator']['jabatan'] = $laporan->fasilitator->jabatan->name;
                $result[$laporan->id_creator]['identitas_fasilitator']['no_wa'] = $laporan->fasilitator->no_hp;
                $result[$laporan->id_creator]['identitas_fasilitator']['domicile_address'] = $laporan->fasilitator->alamat_domisili;
                $result[$laporan->id_creator]['identitas_fasilitator']['domicile_rt'] = $laporan->fasilitator->rt_domisili;
                $result[$laporan->id_creator]['identitas_fasilitator']['domicile_rw'] = $laporan->fasilitator->rw_domisili;
                $result[$laporan->id_creator]['identitas_fasilitator']['domicile_kelurahan'] = $laporan->fasilitator->kelurahan_domisili->name;
                $result[$laporan->id_creator]['identitas_fasilitator']['domicile_kecamatan'] = $laporan->fasilitator->kelurahan_domisili->kecamatan->name;
                $result[$laporan->id_creator]['identitas_fasilitator']['puspaga_kelurahan'] = $laporan->fasilitator->kelurahan->name;
                $result[$laporan->id_creator]['identitas_fasilitator']['puspaga_kecamatan'] = $laporan->fasilitator->kecamatan->name;
                $result[$laporan->id_creator]['identitas_fasilitator']['puspaga_rw'] = $laporan->fasilitator->rw;
                $result[$laporan->id_creator]['identitas_fasilitator']['monev'] = '-';
                $result[$laporan->id_creator]['tanggal_kegiatan'] = $laporan->tanggal_kegiatan;
                $result[$laporan->id_creator]['laporan'][$laporan->id]['rapat'] = $laporan->laporan_rapat;
                $result[$laporan->id_creator]['laporan'][$laporan->id]['konseling'] = $laporan->laporan_konseling;
                $result[$laporan->id_creator]['laporan'][$laporan->id]['sosialisasi'] = $laporan->laporan_sosialisasi;
                $result[$laporan->id_creator]['laporan'][$laporan->id]['piket'] = $laporan->laporan_piket;
            }
            $result = collect(json_decode(json_encode($result), false));
            ini_set('memory_limit', -1);
            return Excel::download(new DatabaseExport($result, 'exports.laporanKegiatanFasilitatorV2'), 'Laporan Kegiatan Fasilitator V2.xlsx');
        } else {
            $this->responseCode = 404;
            $this->responseMessage = 'Data tidak di temukan';
        }

        return response()->json($this->getResponse(), $this->responseCode);
    }

    public function checkPlacement(Request $request,)
    {
        try {
            $data = null;
            if (auth()->user()->id_role == config('env.role.mahasiswa')) {
                $data = MahasiswaBalaiPuspagaRW::where(['id_mahasiswa' => auth()->user()->id_mahasiswa, 'is_active' => true])->with('konselor', 'balai_puspaga.kelurahan.kecamatan')->first();
            } else if (auth()->user()->id_role == config('env.role.fasilitator')) {
                $data = PuspagaRw::where('id', auth()->user()->id_fasilitator)->with('ttd', 'kelurahan.kecamatan')->first();
            }
            if (!$data) {
                $this->responseCode = 404;
                $this->responseMessage = 'Data tidak di temukan';
                return response()->json($this->getResponse(), $this->responseCode);
            }
            $this->responseCode = 200;
            $this->responseData = $data;
            return response()->json($this->getResponse(), $this->responseCode);
        } catch (\Exception $e) {
            $this->responseCode = 500;
            $this->responseMessage = $e->getMessage();
            return response()->json($this->getResponse(), $this->responseCode);
        }
    }

    private function paginate(Request $request, $items, $limit)
    {
        $page = $request->get('page', 1);
        $offset = ($page - 1) * $limit;

        return new \Illuminate\Pagination\LengthAwarePaginator(
            $items->slice($offset, $limit),
            $items->count(),
            $limit,
            $page,
            [
                'path' => $request->url(),
                'query' => $request->query(),
            ]
        );
    }
}
