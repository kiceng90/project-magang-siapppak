<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;
use Askedio\SoftCascade\Traits\SoftCascadeTrait;

class BukuTamu extends Model
{
    use HasFactory, Userstamps, SoftDeletes, SoftCascadeTrait;

    protected $table = 'buku_tamu';
    protected $softCascade = [];
    protected $guarded = [
        'created_at',
        'updated_at',
        'deleted_at',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected $hidden = [
        'updated_at',
        'deleted_at',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    public function mKebutuhanLayanan()
    {
        return $this->belongsToMany(
            MKebutuhanLayanan::class,
            'buku_tamu_kebutuhan_layanan',
            'buku_tamu_id',
            'm_kebutuhan_layanan_id'
        )->withPivot('is_filled')->withTimestamps();
    }

    public function formRujukans()
    {
        return $this->hasMany(FormRujukan::class, 'buku_tamu_kebutuhan_layanan_id');
    }

    public function identifikasiKebutuhan()
    {
        return $this->hasMany(identifikasiKebutuhan::class, 'buku_tamu_id');
    }
}
