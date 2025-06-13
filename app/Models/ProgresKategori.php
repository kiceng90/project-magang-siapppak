<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Wildside\Userstamps\Userstamps;

class ProgresKategori extends Model
{
    use HasFactory, Userstamps;

    protected $table = 'progres_kategori';

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
        'created_by',
        'updated_by',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'created_by',
        'updated_by',
    ];

    public function progresSubkategori()
    {
        return $this->hasMany(ProgresSubkategori::class, 'id_kategori');
    }
}
