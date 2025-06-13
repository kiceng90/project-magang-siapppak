<?php

namespace App\Models;

use App\Enums\JenisMahasiswaStatusEnum;
use Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class MJenisMahasiswa extends Model
{
    use HasFactory, SoftDeletes, SoftCascadeTrait;
    protected $table = 'm_jenis_mahasiswa';
    protected $softCascade = [];
    protected $guarded = [
        'created_at', 'updated_at', 'deleted_at',
    ];
    protected $hidden = [
        'created_at', 'updated_at', 'deleted_at',
    ];
    public function mahasiswa(){
        return $this->hasMany(DMahasiswa::class,'id_jenis_mahasiswa','id');
    }
}
