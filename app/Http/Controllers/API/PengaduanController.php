<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\Pengaduan;
use App\Models\PengaduanFile;
use Illuminate\Support\Str;
use App\Models\DaftarKlien;
use App\Models\Klien;
use App\Models\KlienHistory;
use App\Models\MKonselor;
use App\Http\Resources\DetailPengaduanResource;
use Illuminate\Support\Facades\Crypt;
use App\Models\TimelinePengaduan;
use App\Http\Resources\CetakLaporanResource;
use App\Models\PenjangkauanRollback;
use PDF;
use App\Helpers\HelperPublic;
use App\Models\RencanaIntervensi;
use PDFMerger;
use File;
use FPDF;
use Imagick;
use setasign\Fpdi\Fpdi;

class PengaduanController extends Controller
{
    public $rules;
    public function __construct(Request $req)
    {
        // $this->middleware('role.hotline', ['only' => ['store', 'update', 'getAutoGenerate']]);

        $rules = [
            'id_sumber' => 'required|exists:App\Models\MSumberKeluhan,id,deleted_at,NULL',
            'tanggal_pengaduan' => 'required|date',
            'uraian_singkat_permasalahan' => 'required|string',
            'dokumentasi' => 'required|array|min:1',
            'dokumentasi.*' => 'mimes:png,jpg,jpeg',
            'dokumentasi_existing' => 'nullable|array',
            'dokumentasi_existing.*' => 'exists:App\Models\PengaduanFile,id,deleted_at,NULL',

            // pelapor
            'nama_lengkap_pelapor' => 'required|string',
            'nik_pelapor' => 'nullable|numeric',
            'no_telepon_pelapor' => 'required|string',
            'warga_surabaya_pelapor' => 'nullable|boolean',
            'id_kabupaten_pelapor' => 'nullable|exists:App\Models\MKabupaten,id,deleted_at,NULL',
            'alamat_pelapor' => 'required|string',

            // klien
            'client_type' => 'required|in:1,2,3',
            'id_klien' => 'nullable',
            'nama_lengkap_klien' => 'nullable|string',
            'inisial_klien' => 'nullable|string',
            'nik_klien' => 'nullable|numeric',
            'is_has_nik' => 'nullable|boolean',
            'warga_surabaya_klien' => 'nullable|boolean',
            'id_kabupaten_klien' => 'nullable|exists:App\Models\MKabupaten,id,deleted_at,NULL',
            'no_telepon_klien' => 'nullable|string',
            'alamat_klien' => 'nullable|string',
            'id_kelurahan_klien' => 'nullable|exists:App\Models\MKelurahan,id,deleted_at,NULL',
        ];
        if ($req->filled('warga_surabaya_pelapor') && !$req->warga_surabaya_pelapor) {
            $rules['id_kabupaten_pelapor'] .= '|required';
        }
        if ($req->client_type == 1) {
            $rules['id_klien'] .= '|required|exists:App\Models\DaftarKlien,id,deleted_at,NULL';
        }
        if ($req->client_type == 2) {
            $rules['nama_lengkap_klien'] .= '|required';
            $rules['inisial_klien'] .= '|required';
            if ($req->filled('is_has_nik') && $req->is_has_nik) {
                $rules['nik_klien'] .= '|required';
            }
            if ($req->filled('warga_surabaya_klien') && !$req->warga_surabaya_klien) {
                $rules['id_kabupaten_klien'] .= '|required';
            }

            $rules['id_kelurahan_klien'] .= '|required';
            $rules['no_telepon_klien'] .= '|required';
            $rules['alamat_klien'] .= '|required';
        }

        $this->rules = $rules;
        parent::__construct($req);
    }

    public function index(Request $req)
    {
        $this->authorize('viewAny', Pengaduan::class);

        try {
            $user_role = auth()->user()->id_role;

            $limit = $req->limit ? intval($req->limit) : 10;
            if ($limit > 100) $limit = 100;

            $order = Str::lower($req->order) == 'asc' ? 'asc' : 'desc';
            $sortby = $req->sortby ? $req->sortby : 'id';

            $pengaduan = Pengaduan::select([
                // DB::raw("LPAD(pengaduan.id::text, 4, '0') as lpad_id"),
                'pengaduan.id', 'pengaduan.registration_number',
                'pengaduan.id_klien', DB::raw('daftar_klien.name AS mama_klien'), 'daftar_klien.is_has_nik', 'daftar_klien.identity_number',

                DB::raw('daftar_klien.nik_number AS nik_klien'), 'daftar_klien.residence_address AS alamat_klien',
                'daftar_klien.id_kelurahan_tinggal', 'm_kelurahan.name as nama_kelurahan',
                'm_kelurahan.id_kecamatan', 'm_kecamatan.name AS nama_kecamatan',
                'daftar_klien.id_kabupaten_tinggal', 'm_kabupaten.name AS nama_kabupaten',

                DB::raw('pengaduan.complainant_name AS nama_pelapor'),
                DB::raw('pengaduan.complainant_nik AS nik_pelapor'), DB::raw('pengaduan.complaint_date AS tgl_pengaduan'),
                'pengaduan.id_sumber_keluhan', DB::raw('m_sumber_keluhan.name AS sumber'), DB::raw('pengaduan.id_status AS status'),
            ])
                ->leftJoin('daftar_klien', 'daftar_klien.id', '=', 'pengaduan.id_klien')
                ->leftJoin('m_sumber_keluhan', 'm_sumber_keluhan.id', '=', 'pengaduan.id_sumber_keluhan')
                ->leftJoin('m_kelurahan', 'm_kelurahan.id', '=', 'daftar_klien.id_kelurahan_tinggal')
                ->leftJoin('m_kecamatan', 'm_kecamatan.id', '=', 'm_kelurahan.id_kecamatan')
                ->leftJoin('m_kabupaten', 'm_kabupaten.id', '=', 'daftar_klien.id_kabupaten_tinggal');

            if ($user_role != config('env.role.opd')) {
                if (!$req->start_date) {
                    $req->request->add(['start_date' => date('Y-m-d', strtotime('01/01'))]);
                }
                if (!$req->end_date) {
                    $req->request->add(['end_date' => date('Y-m-d', strtotime('12/31'))]);
                }
                $pengaduan->whereBetween('pengaduan.complaint_date', [$req->start_date . " 00:00:00", $req->end_date . " 23:59:59"]);
            }

            switch ($user_role) {
                case config('env.role.hotline'):
                    break;
                case config('env.role.subkord'):
                    $pengaduan->whereIn('id_status', [3, 4, 6, 7, 8]);
                    break;
                case config('env.role.kabid'):
                    $pengaduan->whereIn('id_status', [4, 5, 8]);
                    break;
                case config('env.role.konselor'):
                    $pengaduan->whereIn('id_status', [5, 6, 7, 8, 9, 10]);
                    $pengaduan->whereHas('penjangkauan.penjangkauan_konselor', function ($q) {
                        $q->where('id_konselor', auth()->user()->id_konselor);
                    });
                    break;
                case config('env.role.opd'):
                    $pengaduan
                        ->whereHas('penjangkauan.rencanaIntervensi', function ($q) {
                            $q->where('id_opd', auth()->user()->id_opd);
                        })
                        ->whereIn('id_status', [8, 9, 10]);
                    break;
                case config('env.role.kadis'):
                    $pengaduan->whereIn('id_status', [9, 10]);
                    break;
                case config('env.role.asisten'):
                    $pengaduan
                        ->whereHas('penjangkauan.rencanaIntervensi');
                    break;
                default:
                    break;
            }

            if ($req->filled('id_status')) {
                $id_status = array_map('trim', explode(',', $req->id_status));
                $pengaduan->whereIn('id_status', $id_status);
            }

            if ($req->filled('search')) {
                $number = explode("/", $req->search);

                if (count($number) == 1) {
                    if ($number[0] != '37') {
                        $pengaduan
                            // ->where('pengaduan.registration_number', 'ILIKE', '%'.$req->search.'%')
                            ->where('daftar_klien.name', 'ILIKE', '%' . $req->search . '%')
                            ->orWhere('pengaduan.complainant_name', 'ILIKE', '%' . $req->search . '%')
                            ->orWhere('m_sumber_keluhan.name', 'ILIKE', '%' . $req->search . '%')
                            ->orWhere(function ($q) use ($req) {
                                $q->where('daftar_klien.nik_number', 'ILIKE', '%' . $req->search . '%')
                                    ->whereNotNull('daftar_klien.nik_number');
                            })
                            ->orWhere(function ($q) use ($req) {
                                $q->where('pengaduan.complainant_nik', 'ILIKE', '%' . $req->search . '%')
                                    ->whereNotNull('pengaduan.complainant_nik');
                            });
                    }
                } else {
                    $pengaduan->where(DB::raw("LPAD(pengaduan.registration_number::text, 4, '0')"), 'ILIKE', '%' . $number[1] . '%');
                    if (isset($number[2])) {
                        if ($number[2]) {
                            $pengaduan->whereHas('penjangkauan.jenis_kasus.kategoriKasus', function ($q) use ($number) {
                                $q->where('name', 'ILIKE', '%' . $number[2] . '%');
                            });
                        }
                        if ($number[2] == '0') {
                            $pengaduan->doesntHave('penjangkauan.jenis_kasus');
                        }
                    }
                    if (isset($number[3]) && $number[3]) {
                        $number[3] = strtoupper($number[3]);
                        $pengaduan->whereMonth('pengaduan.complaint_date', HelperPublic::$romawiBulan[$number[3]] ?? 0);
                    }
                    if (isset($number[4]) && $number[4]) {
                        $pengaduan->whereYear('pengaduan.complaint_date', $number[4]);
                    }
                }
            }

            if ($sortby == 'registration_number') {
                $pengaduan = $pengaduan->orderByRaw($sortby . '::int ' . $order)->paginate($limit);
            } else {
                $pengaduan = $pengaduan->orderBy($sortby, $order)->paginate($limit);
            }

            foreach ($pengaduan as $p) {
                $p->konselor = MKonselor::select(['id', 'name'])->whereHas('penjangkauan', function ($q) use ($p) {
                    $q->whereHas('pengaduan', function ($q) use ($p) {
                        $q->where('id', $p->id);
                    });
                })->get();
            }


            $request = collect(['request' => $req->all()]);
            $data = $request->merge($pengaduan);

            $this->saveLog($data);
            return $data;
        } catch (\Exception $e) {
            $this->responseCode = 500;
            $this->responseMessage = $e->getMessage() . ' ' . $e->getLine();
            return response()->json($this->getResponse(), $this->responseCode);
        }
    }

    public function store(Request $req)
    {
        $this->authorize('create', Pengaduan::class);

        // try {
        DB::beginTransaction();

        $validator = Validator::make($req->all(), $this->rules);
        if ($validator->fails()) {
            $this->responseCode = 422;
            $this->responseMessage = $validator->errors()->first();
            $this->responseData = $validator->errors();
            return response()->json($this->getResponse(), $this->responseCode);
        }

        if ($req->client_type == 2) {
            $klien = DaftarKlien::create([
                'name' => $req->nama_lengkap_klien,
                'initial_name' => $req->inisial_klien,
                'is_has_nik' => $req->filled('is_has_nik') ? $req->is_has_nik : true,
                'nik_number' => $req->filled('is_has_nik') && $req->is_has_nik ? $req->nik_klien : null,
                'identity_number' => !$req->is_has_nik ? DaftarKlien::IdentityNumber() : null,
                'phone_number' => $req->no_telepon_klien,
                'is_surabaya_resident' => $req->filled('warga_surabaya_klien') ? $req->warga_surabaya_klien : true,
                'id_kabupaten_tinggal' => $req->filled('warga_surabaya_klien') && !$req->warga_surabaya_klien ? $req->id_kabupaten_klien : null,
                'id_kelurahan_tinggal' => $req->id_kelurahan_klien,
                'residence_address' => $req->alamat_klien,
            ]);
        }
        if ($req->client_type == 3) {
            $words = explode(" ", $req->nama_lengkap_pelapor);
            $initial = "";

            foreach ($words as $w) {
                $initial .= mb_substr($w, 0, 1);
            }

            $klien = DaftarKlien::create([
                'name' => $req->nama_lengkap_pelapor,
                'initial_name' => strtoupper($initial),
                'is_has_nik' => $req->filled('nik_pelapor') ?? false,
                'nik_number' => $req->filled('nik_pelapor') ? $req->nik_pelapor : null,
                'identity_number' => !$req->filled('nik_pelapor') ? DaftarKlien::IdentityNumber() : null,
                'phone_number' => $req->no_telepon_pelapor,
                'is_surabaya_resident' => $req->filled('warga_surabaya_pelapor') ? $req->warga_surabaya_pelapor : true,
                'id_kabupaten_tinggal' => $req->filled('warga_surabaya_pelapor') && !$req->warga_surabaya_pelapor ? $req->id_kabupaten_pelapor : null,
                'residence_address' => $req->alamat_pelapor,
            ]);
        }

        $pengaduan = new Pengaduan();
        $pengaduan->id_sumber_keluhan = $req->id_sumber;
        $pengaduan->registration_number = (DB::table('pengaduan')
            ->whereYear('complaint_date', date('Y', strtotime($req->tanggal_pengaduan)))
            ->orderByRaw('registration_number::int DESC')->pluck('registration_number')->first()  ?? 0
        ) + 1;
        $pengaduan->complaint_date = $req->tanggal_pengaduan;
        $pengaduan->complainant_name = $req->nama_lengkap_pelapor;
        $pengaduan->complainant_nik = $req->nik_pelapor ?? '';
        if ($req->filled('warga_surabaya_pelapor')) {
            $pengaduan->complainant_is_surabaya_resident = $req->warga_surabaya_pelapor;
            if (!$req->warga_surabaya_pelapor) {
                $pengaduan->complainant_id_kabupaten = $req->id_kabupaten_pelapor;
            }
        }
        $pengaduan->complainant_phone_number = $req->no_telepon_pelapor;
        $pengaduan->complainant_residence_address = $req->alamat_pelapor;
        $pengaduan->problem_description = $req->uraian_singkat_permasalahan;
        $pengaduan->client_type = $req->client_type;
        $pengaduan->id_klien = $req->client_type == 1 ? $req->id_klien : $klien->id;
        $pengaduan->id_status = 1;
        $pengaduan->save();

        foreach ($req->dokumentasi as $file) {
            $changedName = time() . random_int(100, 999) . '.' . $file->getClientOriginalExtension();
            $is_image = false;
            if (substr($file->getClientMimeType(), 0, 5) == 'image') {
                $is_image = true;
            }

            $path = 'private/pengaduan/' . $pengaduan->id;
            $file->storeAs($path, $changedName);

            $PengaduanFile = new PengaduanFile();
            $PengaduanFile->id_pengaduan = $pengaduan->id;
            $PengaduanFile->name = $file->getClientOriginalName();
            $PengaduanFile->path = $path . '/' . $changedName;
            $PengaduanFile->size = $file->getSize();
            $PengaduanFile->ext = $file->getClientOriginalExtension();
            $PengaduanFile->is_image = $is_image;
            $PengaduanFile->save();
        }

        $timeline = TimelinePengaduan::create([
            'id_pengaduan' => $pengaduan->id,
            'id_status' => $pengaduan->id_status,
            'name' => 'Menunggu Verifikasi Hotline',
            'description' => 'Pengaduan baru, sedang dalam proses penanganan awal'
        ]);

        DB::commit();
        $this->responseCode = 201;
        return response()->json($this->getResponse(), $this->responseCode);
        // } catch (\Exception $e) {
        //     DB::rollback();
        //     $this->responseCode = 500;
        //     $this->responseMessage = $e->getMessage(). ' ' .$e->getLine();
        //     return response()->json($this->getResponse(), $this->responseCode);
        // }
    }

    public function update(Request $req, $id)
    {
        $id = intval($id);
        $pengaduan = Pengaduan::find($id);
        if (!$pengaduan) {
            $this->responseCode = 404;
            $this->responseMessage = 'Data tidak ditemukan';
            return response()->json($this->getResponse(), $this->responseCode);
        }

        $this->authorize('update', $pengaduan);

        try {
            DB::beginTransaction();

            if ($req->has('dokumentasi_existing') && count($req->dokumentasi_existing)) {
                $this->rules['dokumentasi'] = 'nullable|array';
            }

            $validator = Validator::make($req->all(), $this->rules);
            if ($validator->fails()) {
                $this->responseCode = 422;
                $this->responseMessage = $validator->errors()->first();
                $this->responseData = $validator->errors();
                return response()->json($this->getResponse(), $this->responseCode);
            }

            $id_klien = $pengaduan->id_klien;

            $pengaduan->id_klien = null;
            $pengaduan->save();

            $klien = DaftarKlien::where('id', $id_klien)
                ->doesntHave('pengaduan')
                ->delete();

            if ($req->client_type == 1) {
                $klien = DaftarKlien::find(intval($req->id_klien));
            }

            if ($req->client_type == 2) {
                $klien = DaftarKlien::create([
                    'name' => $req->nama_lengkap_klien,
                    'initial_name' => $req->inisial_klien,
                    'is_has_nik' => $req->filled('is_has_nik') ? $req->is_has_nik : true,
                    'nik_number' => $req->filled('is_has_nik') && $req->is_has_nik ? $req->nik_klien : null,
                    'identity_number' => !$req->is_has_nik ? DaftarKlien::IdentityNumber() : null,
                    'phone_number' => $req->no_telepon_klien,
                    'is_surabaya_resident' => $req->filled('warga_surabaya_klien') ? $req->warga_surabaya_klien : true,
                    'id_kabupaten_tinggal' => $req->filled('warga_surabaya_klien') && !$req->warga_surabaya_klien ? $req->id_kabupaten_klien : null,
                    'id_kelurahan_tinggal' => $req->id_kelurahan_klien,
                    'residence_address' => $req->alamat_klien,
                ]);
            }


            if ($req->client_type == 3) {
                $words = explode(" ", $req->nama_lengkap_pelapor);
                $initial = "";

                foreach ($words as $w) {
                    $initial .= mb_substr($w, 0, 1);
                }


                $KlienHistory = $KlienHistory = KlienHistory::where('id_daftar_klien', $id_klien)->first();
                // $klien = DaftarKlien::create([
                //     'name' => $req->nama_lengkap_pelapor,
                //     'initial_name' => strtoupper($initial),
                //     'is_has_nik' => $req->filled('nik_pelapor') ?? false,
                //     'nik_number' => $req->filled('nik_pelapor') ? $req->nik_pelapor : null,
                //     'identity_number' => !$req->filled('nik_pelapor') ? DaftarKlien::IdentityNumber() : null,
                //     'phone_number' => $req->no_telepon_pelapor,
                //     'is_surabaya_resident' => $req->filled('warga_surabaya_pelapor') ? $req->warga_surabaya_pelapor : true,
                //     'id_kabupaten_tinggal' => $getLastKlienHistory->id_kabupaten_tinggal,
                //     'id_kelurahan_tinggal' => $getLastKlienHistory->id_kelurahan_tinggal,
                //     'residence_address' => $req->alamat_pelapor,
                // ]);

                $klien = DaftarKlien::create([
                    'name' => $req->nama_lengkap_pelapor,
                    'initial_name' => strtoupper($initial),
                    'is_has_nik' => $req->filled('nik_pelapor') ?? false,
                    'nik_number' => $req->filled('nik_pelapor') ? $req->nik_pelapor : null,
                    'identity_number' => !$req->filled('nik_pelapor') ? DaftarKlien::IdentityNumber() : null,
                    'phone_number' => $req->no_telepon_pelapor,
                    'is_surabaya_resident' => $req->filled('warga_surabaya_pelapor') ? $req->warga_surabaya_pelapor : true,
                    'id_kabupaten_tinggal' => $req->filled('warga_surabaya_pelapor') && !$req->warga_surabaya_pelapor ? $req->id_kabupaten_pelapor : null,
                    'id_kelurahan_tinggal' => $KlienHistory->id_kelurahan_kk ?? null,
                    'residence_address' => $req->alamat_pelapor,
                ]);
            }

            if ($KlienHistory = KlienHistory::where('id_daftar_klien', $id_klien)->first()) {
                $KlienHistory->id_daftar_klien = $klien->id;
                $KlienHistory->residence_address = $klien->residence_address;
                $KlienHistory->id_kabupaten_tinggal = $req->client_type == 2 ? $klien->id_kabupaten_tinggal : $KlienHistory->id_kabupaten_tinggal;
                $KlienHistory->id_kelurahan_tinggal = $req->client_type == 2 ? $klien->id_kelurahan_tinggal : $KlienHistory->id_kelurahan_kk;
                $KlienHistory->save();
            }

            if ($updateKlien = ($pengaduan->penjangkauan->klien ?? null)) {
                auth()->user()->id_role != config('env.role.konselor') ? $updateKlien->stopUserstamping() : null;
                $updateKlien->name = $klien->name;
                $updateKlien->initial_name = $klien->initial_name;
                $updateKlien->is_has_nik = $klien->is_has_nik;
                $updateKlien->identity_number = $klien->identity_number;
                $updateKlien->nik_number = $klien->nik_number;
                $updateKlien->phone_number = $klien->phone_number;
                $updateKlien->is_surabaya_resident = $klien->is_surabaya_resident;
                if ($req->client_type == 2) {
                    $updateKlien->id_kabupaten_tinggal = $klien->id_kabupaten_tinggal;
                    $updateKlien->id_kelurahan_tinggal = $klien->id_kelurahan_tinggal;
                } elseif (
                    $req->client_type == 3
                    && $KlienHistory->id_kelurahan_kk != null
                    && auth()->user()->id_role == config('env.role.kabid')
                ) {

                    $updateKlien->id_kabupaten_tinggal = $KlienHistory->id_kabupaten_tinggal;
                    $updateKlien->id_kelurahan_tinggal = $KlienHistory->id_kelurahan_kk;
                }
                $updateKlien->residence_address = $klien->residence_address;
                $updateKlien->save();
            }



            $pengaduan->id_sumber_keluhan = $req->id_sumber;

            if (date('Y', strtotime($pengaduan->complaint_date)) != date('Y', strtotime($req->tanggal_pengaduan))) {
                $pengaduan->registration_number = (DB::table('pengaduan')
                    ->whereYear('complaint_date', date('Y', strtotime($req->tanggal_pengaduan)))
                    ->orderByRaw('registration_number::int DESC')->pluck('registration_number')->first()  ?? 0
                ) + 1;
            }

            $pengaduan->complaint_date = $req->tanggal_pengaduan;
            $pengaduan->complainant_name = $req->nama_lengkap_pelapor;
            $pengaduan->complainant_nik = $req->nik_pelapor ?? '';
            if ($req->filled('warga_surabaya_pelapor')) {
                $pengaduan->complainant_is_surabaya_resident = $req->warga_surabaya_pelapor;
                if (!$req->warga_surabaya_pelapor) {
                    $pengaduan->complainant_id_kabupaten = $req->id_kabupaten_pelapor;
                }
            }
            $pengaduan->complainant_phone_number = $req->no_telepon_pelapor;
            $pengaduan->complainant_residence_address = $req->alamat_pelapor;
            $pengaduan->problem_description = $req->uraian_singkat_permasalahan;
            $pengaduan->client_type = $req->client_type;
            // $pengaduan->id_klien = $req->client_type == 1 ? $req->id_klien : $klien->id;
            $pengaduan->id_klien = $klien->id;
            // $pengaduan->id_status = 1;
            $pengaduan->save();

            $deletedFile = PengaduanFile::where('id_pengaduan', $pengaduan->id);
            if ($req->dokumentasi_existing) {
                $deletedFile->whereNotIn('id', $req->dokumentasi_existing);
            }
            foreach ($deletedFile->get() as $file) {
                $file->forceDelete();
            }

            if ($req->dokumentasi) {
                foreach ($req->dokumentasi as $file) {
                    $changedName = time() . random_int(100, 999) . '.' . $file->getClientOriginalExtension();
                    $is_image = false;
                    if (substr($file->getClientMimeType(), 0, 5) == 'image') {
                        $is_image = true;
                    }

                    $path = 'private/pengaduan/' . $id;
                    $file->storeAs($path, $changedName);

                    $PengaduanFile = new PengaduanFile();
                    $PengaduanFile->id_pengaduan = $id;
                    $PengaduanFile->name = $file->getClientOriginalName();
                    $PengaduanFile->path = $path . '/' . $changedName;
                    $PengaduanFile->size = $file->getSize();
                    $PengaduanFile->ext = $file->getClientOriginalExtension();
                    $PengaduanFile->is_image = $is_image;
                    $PengaduanFile->save();
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

    public function show($id)
    {
        $id = intval($id);
        $pengaduan = Pengaduan::find($id);
        if (!$pengaduan) {
            $this->responseCode = 404;
            $this->responseMessage = 'Data tidak ditemukan';
            return response()->json($this->getResponse(), $this->responseCode);
        }

        $this->authorize('view', $pengaduan);

        try {
            // if (auth()->user()->id_role == config('env.role.opd')) {
            //     $idOpd = auth()->user()->id_opd;

            //     $IDORchecker = Pengaduan::whereHas('penjangkauan.rencanaIntervensi', function ($q) use ($idOpd) {
            //         $q->where('rencana_intervensi.id_opd', $idOpd);
            //     })->where('id', $id)->exists();

            //     if ($IDORchecker == false) {
            //         // $this->responseCode = 403;
            //         // $this->responseMessage = 'User tidak memiliki hak akses';
            //         $this->responseCode = 404;
            //         $this->responseMessage = 'Data tidak ditemukan';
            //         return response()->json($this->getResponse(), $this->responseCode);
            //     }
            // }

            // if (auth()->user()->id_role == config('env.role.konselor')) {
            //     $idKonselor = auth()->user()->id_konselor;
            //     $IDORchecker = Pengaduan::whereHas('penjangkauan.penjangkauan_konselor', function ($q) use ($idKonselor) {
            //         $q->where('penjangkauan_konselor.id_konselor', $idKonselor);
            //     })->where('id', $id)->exists();

            //     if ($IDORchecker == false) {
            //         // $this->responseCode = 403;
            //         // $this->responseMessage = 'User tidak memiliki hak akses';
            //         $this->responseCode = 404;
            //         $this->responseMessage = 'Data tidak ditemukan';
            //         return response()->json($this->getResponse(), $this->responseCode);
            //     }
            // }

            if (in_array(auth()->user()->id_role, [
                config('env.role.kadis'),
                config('env.role.asisten')
            ])) {
                if ($pengaduan->id_status < 9) {
                    // $this->responseCode = 403;
                    // $this->responseMessage = 'User tidak memiliki hak akses';
                    $this->responseCode = 400;
                    $this->responseMessage = 'Status tidak valid';
                    return response()->json($this->getResponse(), $this->responseCode);
                }
            }

            // if (auth()->user()->id_role == config('env.role.kadis')) {
            //     if ($pengaduan->id_status < 9) {
            //         // $this->responseCode = 403;
            //         // $this->responseMessage = 'User tidak memiliki akses';
            //         $this->responseCode = 400;
            //         $this->responseMessage = 'Status tidak valid';
            //         return response()->json($this->getResponse(), $this->responseCode);
            //     }
            // }

            $this->responseCode = 200;
            $this->responseData = new DetailPengaduanResource($pengaduan);
            return response()->json($this->getResponse(), $this->responseCode);
        } catch (\Exception $e) {
            $this->responseCode = 500;
            $this->responseMessage = $e->getMessage();
            return response()->json($this->getResponse(), $this->responseCode);
        }
    }

    public function getAutoGenerate()
    {
        try {
            $this->responseCode = 200;
            $this->responseData = [
                'nomor_registrasi' => Pengaduan::RegistrationNumber(Pengaduan::select('id')->count() + 1),
                'nomor_identitas' => DaftarKlien::IdentityNumber(),
            ];
            return response()->json($this->getResponse(), $this->responseCode);
        } catch (\Exception $e) {
            $this->responseCode = 500;
            $this->responseMessage = $e->getMessage();
            return response()->json($this->getResponse(), $this->responseCode);
        }
    }

    public function KabidApprove($id)
    {
        $id = intval($id);
        $pengaduan = Pengaduan::find($id);
        if (!$pengaduan) {
            $this->responseCode = 404;
            $this->responseMessage = 'Data tidak ditemukan';
            return response()->json($this->getResponse(), $this->responseCode);
        }

        if (!in_array($pengaduan->id_status, [4, 8])) {
            $this->responseCode = 400;
            $this->responseMessage = 'Status tidak valid';
            return response()->json($this->getResponse(), $this->responseCode);
        }

        $this->authorize('KabidApprove', $pengaduan);

        try {
            DB::beginTransaction();

            $pengaduan->id_status = $pengaduan->id_status == 4 ? 5 : 9;
            $pengaduan->save();

            $timeline = TimelinePengaduan::create([
                'id_pengaduan' => $pengaduan->id,
                'id_status' => $pengaduan->id_status,
                'name' => $pengaduan->id_status == 5 ? 'Konselor Melaksanakan Penjangkauan' : 'Menunggu Verifiasi Kadis',
                'description' =>
                $pengaduan->id_status == 5 ?
                    "Pengaduan telah disetujui oleh kabid, dan konselor sedang melaksanakan penjangkauan ke lokasi klien. Proses penjangkauan membutuhkan waktu hingga lebih dari 1 hari tergantung kasus yang di tangani"
                    : 'Kabid telah menyetujui hasil penjangkauan dan meneruskan ke kadis',
            ]);

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

    public function subkordApprove(Request $req, $id)
    {
        $id = intval($id);

        $pengaduan = Pengaduan::find($id);
        if (!$pengaduan) {
            $this->responseCode = 404;
            $this->responseMessage = 'Data tidak ditemukan';
            return response()->json($this->getResponse(), $this->responseCode);
        }

        if (!in_array($pengaduan->id_status, [7, 8])) {
            $this->responseCode = 400;
            $this->responseMessage = 'Status tidak valid';
            return response()->json($this->getResponse(), $this->responseCode);
        }

        $this->authorize('subkordApprove', $pengaduan);

        try {
            DB::beginTransaction();

            $rules = [
                'is_accepted' => 'nullable|boolean',
                'description' => 'required_if:is_accepted,FALSE|string',

            ];
            $validator = Validator::make($req->all(), $rules);
            if ($validator->fails()) {
                $this->responseCode = 422;
                $this->responseMessage = $validator->errors()->first();
                $this->responseData = $validator->errors();
                return response()->json($this->getResponse(), $this->responseCode);
            }

            if (!$req->is_accepted) {
                $penjangkauan = $pengaduan->penjangkauan;
                if ($penjangkauan) {


                    $toDraft = [
                        'draft_status', 'klien_draft_status',
                        'keluarga_klien_draft_status', 'pelaku_draft_status',
                        'situasi_keluarga_draft_status', 'kronologi_kejadian_draft_status',
                        'harapan_klien_draft_status', 'kondisi_klien_draft_status',
                        'analisis_dp3kappkb_draft_status', 'rencana_intervensi_draft_status',
                        'langkah_dilakukan_draft_status', 'dokumen_pendukung_draft_status',
                    ];

                    foreach ($toDraft as $d) {
                        if ($penjangkauan->$d !== NULL) {
                            $penjangkauan->$d = true;
                        }
                    }
                    $penjangkauan->save();

                    $rollback = PenjangkauanRollback::create([
                        'id_penjangkauan' => $penjangkauan->id,
                        'description' => $req->description,
                    ]);
                }
            }

            // $pengaduan->id_status = $req->is_accepted ?  == 8 ? 9 : 8 : 6;

            if (!$req->is_accepted) {
                $name = 'Pengaduan Butuh Revisi';
                $desc = $pengaduan->id_status == 8 ? 'Kabid mengembalikan pengaduan ke konselor dengan keterangan "' . $req->description . '"' : 'Subkord mengembalikan pengaduan ke konselor dengan keterangan "' . $req->description . '"';
                $pengaduan->id_status = 6;
            } else {
                if ($pengaduan->id_status == 8) {
                    $pengaduan->id_status = 9;
                    $name = 'Menunggu Verifikasi Kadis';
                    $desc = 'Kabid telah menyetujui hasil penjangkauan dan meneruskan ke kadis';
                } else {
                    $pengaduan->id_status = 8;
                    $name = 'Menunggu Verifikasi Kabid';
                    $desc = 'Subkord telah menyetujui hasil penjangkauan dan meneruskan ke kabid';
                }
            }

            $pengaduan->save();

            $timeline = TimelinePengaduan::create([
                'id_pengaduan' => $pengaduan->id,
                'id_status' => $pengaduan->id_status,
                'name' => $name,
                'description' => $desc,
            ]);

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

    public function kadisApprove($id)
    {
        $id = intval($id);
        $pengaduan = Pengaduan::find($id);
        if (!$pengaduan) {
            $this->responseCode = 404;
            $this->responseMessage = 'Data tidak ditemukan';
            return response()->json($this->getResponse(), $this->responseCode);
        }

        if ($pengaduan->id_status != 9) {
            $this->responseCode = 400;
            $this->responseMessage = 'Status tidak valid';
            return response()->json($this->getResponse(), $this->responseCode);
        }

        $this->authorize('kadisApprove', $pengaduan);

        try {
            DB::beginTransaction();

            $pengaduan->id_status = 10;
            $pengaduan->save();

            $timeline = TimelinePengaduan::create([
                'id_pengaduan' => $pengaduan->id,
                'id_status' => $pengaduan->id_status,
                'name' => 'Selesai',
                'description' => 'Hasil penjangkauan telah di setujui kadis, maka pengaduan dianggap selesai dan kasus ditutup'
            ]);


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

    public function timeline(Request $req)
    {
        try {
            $number = $req->number;
            if (!is_numeric($number)) {
                $number = (int) (explode("/", $number)[1] ?? 0);
            }
            $pengaduan = Pengaduan::where('registration_number', $number)
                ->orWhere('complainant_nik', $number)
                ->orWhereHas('klien', function ($q) use ($number) {
                    $q->where('is_has_nik', true)->where('nik_number', $number);
                })
                ->orderBy('created_at', 'DESC')
                ->first();
            if (!$pengaduan) {
                $this->responseCode = 404;
                $this->responseMessage = 'Data tidak ditemukan';
                return response()->json($this->getResponse(), $this->responseCode);
            }

            $timelines = TimelinePengaduan::where('id_pengaduan', $pengaduan->id)->orderBy('created_at', 'ASC')->get();

            $this->responseCode = 200;
            $this->responseData = $timelines;
            return response()->json($this->getResponse(), $this->responseCode);
        } catch (\Exception $e) {
            $this->responseCode = 500;
            $this->responseMessage = $e->getMessage();
            return response()->json($this->getResponse(), $this->responseCode);
        }
    }

    public function cetak($id)
    {
        try {

            $id = intval($id);
            $pengaduan = Pengaduan::where('id', $id)
                // ->where('id_status', 10)
                ->first();

            if (!$pengaduan) {
                $this->responseCode = 404;
                $this->responseMessage = 'Data tidak ditemukan';
                return response()->json($this->getResponse(), $this->responseCode);
            }

            if (auth()->user()->id_role == config('env.role.kadis')) {

                if ($pengaduan->id_status != 10) {
                    $this->responseCode = 403;
                    $this->responseMessage = 'User tidak memiliki akses';
                    return response()->json($this->getResponse(), $this->responseCode);
                }
            }

            $this->responseCode = 200;
            $this->responseData = new CetakLaporanResource($pengaduan);
            return response()->json($this->getResponse(), $this->responseCode);
        } catch (\Exception $e) {
            $this->responseCode = 500;
            $this->responseMessage = $e->getMessage();
            return response()->json($this->getResponse(), $this->responseCode);
        }
    }

    public function cetakPdf($id)
    {
        $id = intval($id);
        $pengaduan = Pengaduan::where('id', $id)
            // ->where('id_status', 10)
            ->first();
        if (!$pengaduan) {
            $this->responseCode = 404;
            $this->responseMessage = 'Data tidak ditemukan';
            return response()->json($this->getResponse(), $this->responseCode);
        }

        request()->request->add(['full_link' => false]);
        $pdf = PDF::loadView('pdf.cetakLaporan', ['data' => json_decode(json_encode(new CetakLaporanResource($pengaduan)))]);
        $pathLaporan = storage_path('app/private/cetak_laporan');
        if (!File::exists($pathLaporan)) {
            File::makeDirectory($pathLaporan, 0777, true, true);
        }
        $pathLaporan .= '/1.pdf';

        $pdf->save($pathLaporan);

        $pdf2 = new FPDF();
        $pdf2->AddPage();

        if ($pengaduan->penjangkauan->dokumenPendukung ?? null) {
            foreach (($pengaduan->penjangkauan->dokumenPendukung()->where('document_type', 7)->get() ?? []) as $s) {
                $imgExt = new Imagick();
                $imgExt->readImage(storage_path('app/' . $s->path));

                $imgPath = 'private/dokumen_pendukung/' . $s->id_penjangkauan . '/' . $s->document_type;
                $imgFullPath = storage_path('app/' . $imgPath . '/' . 'dokumen_pendukung_convert.jpg');

                $imgExt->writeImages($imgFullPath, true);

                $countFilePage = null;
                foreach ($imgExt as $i => $image) {
                    $countFilePage++;
                }

                if ($countFilePage > 1) {
                    foreach ($imgExt as $i => $image) {
                        $pdf2->Image(storage_path('app/' . $imgPath . '/' . 'dokumen_pendukung_convert-' . $i . '.jpg'), null, null, 0, 0);
                    }
                } else {
                    $pdf2->Image(storage_path('app/' . $imgPath . '/' . 'dokumen_pendukung_convert.jpg'), null, null, 0, 0);
                }
            }
        }

        $pathLaporan2 = storage_path('app/private/cetak_laporan');
        $pathLaporan2 .= '/dokumen_pendukung_' . $pengaduan->id . '.pdf';
        $pdf2->Output($pathLaporan2, 'F');

        $oMerger = PDFMerger::init();
        $oMerger->addPDF($pathLaporan, 'all');
        $oMerger->addPDF($pathLaporan2, 'all');

        // if ($pengaduan->penjangkauan->dokumenPendukung ?? null) {
        //     foreach (($pengaduan->penjangkauan->dokumenPendukung()->where('document_type', 7)->get() ?? []) as $s) {
        //         $imgExt = new Imagick();
        //         $imgExt->readImage(storage_path('app/' . $s->path));
        //         $oMerger->add($imgExt->writeImages('pdf_image_doc.jpg', true), 'all');

        //         //$oMerger->addPDF(storage_path('app/' . $s->path), 'all');
        //     }
        // }
        //$oMerger->addPDF(storage_path('app/' . $s->path), 'all');
        $oMerger->merge();

        $this->saveLog();
        // return $pdf->download('cetak_laporan_pengaduan-'.$id.'.pdf');
        return $oMerger->setFileName('cetak_laporan_pengaduan-' . $id . '.pdf')->download();
    }
}
