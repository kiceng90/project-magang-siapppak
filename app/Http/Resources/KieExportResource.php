<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use DateTime;
use Carbon\Carbon;

class KieExportResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $mahasiswaDetail = $this->mahasiswa->detail_mahasiswa ?? null;
        $balaiPuspaga = $this->mahasiswa->balai_puspaga ?? null;

        $konselor = $balaiPuspaga->konselor ?? null;

        // Hitung usia berdasarkan tanggal lahir
        $birthDate = $mahasiswaDetail->birth_date ?? null;
        $usia = $birthDate ? (new DateTime('today'))->diff(new DateTime($birthDate))->y : null;

        // Data mahasiswa
        $data = [
            'identitas_mahasiswa' => [
                'id' => $mahasiswaDetail->id ?? '',
                'nama_lengkap' => $mahasiswaDetail->name ?? '',
                'nik' => $mahasiswaDetail->nik ?? '',
                'no_wa' => $mahasiswaDetail->phone ?? '',
                'pendidikan' => $mahasiswaDetail->pendidikan_terakhir->name ?? '',
                'jenis_mahasiswa' => $mahasiswaDetail->jenis_mahasiswa->name ?? '',
                'univ' => $mahasiswaDetail->instansi_pendidikan->name ?? '',
            ],
            'balai_puspaga' => [
                'kelurahan' => $balaiPuspaga->kelurahan->name ?? '',
                'kecamatan' => $balaiPuspaga->kelurahan->kecamatan->name ?? '',
                'puspaga_rw' => $balaiPuspaga->rw ?? '',
                'konselor' => !empty($konselor) ? [
                    'id' => $konselor->id,
                    'name' => $konselor->name,
                ] : null,
            ],
            'laporan_kegiatan' => [
                'tanggal_kegiatan' => Carbon::parse($this->tanggal_kegiatan)->translatedFormat('d F Y') ?? '',
                'jenis_konten' => $this->jenis_konten ?? '',
                'jenis_aktivitas' => $this->jenis_aktivitas ?? '',
                'aktivitas' => $this->aktivitas ?? '',
                'tema_konten' => $this->tema_konten ?? '',
                'judul_konten' => $this->judul_konten ?? '',
                'narasi_konten' => $this->narasi_konten ?? '',
                'url_video' => $this->url_video ?? '', 
            ],
        ];

        return $data;
    }
}
