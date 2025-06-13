<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Askedio\SoftCascade\Traits\SoftCascadeTrait;

class PenjangkauanKonselor extends Model
{
    use HasFactory, SoftCascadeTrait;
    protected $table = 'penjangkauan_konselor';
    protected $softCascade = [];
    protected $guarded = [
        'created_at', 'updated_at', 
    ];
    protected $hidden = [
        'created_at', 'updated_at',
    ];

    public function konselor()
    {
        return $this->belongsTo(MKonselor::class, 'id_konselor', 'id');
    }
}
