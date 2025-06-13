<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;
use App\Models\MPelayanan;
use App\Models\MKebutuhan;
use App\Models\AnalisisDp3kappkb;
use App\Models\LangkahDilakukan;
use App\Models\RencanaIntervensi;
use App\Models\RealisasiIntervensi;

class CetakLaporanResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {

        $klien = $this->penjangkauan->klien ?? null;
        $penangananAwal = $this->penangananAwal;
        $penjangkauan = $this->penjangkauan;
        $pelaku = $penjangkauan ? $penjangkauan->pelaku : null;
        $kondisiKlien = $penjangkauan ? $penjangkauan->kondisiKlien : null;
        $rencana = $penjangkauan->rencanaIntervensi ?? null;
        $keluargaKlien = $penjangkauan->keluargaKlien ?? null;
        $analisis = $penjangkauan->analisisDp3kappkb ?? null;
        $rujukan = $penjangkauan->rencanaIntervensi ?? null;

        $idDaftarKlien = $langkahDilakukan ?? null;
        $langkahDilakukanCek = $idDaftarKlien ? LangkahDilakukan::whereIn('id_daftar_klien', $idDaftarKlien)->get() : null;

        $langkahDilakukan = $penjangkauan->langkahDilakukan ?? null;
        $realisasi = $rencana ? RealisasiIntervensi::whereIn('id_rencana_intervensi', $rencana->pluck('id')->toArray())->orderBy('created_at', 'desc')->get() : null;

        $data = [
            'nomor_registrasi' => $this->registration_number,
            'pengaduan' => [
                'id' => $this->id,
                'hari' => Carbon::parse($this->complaint_date)->translatedFormat('l'),
                'tanggal' => Carbon::parse($this->complaint_date)->translatedFormat('d/m/Y'),
                'waktu' => Carbon::parse($this->complaint_date)->translatedFormat('H:i'),
                'sumber_aduan' => $this->sumberKeluhan->name,
            ],
            'petugas' => $penjangkauan ? collect($penjangkauan->konselor)->map(function ($i) {
                return [
                    'id' => $i['id'],
                    'nama' => $i['name'],
                    'no_hp' => $i['phone_number'],
                ];
            }) : null,
            'penanganan_awal' => [
                'id' => $penangananAwal->id ?? null,
                'hari' => ($penangananAwal->date ?? null) ? Carbon::parse($penangananAwal->date)->translatedFormat('l') : null,
                'tanggal' => ($penangananAwal->date ?? null) ? Carbon::parse($penangananAwal->date)->translatedFormat('d/m/Y') : null,
                'waktu' => ($penangananAwal->date ?? null) ? Carbon::parse($penangananAwal->date)->translatedFormat('H:i') : null,
            ],
            'tanggal_penjangkauan' => [
                'id' => $penjangkauan->id ?? null,
                'hari' => ($penjangkauan->date ?? null) ? Carbon::parse($penjangkauan->date)->translatedFormat('l') : null,
                'tanggal' => ($penjangkauan->date ?? null) ? Carbon::parse($penjangkauan->date)->translatedFormat('d/m/Y') : null,
                'waktu' => ($penjangkauan->date ?? null) ? Carbon::parse($penjangkauan->date)->translatedFormat('H:i') : null,
            ],
            'data_pelapor' => [
                'nama_lengkap' => $this->complainant_name,
                'nik' => $this->complainant_nik,
                'alamat_domisili' => $this->complainant_residence_address,
                'id_kabupaten' => $this->complainant_id_kabupaten,
                'kabupaten' => $this->kabupaten->name ?? null,
                'no_telepon' => $this->complainant_phone_number,
            ],
            'data_klien' => $klien ? [
                'id' => $klien->id ?? null,
                'nama_lengkap' => $klien->name ?? null,
                'nik' => $klien->nik_number ?? null,
                'no_kk' => $klien->klien_history->kk_number ?? null,
                'ttl' => ($klien->klien_history->kabupaten_lahir->name ?? ' - ') . ', ' . (($klien->klien_history->birth_date ?? null) ? Carbon::parse($klien->klien_history->birth_date)->translatedFormat('d F Y') : '- '),
                'usia' => ($klien->klien_history->birth_date ?? null) ? Carbon::parse($klien->klien_history->birth_date)->age : null,
                'jenis_kelamin' => $klien->klien_history ? $klien->klien_history->gender == 1 ? 'Laki-laki' : 'Perempuan' : null,
                'agama' => $klien->klien_history->agama->name ?? null,
                'pendidikan_terakhir' => $klien->klien_history->pendidikan_terakhir->name ?? null,
                'pekerjaan' => $klien->klien_history->pekerjaan->name ?? null,
                'status_pernikahan' => $klien->klien_history->status_pernikahan->name ?? null,
                'alamat_kk' => ($klien->klien_history->kk_address ?? '') . (($klien->klien_history->kelurahan_kk ?? null) ? ', Kel. ' . $klien->klien_history->kelurahan_kk->name . ', Kec. ' . $klien->klien_history->kelurahan_kk->kecamatan->name : ''),
                'alamat_domisili' => ($klien->klien_history->residence_address ?? '') . (($klien->klien_history->kelurahan_tinggal ?? null) ? ', Kel. ' . $klien->klien_history->kelurahan_tinggal->name . ', Kec. ' . $klien->klien_history->kelurahan_tinggal->kecamatan->name : ''),
                'no_telepon' => $klien->phone_number ?? null,
            ] : null,
            'data_keluarga_klien' => $keluargaKlien ?
                collect($keluargaKlien)->map(function ($i) {
                    return [
                        'id' => $i->id,
                        'nama_lengkap' => $i->name,
                        'nik' => $i->nik_number,
                        'alamat_kk' => ($i->kk_address ?? '') . ($i->kelurahan_kk ? ', Kel. ' . $i->kelurahan_kk->name . ', Kec. ' . $i->kelurahan_kk->kecamatan->name : ''),
                        'alamat_domisili' => ($i->residence_address ?? '') . ($i->kelurahan_tinggal ? ', Kel. ' . $i->kelurahan_tinggal->name . ', Kec. ' . $i->kelurahan_tinggal->kecamatan->name : ''),
                        'pekerjaan' => $i->pekerjaan->name ?? null,
                        'hubungan_dengan_klien' => $i->hubungan->name ?? null,
                        'no_telepon' => $i->phone_number,
                    ];
                }) :
                null,
            'data_pelaku' => $pelaku ? [
                'id' => $pelaku->id,
                'nama_lengkap' => $pelaku->name,
                'nik' => $pelaku->nik_number,
                'no_kk' => $pelaku->kk_number,
                'ttl' => ($pelaku->kabupatenLahir->name ?? ' - ') . ', ' . (($pelaku->birth_date ?? null) ? Carbon::parse($pelaku->birth_date)->translatedFormat('d F Y') : '- '),
                'usia' => $pelaku->birth_date ? Carbon::parse($pelaku->birth_date)->age : null,
                'jenis_kelamin' => $pelaku->gender == 1 ? 'Laki-laki' : 'Perempuan',
                'agama' => $pelaku->agama->name ?? null,
                'pendidikan_terakhir' => $pelaku->pendidikanTerakhir->name ?? null,
                'pekerjaan' => $pelaku->pekerjaan->name ?? null,
                'status_pernikahan' => $pelaku->statusPernikahan->name ?? null,
                'alamat_kk' => ($pelaku->kk_address ?? '') . ($pelaku->kelurahanKK ? ', Kel. ' . $pelaku->kelurahanKK->name . ', Kec. ' . $pelaku->kelurahanKK->kecamatan->name : ''),
                'alamat_domisili' => ($pelaku->residence_address ?? '') . ($pelaku->kelurahanTinggal ? ', Kel. ' . $pelaku->kelurahanTinggal->name . ', Kec. ' . $pelaku->kelurahanTinggal->kecamatan->name : ''),
                'kewarganegaraan' => $pelaku->citizenship == 1 ? 'WNI' : 'WNA',
                'nomor_telepon' => $pelaku->phone_number,
                'hubungan_pelaku' => $pelaku->hubungan->name ?? null,
            ] : null,
            'data_kasus' => $penjangkauan ? [
                'id' => $penjangkauan->id,
                'jenis_klien' => $klien && $klien->klien_history ? $klien->klien_history->physical_category == 1 ? 'Umum' : 'Disabilitas' : '',
                'kategori_klien' => $klien && $klien->klien_history ? $klien->klien_history->age_category  == 1 ? 'Anak-anak' : 'Dewasa' : '',
                'tipe_permasalahan' => $penjangkauan->jenis_kasus->kategoriKasus->tipePermasalahan->name ?? null,
                'kategori_kasus' => $penjangkauan->jenis_kasus->kategoriKasus->name ?? null,
                'jenis_kasus' => $penjangkauan->jenis_kasus->name ?? null,
                'deskripsi' => $penjangkauan->case_description,
                'lokasi_kejadian' => $penjangkauan->lokasi_kejadian->name ?? null,
                'tanggal_dan_waktu' => Carbon::parse($penjangkauan->case_date)->translatedFormat('d F Y, H:i') . ' WIB',
            ] : null,
            'situasi_keluarga' => $this->penjangkauan->situasiKeluarga->description ?? null,
            'kronologis_kejadian' => $this->penjangkauan->kronologiKejadian->description ?? null,
            'harapan_klien' => $this->penjangkauan->harapanKlien->description ?? null,
            'kondisi_klien' => $kondisiKlien ? [
                'id' => $kondisiKlien->id,
                'fisik' => $kondisiKlien->physical_description,
                'psikologis' => $kondisiKlien->psycological_description,
                'sosial' => $kondisiKlien->social_description,
                'spiritual' => $kondisiKlien->spiritual_description,
            ] : null,
            'rencana_analisis' => $penjangkauan ? collect(MPelayanan::orderBy('id', 'ASC')->get())->map(function ($i) use ($penjangkauan) {
                return [
                    'id' => $i->id,
                    'name' => $i->name,
                    'deskripsi' => $penjangkauan ? AnalisisDp3kappkb::where('id_pelayanan', $i->id)->where('id_penjangkauan', $penjangkauan->id)->pluck('description')->first() : null,
                ];
            })->reject(function ($i) use ($penjangkauan) {
                return  empty(AnalisisDp3kappkb::where('id_pelayanan', $i['id'])->where('id_penjangkauan', $penjangkauan->id)->first());
            })->toArray() : [],

            // 'rencana_rujukan' => $penjangkauan ? collect(MKebutuhan::orderBy('id', 'ASC')->get())->map(function ($i) use ($penjangkauan) {
            //     return [
            //         'id' => $i->id,
            //         'name' => $i->name,
            //         'deskripsi' => (RencanaIntervensi::where('id_kebutuhan', $i->id)->where('id_penjangkauan', $penjangkauan->id)->first())->intervensi->name ?? null,
            //     ];
            'rencana_rujukan' => $penjangkauan ? collect(RencanaIntervensi::with('kebutuhan')->where('id_penjangkauan', $penjangkauan->id)->get())->map(function ($i) use ($penjangkauan) {
                return [
                    'id' => $i->kebutuhan->id,
                    'name' => $i->kebutuhan->name,
                    'deskripsi' => (RencanaIntervensi::where('id', $i->id)->first())->intervensi->name ?? null,
                ];
            })->reject(function ($i) use ($penjangkauan) {
                return empty(RencanaIntervensi::where('id_kebutuhan', $i['id'])->where('id_penjangkauan', $penjangkauan->id)->first());
            })->toArray() : [],
            'langkah_dilakukan_dp3appkb' => $langkahDilakukan ? collect($langkahDilakukan)->map(function ($i) {
                return [
                    'id' => $i->id,
                    'tanggal_pelayanan' => Carbon::parse($i->service_date)->translatedFormat('d F Y'),
                    'pelayanan_diberikan' => $i->pelayanan->name ?? null,
                    'deskripsi' => $i->description,
                ];
            }) : null,
            'langkah_dilakukan_cek' => $langkahDilakukanCek ? collect($langkahDilakukanCek)->map(function ($i) {
                return [
                    'id' => $i->id,
                    'tanggal_pelayanan' => Carbon::parse($i->service_date)->translatedFormat('d F Y'),
                    'pelayanan_diberikan' => $i->pelayanan->name ?? null,
                    'deskripsi' => $i->description,
                ];
            }) : null,
            'langkah_dilakukan' => $realisasi ? collect($realisasi)->map(function ($i) {
                return [
                    'id' => $i->id,
                    'tanggal_pelayanan' => Carbon::parse($i->created_at)->translatedFormat('d F Y'),
                    'instansi' => $i->rencana_intervensi->opd->name ?? null,
                    'pelayanan_diberikan' => $i->rencana_intervensi->intervensi->name ?? null,
                    'deskripsi' => $i->description,
                ];
            }) : null,
            'dokumen_pendukung' => $penjangkauan ? new DokumenPendukungResource($penjangkauan) : null,
            'ttd_kadis' => config('env.ttd_kadis') + ['ttd' => 'ttd/ttd_kadis.png'],
        ];

        if (!$data['data_klien']) {
            $klien = $this->klien;
            $data['data_klien'] = [
                'id' => $klien->id ?? null,
                'nama_lengkap' => $klien->name ?? null,
                'nik' => $klien->is_has_nik ? $klien->nik_number : $klien->identity_number,
                'no_kk' => null,
                'ttl' => null,
                'usia' => null,
                'jenis_kelamin' => null,
                'agama' => null,
                'pendidikan_terakhir' => null,
                'pekerjaan' => null,
                'status_pernikahan' => null,
                'alamat_kk' => null,
                'alamat_domisili' => ($klien->residence_address ?? '') . ($klien->kelurahan ? ', Kel. ' . $klien->kelurahan->name . ', Kec. ' . $klien->kelurahan->kecamatan->name : ''),
                'no_telepon' => $klien->phone_number ?? null,
            ];
        }

        return $data;
    }
}
