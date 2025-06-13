<?php

namespace App\Models;

use Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DBalaiPuspagaRW extends Model
{
    use HasFactory, SoftDeletes, SoftCascadeTrait;
    
    protected $table = 'd_balai_puspaga_rw';
    protected $appends = [];
    protected $softCascade = [];
    protected $guarded = [
        'created_at', 'updated_at', 'deleted_at'
    ];
    protected $hidden = [
        'created_at', 'updated_at', 'deleted_at'
    ];

    public function konselor(){
        return $this->hasOne(MKonselor::class,'id','id_konselor');
    }

    public function wilayah(){
        return $this->hasOne(MWilayah::class,'id','id_wilayah');
    }

    public function kelurahan(){
        return $this->hasOne(MKelurahan::class,'id','id_kelurahan');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
