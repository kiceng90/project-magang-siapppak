<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\MTipePermasalahan;
use App\Models\Pengaduan;


use Illuminate\Support\Facades\DB;

class RekapTahunanResource extends JsonResource
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

        $tahun = [];
        for ($i = (int)$request->tahun_awal; $i <= $request->tahun_akhir; $i++) {
            $tahun[] = $i;
        }

        $data = [
            'id' => $this->id,
            'name' => $this->name,
            'grand_total' => 0,
            'tahun' => [],
        ];

        $thn = [];
        foreach ($tahun as $t) {
            $anak = Pengaduan::whereYear('complaint_date', $t)->whereHas('klien.latest_klien_history', function ($q) {
                $q->where('age_category', 1);
            })->whereHas('penjangkauan.jenis_kasus.kategoriKasus.tipePermasalahan', function ($q) {
                $q->where('id', $this->id);
            })
                ->where('id_status', '>=', $this->status);
            $dewasa = Pengaduan::whereYear('complaint_date', $t)->whereHas('klien.latest_klien_history', function ($q) {
                $q->where('age_category', 2);
            })->whereHas('penjangkauan.jenis_kasus.kategoriKasus.tipePermasalahan', function ($q) {
                $q->where('id', $this->id);
            })
                ->where('id_status', '>=', $this->status);

            if ($request->filled('id_kategori_kasus')) {
                $anak->whereHas('penjangkauan.jenis_kasus', function ($q) use ($request) {
                    $q->where('id_kategori_kasus', $request->id_kategori_kasus);
                });
                $dewasa->whereHas('penjangkauan.jenis_kasus', function ($q) use ($request) {
                    $q->where('id_kategori_kasus', $request->id_kategori_kasus);
                });
            }

            $anak = $anak->count();
            $dewasa = $dewasa->count();

            $thn[] = [
                'tahun' => $t,
                'anak' => $anak,
                'dewasa' => $dewasa,
                'total' => $anak + $dewasa,
            ];
            $data['grand_total'] += $anak + $dewasa;
        }
        $data['tahun'] = $thn;

        $data['kategori_kasus'] = collect(
            $this->kategoriKasus()->whereHas('jenisKasus.penjangkauan.pengaduan', function ($q) use ($request) {
                $q->whereHas('klien.latest_klien_history');
                $q->whereBetween(DB::raw('EXTRACT(YEAR FROM complaint_date)'), [$request->tahun_awal, $request->tahun_akhir]);
                $q->where('id_status', '>=', $this->status);
                if ($request->filled('id_kategori_kasus')) {
                    $q->where('id', $request->id_kategori_kasus);
                }
            })->get()
        )->map(function ($i) use ($tahun, $request) {
            $kategoriKasus = [
                'id' => $i->id,
                'name' => $i->name,
                'grand_total' => 0,
            ];

            $thnKategori = [];
            foreach ($tahun as $t) {
                $anak = Pengaduan::whereYear('complaint_date', $t)->whereHas('klien.latest_klien_history', function ($q) {
                    $q->where('age_category', 1);
                })->whereHas('penjangkauan.jenis_kasus.kategoriKasus', function ($q) use ($i) {
                    $q->where('id', $i->id);
                })
                    ->where('id_status', '>=', $this->status);
                $dewasa = Pengaduan::whereYear('complaint_date', $t)->whereHas('klien.latest_klien_history', function ($q) {
                    $q->where('age_category', 2);
                })->whereHas('penjangkauan.jenis_kasus.kategoriKasus', function ($q) use ($i) {
                    $q->where('id', $i->id);
                })
                    ->where('id_status', '>=', $this->status);

                $anak = $anak->count();
                $dewasa = $dewasa->count();

                $thnKategori[] = [
                    'tahun' => $t,
                    'anak' => $anak,
                    'dewasa' => $dewasa,
                    'total' => $anak + $dewasa,
                ];

                $kategoriKasus['grand_total'] += $anak + $dewasa;
            }
            $kategoriKasus['tahun'] = $thnKategori;
            $kategoriKasus['jenis_kasus'] = collect(
                $i->jenisKasus()->whereHas('penjangkauan.pengaduan', function ($q) use ($request) {
                    $q->whereHas('klien.latest_klien_history');
                    $q->whereBetween(DB::raw('EXTRACT(YEAR FROM complaint_date)'), [$request->tahun_awal, $request->tahun_akhir]);
                    $q->where('id_status', '>=', $this->status);
                })->get()
            )->map(function ($j) use ($tahun, $request) {
                $jenisKasus = [
                    'id' => $j->id,
                    'name' => $j->name,
                    'grand_total' => 0,
                ];

                $thnJenis = [];
                foreach ($tahun as $t) {
                    $anak = Pengaduan::whereYear('complaint_date', $t)->whereHas('klien.latest_klien_history', function ($q) {
                        $q->where('age_category', 1);
                    })->whereHas('penjangkauan.jenis_kasus', function ($q) use ($j) {
                        $q->where('id', $j->id);
                    })
                        ->where('id_status', '>=', $this->status);
                    $dewasa = Pengaduan::whereYear('complaint_date', $t)->whereHas('klien.latest_klien_history', function ($q) {
                        $q->where('age_category', 2);
                    })->whereHas('penjangkauan.jenis_kasus', function ($q) use ($j) {
                        $q->where('id', $j->id);
                    })
                        ->where('id_status', '>=', $this->status);

                    $anak = $anak->count();
                    $dewasa = $dewasa->count();

                    $thnJenis[] = [
                        'tahun' => $t,
                        'anak' => $anak,
                        'dewasa' => $dewasa,
                        'total' => $anak + $dewasa,
                    ];

                    $jenisKasus['grand_total'] += $anak + $dewasa;
                }
                $jenisKasus['tahun'] = $thnJenis;

                return $jenisKasus;
            });

            return $kategoriKasus;
        });

        return $data;
    }
}
