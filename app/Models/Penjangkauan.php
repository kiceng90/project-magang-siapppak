<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;
use Askedio\SoftCascade\Traits\SoftCascadeTrait;

class Penjangkauan extends Model
{
    use HasFactory, Userstamps, SoftDeletes, SoftCascadeTrait;
    protected $table = 'penjangkauan';
    protected $softCascade = [];
    protected $guarded = [
        'created_at', 'updated_at', 'deleted_at',
        'created_by', 'updated_by', 'deleted_by',
    ];
    protected $hidden = [
        'created_at', 'updated_at', 'deleted_at',
        'created_by', 'updated_by', 'deleted_by',
    ];

    public function pengaduan()
    {
        return $this->belongsTo(Pengaduan::class, 'id_pengaduan', 'id');
    }

    public function jenis_kasus()
    {
        return $this->belongsTo(MJenisKasus::class, 'id_jenis_kasus', 'id');
    }

    public function lokasi_kejadian()
    {
        return $this->belongsTo(MLokasiKejadian::class, 'id_lokasi_kejadian', 'id');
    }

    public function penjangkauan_konselor()
    {
        return $this->hasMany(PenjangkauanKonselor::class, 'id_penjangkauan', 'id');
    }

    public function konselor()
    {
        return $this->belongsToMany(MKonselor::class, 'penjangkauan_konselor', 'id_penjangkauan', 'id_konselor');
    }

    public function dokumenPendukung()
    {
        return $this->hasMany(DokumenPendukung::class, 'id_penjangkauan', 'id')->orderBy('id', 'DESC');
    }

    public function rencanaIntervensi()
    {
        return $this->hasMany(RencanaIntervensi::class, 'id_penjangkauan', 'id')->orderBy('id', 'DESC');
    }

    public function klien()
    {
        return $this->hasOne(Klien::class, 'id_penjangkauan', 'id');
    }

    public function pelaku()
    {
        return $this->hasOne(Pelaku::class, 'id_penjangkauan', 'id');
    }

    public function keluargaKlien()
    {
        return $this->hasMany(KeluargaKlien::class, 'id_penjangkauan', 'id')->orderBy('id', 'DESC');
    }

    public function saudaraKlien()
    {
        return $this->hasMany(SaudaraKlien::class, 'id_penjangkauan', 'id')->orderBy('child_order', 'ASC');
    }

    public function situasiKeluarga()
    {
        return $this->hasOne(SituasiKeluarga::class, 'id_penjangkauan', 'id');
    }

    public function kronologiKejadian()
    {
        return $this->hasOne(KronologiKejadian::class, 'id_penjangkauan');
    }

    public function harapanKlien()
    {
        return $this->hasOne(HarapanKlien::class, 'id_penjangkauan');
    }

    public function kondisiKlien()
    {
        return $this->hasOne(KondisiKlien::class, 'id_penjangkauan');
    }

    public function analisisDp3kappkb()
    {
        return $this->hasMany(AnalisisDp3kappkb::class, 'id_penjangkauan')->orderBy('id', 'DESC');
    }

    public function langkahDilakukan()
    {
        return $this->hasMany(LangkahDilakukan::class, 'id_penjangkauan')->orderBy('service_date', 'DESC');
    }

    public function penjangkauanRollback()
    {
        return $this->hasMany(PenjangkauanRollback::class, 'id_penjangkauan', 'id')->orderBy('created_at', 'DESC');
    }

    public function surat_pernyataan_tidak_bersedia_didampingi()
    {
        return $this->hasOne(PenjangkauanFile::class, 'id_penjangkauan')->where('type', 1);
    }

    public function berita_acara_pendampingan()
    {
        return $this->hasMany(PenjangkauanFile::class, 'id_penjangkauan')->where('type', 2);
    }

    public function surat_pernyataan_klien()
    {
        return $this->hasOne(PenjangkauanFile::class, 'id_penjangkauan')->where('type', 3);
    }

    public function surat_pernyataan_selesai_pendampingan()
    {
        return $this->hasOne(PenjangkauanFile::class, 'id_penjangkauan')->where('type', 4);
    }
}
