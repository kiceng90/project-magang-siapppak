<?php

namespace App\Models;

use Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class RumahPerubahanDetailJawaban extends Model
{
    use HasFactory, Userstamps, SoftDeletes, SoftCascadeTrait;
    protected $table = 'rumah_perubahan_detail_jawaban';
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
        return $this->belongsTo(MRumahPerubahanSoal::class, 'id_soal', 'id');
    }

    public function jawaban()
    {
        return $this->belongsTo(RumahPerubahanJawaban::class, 'id_jawaban', 'id');
    }

    public function pilihanJawaban()
    {
        return $this->belongsTo(RumahPerubahanPilihanJawaban::class, 'id_pilihan_jawaban', 'id');
    }
}
