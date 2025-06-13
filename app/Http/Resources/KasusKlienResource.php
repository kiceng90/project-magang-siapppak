<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;
use Datetime;

class KasusKlienResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $daftarKlien = $this->klien ?? null;
        $klienHistory = $daftarKlien->latest_klien_history ?? null;
        $penjangkauan = $this->penjangkauan ?? null;
        $penagananAwal = $this->penangananAwal ?? null;
        $pengaduanDate = new Datetime($this->complaint_date);
        $penangananDate = new Datetime($penagananAwal->date);
        $diff = ($pengaduanDate && $penangananDate) && ($penangananDate > $pengaduanDate) ? $pengaduanDate->diff($penangananDate) : null;

        switch ($klienHistory->bpjs_category ?? '') {
            case 1:
                $klien_bpjs_category = 'PBI';
                break;
            case 2:
                $klien_bpjs_category = 'Korporasi';
                break;
            case 3:
                $klien_bpjs_category = 'Mandiri';
                break;
            default:
                $klien_bpjs_category = 'Tidak Punya';
                break;
        }
        $data = [
            'id' => $this->id,
            'identitas_klien' => [
                'no_registrasi' => $this->registration_number,
                'nama_klien' => $daftarKlien->name ?? '',
                'inisial' => $daftarKlien->initial_name ?? '',
                'nik' => $daftarKlien->nik_number ?? '',
                'no_kk' => $klienHistory->kk_number ?? '',
                'l_p' => $klienHistory ? $klienHistory->gender == 1 ? 'L' : 'P' : '',
                'pendidikan' => $klienHistory->pendidikan_terakhir->name ?? '',
                'kelas' => $klienHistory->highest_class ?? '',
                'jurusan' => $klienHistory->jurusan->name ?? '',
                'tahun_lulus' => $klienHistory->graduation_year ?? '',
                'nama_instansi' => $klienHistory->school_name ?? '',
                'pekerjaan' => $klienHistory->pekerjaan->name ?? '',
                'penghasilan_perbulan' => ($klienHistory->monthly_income ?? null) ? 'Rp ' . number_format($klienHistory->monthly_income, 0, ',', '.') : '',
                'agama' => $klienHistory->agama->name ?? '',
                'status_perkawinan' => $klienHistory->status_pernikahan->name ?? '',
                'tempat_lahir' => $klienHistory->kabupaten_lahir->name ?? '',
                'tanggal_lahir' => ($klienHistory->birth_date ?? null) ? Carbon::parse($klienHistory->birth_date)->translatedFormat('d F Y') ?? '' : '',
                'usia' => ($klienHistory->birth_date ?? null) ? Carbon::parse($klienHistory->birth_date)->diffInYears(Carbon::now()) ?? '' : '',
                //date('Y') - date('Y', strtotime($klienHistory->birth_date)) ?? '' : '',
                'kategori_klien' => $klienHistory ? $klienHistory->age_category == 1 ? 'Anak' : 'Dewasa' : '',
                'jenis_klien' => $klienHistory ? $klienHistory->physical_category == 1 ? 'Umum' : 'Disabilitas' : '',
                'no_telpon' => $daftarKlien->phone_number ?? '',
            ],
            'alamat_kk' => [
                'alamat' => $klienHistory->kk_address ?? '',
                'rt' => 0,
                'rw' => 0,
                'kelurahan' => $klienHistory->kelurahan_kk->name ?? '',
                'kecamatan' => $klienHistory->kelurahan_kk->kecamatan->name ?? '',
                'wilayah' => $klienHistory->kelurahan_kk->kecamatan->wilayah->name ?? '',
            ],
            'alamat_domisili' => [
                'alamat' => $klienHistory->residence_address ?? '',
                'rt' => 0,
                'rw' => 0,
                'kelurahan' => $klienHistory->kelurahan_tinggal->name ?? '',
                'kecamatan' => $klienHistory->kelurahan_tinggal->kecamatan->name ?? '',
                'wilayah' => $klienHistory->kelurahan_tinggal->kecamatan->wilayah->name ?? '',
            ],
            'kasus' => [
                'tipe_kasus' => (($penjangkauan->case_type ?? null) == 1 ? 'Kasus Lama' : 'Kasus Baru') ?? '',
                'tipe_permasalahan' => $penjangkauan->jenis_kasus->kategoriKasus->tipePermasalahan->name ?? '',
                'kategori_kasus' => $penjangkauan->jenis_kasus->kategoriKasus->name ?? '',
                'jenis_kasus' => $penjangkauan->jenis_kasus->name ?? '',
                'deskripsi' => $penjangkauan->case_description ?? '',
                'lokasi_kasus' => $penjangkauan->lokasi_kejadian->name ?? '',
                'tanggal_dan_jam' => ($penjangkauan->case_date ?? null) ? Carbon::parse($penjangkauan->case_date)->translatedFormat('d F Y, H:i') : '',
            ],
            'lainnya' => [
                'kepemilikan_bpjs' => $klien_bpjs_category,
                'tanggal_pengaduan' => $this->complaint_date ? Carbon::parse($this->complaint_date)->translatedFormat('d F Y, H:i') : '',
                'tanggal_penanganan_awal' => ($penagananAwal->date ?? null) ? Carbon::parse($penagananAwal->date)->translatedFormat('d F Y, H:i') ?? '' : '',
                'tanggal_penjangkauan' => ($penjangkauan->date ?? null) ? Carbon::parse($penjangkauan->date)->translatedFormat('d F Y, H:i') : '',
                'konselor' => ($penjangkauan->konselor ?? []),
                'sumber_pengaduan' => $this->sumberKeluhan->name ?? '',
            ],
            'duration' => (((($diff->days ?? 0) * 24) + ($diff->h ?? 0)) . ' Jam, ' . ($diff->i ?? 0) . ' menit, ' . ($diff->s ?? 0) . ' Detik'),
        ];
        return $data;
    }
}
