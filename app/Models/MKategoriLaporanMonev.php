<?php

namespace App\Models;

use Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MKategoriLaporanMonev extends Model
{
    use HasFactory, SoftDeletes, SoftCascadeTrait;
    protected $table = 'm_kategori_laporan_monev';
    protected $softCascade = [];
    protected $guarded = [
        'created_at', 'updated_at', 'deleted_at'
    ];
    protected $hidden = [
        'created_at', 'updated_at', 'deleted_at'
    ];

    public function sub_kategori()
    {
        return $this->hasMany(MSubKategoriLaporanMonev::class,'id_kategori_laporan_monev','id')->orderBy('m_sub_kategori_laporan_monev.order');
    }
}
