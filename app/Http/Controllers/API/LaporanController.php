<?php

namespace App\Http\Controllers\API;

use App\Enums\JenisMahasiswaStatusEnum;
use App\Enums\MahasiswaStatusEnum;
use App\Exports\DatabaseExport;
use App\Exports\IntervensiAllExport;
use App\Exports\KeluargaExport;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Exports\KasusKlienExport;
use App\Exports\KasusKlienDefaultExport;
use App\Exports\PelakuExport;
use App\Models\Pengaduan;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Resources\KasusKlienResource;
use App\Http\Resources\RekapTahunanResource;
use Carbon\Carbon;
use App\Models\MKategoriKasus;
use App\Models\MTipePermasalahan;
use App\Exports\RekapTahunanExport;
use App\Exports\RekapBulananExport;
use App\Helpers\HelperPublic;
use App\Http\Resources\RekapBulananResource;
use App\Http\Resources\RekapBulananTipePermasalahanResource;

use App\Http\Resources\PelaporExportResource;
use App\Http\Resources\KlienExportResource;
use App\Http\Resources\PelakuExportResource;
use App\Http\Resources\KeluargaExportResource;
use App\Http\Resources\KeteranganExportResource;
use App\Http\Resources\RencanaDp3appkbExportResource;
use App\Http\Resources\IntervensiDp3appkbExportResource;
use App\Http\Resources\IntervensiOpdExportResource;
use App\Models\DBalaiPuspagaRW;
use App\Models\DMahasiswa;
use App\Models\MahasiswaBalaiPuspagaRW;
use App\Models\MInstansiPendidikan;
use App\Models\MJenisMahasiswa;
use App\Models\MKecamatan;
use App\Models\MKelurahan;
use App\Models\MPendidikanTerakhir;
use App\Models\Penjangkauan;
use App\Models\RealisasiIntervensi;
use App\Models\RencanaIntervensi;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;

class LaporanController extends Controller
{
    protected $status;

    public function __construct()
    {
        $this->status = 8;
    }

    public function kasusKlien(Request $req)
    {
        ini_set('max_execution_time', 600);

        $rules = [
            'type' => 'required|in:default,spesifik,intervensiAll,keluarga',
            'periode' => 'nullable|in:1,2,3,4',
            'start_date' => 'nullable|date|required_if:periode,4',
            'end_date' => 'nullable|required_if:periode,4|date',
            'kategori' => 'nullable|in:dewasa,anak',
            'id_tipe_permasalahan' => 'nullable|exists:App\Models\MTipePermasalahan,id,deleted_at,NULL',
            'id_kategori_kasus' => 'nullable|exists:App\Models\MKategoriKasus,id,deleted_at,NULL',
            'id_kecamatan' => 'nullable|exists:App\Models\MKecamatan,id,deleted_at,NULL',
            'id_pendidikan_terakhir' => 'nullable|exists:App\Models\MPendidikanTerakhir,id,deleted_at,NULL',
            'id_opd' => 'nullable|exists:App\Models\MOpd,id,deleted_at,NULL',
            'id_pelayanan_intervensi' => 'nullable|exists:App\Models\MIntervensi,id,deleted_at,NULL',
            'id_status_penanganan' => 'nullable|in:1,2',
            'is_download' => 'nullable|boolean',
        ];

        $validator = Validator::make($req->all(), $rules);
        if ($validator->fails()) {
            $this->responseCode = 422;
            $this->responseMessage = $validator->errors()->first();
            $this->responseData = $validator->errors();
            return response()->json($this->getResponse(), $this->responseCode);
        }

        $pengaduan = Pengaduan::where('id_status', '>', 5);

        switch ($req->periode) {
            case 1:
                $pengaduan->whereBetween('complaint_date', [date('Y-m-01 00:00:00'), date('Y-m-t 23:59:59')]);
                break;
            case 2:
                $pengaduan->whereBetween('complaint_date', [date('Y-m-01', strtotime('-2 month')), date('Y-m-t 23:59:59')]);
                break;
            case 3:
                $pengaduan->whereBetween('complaint_date', [date('Y-m-d 00:00:00', strtotime('01/01')), date('Y-m-d 23:59:59', strtotime('12/31'))]);
                break;
            case 4:
                $pengaduan->whereBetween('complaint_date', [date('Y-m-d H:i:s', strtotime($req->start_date)), date('Y-m-d H:i:s', strtotime($req->end_date))]);
                break;
            default:
                break;
        }

        if ($req->type == 'spesifik') {
            if ($req->filled('kategori')) {
                $kategori = $req->kategori == 'anak' ? 1 : 2;
                $pengaduan->whereHas('klien.latest_klien_history', function ($q) use ($kategori) {
                    $q->where('age_category', $kategori);
                });
            }
            if ($req->filled('id_kategori_kasus')) {
                $pengaduan->whereHas('penjangkauan.jenis_kasus', function ($q) use ($req) {
                    $q->where('id_kategori_kasus', $req->id_kategori_kasus);
                });
            } elseif ($req->filled('id_tipe_permasalahan')) {
                $pengaduan->whereHas('penjangkauan.jenis_kasus.kategoriKasus', function ($q) use ($req) {
                    $q->where('id_tipe_permasalahan', $req->id_tipe_permasalahan);
                });
            }
            if ($req->filled('id_kecamatan')) {
                $pengaduan->whereHas('klien.latest_klien_history.kelurahan_tinggal', function ($q) use ($req) {
                    $q->where('id_kecamatan', $req->id_kecamatan);
                });
            }
            if ($req->filled('id_pendidikan_terakhir')) {
                $pengaduan->whereHas('klien.latest_klien_history', function ($q) use ($req) {
                    $q->where('id_pendidikan_terakhir', $req->id_pendidikan_terakhir);
                });
            }
        } elseif ($req->type == 'intervensiAll') {
            if ($req->filled('id_opd')) {
                $pengaduan->whereHas('penjangkauan.rencanaIntervensi', function ($q) use ($req) {
                    $q->where('id_opd', $req->id_opd);
                });
            }
            if ($req->filled('id_pelayanan_intervensi')) {
                $pengaduan->whereHas('penjangkauan.rencanaIntervensi', function ($q) use ($req) {
                    $q->where('id_intervensi', $req->id_pelayanan_intervensi);
                });
            }
            if ($req->filled('id_status_penanganan')) {
                $statusPenanganan = $req->id_status_penanganan == 1;
                $pengaduan->whereHas('penjangkauan.rencanaIntervensi', function ($q) use ($statusPenanganan) {
                    $q->where('realisasi_draft_status', $statusPenanganan);
                });
            }
        } elseif ($req->type == 'keluarga')
        

        $pengaduan = $pengaduan->orderBy('complaint_date', 'ASC')->get();

        if ($req->type == 'default') {
            $this->responseData = [
                'pelapor' => PelaporExportResource::collection($pengaduan),
                'klien' => KlienExportResource::collection($pengaduan),
                'pelaku' => PelakuExportResource::collection($pengaduan),
                'keluarga' => KeluargaExportResource::collection($pengaduan),
                'keterangan' => KeteranganExportResource::collection($pengaduan),
                'rencana_dp3appkb' => RencanaDp3appkbExportResource::collection($pengaduan),
                'rencana_rujukan_opd' => IntervensiOpdExportResource::collection($pengaduan),
                'intervensi_dp3appkb' => IntervensiDp3appkbExportResource::collection($pengaduan),
                'intervensi_opd' => IntervensiOpdExportResource::collection($pengaduan),
                'intervensi_all' => IntervensiOpdExportResource::collection($pengaduan),
            ];
            if ($req->is_download) {
                return Excel::download(new KasusKlienDefaultExport(json_decode(json_encode($this->responseData))), 'KasusKlienExport' . date('Y-m-d') . '.xlsx');
            }
        } elseif ($req->type == 'spesifik') {
            if ($req->is_download) {
                return Excel::download(new KasusKlienExport(json_decode(json_encode(KasusKlienResource::collection($pengaduan)))), 'KasusKlienSpesifik' . date('Y-m-d') . '.xlsx');
            }
            $this->responseData = KasusKlienResource::collection($pengaduan);
        } elseif ($req->type == 'intervensiAll') {
            if ($req->is_download) {
                return Excel::download(new IntervensiAllExport(json_decode(json_encode(IntervensiOpdExportResource::collection($pengaduan)))), 'KasusKlienIntervensi' . date('Y-m-d') . '.xlsx');
            }
            $this->responseData = IntervensiOpdExportResource::collection($pengaduan);
        } elseif ($req->type == 'keluarga') {
            if ($req->is_download) {
                return Excel::download(new KeluargaExport (json_decode(json_encode(KeluargaExportResource::collection($pengaduan)))), 'KasusKlienKeluarga' . date('Y-m-d') . '.xlsx');
            }
            $this->responseData = KeluargaExportResource::collection($pengaduan);
        }

        $this->responseCode = 200;
        return response()->json($this->getResponse(), $this->responseCode);
    }

    public function rekapTahunan(Request $req)
    {
        $rules = [
            'tahun_awal' => 'required|numeric',
            'tahun_akhir' => 'required|numeric',
            'id_kategori_kasus' => 'nullable|exists:App\Models\MKategoriKasus,id,deleted_at,NULL',
            'id_tipe_permasalahan' => 'nullable|exists:App\Models\MTipePermasalahan,id,deleted_at,NULL',
        ];
        $validator = Validator::make($req->all(), $rules);
        if ($validator->fails()) {
            $this->responseCode = 422;
            $this->responseMessage = $validator->errors()->first();
            $this->responseData = $validator->errors();
            return response()->json($this->getResponse(), $this->responseCode);
        }

        $tipePermasalahan = MTipePermasalahan::whereHas('kategoriKasus.jenisKasus.penjangkauan', function ($q) use ($req) {
            $q->whereHas('pengaduan', function ($q) use ($req) {
                $q->whereHas('klien.latest_klien_history');
                $q->whereBetween(DB::raw('EXTRACT(YEAR FROM complaint_date)'), [$req->tahun_awal, $req->tahun_akhir]);
                $q->where('id_status', '>=', $this->status);
            });
            // $q->where('pendampingan', true);
        });
        if ($req->filled('id_kategori_kasus')) {
            $tipePermasalahan->whereHas('kategoriKasus', function ($q) use ($req) {
                $q->where('id', $req->id_kategori_kasus);
            });
        } else if ($req->filled('id_tipe_permasalahan')) {
            $tipePermasalahan->where('id', $req->id_tipe_permasalahan);
        }
        $tipePermasalahan = $tipePermasalahan->get();

        if ($req->is_download) {
            $this->saveLog();
            return Excel::download(new RekapTahunanExport(json_decode(json_encode(RekapTahunanResource::collection($tipePermasalahan)))), 'RekapTahunanExport' . date('Y-m-d') . '.xlsx');
        }

        $this->responseCode = 200;
        $this->responseData = RekapTahunanResource::collection($tipePermasalahan);

        return response()->json($this->getResponse(), $this->responseCode);
    }

    public function rekapBulanan(Request $req)
    {
        ini_set('max_execution_time', 600);

        $rules = [
            'bulan_awal' => 'required|date_format:Y-m',
            'bulan_akhir' => 'required|date_format:Y-m|after_or_equal:bulan_awal',
            'id_kategori_kasus' => 'nullable|exists:App\Models\MKategoriKasus,id,deleted_at,NULL',
            'id_tipe_permasalahan' => 'nullable|exists:App\Models\MTipePermasalahan,id,deleted_at,NULL',
        ];
        $messages = [
            'after' => ':attribute harus berisi bulan setelah atau sama dengan bulan awal.',
        ];
        $validator = Validator::make($req->all(), $rules, $messages);
        if ($validator->fails()) {
            $this->responseCode = 422;
            $this->responseMessage = $validator->errors()->first();
            $this->responseData = $validator->errors();
            return response()->json($this->getResponse(), $this->responseCode);
        }

        $awal = explode("-", $req->bulan_awal);
        $akhir = explode("-", $req->bulan_akhir);
        $tipePermasalahan = MTipePermasalahan::whereHas('kategoriKasus.jenisKasus.penjangkauan', function ($q) use ($awal, $akhir) {
            $q->whereHas('pengaduan', function ($q) use ($awal, $akhir) {
                $q->whereBetween(DB::raw('EXTRACT(YEAR FROM complaint_date)'), [$awal[0], $akhir[0]]);
                $q->whereBetween(DB::raw('EXTRACT(MONTH FROM complaint_date)'), [$awal[1], $akhir[1]]);
                $q->where('id_status', '>=', $this->status);
            });
            // $q->where('pendampingan', true);
        });
        if ($req->filled('id_kategori_kasus')) {
            $tipePermasalahan->whereHas('kategoriKasus', function ($q) use ($req) {
                $q->where('id', $req->id_kategori_kasus);
            });
        } else if ($req->filled('id_tipe_permasalahan')) {
            $tipePermasalahan->where('id', $req->id_tipe_permasalahan);
        }
        $tipePermasalahan = $tipePermasalahan->get();

        // //code untuk debug
        // $test = Pengaduan::with('klien.latest_klien_history')
        //     // ->whereDoesntHave('klien.latest_klien_history')
        //     ->whereHas('klien.latest_klien_history')
        //     ->whereHas('penjangkauan', function ($q) {
        //         $q->whereNotNull('date');
        //     })->whereBetween(DB::raw('EXTRACT(YEAR FROM complaint_date)'), ['2023', '2023'])
        //     ->whereBetween(DB::raw('EXTRACT(MONTH FROM complaint_date)'), ['01', '01'])
        //     ->where('id_status', '>=', 8)->count();

        // $test = Pengaduan::whereHas('klien.latest_klien_history')
        //     ->whereHas('penjangkauan.jenis_kasus.kategoriKasus.tipePermasalahan', function ($q) {
        //         $q->where('id', $this->id);
        //     })
        //     ->whereMonth('complaint_date', '01')
        //     ->whereYear('complaint_date', '2023')
        //     ->where('id_status', '>=', $this->status)
        //     ->count();
        // var_dump($test);

        $this->responseCode = 200;
        $this->responseData = RekapBulananTipePermasalahanResource::collection($tipePermasalahan);

        if ($req->is_download) {
            $this->saveLog();
            return Excel::download(new RekapBulananExport(json_decode(json_encode($this->responseData))), 'RekapBulananExport' . date('Y-m-d') . '.xlsx');
        }

        return response()->json($this->getResponse(), $this->responseCode);
    }
    

    public function rekapMahasiswaByUniv(Request $request)
    {
        $rules = [
            'id_instansi_pendidikan' => 'nullable|exists:App\Models\MInstansiPendidikan,id,deleted_at,NULL',
            'is_download' => 'nullable|boolean'
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $this->responseCode = 422;
            $this->responseMessage = $validator->errors()->first();
            $this->responseData = $validator->errors();
            return response()->json($this->getResponse(), $this->responseCode);
        }

        $data = [];
        $data['header']['category1']['name'] = 'Asal Universitas';
        $data['header']['category2']['name'] = 'Jenis Mahasiswa';
        $data['header']['total']['name'] = 'Total';
        
        $category1 = [];
        if($request->filled('id_instansi_pendidikan')){
            $category1 = MInstansiPendidikan::where('id',$request->id_instansi_pendidikan)->get();
        }
        else{
            $category1 = MInstansiPendidikan::all();
        }
        $category2 = MJenisMahasiswa::all();
        foreach($category2 as $category){
            $data['header']['category2']['child'][$category->id] = $category->name;
        }
        
        $data['body']['total']['name'] = 'Jumlah';
        $data['body']['total']['count'] = 0;
        $data['body']['total']['child'] = array();
        foreach($category1 as $cat1){
            $data['body']['category'][$cat1->id]['name'] = $cat1->name;
            $data['body']['category'][$cat1->id]['count'] = 0;

            foreach($category2 as $cat2){
                $count = DMahasiswa::where([
                    'is_active' => true,
                    'id_instansi_pendidikan' => $cat1->id,
                    'id_jenis_mahasiswa' => $cat2->id,
                ])->count();
                $data['body']['category'][$cat1->id]['child'][$cat2->id]['name'] = $cat2->name;
                $data['body']['category'][$cat1->id]['child'][$cat2->id]['count'] = $count;
                if(!empty($data['body']['total']['child'][$cat2->id]['count'])){
                    $data['body']['total']['child'][$cat2->id]['count']
                        = 
                    $data['body']['total']['child'][$cat2->id]['count'] + $count;
                }
                else{
                    $data['body']['total']['child'][$cat2->id]['name'] = $cat2->name;
                    $data['body']['total']['child'][$cat2->id]['count'] = $count;
                }
                $data['body']['total']['count'] +=$count;
                $data['body']['category'][$cat1->id]['count'] += $count;
            }
        }

        // return view('exports.rekapMahasiswa',['data' => HelperPublic::arrayToCollection($data)]);
        if ($request->is_download) {
            $this->saveLog();
            return Excel::download(new DatabaseExport(HelperPublic::arrayToCollection($data), 'exports.rekapMahasiswa'), 'Rekap Mahasiswa - Univ.xlsx');
        }
        return response()->json($data, $this->responseCode);
    }
    
    public function rekapMahasiswaByPend(Request $request)
    {
        $rules = [
            'id_pendidikan_terakhir' => 'nullable|exists:App\Models\MPendidikanTerakhir,id,deleted_at,NULL',
            'is_download' => 'nullable|boolean'
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $this->responseCode = 422;
            $this->responseMessage = $validator->errors()->first();
            $this->responseData = $validator->errors();
            return response()->json($this->getResponse(), $this->responseCode);
        }

        $data = [];
        $data['header']['category1']['name'] = 'Asal Universitas';
        $data['header']['category2']['name'] = 'Jenis Mahasiswa';
        $data['header']['total']['name'] = 'Total';
        
        $category1 = [];
        if($request->filled('id_pendidikan_terakhir')){
            $category1 = MPendidikanTerakhir::where('id',$request->id_pendidikan_terakhir)->get();
        }
        else{
            $category1 = MPendidikanTerakhir::all();
        }
        
        $category2 = MJenisMahasiswa::all();
        foreach($category2 as $category){
            $data['header']['category2']['child'][$category->id] = $category->name;
        }
        
        $data['body']['total']['name'] = 'Jumlah';
        $data['body']['total']['count'] = 0;
        $data['body']['total']['child'] = array();
        foreach($category1 as $cat1){
            $data['body']['category'][$cat1->id]['name'] = $cat1->name;
            $data['body']['category'][$cat1->id]['count'] = 0;

            foreach($category2 as $cat2){
                $count = DMahasiswa::where([
                    'is_active' => true,
                    'id_pendidikan_terakhir' => $cat1->id,
                    'id_jenis_mahasiswa' => $cat2->id,
                ])->count();
                $data['body']['category'][$cat1->id]['child'][$cat2->id]['name'] = $cat2->name;
                $data['body']['category'][$cat1->id]['child'][$cat2->id]['count'] = $count;
                if(!empty($data['body']['total']['child'][$cat2->id]['count'])){
                    $data['body']['total']['child'][$cat2->id]['count']
                        = 
                    $data['body']['total']['child'][$cat2->id]['count'] + $count;
                }
                else{
                    $data['body']['total']['child'][$cat2->id]['name'] = $cat2->name;
                    $data['body']['total']['child'][$cat2->id]['count'] = $count;
                }
                $data['body']['total']['count'] +=$count;
                $data['body']['category'][$cat1->id]['count'] += $count;
            }
        }
        if ($request->is_download) {
            $this->saveLog();
            return Excel::download(new DatabaseExport(HelperPublic::arrayToCollection($data), 'exports.rekapMahasiswa'), 'Rekap Mahasiswa - Pendidikan.xlsx');
        }
        return response()->json($data, $this->responseCode);
    }
    
    public function rekapPenugasanMahasiswaByWilayah(Request $request)
    {
        $rules = [
            'id_kelurahan' => 'nullable|exists:App\Models\MKelurahan,id,deleted_at,NULL',
            'id_kecamatan' => 'nullable|exists:App\Models\MKecamatan,id,deleted_at,NULL',
            'is_download' => 'nullable|boolean'
        ];
        
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $this->responseCode = 422;
            $this->responseMessage = $validator->errors()->first();
            $this->responseData = $validator->errors();
            return response()->json($this->getResponse(), $this->responseCode);
        }

        $data = [];
        $data['header']['maincategory']['name'] = 'Kecamatan - Kelurahan - RW';
        $data['header']['subcategory']['name'] = 'Jumlah Mahasiswa yang Bertugas';
        $data['header']['total']['name'] = 'Total';
        
        $kecamatan = [];
        if($request->filled('id_kecamatan')){
            $kecamatan = MKecamatan::where('id',$request->id_kecamatan)->with('kelurahan');
        }
        else{
            $kecamatan = MKecamatan::with('kelurahan');
        }
        if($request->filled('id_kelurahan')){
            $kecamatan->whereHas('kelurahan',function($query) use ($request){
                $query->where('id',$request->id_kelurahan);
            });
        }
        $kecamatan = $kecamatan->get();
        $subcategory = MahasiswaStatusEnum::toObject();
        $subcategory_temp = [];
        $i = 0;
        foreach($subcategory as $category){
            $data['header']['subcategory']['child'][$category->value] = $category->label;
            $arr = [
                'id' => $category->value,
                'name' => $category->name
            ];
            $subcategory_temp[$i] = (object) $arr;
            $i++;
        }
        $subcategory = collect($subcategory_temp);

        $data['body']['total']['name'] = 'Jumlah';
        $data['body']['total']['count'] = 0;
        $data['body']['total']['child'] = array();
        foreach($kecamatan as $kec){
            $data['body']['kecamatan'][$kec->id]['name'] = $kec->name;
            $data['body']['kecamatan'][$kec->id]['count'] = 0;

            foreach($kec->kelurahan as $kel){
                $data['body']['kecamatan'][$kec->id]['kelurahan'][$kel->id]['name'] = $kel->name;
                $data['body']['kecamatan'][$kec->id]['kelurahan'][$kel->id]['count'] = 0;

                $balai_puspaga = DBalaiPuspagaRW::where('id_kelurahan',$kel->id)->get();
                foreach($balai_puspaga as $balai){
                    $data['body']['kecamatan'][$kec->id]['kelurahan'][$kel->id]['balai'][$balai->id]['name'] = "RW - ".$balai->rw;
                    $data['body']['kecamatan'][$kec->id]['kelurahan'][$kel->id]['balai'][$balai->id]['count'] = 0;

                    // Loop to initiate subcategory initial count only
                    foreach($subcategory as $sub){
                        if(empty($data['body']['kecamatan'][$kec->id]['subcategory'][$sub->id])){
                            $data['body']['kecamatan'][$kec->id]['subcategory'][$sub->id]['name'] = $sub->name;
                            $data['body']['kecamatan'][$kec->id]['subcategory'][$sub->id]['count'] = 0;
                        }
                        if(empty($data['body']['kecamatan'][$kec->id]['kelurahan'][$kel->id]['subcategory'][$sub->id])){
                            $data['body']['kecamatan'][$kec->id]['kelurahan'][$kel->id]['subcategory'][$sub->id]['name'] = $sub->name;
                            $data['body']['kecamatan'][$kec->id]['kelurahan'][$kel->id]['subcategory'][$sub->id]['count'] = 0;
                        }
                        if(empty($data['body']['kecamatan'][$kec->id]['kelurahan'][$kel->id]['balai'][$balai->id]['subcategory'][$sub->id])){
                            $data['body']['kecamatan'][$kec->id]['kelurahan'][$kel->id]['balai'][$balai->id]['subcategory'][$sub->id]['name'] = $sub->name;
                            $data['body']['kecamatan'][$kec->id]['kelurahan'][$kel->id]['balai'][$balai->id]['subcategory'][$sub->id]['count'] = 0;
                        }
                        if(empty($data['body']['total']['child'][$sub->id])){
                            $data['body']['total']['child'][$sub->id]['name'] = $sub->name;
                            $data['body']['total']['child'][$sub->id]['count'] = 0;
                        }
                    }

                    // Count assigned mahasiswa to balai first
                    $assigned_mahasiswa = MahasiswaBalaiPuspagaRW::where('id_balai_puspaga_rw',$balai->id)->with('sample_mahasiswa')->get();
                    foreach($assigned_mahasiswa as $mahasiswa){
                        $sub = $mahasiswa->sample_mahasiswa->status;
                        $data['body']['kecamatan'][$kec->id]['subcategory'][$sub]['count'] += 1;
                        $data['body']['kecamatan'][$kec->id]['kelurahan'][$kel->id]['subcategory'][$sub]['count'] += 1;
                        $data['body']['kecamatan'][$kec->id]['kelurahan'][$kel->id]['balai'][$balai->id]['subcategory'][$sub]['count'] +=1;
                        $data['body']['total']['child'][$sub]['count'] += 1;

                        $data['body']['kecamatan'][$kec->id]['count'] += 1;
                        $data['body']['kecamatan'][$kec->id]['kelurahan'][$kel->id]['count'] += 1;
                        $data['body']['kecamatan'][$kec->id]['kelurahan'][$kel->id]['balai'][$balai->id]['count'] += 1;
                        $data['body']['total']['count'] += 1;
                    }

                }
            }
        }
        if ($request->is_download) {
            $this->saveLog();
            return Excel::download(new DatabaseExport(HelperPublic::arrayToCollection($data), 'exports.rekapPenugasanMhs'), 'Rekap Penugasan Mahasiswa - Wilayah.xlsx');
        }
        return response()->json($data, $this->responseCode);
    }
}
