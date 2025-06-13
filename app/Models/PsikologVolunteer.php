<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;
use Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Illuminate\Support\Facades\Crypt;

class PsikologVolunteer extends Model
{
    use HasFactory, Userstamps, SoftDeletes, SoftCascadeTrait;
    protected $table = 'psikolog_volunteer';
    protected $softCascade = [];
    protected $guarded = [
        'id',
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
            return route('file.show', ['id' => Crypt::encrypt($value), 'model' => 'PsikologVolunteerFile']);
        }
        return null;
    }    

    public function fotoFile()
    {
        return $this->hasOne(PsikologVolunteerFile::class, 'id_psikolog_volunteer', 'id');
    }

    public function jadwal()
    {
        return $this->hasMany(MJadwalKonseling::class, 'id_psikolog_volunteer')->orderBy('m_jadwal_konseling.day', 'ASC');
    }

    public function jadwalActive()
    {
        return $this->hasMany(MJadwalKonseling::class, 'id_psikolog_volunteer')->where('m_jadwal_konseling.is_active', true);
    }

    public function getConsultantTypeAttribute()
    {
        return "Psikolog";
    }

    public function konseling()
    {
        return $this->hasMany(Konseling::class, 'id_psikolog_volunteer', 'id');
    }
}
