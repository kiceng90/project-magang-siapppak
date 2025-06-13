<?php

namespace App\Models;

use App\Enums\DayEnum;
use Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MJadwalKonseling extends Model
{   
    use HasFactory, SoftDeletes, SoftCascadeTrait;
    protected $table = 'm_jadwal_konseling';
    protected $appends = ['day_string'];
    protected $softCascade = [];
    protected $guarded = [
        'created_at', 'updated_at', 'deleted_at'
    ];
    protected $hidden = [
        'created_at', 'updated_at', 'deleted_at'
    ];
    protected $append = [
        'day_string'
    ];

    public function getDayStringAttribute(){
        return DayEnum::label(intval($this->day));
    }

    public function konselor(){
        return $this->belongsTo(MKonselor::class,'id_konselor','id');
    }

    public function psikolog(){
        return $this->belongsTo(PsikologVolunteer::class,'id_psikolog_volunteer','id');
    }

    public function jadwalDetail(){
        return $this->hasMany(MJadwalKonselingDetail::class,'id_jadwal_konseling','id')->with('kategori');
    }

    public function jadwalDetailActive(){
        return $this->hasMany(MJadwalKonselingDetail::class,'id_jadwal_konseling','id')->where('m_jadwal_konseling.is_active', true)->with('kategori');
    }
}
