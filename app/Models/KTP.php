<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KTP extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'nik',
        'nama',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'alamat_ktp',
        'rt_ktp',
        'rw_ktp',
        'kel_desa_ktp',
        'kecamatan_ktp',
        'kota_kabupaten_ktp',
        'provinsi',
        'agama',
        'status_perkawinan',
        'pekerjaan',
        'kewarganegaraan',
        'image_path',
        'raw_data',
    ];
    
    protected $casts = [
        'tanggal_lahir' => 'date',
        'raw_data' => 'array',
    ];
}