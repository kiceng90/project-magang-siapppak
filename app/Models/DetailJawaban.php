<?php

namespace App\Models;

use Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class DetailJawaban extends Model
{
    use HasFactory, Userstamps, SoftDeletes, SoftCascadeTrait;
    protected $table = 'detail_jawaban';
    protected $softCascade = [];
    protected $guarded = [
        'created_at', 'updated_at', 'deleted_at',
        'created_by', 'updated_by', 'deleted_by',
    ];
    protected $hidden = [
        'created_at', 'updated_at', 'deleted_at',
        'created_by', 'updated_by', 'deleted_by',
    ];

    public function soal()
    {
        return $this->belongsTo(Soal::class, 'id_soal', 'id');
    }

    public function jawaban()
    {
        return $this->belongsTo(Jawaban::class, 'id_jawaban', 'id');
    }

    public function pilihanJawaban()
    {
        return $this->belongsTo(pilihanJawaban::class, 'id_pilihan_jawaban', 'id');
    }
}
