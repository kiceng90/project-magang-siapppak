<?php

namespace App\Models;

use Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MKategoriMitra extends Model
{
    use HasFactory, SoftDeletes, SoftCascadeTrait;
    protected $table = 'm_kategori_mitra';
    protected $softCascade = [];
    protected $guarded = [
        'created_at', 'updated_at', 'deleted_at'
    ];
    protected $hidden = [
        'created_at', 'updated_at', 'deleted_at'
    ];

    public function mitra(){
        return $this->hasMany(Mitra::class, 'id_kategori_mitra', 'id');
    }
}
