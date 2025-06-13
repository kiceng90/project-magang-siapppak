<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class KeteranganExportResource extends JsonResource
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
        $kondisiKlien = $penjangkauan->kondisiKlien ?? null;

        $data = [
            'identitas_klien' => [
                'id' => $daftarKlien->id ?? '',
                'nama' => $daftarKlien->name ?? '',
                'nik' => $daftarKlien->nik_number ?? '',
            ],
            'situasi_keluarga' => ($penjangkauan->situasiKeluarga->description ?? null) ? trim(preg_replace('/\s+/', ' ', html_entity_decode(strip_tags($penjangkauan->situasiKeluarga->description)))) : '',
            'kronologi_kejadian' => ($penjangkauan->kronologiKejadian->description ?? null) ? trim(preg_replace('/\s+/', ' ', html_entity_decode(strip_tags($penjangkauan->kronologiKejadian->description)))) : '',
            'harapan_klien' => ($penjangkauan->harapanKlien->description ?? null) ? trim(preg_replace('/\s+/', ' ', html_entity_decode(strip_tags($penjangkauan->harapanKlien->description)))) : '',
            'kondisi_klien' => [
                'fisik' => $kondisiKlien->physical_description ?? '',
                'psikologi' => $kondisiKlien->psycological_description ?? '',
                'sosial' => $kondisiKlien->social_description ?? '',
                'spiritual' => $kondisiKlien->spiritual_description ?? '',
            ],
        ];

        return $data;
    }
}
