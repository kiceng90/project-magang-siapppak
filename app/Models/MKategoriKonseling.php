<?php

namespace App\Models;

use Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MKategoriKonseling extends Model
{    
    use HasFactory, SoftDeletes, SoftCascadeTrait;
    protected $table = 'm_kategori_konseling';
    protected $softCascade = [];
    protected $guarded = [
        'created_at', 'updated_at', 'deleted_at'
    ];
    protected $hidden = [
        'created_at', 'updated_at', 'deleted_at'
    ];

    public function jadwal(){
        return $this->hasMany(MJadwalKonselingDetail::class,'id_kategori_konseling','id')->with('jadwal');
    }
}
