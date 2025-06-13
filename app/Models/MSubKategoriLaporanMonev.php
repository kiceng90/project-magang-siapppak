<?php

namespace App\Models;

use Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MSubKategoriLaporanMonev extends Model
{
    use HasFactory, SoftDeletes, SoftCascadeTrait;
    protected $table = 'm_sub_kategori_laporan_monev';
    protected $softCascade = [];
    protected $guarded = [
        'created_at', 'updated_at', 'deleted_at'
    ];
    protected $hidden = [
        'created_at', 'updated_at', 'deleted_at'
    ];

    public function kategori()
    {
        return $this->belongsTo(MKategoriLaporanMonev::class,'id_kategori_laporan_monev','id');
    }

    public function kuesioner()
    {
        return $this->hasMany(MKuesionerLaporanMonev::class,'id_sub_kategori_laporan_monev','id')->orderBy('m_kuesioner_laporan_monev.order');
    }
}
