<?php

namespace App\Models;

use Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class RumahPerubahanJawaban extends Model
{
    use HasFactory, Userstamps, SoftDeletes, SoftCascadeTrait;
    protected $table = 'rumah_perubahan_jawaban';
    protected $fillable = [
        'nama',
        'nik',
        'id_kabupaten',
        'id_kecamatan',
        'id_kelurahan',
        'alamat',
        'no_telepon'    
    ];
    protected $softCascade = [];
    protected $guarded = [
        'created_at', 'updated_at', 'deleted_at',
        'created_by', 'updated_by', 'deleted_by',
    ];
    protected $hidden = [
        'updated_at', 'deleted_at',
        'created_by', 'updated_by', 'deleted_by',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }

    public function materi()
    {
        return $this->belongsTo(MRumahPerubahanMateri::class, 'id_materi', 'id');
    }
    // Relationship with Kabupaten
    public function kabupaten()
    {
        return $this->belongsTo(MKabupaten::class, 'id_kabupaten', 'id');
    }

    // Relationship with Kecamatan
    public function kecamatan()
    {
        return $this->belongsTo(MKecamatan::class, 'id_kecamatan', 'id');
    }

    // Relationship with Kelurahan
    public function kelurahan()
    {
        return $this->belongsTo(MKelurahan::class, 'id_kelurahan', 'id');
    }
}
