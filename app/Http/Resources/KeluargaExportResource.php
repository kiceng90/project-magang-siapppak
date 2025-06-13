<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;
use DateTime;

class KeluargaExportResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $daftarKlien = $this->klien;
        $penjangkauan = $this->penjangkauan;
        $keluargaKlien = $penjangkauan->keluargaKlien ?? null;
        $saudaraKlien = $penjangkauan->saudaraKlien ?? null;

        $data = [
            'identitas_klien' => [
                'id' => $daftarKlien->id ?? '',
                'nama' => $daftarKlien->name ?? '',
                'nik' => $daftarKlien->nik_number ?? '',
            ],
            'keluarga' => !empty($keluargaKlien) ? collect($keluargaKlien)->map(function($d){
                
                switch ($d->bpjs_category ?? null) {
                    case 1:
                        $kepemilikan_bpjs = 'PBI';
                        break;
                    case 2:
                        $kepemilikan_bpjs = 'Korporasi';
                        break;
                    case 3:
                        $kepemilikan_bpjs = 'Mandiri';
                        break;
                        
                    default:
                        $kepemilikan_bpjs = 'Tidak Punya';
                        break;
                }

                return [
                    'id' => $d->id,
                    'hubungan' => $d->hubungan->name ?? '',
                    'nama' => $d->name ?? '',
                    'nik' => $d->nik_number ?? '',
                    'kk' => $d->kk_number ?? '',
                    'pekerjaan' => $d->pekerjaan->name ?? '',
                    'sifat_pekerjaan' => $d->work_type ?? '',
                    'penghasilan' => ($d->monthly_income ?? null) ? number_format($d->monthly_income, 0, ',', '.') : '',
                    'status_pernikahan' => $d->status_pernikahan->name ?? '',
                    'agama' => $d->agama->name ?? '',
                    'tempat_lahir' => $d->kabupaten_lahir->name ?? '',
                    'tanggal_lahir' => ($d->birth_date ?? null) ? Carbon::parse($d->birth_date)->translatedFormat('d F Y') : '',
                    'usia' => ($d->birth_date ?? null) ? (new DateTime('today'))->diff((new DateTime($d->birth_date)))->y : '',
                    'no_telp' => $d->phone_number ?? '',
                    'kepemilikan_bpjs' => $kepemilikan_bpjs,
                    'alamat_kk' => [
                        'alamat' => $d->kk_address ?? '',
                        'rt' => 0,
                        'rw' => 0,
                        'kelurahan' => $d->kelurahan_kk->name ?? '',
                        'kecamatan' => $d->kelurahan_kk->kecamatan->name ?? '',
                        'wilayah' => $d->kelurahan_kk->kecamatan->wilayah->name ?? '',
                    ],
                    'alamat_domisili' => [
                        'alamat' => $d->residence_address ?? '',
                        'rt' => 0,
                        'rw' => 0,
                        'kelurahan' => $d->kelurahan_tinggal->name ?? '',
                        'kecamatan' => $d->kelurahan_tinggal->kecamatan->name ?? '',
                        'wilayah' => $d->kelurahan_tinggal->kecamatan->wilayah->name ?? '',
                    ],
                    
                ];
            }) : null,
            'saudara' => !empty($saudaraKlien) ? collect($saudaraKlien)->map(function($d){
                return [
                    'id' => $d->id,
                    'nama' => $d->name ?? '',
                ];
            }) : null,
        ];

        return $data;
    }
}
