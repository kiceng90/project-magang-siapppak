<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;
use Askedio\SoftCascade\Traits\SoftCascadeTrait;

class RealisasiIntervensi extends Model
{
   use HasFactory, Userstamps, SoftDeletes, SoftCascadeTrait;
    protected $table = 'realisasi_intervensi';
    protected $guarded = [
        'created_at', 'updated_at', 'deleted_at',
        'created_by', 'updated_by', 'deleted_by',
    ];
    protected $hidden = [
        // 'created_at', 'updated_at', 'deleted_at',
        'created_by', 'updated_by', 'deleted_by',
    ];

    public function rencana_intervensi()
    {
        return $this->belongsTo(RencanaIntervensi::class, 'id_rencana_intervensi', 'id');
    }

    public function realisasi_intervensi_file()
    {
        return $this->hasMany(RealisasiIntervensiFile::class, 'id_realisasi_intervensi', 'id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }
}
