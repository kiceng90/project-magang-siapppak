<?php

namespace App\Models;

use App\Enums\LaporanMonevStatusEnum;
use Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LaporanMonev extends Model
{
    use HasFactory, SoftDeletes, SoftCascadeTrait;
    protected $table = 'laporan_monev';
    protected $softCascade = [];
    protected $guarded = [
        'created_at', 'updated_at', 'deleted_at'
    ];
    protected $hidden = [
        'created_at', 'updated_at', 'deleted_at'
    ];
    protected $appends = ['status_string', 'active_string', 'tanggal_monev'];
    
    public function balai_puspaga_rw()
    {
        return $this->hasOne(DBalaiPuspagaRW::class,'id','id_d_balai_puspaga_rw');
    }
    public function jabatan()
    {
        return $this->hasOne(MJabatanDalamInstansi::class,'id','id_jabatan_dalam_instansi');
    }
    public function jawaban()
    {
        return $this->hasMany(LaporanMonevJawaban::class,'id_laporan_monev','id');
    }
    public function konselor()
    {
        return $this->hasOne(MKonselor::class,'id','id_konselor');
    }
    public function getStatusStringAttribute()
    {
        return LaporanMonevStatusEnum::label($this->status);
    }
    public function getActiveStringAttribute(){
        if($this->is_active){
            return "Aktif";
        }
        else{
            return "Tidak Aktif";
        }
    }
    
    public function getTanggalMonevAttribute(){
        return Carbon::parse($this->date)->translatedFormat('Y-m-d');
    }
}
