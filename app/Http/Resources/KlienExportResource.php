<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

use DateTime;
use Carbon\Carbon;

class KlienExportResource extends JsonResource
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
        $klienHistory = $penjangkauan->klien->klien_history ?? null;
        $kepemilikan_bpjs = '';
        switch ($klienHistory->bpjs_category ?? null) {
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

        $konselor = ($penjangkauan->konselor ?? null);

        $pengaduanDate = $this->complaint_date ? new Datetime($this->complaint_date) : null;
        $penangananDate = ($this->penangananAwal->date ?? null) ? new Datetime($this->penangananAwal->date) : null;
        $diff = ($pengaduanDate && $penangananDate) && ($penangananDate > $pengaduanDate) ? $pengaduanDate->diff($penangananDate) : null;

        $data = [
            'identitas_klien' => [
                'id' => $daftarKlien->id ?? '',
                'no_registrasi' => $this->registration_number,
                'nama' => $daftarKlien->name ?? '',
                'inisial' => $daftarKlien->initial_name ?? '',
                'nik' => $daftarKlien->nik_number ?? '',
                'no_kk' => $klienHistory->kk_number ?? '',
                'l_p' => ($klienHistory->gender ?? null) != null ? $klienHistory->gender == 1 ? 'L' : 'P' : '',
                'pendidikan' => $klienHistory->pendidikan_terakhir->name ?? '',
                'kelas' => $klienHistory->highest_class ?? '',
                'jurusan' => $klienHistory->jurusan->name ?? '',
                'tahun_lulus' => $klienHistory->graduation_year ?? '',
                'instansi' => $klienHistory->school_name ?? '',
                'pekerjaan' => $klienHistory->pekerjaan->name ?? '',
                'penghasilan_perbulan' => ($klienHistory->monthly_income ?? null) ? number_format($klienHistory->monthly_income, 0, ',', '.') : '',
                'agama' => $klienHistory->agama->name ?? '',
                'status_perkawinan' => $klienHistory->status_pernikahan->name ?? '',
                'tempat_lahir' => $klienHistory->kabupaten_lahir->name ?? '',
                'tanggal_lahir' => $klienHistory && $klienHistory->birth_date ? Carbon::parse($klienHistory->birth_date)->translatedFormat('d F Y') : '',
                'usia' => ($klienHistory->birth_date ?? null) ? (new DateTime('today'))->diff((new DateTime($klienHistory->birth_date)))->y : '',
                'kategori' => ($klienHistory->age_category ?? null) != null ? $klienHistory->age_category == 1 ? 'ANAK' : 'DEWASA' : '',
                'jenis' => ($klienHistory->physical_category ?? null) != null ? $klienHistory->physical_category == 1 ? 'UMUM' : 'DISABILITAS' : '',
                'no_telepon' => $daftarKlien->phone_number ?? '',
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
            'detail_kasus' => [
                'tipe_kasus' => ($penjangkauan->case_type ?? null) != null ? $penjangkauan->case_type == 1 ? 'Kasus Lama' : 'Kasus Baru' : '',
                'tipe_permasalahan' => $penjangkauan->jenis_kasus->kategoriKasus->tipePermasalahan->name ?? '',
                'kategori_kasus' => $penjangkauan->jenis_kasus->kategoriKasus->name ?? '',
                'jenis_kasus' => $penjangkauan->jenis_kasus->name ?? '',
                'uraian' => $penjangkauan->case_description ?? '',
                'lokasi' => $penjangkauan->lokasi_kejadian->name ?? '',
                'tanggal_dan_jam' => $penjangkauan && $penjangkauan->case_date ? Carbon::parse($penjangkauan->case_date)->translatedFormat('d F Y, H:i') : '',
            ],
            'lainnya' => [
                'kepemilikan_bpjs' => $kepemilikan_bpjs,
                'tanggal_dan_jam_pengaduan' => $this->complaint_date ? Carbon::parse($this->complaint_date)->translatedFormat('d F Y, H:i') : '',
                'tanggal_dan_jam_penanganan' => ($this->penangananAwal->date ?? null) ? Carbon::parse($this->penangananAwal->date)->translatedFormat('d F Y, H:i') : '',
                'tanggal_dan_jam_penjangkauan' => ($penjangkauan->date ?? null) ? Carbon::parse($penjangkauan->date)->translatedFormat('d F Y, H:i') : '',
                'konselor_1' => !empty($konselor) ? [
                    'id' => $konselor[0]['id'],
                    'name' => $konselor[0]['name'],
                ] : null,
                'konselor_2' => count($konselor ?? []) > 1 ? [
                    'id' => $konselor[1]['id'],
                    'name' => $konselor[1]['name'],
                ] : null,
                'sumber_pengaduan' => $this->sumberKeluhan->name ?? '',
            ],
            'durasi' => (((($diff->days ?? 0) * 24) + ($diff->h ?? 0)) . ' Jam, ' . ($diff->i ?? 0) . ' menit, ' . ($diff->s ?? 0) . ' Detik'),
            'pengaduanDate' => $pengaduanDate,
            'penangananDate' => $penangananDate,
        ];
        return $data;
    }
}
