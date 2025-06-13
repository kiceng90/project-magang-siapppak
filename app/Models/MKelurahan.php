<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;
use Askedio\SoftCascade\Traits\SoftCascadeTrait;

class MKelurahan extends Model
{
    use HasFactory, Userstamps, SoftDeletes, SoftCascadeTrait;
    protected $table = 'm_kelurahan';
    protected $softCascade = [];
    protected $guarded = [
        'created_at', 'updated_at', 'deleted_at',
        'created_by', 'updated_by', 'deleted_by',
    ];
    protected $hidden = [
        'created_at', 'updated_at', 'deleted_at',
        'created_by', 'updated_by', 'deleted_by',
    ];

    public function kecamatan()
    {
        return $this->belongsTo(MKecamatan::class, 'id_kecamatan', 'id');
    }

    public function puspagaRw()
    {
        return $this->hasMany(PuspagaRw::class, 'id_kelurahan_domisili', 'id');
    }

    public function puspagaRwLembaga()
    {
        return $this->hasMany(PuspagaRw::class, 'id_kelurahan', 'id');
    }

    public function psikologVolunteer()
    {
        return $this->hasMany(PsikologVolunteer::class, 'id_kelurahan_domisili', 'id');
    }

    public function pkbm()
    {
        return $this->hasMany(Pkbm::class, 'id_kelurahan_domisili', 'id');
    }

    public function satgasPpa()
    {
        return $this->hasMany(SatgasPpa::class, 'id_kelurahan_domisili', 'id');
    }

    public function satgasPpaCreator()
    {
        return $this->hasMany(SatgasPpa::class, 'id_kelurahan', 'id');
    }

    public function dKonselor()
    {
        return $this->hasMany(DKonselor::class, 'id_kelurahan_domisili', 'id');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id_kelurahan', 'id');
    }
}
