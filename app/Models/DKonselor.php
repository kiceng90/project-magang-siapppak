<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;
use Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Illuminate\Support\Facades\Crypt;

class DKonselor extends Model
{
    use HasFactory, Userstamps, SoftDeletes, SoftCascadeTrait;
    protected $table = 'd_konselor';
    protected $softCascade = [];
    protected $guarded = [
        'id',
        'created_at', 'updated_at', 'deleted_at',
        'created_by', 'updated_by', 'deleted_by',
    ];
    protected $hidden = [
        'created_at', 'updated_at', 'deleted_at',
        'created_by', 'updated_by', 'deleted_by',
    ];

    public function getFotoAttribute($value)
    {
        if($value){
            return route('file.show', ['id' => Crypt::encrypt($value), 'model' => 'DKonselorFile']);
        }
        return null;
    }

    public function mKonselor()
    {
        return $this->belongsTo(MKonselor::class, 'id_m_konselor');
    }

    public function fotoFile()
    {
        return $this->hasOne(DKonselorFile::class, 'id_d_konselor', 'id');
    }
}
