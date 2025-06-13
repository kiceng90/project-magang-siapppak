<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;
use Askedio\SoftCascade\Traits\SoftCascadeTrait;

class MKategoriKasus extends Model
{
    use HasFactory, Userstamps, SoftDeletes, SoftCascadeTrait;
    protected $table = 'm_kategori_kasus';
    protected $softCascade = [
        'jenisKasus',
    ];
    protected $guarded = [
        'created_at', 'updated_at', 'deleted_at',
        'created_by', 'updated_by', 'deleted_by',
    ];
    protected $hidden = [
        'created_at', 'updated_at', 'deleted_at',
        'created_by', 'updated_by', 'deleted_by',
    ];

    public function tipePermasalahan()
    {
        return $this->belongsTo(MTipePermasalahan::class, 'id_tipe_permasalahan', 'id');
    }

    public function jenisKasus()
    {
        return $this->hasMany(MJenisKasus::class, 'id_kategori_kasus', 'id');
    }
}
