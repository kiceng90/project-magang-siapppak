<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

use App\Http\Resources\JenisKasusResource;
use App\Http\Resources\LokasiKejadianResource;
use App\Http\Resources\PenjangkauanKonselorResource;

class PenjangkauanResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $result = [
            'id' => $this->id,
            'id_pengaduan' => $this->id_pengaduan,
            'location' => $this->location,
            'address' => $this->address,
            'tanggal_panjangkauan' => (!empty($this->date)) ? Carbon::parse($this->date)->format('d-m-Y') : null,
            'waktu_penjangkauan' => (!empty($this->date)) ? Carbon::parse($this->date)->format('H:i') : null,
            'case_type' => $this->case_type,
            'tipe_permaslahan' => $this->jenis_kasus ? [
                'id' => $this->jenis_kasus->kategoriKasus->tipePermasalahan->id ?? null,
                'nama' => $this->jenis_kasus->kategoriKasus->tipePermasalahan->name ?? null,
                'butuh_pelaku' => $this->jenis_kasus->kategoriKasus->tipePermasalahan->butuh_pelaku ?? null,
            ] : null,
            'kategori_kasus' => $this->jenis_kasus ? [
                'id' => $this->jenis_kasus->kategoriKasus->id ?? null,
                'nama' => $this->jenis_kasus->kategoriKasus->name ?? null,
            ] : null,
            'jenis_kasus' => new JenisKasusResource($this->whenLoaded('jenis_kasus')),
            'lokasi_kejadian' => new LokasiKejadianResource($this->whenLoaded('lokasi_kejadian')),
            'case_description' => $this->case_description,
            'tanggal_kejadian' => (!empty($this->case_date)) ? Carbon::parse($this->case_date)->format('d-m-Y') : null,
            'waktu_kejadian' => (!empty($this->case_date)) ? Carbon::parse($this->case_date)->format('H:i') : null,
            'penjangkauan_konselor' => PenjangkauanKonselorResource::collection($this->whenLoaded('penjangkauan_konselor')),

            'draft_status' => $this->draft_status,

            'klien_draft_status' => $this->klien_draft_status,
            'klien_updated_by' => $this->klien->updatedBy->konselor->name ?? null,
            'klien_updated_at' => $this->klien->updated_at ?? null,

            'keluarga_klien_draft_status' => $this->keluarga_klien_draft_status,
            'keluarga_klien_updated_by' => $this->keluargaKlien()->orderBy('updated_at', 'DESC')->first()->updatedBy->konselor->name ?? null,
            'keluarga_klien_updated_at' => $this->keluargaKlien()->orderBy('updated_at', 'DESC')->first()->updated_at ?? null,

            'pelaku_draft_status' => $this->pelaku_draft_status,
            'pelaku_updated_by' => $this->pelaku->updatedBy->konselor->name ?? null,
            'pelaku_updated_at' => $this->pelaku->updated_at ?? null,

            'situasi_keluarga_draft_status' => $this->situasi_keluarga_draft_status,
            'situasi_keluarga_updated_by' => $this->situasiKeluarga->updatedBy->konselor->name ?? null,
            'situasi_keluarga_updated_at' => $this->situasiKeluarga->updated_at ?? null,

            'kronologi_kejadian_draft_status' => $this->kronologi_kejadian_draft_status,
            'kronologi_kejadian_updated_by' => $this->kronologiKejadian->updatedBy->konselor->name ?? null,
            'kronologi_kejadian_updated_at' => $this->kronologiKejadian->updated_at ?? null,

            'harapan_klien_draft_status' => $this->harapan_klien_draft_status,
            'harapan_klien_updated_by' => $this->harapanKlien->updatedBy->konselor->name ?? null,
            'harapan_klien_updated_at' => $this->harapanKlien->updated_at ?? null,

            'kondisi_klien_draft_status' => $this->kondisi_klien_draft_status,
            'kondisi_klien_updated_by' => $this->kondisiKlien->updatedBy->konselor->name ?? null,
            'kondisi_klien_updated_at' => $this->kondisiKlien->updated_at ?? null,

            'analisis_dp3kappkb_draft_status' => $this->analisis_dp3kappkb_draft_status,
            'analisis_dp3kappkb_updated_by' => $this->analisisDp3kappkb()->orderBy('updated_at', 'DESC')->first()->updatedBy->konselor->name ?? null,
            'analisis_dp3kappkb_updated_at' => $this->analisisDp3kappkb()->orderBy('updated_at', 'DESC')->first()->updated_at ?? null,

            'rencana_intervensi_draft_status' => $this->rencana_intervensi_draft_status,
            'rencana_intervensi_updated_by' => $this->rencanaIntervensi()->orderBy('updated_at', 'DESC')->first()->updatedBy->konselor->name ?? null,
            'rencana_intervensi_updated_at' => $this->rencanaIntervensi()->orderBy('updated_at', 'DESC')->first()->updated_at ?? null,

            'langkah_dilakukan_draft_status' => $this->langkah_dilakukan_draft_status,
            'langkah_dilakukan_updated_by' => $this->langkahDilakukan()->orderBy('updated_at', 'DESC')->first()->updatedBy->konselor->name ?? null,
            'langkah_dilakukan_updated_at' => $this->langkahDilakukan()->orderBy('updated_at', 'DESC')->first()->updated_at ?? null,

            'dokumen_pendukung_draft_status' => $this->dokumen_pendukung_draft_status,
            'dokumen_pendukung_updated_by' => $this->dokumenPendukung()->orderBy('updated_at', 'DESC')->first()->updatedBy->konselor->name ?? null,
            'dokumen_pendukung_updated_at' => $this->dokumenPendukung()->orderBy('updated_at', 'DESC')->first()->updated_at ?? null,

            'last_rollback' => $this->penjangkauanRollback->count() ? [
                'id' => $this->penjangkauanRollback->first()->id,
                'description' => $this->penjangkauanRollback->first()->description,
            ] : null,

            'pendampingan' => $this->pendampingan,
            'files' => [
                'surat_pernyataan_tidak_bersedia_didampingi' => new FileResource($this->surat_pernyataan_tidak_bersedia_didampingi),
                'berita_acara_pendampingan' => FileResource::collection($this->berita_acara_pendampingan),
                'surat_pernyataan_klien' => new FileResource($this->surat_pernyataan_klien),
                'surat_pernyataan_selesai_pendampingan' => new FileResource($this->surat_pernyataan_selesai_pendampingan),
            ],
            'saksi1' => $this->saksi1,
            'saksi2' => $this->saksi2,
            'nama_wali' => $this->nama_wali,
            'nomor_telepon_wali' => $this->nomor_telepon_wali,
            'hasil_pendampingan' => $this->hasil_pendampingan,
        ];

        return $result;
    }
}
