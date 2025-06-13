<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Wildside\Userstamps\Userstamps;

class ProgresSubkategori extends Model
{
    use HasFactory, Userstamps;

    protected $table = 'progres_subkategori';

    // Gunakan guarded atau fillable, pilih salah satu
    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
        'created_by',
        'updated_by',
    ];

    // Properti yang disembunyikan saat serialisasi
    protected $hidden = [
        'created_at',
        'created_by',
        'updated_by',
    ];

    // Properti yang dikonversi tipe data
    protected $casts = [
        'is_completed' => 'boolean',
    ];

    /**
     * Relasi ke model SubKategori
     */
    public function subKategori()
    {
        return $this->belongsTo(SubKategori::class, 'id_sub_kategori');
    }

    /**
     * Relasi ke model User
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
