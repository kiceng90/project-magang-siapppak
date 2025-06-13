<?php

namespace App\Models;

use App\Enums\LaporanKegiatanCreatorType;
use App\Enums\LaporanKegiatanFileSourceEnum;
use App\Enums\LaporanKegiatanFileTypeEnum;
use App\Enums\LaporanKegiatanKonselingTypeEnum;
use Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Crypt;

class LaporanKegiatan extends Model
{
    use HasFactory, SoftDeletes, SoftCascadeTrait;
    protected $table = 'laporan_kegiatan';
    protected $softCascade = [];
    protected $appends = ['tanggal_kegiatan'];
    protected $guarded = [
        'created_at', 'updated_at', 'deleted_at',
    ];
    protected $casts = [];
    protected $hidden = [
        'created_at', 'updated_at', 'deleted_at',
    ];

    public function laporan_sosialisasi()
    {
        return $this->hasOne(LaporanKegiatanSosialisasi::class, 'id_laporan_kegiatan', 'id');
    }
    public function laporan_rapat()
    {
        return $this->hasOne(LaporanKegiatanRapat::class, 'id_laporan_kegiatan', 'id');
    }
    public function laporan_konseling()
    {
        return $this->hasOne(LaporanKegiatanKonseling::class, 'id_laporan_kegiatan', 'id');
    }
    public function laporan_piket()
    {
        return $this->hasOne(LaporanKegiatanPiket::class, 'id_laporan_kegiatan', 'id');
    }
    public function laporan_kegiatan_publikasi_k_i_e()
    {
        return $this->hasOne(LaporanKegiatanPublikasiKIE::class, 'id_laporan_kegiatan', 'id');
    }
    public function getCreatorAttribute()
    {
        if ($this->creator_type == LaporanKegiatanCreatorType::MAHASISWA) {
            return MahasiswaBalaiPuspagaRW::where('id', $this->id_creator)
                ->with(
                    'sample_mahasiswa.jenis_mahasiswa',
                    'sample_mahasiswa.pendidikan_terakhir',
                    'sample_mahasiswa.instansi_pendidikan',
                    'sample_mahasiswa.jurusan',
                    'balai_puspaga.kelurahan.kecamatan.kabupaten',
                    'konselor'
                )->first();
        }
        if ($this->creator_type == LaporanKegiatanCreatorType::FASILITATOR) {
            return PuspagaRw::where('id', $this->id_creator)
                ->with(
                    'ttd',
                    'jabatan',
                    'kelurahan.kecamatan.kabupaten',
                    'kelurahan_domisili.kecamatan'
                )->first();
        }
    }
    public function mahasiswa()
    {
        return $this->belongsTo(MahasiswaBalaiPuspagaRW::class, 'id_creator', 'id');
    }
    public function fasilitator()
    {
        return $this->belongsTo(PuspagaRw::class, 'id_creator', 'id');
    }
    public function getTanggalKegiatanAttribute()
    {
        return Carbon::parse($this->date)->translatedFormat('Y-m-d');
    }
}
