<?php

namespace App\Models;

use Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Wildside\Userstamps\Userstamps;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable, Userstamps, SoftDeletes, SoftCascadeTrait;

    protected $table = 'm_user';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_role', 'id_konselor', 'id_psikolog_volunteer', 'name',
        'username', 'email', 'password',
        'is_active', 'id_opd', 'id_kelurahan',
        'id_kecamatan', 'id_fasilitator', 'id_mahasiswa'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
        'created_at', 'updated_at', 'deleted_at',
        'created_by', 'updated_by', 'deleted_by',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function opd()
    {
        return $this->belongsTo(MOpd::class, 'id_opd', 'id');
    }

    public function konselor()
    {
        return $this->belongsTo(MKonselor::class, 'id_konselor', 'id');
    }

    public function satgasPpa()
    {
        return $this->hasMany(SatgasPpa::class, 'created_by', 'id');
    }

    public function pkbm()
    {
        return $this->hasMany(Pkbm::class, 'created_by', 'id');
    }

    public function puspagaRw()
    {
        return $this->hasMany(PuspagaRw::class, 'created_by', 'id');
    }

    public function mahasiswa()
    {
        return $this->belongsTo(DMahasiswa::class, 'id_mahasiswa', 'id');
    }

    public function role()
    {
        return $this->belongsTo(MRole::class, 'id_role', 'id');
    }

    public function klienKonseling()
    {
        return $this->hasOne(DKlienKonseling::class, 'id_user', 'id');  // Menyesuaikan dengan nama relasi dan kolom yang ada
    }

}
