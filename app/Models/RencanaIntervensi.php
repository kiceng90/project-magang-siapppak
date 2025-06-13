<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;
use Askedio\SoftCascade\Traits\SoftCascadeTrait;

class RencanaIntervensi extends Model
{
    use HasFactory, Userstamps, SoftDeletes, SoftCascadeTrait;
    protected $table = 'rencana_intervensi';
    protected $guarded = [
        'created_at', 'updated_at', 'deleted_at',
        'created_by', 'updated_by', 'deleted_by',
    ];
    protected $hidden = [
        'created_at', 'updated_at', 'deleted_at',
        'created_by', 'updated_by', 'deleted_by',
    ];

    public function kebutuhan()
    {
        return $this->belongsTo(MKebutuhan::class, 'id_kebutuhan', 'id');
    }

    public function opd()
    {
        return $this->belongsTo(MOpd::class, 'id_opd', 'id');
    }

    public function intervensi()
    {
        return $this->belongsTo(MIntervensi::class, 'id_intervensi', 'id');
    }

    public function rencana_intervensi_file()
    {
        return $this->hasMany(RencanaIntervensiFile::class, 'id_rencana_intervensi', 'id');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }

    public function penjangkauan()
    {
        return $this->belongsTo(Penjangkauan::class, 'id_penjangkauan', 'id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function realisasiIntervensi()
    {
        return $this->hasMany(RealisasiIntervensi::class,'id_rencana_intervensi', 'id');
    }
}
