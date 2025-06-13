<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;
use Askedio\SoftCascade\Traits\SoftCascadeTrait;

class MBentukKegiatan extends Model
{
    use HasFactory, Userstamps, SoftDeletes, SoftCascadeTrait;

    protected $table = 'm_bentuk_kegiatan';
    protected $softCascade = [];

    protected $guarded = [
        'created_at', 'updated_at', 'deleted_at',
        'created_by', 'updated_by', 'deleted_by',
    ];
    protected $hidden = [
        'created_at', 'updated_at', 'deleted_at',
        'created_by', 'updated_by', 'deleted_by',
    ];

    public function jenisKegiatan()
    {
        return $this->belongsTo(MJenisKegiatan::class, 'id_jenis_kegiatan');
    }

    public function tambahKegiatan()
    {
        return $this->hasMany(MKegiatanPuspaga::class, 'id_bentuk_kegiatan');
    }
}
