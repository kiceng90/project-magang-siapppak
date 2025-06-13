<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

use Carbon\Carbon;
use DateTime;

class PelakuExportResource extends JsonResource
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
        $pelaku = $penjangkauan->pelaku ?? null;
        $usia_pelaku = ($pelaku->birth_date ?? null) ? (new DateTime('today'))->diff((new DateTime($pelaku->birth_date)))->y : '';
        $data = [
            'identitas_klien' => [
                'id' => $daftarKlien->id ?? '',
                'nama' => $daftarKlien->name ?? '',
                'nik' => $daftarKlien->nik_number ?? '',
            ],
            'identitas_pelaku' => [
                'id' => $pelaku->id ?? '',
                'nama' => $pelaku->name ?? '',
                'nik' => $pelaku->nik_number ?? '',
                'kk' => $pelaku->kk_number ?? '',
                'l_p' => $pelaku && $pelaku->gender ? $pelaku->gender == 1 ? 'L' : 'P' : '',
                'pendidikan' => $pelaku->pendidikanTerakhir->name ?? '',
                'jurusan' => $pelaku->jurusan->name ?? '',
                'tahun_lulus' => $pelaku->graduation_year ?? '',
                'instansi' => $pelaku->school_name ?? '',
                'pekerjaan' => $pelaku->pekerjaan->name ?? '',
                'agama' => $pelaku->agama->name ?? '',
                'status_perkawinan' => $pelaku->statusPernikahan->name ?? '',
                'tempat_lahir' => $pelaku->kabupatenLahir->name ?? '',
                'tanggal_lahir' => ($pelaku->birth_date ?? null) ? Carbon::parse($pelaku->birth_date)->translatedFormat('d F Y') : '',
                'usia' => $usia_pelaku,
                'kategori' => $usia_pelaku ? $usia_pelaku <=18 ? 'ANAK' : 'DEWASA' : '',
                'no_telepon' => $pelaku->phone_number ?? '',
                'tanggal_kenal_pelaku' => '',
                'hub_dengan_korban' => $pelaku->hubungan->name ?? '',
                'kewarganegaraan' => $pelaku && $pelaku->citizenship ? $pelaku->citizenship == 1 ? 'WNI' : 'WNA' : '',
            ],
            'alamat_kk' => [
                'alamat' => $pelaku->kk_address ?? '',
                'rt' => 0,
                'rw' => 0,
                'kelurahan' => $pelaku->kelurahanKK->name ?? '',
                'kecamatan' => $pelaku->kelurahanKK->kecamatan->name ?? '',
                'wilayah' => $pelaku->kelurahanKK->kecamatan->wilayah->name ?? '',
            ],
            'alamat_domisili' => [
                'alamat' => $pelaku->residence_address ?? '',
                'rt' => 0,
                'rw' => 0,
                'kelurahan' => $pelaku->kelurahanTinggal->name ?? '',
                'kecamatan' => $pelaku->kelurahanTinggal->kecamatan->name ?? '',
                'wilayah' => $pelaku->kelurahanTinggal->kecamatan->wilayah->name ?? '',
            ],
        ];
        return $data;
    }
}
