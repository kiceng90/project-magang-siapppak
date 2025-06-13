<?php

namespace App\Models;

use Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MJadwalKonselingDetail extends Model
{
    use HasFactory, SoftDeletes, SoftCascadeTrait;
    protected $table = 'm_jadwal_konseling_detail';
    protected $softCascade = [];
    protected $guarded = [
        'created_at', 'updated_at', 'deleted_at'
    ];
    protected $hidden = [
        'created_at', 'updated_at', 'deleted_at'
    ];
    protected $casts = [
        'start_time' => 'datetime:H:i',
        'end_time' => 'datetime:H:i',
    ];
    protected $appends = [
        'is_booked'
    ];
    public function jadwal(){
        return $this->belongsTo(MJadwalKonseling::class,'id_jadwal_konseling','id');
    }
    public function kategori(){
        return $this->belongsTo(MKategoriKonseling::class,'id_kategori_konseling','id');
    }
    public function konseling()
    {
        return $this->hasMany(Konseling::class, 'id_jadwal_konseling_detail', 'id');
    }
    public function getIsBookedAttribute()
    {
        return $this->konseling()->whereBetween('date', [date('Y-m-d'), Carbon::now()->addDays(6)])->first() == true;
    }
}
