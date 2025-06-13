<?php

namespace App\Http\Controllers;

use App\Enums\LaporanKegiatanCreatorType;
use App\Exports\CekExport;
use App\Exports\FasilitatorExport;
use App\Exports\DatabaseExport;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Helpers\HelperPublic;
use App\Models\LaporanKegiatan;
use App\Models\SatgasPpa;
use App\Models\UserLog;
use Maatwebsite\Excel\Facades\Excel;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $responseCode = Response::HTTP_OK;
    protected $responseStatus = '';
    protected $responseMessage = '';
    protected $responseData = [];
    protected $responseRequest = [];

    public function __construct(Request $request)
    {
        $this->responseRequest = $request->all();
    }

    public function getResponse()
    {
        $response = HelperPublic::helpResponse($this->responseCode, $this->responseData, $this->responseMessage, $this->responseStatus, $this->responseRequest);

        // log user request
        UserLog::saveLog($response);
        return $response;
    }

    public function saveLog($response = null)
    {
        return UserLog::saveLog($response);
    }

    public function pageNotFound()
    {
        return response()->view('errors.404', [], 404);
    }

    public function accessForbidden()
    {
        return response()->view('errors.403', [], 403);
    }

    // public function send_firebase($token, $message, $single = FALSE)
    // {
    //     $url = 'https://fcm.googleapis.com/fcm/send';

    //     if($single == TRUE){
    //         $field = [
    //             'to' => $token,
    //             'notification' => [
    //                 'title' => $message['title'],
    //                 'body' => $message['message'],
    //             ],
    //             'data' => $message
    //         ];
    //     }else{
    //         $field = [
    //             'registration_ids' => $token,
    //             'notification' => [
    //                 'title' => $message['title'],
    //                 'body' => $message['message'],
    //             ],
    //             'data' => $message
    //         ];
    //     }

    //     $headers = [
    //         'Authorization:key='.env('FCM_AUTHORIZATION_KEY'),
    //         'Content-Type: application/json'
    //     ];

    //     $ch = curl_init();
    //     curl_setopt($ch, CURLOPT_URL, $url);
    //     curl_setopt($ch, CURLOPT_POST, true);
    //     curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    //     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    //     curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    //     curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    //     curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($field));

    //     $result = curl_exec($ch);
    //     if($result === FALSE){
    //         die('Curl failed: '. curl_error($ch));
    //     }

    //     curl_close($ch);
    //     return $result;
    // }

    public static function getStatusPengaduan($status_id = 0, $pengaduan = null)
    {
        $user_role = auth()->user()->id_role;

        $status = [
            [
                'status' => '',
                'description' => '',
                'label_status' => '',
            ],
            [
                'status' => 'Perlu Penanganan Hotline',
                'description' => '',
                'label_status' => 'badge-light-primary',
            ],
            [
                'status' => 'Pengaduan dirujuk',
                'description' => '',
                'label_status' => 'badge-light-danger',
            ],
            [
                'status' => 'Verifikasi Subkord',
                'description' => 'Verifikasi Pengaduan',
                'label_status' => 'badge-light-info',
            ],
            [
                'status' => 'Verifikasi Kabid',
                'description' => 'Verifikasi Pengaduan',
                'label_status' => 'badge-light-info',
            ],
            [
                'status' => 'Proses Penjangkauan',
                'description' => '',
                'label_status' => 'badge-light-warning',
            ],
            [
                'status' => 'Proses Revisi',
                'description' => '',
                'label_status' => 'badge-light-danger',
            ],
            [
                'status' => 'Verifikasi Subkord',
                'description' => 'Verifikasi Penjangkauan',
                'label_status' => 'badge-light-info',
            ],
            [
                'status' => 'Verifikasi Kabid',
                'description' => 'Verifikasi Penjangkauan',
                'label_status' => 'badge-light-info',
            ],
            [
                'status' => 'Verifikasi Kadis',
                'description' => 'Verifikasi Penjangkauan',
                'label_status' => 'badge-light-info',
            ],
            [
                'status' => 'Selesai',
                'description' => 'Telah disetujui Kadis',
                'label_status' => 'badge-light-success',
            ],
        ];

        if ($user_role == config('env.role.hotline')) {
            $status[1]['status'] = "Perlu Penanganan";
        } else if ($user_role == config('env.role.subkord')) {
            $status[3]['status'] = "Perlu Verifikasi";
            $status[7]['status'] = "Perlu Verifikasi";
        } else if ($user_role == config('env.role.kabid')) {
            $status[4]['status'] = "Perlu Verifikasi";
            $status[8]['status'] = "Perlu Verifikasi";
        } else if ($user_role == config('env.role.konselor')) {
            $status[6]['status'] = "Perlu Revisi";
        } else if ($user_role == config('env.role.opd')) {
            // $status[6]['status'] = "Proses Intervensi";

            $draft_status = $pengaduan->penjangkauan->rencanaIntervensi()->where('id_opd', auth()->user()->id_opd)->pluck('realisasi_draft_status')->first() ?? null;
            // $draft_status = $pengaduan->penjangkauan->rencanaIntervensi()
            //     ->where('id_opd', auth()->user()->id_opd)
            //     ->where('rencana_intervensi.realisasi_draft_status', '!=', false)
            //     ->whereDoesntHave('realisasiIntervensi', function ($query) {
            //         $query->whereNull('realisasi_intervensi.deleted_at');
            //     })->get();

            return [
                // 'id' => $status_id,
                // 'status' => !empty($draft_status)  ? 'Proses Intervensi' : 'Intervensi Selesai',
                // 'description' => !empty($draft_status)  ? '' : 'Diteruskan ke DP5A',
                // 'label_status' => !empty($draft_status)  ? 'badge-light-info' : 'badge-light-success',
                'id' => $status_id,
                'status' => $draft_status  ? 'Proses Intervensi' : 'Intervensi Selesai',
                'description' => $draft_status  ? '' : 'Diteruskan ke DP5A',
                'label_status' => $draft_status  ? 'badge-light-info' : 'badge-light-success',
            ];
        } else if ($user_role == config('env.role.kadis')) {
            $status[9]['status'] = "Perlu Verifikasi";
            $status[10]['description'] = "Telah disetujui";
        }

        if ($status_id > 10) {
            $status[0]['id'] = 0;
            return $status[0];
        } else {
            $status[$status_id]['id'] = $status_id;
            return $status[$status_id];
        }
    }
    
    public function cek(Request $request)
    {
        ini_set('max_execution_time', 600);

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


            return Excel::download(new CekExport($multiple), 'Laporan Kegiatan Mahasiswa V1.xlsx');
            
            
            //return Excel::download(new DatabaseExport($result, 'exports.laporanKegiatanMhsV1'), 'Laporan Kegiatan Mahasiswa V1.xlsx');
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

            dd($multiple);
            
            return Excel::download(new FasilitatorExport($multiple), 'Laporan Kegiatan Fasilitator V1.xlsx');
        }
    }

    public function tes(Request $req)
    {
        $this->authorize('export', SatgasPpa::class);

        ini_set('memory_limit', -1);
        return Excel::download(new DatabaseExport((json_decode($this->select()->get())), 'exports.satgasPPA'), 'SatgasPPA.xlsx');
    }
}
