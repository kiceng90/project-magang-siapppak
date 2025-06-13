<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Controllers\Controller;

class DetailPengaduanResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $data = [
            'id' => $this->id,
            'penjangkauan_id' => $this->penjangkauan ? $this->penjangkauan->id : null,
            'created_at' => $this->created_at,
            'status' => Controller::getStatusPengaduan($this->id_status, $this),
            'waktu_pengaduan' => [
                'nomor_registrasi' => $this->registration_number,
                'id_sumber' => $this->id_sumber_keluhan,
                'sumber_pengaduan' => $this->sumberKeluhan ? $this->sumberKeluhan->name : null,
                'waktu_penngaduan' => $this->complaint_date,
            ],
            'identitas_pelapor' => [
                'nama' => $this->complainant_name,
                'nik' => $this->complainant_nik,
                'warga_surabaya' => $this->complainant_is_surabaya_resident,
                'id_kabupaten' => $this->complainant_id_kabupaten,
                'kabupaten' => $this->kabupaten ? $this->kabupaten->name : null,
                'alamat' => $this->complainant_residence_address,
                'nomor' => $this->complainant_phone_number,
            ],
            'identitas_klien' => [
                'client_type' => $this->client_type,
                'id_klien' => $this->id_klien,
                'nama' => $this->klien ? $this->klien->name : null,
                'inisial_klien' => $this->klien ? $this->klien->initial_name : null,
                'nik' => $this->klien ? $this->klien->is_has_nik ? $this->klien->nik_number : $this->klien->identity_number : null,
                'is_has_nik' => $this->klien ? $this->klien->is_has_nik : null,
                'label_nik' => $this->klien ? $this->klien->is_has_nik ? 'NIK' : 'Nomor Identitas' : null,
                'warga_surabaya' => $this->klien ? $this->klien->is_surabaya_resident : null,
                'id_kabupaten' => $this->klien ? $this->klien->id_kabupaten_tinggal : null,
                'kabupaten' => $this->klien ? $this->klien->kabupaten ? $this->klien->kabupaten->name : null : null,
                'alamat' => $this->klien ? $this->klien->residence_address : null,
                'nomor' => $this->klien ? $this->klien->phone_number : null,
                'id_kecamatan' => $this->klien ? $this->klien->kelurahan ? $this->klien->kelurahan->id_kecamatan : null : null,
                'kecamatan' => $this->klien ? $this->klien->kelurahan ? $this->klien->kelurahan->kecamatan ? $this->klien->kelurahan->kecamatan->name : null : null : null,
                'id_kelurahan' => $this->klien ? $this->klien->id_kelurahan_tinggal : null,
                'kelurahan' => $this->klien ? $this->klien->kelurahan ? $this->klien->kelurahan->name : null : null,
            ],
            'permasalahan' => [
                'uraian' => $this->problem_description,
            ],
            'dokumentasi' => FileResource::collection($this->files),
        ];
        return $data;
    }
}
