<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Wildside\Userstamps\Userstamps;

class Sertifikat extends Model
{
    use HasFactory, Userstamps;

    protected $table = 'sertifikat';

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
        return $this->belongsTo(ProgresSubkategori::class, 'id_sub_kategori');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
