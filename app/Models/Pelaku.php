<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;
use Askedio\SoftCascade\Traits\SoftCascadeTrait;
use App\Http\Controllers\Controller;

class Pelaku extends Model
{
    use HasFactory, Userstamps, SoftDeletes, SoftCascadeTrait;
    protected $table = 'pelaku';
    protected $softCascade = [];
    protected $guarded = [
        'created_at', 'updated_at', 'deleted_at',
        'created_by', 'updated_by', 'deleted_by',
    ];
    protected $hidden = [
        'created_at', 'updated_at', 'deleted_at',
        'created_by', 'updated_by', 'deleted_by',
    ];

    public function hubungan()
    {
        return $this->belongsTo(MHubungan::class, 'id_hubungan', 'id');
    }

    public function kabupatenLahir()
    {
        return $this->belongsTo(MKabupaten::class, 'id_kabupaten_lahir', 'id');
    }

    public function kelurahanTinggal()
    {
        return $this->belongsTo(MKelurahan::class, 'id_kelurahan_tinggal', 'id');
    }

    public function kelurahanKK()
    {
        return $this->belongsTo(MKelurahan::class, 'id_kelurahan_kk', 'id');
    }

    public function agama()
    {
        return $this->belongsTo(MAgama::class, 'id_agama', 'id');
    }

    public function pekerjaan()
    {
        return $this->belongsTo(MPekerjaan::class, 'id_pekerjaan', 'id');
    }

    public function statusPernikahan()
    {
        return $this->belongsTo(MStatusPernikahan::class, 'id_status_pernikahan', 'id');
    }

    public function pendidikanTerakhir()
    {
        return $this->belongsTo(MPendidikanTerakhir::class, 'id_pendidikan_terakhir', 'id');
    }

    public function jurusan()
    {
        return $this->belongsTo(MJurusan::class, 'id_jurusan', 'id');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }
}
