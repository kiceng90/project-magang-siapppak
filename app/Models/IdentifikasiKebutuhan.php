<?php

namespace App\Models;

use Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class IdentifikasiKebutuhan extends Model
{
    use HasFactory, Userstamps, SoftDeletes, SoftCascadeTrait;

    protected $table = 'identifikasi_kebutuhans';

    protected $guarded = [
        'created_at',
        'updated_at',
        'deleted_at',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected $casts = [
        'tanggal_identifikasi' => 'date',
        'dukungan_psikologis_awal' => 'boolean',
        'disposisi_pimpinan' => 'boolean',
        'layanan_dibutuhkan' => 'array',    
    ];

    public function bukuTamu()
    {
        return $this->belongsTo(BukuTamu::class, 'buku_tamu_id');
    }
}
