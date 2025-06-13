<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;
use Askedio\SoftCascade\Traits\SoftCascadeTrait;

class AbsensiKelasCatin extends Model
{
    use HasFactory, Userstamps, SoftDeletes, SoftCascadeTrait;

    protected $table = 'absensi_kelas_catins';
    protected $softCascade = [];
    protected $casts = [
        'is_active' => 'boolean',
        'tanggal_lahir' => 'date'
    ];

    protected $guarded = [
        'created_at', 'updated_at', 'deleted_at',
        'created_by', 'updated_by', 'deleted_by',
    ];
    protected $hidden = [
        'created_at', 'updated_at', 'deleted_at',
        'created_by', 'updated_by', 'deleted_by',
    ];

    public function tambahKegiatan()
    {
        return $this->hasMany(TambahKegiatan::class, 'id_absensi_catin');
    }
}
