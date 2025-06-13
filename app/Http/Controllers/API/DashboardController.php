<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Pengaduan;
use App\Models\RencanaIntervensi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public $status;
    public function __construct()
    {
        $this->status = 6;
    }
    public function interventionOpdNotFinish(Request $request)
    {
        try {
            $interventionPlan = RencanaIntervensi::with([
                'penjangkauan.pengaduan.klien',
                'realisasiIntervensi' => function ($q) {
                    $q->orderBy('updated_at', 'DESC');
                    $q->take(1);
                },
                'kebutuhan',
                'opd',
                'intervensi',
            ])
                ->whereHas('opd')
                ->where('realisasi_draft_status', true)
                ->whereHas('penjangkauan.pengaduan', function ($q) {
                    $q->whereYear('complaint_date', 2024) // Filter tahun 2024
                      ->whereIn('id_status', [9, 10])
                      ->where('id_status', '>', $this->status);
                });
    
            if ($request->filled('limit')) {
                $interventionPlan->take($request->limit);
            }
    
            $this->responseCode = 200;
            $this->responseData = $interventionPlan->orderBy('id_opd', 'ASC')->get();
        } catch (\Exception $ex) {
            $this->responseCode = 500;
            $this->responseMessage = $ex->getMessage();
        }
    
        return response()->json(
            $this->getResponse() + [
                'total' => count(
                    RencanaIntervensi::select('id_opd')
                        ->whereHas('opd')
                        ->where('realisasi_draft_status', true)
                        ->groupBy('id_opd')
                        ->whereHas('penjangkauan.pengaduan', function ($q) {
                            $q->whereYear('complaint_date', 2024) // Filter tahun 2024
                              ->whereIn('id_status', [9, 10])
                              ->where('id_status', '>', $this->status);
                        })
                        ->get()
                ),
            ],
            $this->responseCode
        );    
    }

    public function trendStatisticAll(Request $request)
    {
        try {
            $year = date('Y');

            if ($request->filled('tahun')) {
                $year = $request->tahun;
            }

            $trendStatistic = Pengaduan::select([
                DB::raw("EXTRACT(MONTH FROM pengaduan.complaint_date) AS month_number"),
                DB::raw("COUNT(CASE WHEN klien_history.age_category = 1 THEN 1 END) AS total_child"),
                DB::raw("COUNT(CASE WHEN klien_history.age_category = 2 THEN 1 END) AS total_adult")
            ])
                ->join('penjangkauan', 'penjangkauan.id_pengaduan', 'pengaduan.id')
                ->join('klien', 'klien.id_penjangkauan', 'penjangkauan.id')
                ->join('klien_history', 'klien_history.id', 'klien.id_klien_history')
                ->whereYear('pengaduan.complaint_date', $year)
                ->where('pengaduan.id_status', '>', $this->status)
                ->groupBy([
                    DB::raw("EXTRACT(MONTH FROM pengaduan.complaint_date)")
                ])
                ->orderBy('month_number', 'ASC')
                ->get();

            $this->responseCode = 200;
            $this->responseData = $trendStatistic;
        } catch (\Exception $ex) {
            $this->responseCode = 500;
            $this->responseMessage = $ex->getMessage();
        }
        return response()->json($this->getResponse(), $this->responseCode);
    }

    public function trendStatisticByMonthAndProblemType(Request $request)
    {
        try {
            $year = date('Y');

            if ($request->filled('tahun')) {
                $year = $request->tahun;
            }

            $trendStatistic = Pengaduan::select([
                DB::raw("EXTRACT(MONTH FROM pengaduan.complaint_date) AS month_number"),
                'm_tipe_permasalahan.name',
                DB::raw("COUNT(CASE WHEN klien_history.age_category = 1 THEN 1 END) AS total_child"),
                DB::raw("COUNT(CASE WHEN klien_history.age_category = 2 THEN 1 END) AS total_adult")
            ])
                ->join('penjangkauan', 'penjangkauan.id_pengaduan', 'pengaduan.id')
                ->join('klien', 'klien.id_penjangkauan', 'penjangkauan.id')
                ->join('klien_history', 'klien_history.id', 'klien.id_klien_history')
                ->join('m_jenis_kasus', 'm_jenis_kasus.id', 'penjangkauan.id_jenis_kasus')
                ->join('m_kategori_kasus', 'm_kategori_kasus.id', 'm_jenis_kasus.id_kategori_kasus')
                ->join('m_tipe_permasalahan', 'm_tipe_permasalahan.id', 'm_kategori_kasus.id_tipe_permasalahan')
                ->whereYear('pengaduan.complaint_date', $year)
                ->where('pengaduan.id_status', '>', $this->status);

            if ($request->filled('id_tipe_permasalahan')) {
                $trendStatistic = $trendStatistic->where('m_tipe_permasalahan.id', $request->id_tipe_permasalahan);
            }

            $trendStatistic = $trendStatistic->groupBy([
                DB::raw("EXTRACT(MONTH FROM pengaduan.complaint_date)"),
                'm_tipe_permasalahan.name',
            ])
                ->orderBy('month_number', 'ASC')
                ->get();

            $this->responseCode = 200;
            $this->responseData = $trendStatistic;
        } catch (\Exception $ex) {
            $this->responseCode = 500;
            $this->responseMessage = $ex->getMessage();
        }
        return response()->json($this->getResponse(), $this->responseCode);
    }

    public function trendStatisticByYearAndProblemType(Request $request)
    {
        try {
            $year = date('Y');

            if ($request->filled('tahun')) {
                $year = $request->tahun;
            }

            $trendStatistic = Pengaduan::select([
                'm_tipe_permasalahan.name',
                DB::raw("COUNT(CASE WHEN klien_history.age_category = 1 THEN 1 END) AS total_child"),
                DB::raw("COUNT(CASE WHEN klien_history.age_category = 2 THEN 1 END) AS total_adult")
            ])
                ->join('penjangkauan', 'penjangkauan.id_pengaduan', 'pengaduan.id')
                ->join('klien', 'klien.id_penjangkauan', 'penjangkauan.id')
                ->join('klien_history', 'klien_history.id', 'klien.id_klien_history')
                ->join('m_jenis_kasus', 'm_jenis_kasus.id', 'penjangkauan.id_jenis_kasus')
                ->join('m_kategori_kasus', 'm_kategori_kasus.id', 'm_jenis_kasus.id_kategori_kasus')
                ->join('m_tipe_permasalahan', 'm_tipe_permasalahan.id', 'm_kategori_kasus.id_tipe_permasalahan')
                ->whereYear('pengaduan.complaint_date', $year)
                ->where('pengaduan.id_status', '>', $this->status);

            if ($request->filled('id_tipe_permasalahan')) {
                $trendStatistic = $trendStatistic->where('m_tipe_permasalahan.id', $request->id_tipe_permasalahan);
            }

            $trendStatistic = $trendStatistic->groupBy([
                'm_tipe_permasalahan.name'
            ])
                ->get();

            $this->responseCode = 200;
            $this->responseData = $trendStatistic;
        } catch (\Exception $ex) {
            $this->responseCode = 500;
            $this->responseMessage = $ex->getMessage();
        }
        return response()->json($this->getResponse(), $this->responseCode);
    }

    public function trendKasusPerkecamatan(Request $req)
    {
        try {
            $month = date('m');
            $year = date('Y');
            if ($req->filled('month')) {
                $month = date('m', strtotime($req->month));
                $year = date('Y', strtotime($req->month));
            }

            $pengaduan = Pengaduan::select(
                DB::raw('m_kecamatan.id AS kecamatan_id'),
                DB::raw('m_kecamatan.name AS kecamatan_name'),
                DB::raw("COUNT(CASE WHEN klien_history.age_category = 1 THEN 1 END) AS anak"),
                DB::raw("COUNT(CASE WHEN klien_history.age_category = 2 THEN 1 END) AS dewasa"),
                DB::raw('COUNT(CASE WHEN klien_history.age_category = 1 THEN 1 END) + COUNT(CASE WHEN klien_history.age_category = 2 THEN 1 END) AS total')
            )
                ->join('penjangkauan', 'penjangkauan.id_pengaduan', 'pengaduan.id')
                ->join('klien', 'klien.id_penjangkauan', 'penjangkauan.id')
                ->join('klien_history', 'klien_history.id', 'klien.id_klien_history')
                ->join('m_kelurahan', 'm_kelurahan.id', 'klien_history.id_kelurahan_tinggal')
                ->join('m_kecamatan', 'm_kelurahan.id_kecamatan', 'm_kecamatan.id')
                ->whereMonth('pengaduan.complaint_date', $month)
                ->whereYear('pengaduan.complaint_date', $year)
                ->where('pengaduan.id_status', '>', $this->status)
                ->groupBy(['m_kecamatan.id'])
                ->orderBy('total', 'DESC')
                ->get();

            $this->responseCode = 200;
            $this->responseData = $pengaduan;
        } catch (\Exception $ex) {
            $this->responseCode = 500;
            $this->responseMessage = $ex->getMessage();
        }
        return response()->json($this->getResponse(), $this->responseCode);
    }

    public function ketuntasaOPD()
    {
        try {
            $total = RencanaIntervensi::select('id_opd')
                ->whereHas('opd')
                ->groupBy('id_opd')
                ->whereHas('penjangkauan.pengaduan', function ($q) {
                    $q->whereYear('complaint_date', 2024) // Filter tahun 2024
                        ->whereIn('id_status', [9, 10])
                        ->where('id_status', '>', $this->status);
                })
                ->count();

            $tuntas = RencanaIntervensi::select('id_opd')
                ->whereHas('opd')
                ->groupBy('id_opd')
                ->where('realisasi_draft_status', false)
                ->whereHas('penjangkauan.pengaduan', function ($q) {
                    $q->whereYear('complaint_date', 2024) // Filter tahun 2024
                        ->whereIn('id_status', [9, 10])
                        ->where('id_status', '>', $this->status);
                })
                ->count();

            $tidak = RencanaIntervensi::select('id_opd')
                ->whereHas('opd')
                ->groupBy('id_opd')
                ->where('realisasi_draft_status', true)
                ->whereHas('penjangkauan.pengaduan', function ($q) {
                    $q->whereYear('complaint_date', 2024) // Filter tahun 2024
                        ->whereIn('id_status', [9, 10])
                        ->where('id_status', '>', $this->status);
                })
                ->count();

            $data = [
                'total' => $total,
                'tuntas' => $tuntas,
                'tidak_tuntas' => $tidak,
                'persen' => [
                    'tuntas' => $total ? $tuntas / $total * 100 : 0,
                    'tidak_tuntas' => $total ? $tidak / $total * 100 : 0,
                ],
            ];

            $this->responseCode = 200;
            $this->responseData = $data;
        } catch (\Exception $ex) {
            $this->responseCode = 500;
            $this->responseMessage = $ex->getMessage();
        }
        return response()->json($this->getResponse(), $this->responseCode);
    }
}
