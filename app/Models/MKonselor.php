<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;
use Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Illuminate\Support\Facades\Crypt;

class MKonselor extends Model
{
    use HasFactory, Userstamps, SoftDeletes, SoftCascadeTrait;
    protected $table = 'm_konselor';
    protected $softCascade = [];
    protected $guarded = [
        'created_at', 'updated_at', 'deleted_at',
        'created_by', 'updated_by', 'deleted_by',
    ];
    protected $hidden = [
        'created_at', 'updated_at', 'deleted_at',
        'created_by', 'updated_by', 'deleted_by',
    ];
    protected $appends = [
        'foto', 'consultant_type'
    ];

    public function getFotoAttribute($value)
    {
        if($value){
            return route('file.show', ['id' => Crypt::encrypt($value), 'model' => 'MKonselorFile']);
        }
        else if($this->photo){
            return route('file.show', ['id' => Crypt::encrypt($this->photo->id), 'model' => 'MKonselorFile']);
        }
        return null;
    }

    public function photo()
    {
        return $this->hasOne(MKonselorFile::class, 'id_m_konselor', 'id');
    }

    public function penjangkauan()
    {
        return $this->belongsToMany(Penjangkauan::class, 'penjangkauan_konselor', 'id_konselor', 'id_penjangkauan');
    }

    public function jadwal()
    {
        return $this->hasMany(MJadwalKonseling::class, 'id_konselor')->orderBy('m_jadwal_konseling.day', 'ASC');
    }

    public function jadwalActive()
    {
        return $this->hasMany(MJadwalKonseling::class, 'id_konselor')->where('m_jadwal_konseling.is_active', true)->orderBy('m_jadwal_konseling.day', 'ASC');
    }
    public function dkonselor(){
        return $this->hasOne(DKonselor::class,'id_m_konselor','id');
    }
    public function getConsultantTypeAttribute()
    {
        return "Konselor";
    }
}
