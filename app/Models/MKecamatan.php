<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;
use Askedio\SoftCascade\Traits\SoftCascadeTrait;

class MKecamatan extends Model
{
    use HasFactory, Userstamps, SoftDeletes, SoftCascadeTrait;
    protected $table = 'm_kecamatan';
    protected $softCascade = [
        'kelurahan',
    ];
    protected $guarded = [
        'created_at', 'updated_at', 'deleted_at',
        'created_by', 'updated_by', 'deleted_by',
    ];
    protected $hidden = [
        'created_at', 'updated_at', 'deleted_at',
        'created_by', 'updated_by', 'deleted_by',
    ];

    public function kabupaten()
    {
        return $this->belongsTo(MKabupaten::class, 'id_kabupaten', 'id');
    }

    public function wilayah()
    {
        return $this->belongsTo(MWilayah::class, 'id_wilayah', 'id');
    }

    public function kelurahan()
    {
        return $this->hasMany(Mkelurahan::class, 'id_kecamatan', 'id');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id_kecamatan', 'id');
    }

    public function pkbm()
    {
        return $this->hasOne(Pkbm::class, 'id_kecamatan', 'id');
    }

    public function puspagaRw()
    {
        return $this->hasMany(PuspagaRw::class, 'id_kecamatan', 'id');
    }
}
