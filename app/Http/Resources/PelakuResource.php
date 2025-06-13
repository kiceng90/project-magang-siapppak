<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PelakuResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $parent = parent::toArray($request);
        $data = [
            'nama_hubungan' => $this->hubungan->name ?? null,
            'nama_kabupaten_lahir' => $this->kabupatenLahir->name ?? null,
            'id_kecamatan_tinggal' => $this->kelurahanTinggal->kecamatan->id ?? null,
            'nama_kecamatan_tinggal' => $this->kelurahanTinggal->kecamatan->name ?? null,
            'nama_kelurahan_tinggal' => $this->kelurahanTinggal->name ?? null,
            'id_kecamatan_kk' => $this->kelurahanKK->kecamatan->id ?? null,
            'nama_kecamatan_kk' => $this->kelurahanKK->kecamatan->name ?? null,
            'nama_kelurahan_kk' => $this->kelurahanKK->name ?? null,
            'nama_agama' => $this->agama->name ?? null,
            'nama_pekerjaan' => $this->pekerjaan->name ?? null,
            'nama_status_pernikahan' => $this->statusPernikahan->name ?? null,
            'nama_pendidikan_terakhir' => $this->pendidikanTerakhir->name ?? null,
            'nama_jurusan' => $this->jurusan->name ?? null,
        ];
        return $parent + $data;
    }
}
