<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use DateTime;
use Carbon\Carbon;

class KonselingExportResource extends JsonResource
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
                'nama_klien' => $this->nama_klien ?? '',
                'nik' => $this->nik ?? '',
                'tipe_konseling' => $this->tipe_konseling ?? '',
                'kategori_kasus' => $this->kategori_kasus ?? '',
                'warga_surabaya' => $this->warga_surabaya ?? '',
                'kota_domisili' => $this->kota_domisili ?? '',
                'kec_domisili' => $this->kec_domisili ?? '',
                'kel_domisili' => $this->kel_domisili ?? '',
                'alamat_domisili' => $this->alamat_domisili ?? '',
                'uraian_permasalahan' => $this->uraian_permasalahan ?? '',
                'tindak_lanjut' => $this->tindak_lanjut ?? '', 
                'no_klien' => $this->no_klien ?? '', 
            ],
        ];

        return $data;
    }
}
