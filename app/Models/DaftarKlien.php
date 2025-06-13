<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;
use Askedio\SoftCascade\Traits\SoftCascadeTrait;

class DaftarKlien extends Model
{
    use HasFactory, Userstamps, SoftDeletes, SoftCascadeTrait;
    protected $table = 'daftar_klien';
    protected $softCascade = [
        // 'latest_klien_history',
    ];
    protected $guarded = [
        'created_at', 'updated_at', 'deleted_at',
        'created_by', 'updated_by', 'deleted_by',
    ];
    protected $hidden = [
        'created_at', 'updated_at', 'deleted_at',
        'created_by', 'updated_by', 'deleted_by',
    ];

    public static function IdentityNumber($created_at=0, $gender=0, $tanggal_lahir=0, $val=0)
    {
        $number = ''.$gender;
        $number .= $tanggal_lahir ? ''. $tanggal_lahir : '00000000';
        if($created_at){
            $number .= date('Y', $created_at) . date('m', $created_at) . $val;
        }else{
            $number .= date('Y') . date('m') . $val;
        }
        
        if($cek = self::where('identity_number', $number)->first()){
            $val += 1;
            return self::IdentityNumber($created_at, $gender, $tanggal_lahir, $val);
        }
        return $number;
    }

    public function pengaduan()
    {
        return $this->hasMany(Pengaduan::class, 'id_klien', 'id');
    }

    public function kabupaten_tinggal()
    {
        return $this->belongsTo(MKabupaten::class, 'id_kabupaten_tinggal', 'id');
    }
    
    public function kelurahan_tinggal()
    {
        return $this->belongsTo(MKelurahan::class, 'id_kelurahan_tinggal', 'id');
    }

    public function latest_klien_history()
    {
        return $this->hasOne(KlienHistory::class, 'id_daftar_klien', 'id')->latest();
    }

    public function kelurahan()
    {
        return $this->belongsTo(MKelurahan::class, 'id_kelurahan_tinggal');
    }

    public function kabupaten()
    {
        return $this->belongsTo(MKabupaten::class, 'id_kabupaten_tinggal');
    }
}
