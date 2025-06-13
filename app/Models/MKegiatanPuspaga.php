<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;
use Askedio\SoftCascade\Traits\SoftCascadeTrait;

class MKegiatanPuspaga extends Model
{
    use HasFactory, Userstamps, SoftDeletes, SoftCascadeTrait;

    protected $table = 'm_kegiatan_puspaga';
    protected $softCascade = [];

    protected $guarded = [
        'created_at', 'updated_at', 'deleted_at',
        'created_by', 'updated_by', 'deleted_by',
    ];
    protected $hidden = [
        'created_at', 'updated_at', 'deleted_at',
        'created_by', 'updated_by', 'deleted_by',
    ];

    public function programKegiatan()
    {
        return $this->belongsTo(MProgramKegiatan::class, 'id_program_kegiatan');
    }

    public function jenisKegiatan()
    {
        return $this->belongsTo(MJenisKegiatan::class, 'id_jenis_kegiatan');
    }

    public function bentukKegiatan()
    {
        return $this->belongsTo(MBentukKegiatan::class, 'id_bentuk_kegiatan');
    }
}
