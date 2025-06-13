<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class IntervensiDp3appkbExportResource extends JsonResource
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
        $langkahdilakukan = $penjangkauan->langkahdilakukan ?? null;

        $data = [
            'identitas_klien' => [
                'id' => $daftarKlien->id ?? '',
                'nama' => $daftarKlien->name ?? '',
                'nik' => $daftarKlien->nik_number ?? '',
            ],
            'pelayanan' => !empty($langkahdilakukan) ? collect($langkahdilakukan)->map(function($d){
                return [
                    'id' => $d->id,
                    'tanggal_pelayanan' => '',
                    'pelayanan_diberikan' => $d->pelayanan->name ?? '',
                    'deskripsi' => $d->description ?? '',
                ];
            }) : null,
        ];

        return $data;
    }
}