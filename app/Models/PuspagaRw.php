<?php

namespace App\Models;

use App\Enums\PuspagaRwFileTypeEnum;
use App\Notifications\DatabaseNotification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Notification;
use Wildside\Userstamps\Userstamps;
use Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Illuminate\Support\Facades\Crypt;

class PuspagaRw extends Model
{
    use HasFactory, Userstamps, SoftDeletes, SoftCascadeTrait;
    protected $table = 'puspaga_rw';
    protected $softCascade = [];
    protected $appends = ['ttd_url'];
    protected $guarded = [
        'created_at', 'updated_at', 'deleted_at',
        'created_by', 'updated_by', 'deleted_by',
    ];
    protected $hidden = [
        'created_at', 'updated_at', 'deleted_at',
        'created_by', 'updated_by', 'deleted_by',
    ];

    public function getFotoAttribute($value)
    {
        if ($value) {
            return route('file.show', ['id' => Crypt::encrypt($value), 'model' => 'PuspagaRwFile']);
        }
        return null;
    }

    public function getKtpLinkAttribute($value)
    {
        if ($value) {
            return route('file.show', ['id' => Crypt::encrypt($value), 'model' => 'PuspagaRwFile']);
        }
        return null;
    }

    public function getTtdUrlAttribute()
    {

        $file = PuspagaRwFile::where('id_puspaga_rw', $this->id)->where('is_image', true)->where('type', PuspagaRwFileTypeEnum::TTD)->first();
        if (empty($file)) {
            return null;
        }
        return route('file.show', ['id' => Crypt::encrypt($file->id), 'model' => 'PuspagaRwFile']);
    }
    public function foto()
    {
        return $this->hasOne(PuspagaRwFile::class, 'id_puspaga_rw', 'id')->where('type', PuspagaRwFileTypeEnum::FOTO)->first();
    }

    public function fileSk()
    {
        return $this->hasMany(PuspagaRwFile::class, 'id_puspaga_rw', 'id')->where('type', PuspagaRwFileTypeEnum::SK);
    }

    public function ktp()
    {
        return $this->hasOne(PuspagaRwFile::class, 'id_puspaga_rw', 'id')->where('type', PuspagaRwFileTypeEnum::KTP);
    }

    public function ttd()
    {
        return $this->hasOne(PuspagaRwFile::class, 'id_puspaga_rw', 'id')->where('type', PuspagaRwFileTypeEnum::TTD);
    }

    public function kelurahan()
    {
        return $this->belongsTo(MKelurahan::class, 'id_kelurahan', 'id');
    }
    public function kelurahan_domisili()
    {
        return $this->belongsTo(MKelurahan::class, 'id_kelurahan_domisili', 'id');
    }
    public function kecamatan()
    {
        return $this->belongsTo(MKecamatan::class, 'id_kelurahan', 'id');
    }
    public function jabatan()
    {
        return $this->hasOne(MJabatanDalamInstansi::class, 'id', 'id_jabatan_dalam_instansi');
    }

    public function laporan_rapat()
    {
        return $this->hasMany(LaporanKegiatanRapat::class, 'id_puspaga_rw', 'id')->with('files');
    }
    public function laporan_konseling()
    {
        return $this->hasMany(LaporanKegiatanKonseling::class, 'id_puspaga_rw', 'id')->with('files');
    }
    public function laporan_sosialisasi()
    {
        return $this->hasMany(LaporanKegiatanSosialisasi::class, 'id_puspaga_rw', 'id')->with('files');
    }
    public function laporan_piket()
    {
        return $this->hasMany(LaporanKegiatanPiket::class, 'id_puspaga_rw', 'id')->with('files');
    }
    public static function boot()
    {
        parent::boot();
        self::created(function ($model) {
            Notification::send(
                User::where('id_role', config('env.role.admin'))->get(),
                new DatabaseNotification([
                    'title' => 'Ada Puspaga RW baru dibuat',
                    'description' => 'User ' . auth()->user()->name . ' menambahkan data puspaga rw baru',
                    'type' => 0,
                    'to' => 'puspaga_rw',
                    'id_puspaga_rw' => $model->id
                ])
            );
        });
    }
}
