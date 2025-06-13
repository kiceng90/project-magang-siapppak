<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;
use Askedio\SoftCascade\Traits\SoftCascadeTrait;

class MRumahPerubahanMateri extends Model
{
    use HasFactory, Userstamps, SoftDeletes, SoftCascadeTrait;

    protected $table = 'm_rumah_perubahan_materi';
    protected $softCascade = [];
    protected $guarded = [
        'created_at',
        'updated_at',
        'deleted_at',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    public function kategori()
    {
        return $this->belongsTo(MRumahPerubahanKategori::class, 'id_kategori', 'id');
    }

    public function soal()
    {
        return $this->hasMany(MRumahPerubahanSoal::class, 'id_materi');
    }

    public function jawaban()
    {
        return $this->hasMany(Jawaban::class, 'id_materi');
    }
}
