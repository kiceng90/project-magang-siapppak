<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;
use Datetime;

class IntervensiOpdExportResource extends JsonResource
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
        $rencanaIntervensi = $penjangkauan->rencanaIntervensi ?? null;
        $statusPenanganan = $request->filled('id_status_penanganan') ? ($request->id_status_penanganan == 1) : null;
        $penagananAwal = $this->penangananAwal ?? null;
        $pengaduanDate = new Datetime($this->complaint_date);
        $penangananDate = new Datetime($penagananAwal->date);
        $diff = ($pengaduanDate && $penangananDate) && ($penangananDate > $pengaduanDate) ? $pengaduanDate->diff($penangananDate) : null;

        $data = [
            'identitas_klien' => [
                'id' => $daftarKlien->id ?? '',
                'nama' => $daftarKlien->name ?? '',
                'nik' => $daftarKlien->nik_number ?? '',
                'no_registrasi' => $this->registration_number ?? '',
            ],
            'kasus' => [
                'tipe_permasalahan' => $penjangkauan->jenis_kasus->kategoriKasus->tipePermasalahan->name ?? '',
                'kategori_kasus' => $penjangkauan->jenis_kasus->kategoriKasus->name ?? '',
                'jenis_kasus' => $penjangkauan->jenis_kasus->name ?? '',
            ],
            'lainnya' => [
                'tanggal_pengaduan' => $this->complaint_date ? Carbon::parse($this->complaint_date)->translatedFormat('d F Y, H:i') : '',
            ],
            'pelayanan' => !empty($rencanaIntervensi) ? collect($rencanaIntervensi)->filter(function ($d) use ($request, $statusPenanganan) {
                if ($request->filled('id_opd') && $d->opd->id != $request->id_opd) {
                    return false;
                }
                if ($request->filled('id_intervensi') && $d->intervensi->id != $request->id_intervensi) {
                    return false;
                }
                if ($statusPenanganan !== null && $d->realisasi_draft_status != $statusPenanganan) {
                    return false;
                }
                return true;
            })->map(function ($d) {
            
                $status = $d->realisasi_draft_status == 1 ? 'Proses Intervensi' : 'Selesai';

                return [
                    'id' => $d->id,
                    'kebutuhan' => $d->kebutuhan->name ?? '',
                    'opd' => $d->opd->name ?? '',
                    'tanggal_pelayanan' => ($d->realisasiIntervensi->first()->created_at ?? null) ? Carbon::parse($d->realisasiIntervensi->first()->created_at)->translatedFormat('d F Y') : '',
                    'pelayanan_diberikan' => $d->intervensi->name ?? '',
                    'deskripsi' => $d->realisasiIntervensi->first()->description ?? '',
                    'status' => $status,
                ];
            })->toArray() : [],
        ];

        return $data;
    }
}
