<?php

namespace App\Models;

use Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class BukuTamuKebutuhanLayanan extends Model
{
    use HasFactory, Userstamps, SoftDeletes, SoftCascadeTrait;

    protected $table = 'buku_tamu_kebutuhan_layanan';

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


    public function bukuTamu()
    {
        return $this->belongsTo(BukuTamu::class, 'buku_tamu_id');
    }

    public function mKebutuhanLayanan()
    {
        return $this->belongsTo(MKebutuhanLayanan::class, 'm_kebutuhan_layanan_id');
    }
}
