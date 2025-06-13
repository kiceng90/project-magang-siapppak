<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Pengaduan;
use Carbon\Carbon;
use DB;

class RekapBulananResource extends JsonResource
{
    protected $age_category;
    
    public function age_category($val)
    {
        // anak = 1; dewasa = 2;
        if(!is_numeric($val)){
            $val = $val == 'anak' ? 1 : 2;
        }
        $this->age_category = $val;
        return $this;
    }

    public function toArray($request)
    {
        $bulan = [];
        $awal = explode("-",$request->bulan_awal);
        $akhir = explode("-",$request->bulan_akhir);
        $range = $akhir[0] - $awal[0];
        for ($i = (int)$awal[0]; $i <= $akhir[0]; $i++) {

            $start = 1;
            $end = 12;

            if($range && ($i == $awal[0])){
                $start = $awal[1];
            }
            if($range && ($i == $akhir[0])){
                $end = $akhir[1];
            }

            if(!$range){
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
        ];

        $bln = [];
        foreach($bulan as $k => $b){
            $count = Pengaduan::whereHas('klien.latest_klien_history', function($q){
                $q->where('age_category', $this->age_category);
            })
            ->whereHas('penjangkauan.jenis_kasus.kategoriKasus', function($q){
                $q->where('id', $this->id);
            })
            ->whereMonth('complaint_date', $b['bulan'])
            ->whereYear('complaint_date', $b['tahun'])
            ->count();

            $bln[] = [
                'tahun' => $b['tahun'],
                'bulan' => Carbon::create()->month($b['bulan'])->startOfMonth()->translatedFormat('M'),
                'count' => $count,
            ];

            $data['grand_total'] += $count;
        }

        $data['bulan'] = $bln;
        $data['jenis_kasus'] = collect(
            $this->jenisKasus()->whereHas('penjangkauan.pengaduan', function($q) use($request, $awal, $akhir) {
                $q->whereBetween(DB::raw('EXTRACT(YEAR FROM complaint_date)'), [$awal[0], $akhir[0]]);
                $q->whereBetween(DB::raw('EXTRACT(MONTH FROM complaint_date)'), [$awal[1], $akhir[1]]);
                $q->whereHas('klien.latest_klien_history', function($q){
                    $q->where('age_category', $this->age_category);
                });
            })->get()
        )->map(function($i) use($bulan, $request) {
            $dataChild = [
                'id' => $i->id,
                'name' => $i->name,
                'grand_total' => 0,
            ];

            $blnChild = [];
            foreach($bulan as $k => $b){
                $count = Pengaduan::whereHas('klien.latest_klien_history', function($q){
                    $q->where('age_category', $this->age_category);
                })
                ->whereHas('penjangkauan.jenis_kasus', function($q) use($i) {
                    $q->where('id', $i->id);
                })
                ->whereMonth('complaint_date', $b['bulan'])
                ->whereYear('complaint_date', $b['tahun'])
                ->count();
    
                $blnChild[] = [
                    'tahun' => $b['tahun'],
                    'bulan' => Carbon::create()->month($b['bulan'])->startOfMonth()->translatedFormat('M'),
                    'count' => $count,
                ];
    
                $dataChild['grand_total'] += $count;

            }

            $dataChild['bulan'] = $blnChild;
            return $dataChild;
        });

        return $data;
    }

    public static function collection($resource){
        return new RekapBulananResourceCollection($resource);
    }
}
