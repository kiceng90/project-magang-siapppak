<?php

namespace App\Models;

use Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class MahasiswaBalaiPuspagaRW extends Model
{
    use HasFactory, SoftDeletes, SoftCascadeTrait;
    protected $table = 'mahasiswa_balai_puspaga_rw';
    protected $softCascade = [];
    protected $guarded = [
        'created_at', 'updated_at', 'deleted_at',
    ];
    protected $hidden = [
        'created_at', 'updated_at', 'deleted_at',
    ];
    public function mahasiswa(){
        return $this->hasMany(DMahasiswa::class,'id','id_mahasiswa');
    }
    public function sample_mahasiswa(){
        return $this->hasOne(DMahasiswa::class,'id','id_mahasiswa');
    }
    public function balai_puspaga(){
        return $this->hasOne(DBalaiPuspagaRW::class,'id','id_balai_puspaga_rw');
    }
    public function konselor(){
        return $this->hasOne(MKonselor::class,'id','id_konselor');
    }
    public function laporan_rapat(){
        return $this->hasMany(LaporanKegiatanRapat::class,'id_mahasiswa_balai_puspaga_rw','id')->with('files');
    }
    public function laporan_konseling(){
        return $this->hasMany(LaporanKegiatanKonseling::class,'id_mahasiswa_balai_puspaga_rw','id')->with('files');
    }
    public function laporan_sosialisasi(){
        return $this->hasMany(LaporanKegiatanSosialisasi::class,'id_mahasiswa_balai_puspaga_rw','id')->with('files');
    }
    
    public function detail_mahasiswa(){
        return $this->hasOne(DMahasiswa::class,'id','id_mahasiswa');
    }
}