<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Pengaduan;
use Carbon\Carbon;
use DB;

class RekapBulananTipePermasalahanResource extends JsonResource
{
    protected $status = 8;

    // public function __construct()
    // {
    //     $this->status = 6;
    // }
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $bulan = [];
        $awal = explode("-", $request->bulan_awal);
        $akhir = explode("-", $request->bulan_akhir);
        $range = $akhir[0] - $awal[0];
        for ($i = (int)$awal[0]; $i <= $akhir[0]; $i++) {

            $start = 1;
            $end = 12;

            if ($range && ($i == $awal[0])) {
                $start = $awal[1];
            }
            if ($range && ($i == $akhir[0])) {
                $end = $akhir[1];
            }

            if (!$range) {
                $start = $awal[1];
                $end = $akhir[1];
            }

            for ($j = $start; $j <= $end; $j++) {
                $bulan[] = [
                    'tahun' => $i,
                    'bulan' => $j,
                ];
            }
        }

        $data = [
            'id' => $this->id,
            'name' => $this->name,
            'grand_total' => 0,
            'bulan' => [],
            'anak' => [
                'grand_total' => 0,
                'bulan' => [],
                'kategori_kasus' => [],
            ],
            'dewasa' => [
                'grand_total' => 0,
                'bulan' => [],
                'kategori_kasus' => [],
            ],
        ];

        $bln = [];
        $blnAnak = [];
        $blnDewasa = [];
        foreach ($bulan as $k => $b) {
            $count = Pengaduan::whereHas('klien.latest_klien_history')
                ->whereHas('penjangkauan.jenis_kasus.kategoriKasus.tipePermasalahan', function ($q) {
                    $q->where('id', $this->id);
                })
                ->whereMonth('complaint_date', $b['bulan'])
                ->whereYear('complaint_date', $b['tahun'])
                ->where('id_status', '>=', $this->status)
                ->count();

            $countAnak = Pengaduan::whereHas('klien.latest_klien_history', function ($q) {
                $q->where('age_category', 1);
            })
                ->whereHas('penjangkauan.jenis_kasus.kategoriKasus.tipePermasalahan', function ($q) {
                    $q->where('id', $this->id);
                })
                ->whereMonth('complaint_date', $b['bulan'])
                ->whereYear('complaint_date', $b['tahun'])
                ->where('id_status', '>=', $this->status)
                ->count();
            // var_dump($this->id);
            $countDewasa = Pengaduan::whereHas('klien.latest_klien_history', function ($q) {
                $q->where('age_category', 2);
            })
                ->whereHas('penjangkauan.jenis_kasus.kategoriKasus.tipePermasalahan', function ($q) {
                    $q->where('id', $this->id);
                })
                ->whereMonth('complaint_date', $b['bulan'])
                ->whereYear('complaint_date', $b['tahun'])
                ->where('id_status', '>=', $this->status)
                ->count();

            $bln[] = [
                'tahun' => $b['tahun'],
                'bulan' => Carbon::create()->month($b['bulan'])->startOfMonth()->translatedFormat('M'),
                'count' => $count,
            ];
            $blnAnak[] = [
                'tahun' => $b['tahun'],
                'bulan' => Carbon::create()->month($b['bulan'])->startOfMonth()->translatedFormat('M'),
                'count' => $countAnak,
            ];
            $blnDewasa[] = [
                'tahun' => $b['tahun'],
                'bulan' => Carbon::create()->month($b['bulan'])->startOfMonth()->translatedFormat('M'),
                'count' => $countDewasa,
            ];

            $data['grand_total'] += $count;
            $data['anak']['grand_total'] += $countAnak;
            $data['dewasa']['grand_total'] += $countDewasa;
        }
        $data['bulan'] = $bln;
        if ($data['anak']['grand_total']) {
            $data['anak']['bulan'] = $blnAnak;
            $data['anak']['kategori_kasus'] = RekapBulananResource::collection(
                $this->kategoriKasus()->where(function ($q) use ($request, $awal, $akhir) {
                    $q->whereHas('jenisKasus.penjangkauan.pengaduan', function ($q) use ($request, $awal, $akhir) {
                        $q->whereBetween(DB::raw('EXTRACT(YEAR FROM complaint_date)'), [$awal[0], $akhir[0]]);
                        $q->whereBetween(DB::raw('EXTRACT(MONTH FROM complaint_date)'), [$awal[1], $akhir[1]]);
                        $q->whereHas('klien.latest_klien_history', function ($q) {
                            $q->where('age_category', 1);
                        });
                        $q->where('id_status', '>=', $this->status);
                    });
                    if ($request->filled('id_kategori_kasus')) {
                        $q->where('id', $request->id_kategori_kasus);
                    }
                })->get()
            )->age_category('anak');
        } else {
            unset($data['anak']);
        }
        if ($data['dewasa']['grand_total']) {
            $data['dewasa']['bulan'] = $blnDewasa;
            $data['dewasa']['kategori_kasus'] = RekapBulananResource::collection(
                $this->kategoriKasus()->where(function ($q) use ($request, $awal, $akhir) {
                    $q->whereHas('jenisKasus.penjangkauan.pengaduan', function ($q) use ($request, $awal, $akhir) {
                        $q->whereBetween(DB::raw('EXTRACT(YEAR FROM complaint_date)'), [$awal[0], $akhir[0]]);
                        $q->whereBetween(DB::raw('EXTRACT(MONTH FROM complaint_date)'), [$awal[1], $akhir[1]]);
                        $q->whereHas('klien.latest_klien_history', function ($q) {
                            $q->where('age_category', 2);
                        });
                        $q->where('id_status', '>=', $this->status);
                    });
                    if ($request->filled('id_kategori_kasus')) {
                        $q->where('id', $request->id_kategori_kasus);
                    }
                })->get()
            )->age_category('dewasa');
        } else {
            unset($data['dewasa']);
        }

        return $data;
    }
}
