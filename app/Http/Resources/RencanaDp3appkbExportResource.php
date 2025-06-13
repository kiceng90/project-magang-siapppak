<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RencanaDp3appkbExportResource extends JsonResource
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
        $analisisDp3kappkb = $penjangkauan->analisisDp3kappkb ?? null;

        $data = [
            'identitas_klien' => [
                'id' => $daftarKlien->id ?? '',
                'nama' => $daftarKlien->name ?? '',
                'nik' => $daftarKlien->nik_number ?? '',
                'no_registrasi' => $this->registration_number ?? '',
            ],
            'pelayanan' => !empty($analisisDp3kappkb) ? collect($analisisDp3kappkb)->map(function($d){
                return [
                    'id' => $d->id,
                    'tanggal_pelayanan' => '',
                    'pelayanan_diberikan' => $d->pelayanan->name ?? '',
                    'deskripsi' => $d->description ?? '',
                    'status' => $d->status ?? '',
                ];
            }) : null,
        ];

        return $data;
    }
}
