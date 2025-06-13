<?php

namespace App\Models;

use App\Enums\LaporanMonevKuesionerInputTypeEnum;
use Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MKuesionerLaporanMonev extends Model
{
    use HasFactory, SoftDeletes, SoftCascadeTrait;
    protected $table = 'm_kuesioner_laporan_monev';
    protected $appends = ['input_type_string'];
    protected $softCascade = [];
    protected $guarded = [
        'created_at', 'updated_at', 'deleted_at'
    ];
    protected $hidden = [
        'created_at', 'updated_at', 'deleted_at'
    ];

    public function sub_kategori()
    {
        return $this->belongsTo(MSubKategoriLaporanMonev::class,'id_sub_kategori_laporan_monev','id');
    }

    public function getInputTypeStringAttribute()
    {
        return LaporanMonevKuesionerInputTypeEnum::label(intval($this->input_type));
    }

    public function jawaban()
    {
        return $this->hasMany(LaporanMonevJawaban::class, 'id_kuesioner_laporan_monev');
    }
}
