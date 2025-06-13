<?php

namespace App\Models;

use App\Enums\LaporanKegiatanFileSourceEnum;
use App\Enums\LaporanKegiatanFileTypeEnum;
use Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Crypt;
use Wildside\Userstamps\Userstamps;

class LaporanKegiatanRapat extends Model
{
    use HasFactory, SoftDeletes, SoftCascadeTrait;
    protected $table = 'laporan_kegiatan_rapat';
    protected $softCascade = [];
    protected $appends = ['tanggal_kegiatan','foto_url','materi_url'];
    protected $guarded = [
        'created_at', 'updated_at', 'deleted_at',
    ];
    protected $casts = [
        
    ];
    protected $hidden = [
        'created_at', 'updated_at', 'deleted_at',
    ];
    public function getTanggalKegiatanAttribute(){
        return Carbon::parse($this->date)->translatedFormat('d F Y');
    }
    public function mahasiswa(){
        return $this->belongsTo(MahasiswaBalaiPuspagaRW::class,'id_mahasiswa_balai_puspaga_rw','id');
    }
    public function fasilitator(){
        return $this->belongsTo(PuspagaRw::class,'id_puspaga_rw','id');
    }
    public function kelurahan(){
        return $this->hasOne(MKelurahan::class,'id','id_kelurahan');
    }
    public function files(){
        return $this->hasMany(LaporanKegiatanFile::class,'id_source','id')->where('source',LaporanKegiatanFileSourceEnum::RAPAT);
    }
    public function file_foto(){
        return $this->hasOne(LaporanKegiatanFile::class,'id_source','id')->where('source',LaporanKegiatanFileSourceEnum::RAPAT)->where('type',LaporanKegiatanFileTypeEnum::FOTO);
    }
    public function file_materi(){
        return $this->hasOne(LaporanKegiatanFile::class,'id_source','id')->where('source',LaporanKegiatanFileSourceEnum::RAPAT)->where('type',LaporanKegiatanFileTypeEnum::MATERI);
    }
    public function getFotoUrlAttribute(){
        
        $file = LaporanKegiatanFile::where('id_source',$this->id)->where('source',LaporanKegiatanFileSourceEnum::RAPAT)->where('is_image',true)->where('type',LaporanKegiatanFileTypeEnum::FOTO)->first();
        if(empty($file)){
            return null;
        }
        return route('file.show', ['id' => Crypt::encrypt($file->id), 'model' => 'LaporanKegiatanFile']);
    }
    public function getMateriUrlAttribute(){
        $file = LaporanKegiatanFile::where('id_source',$this->id)->where('source',LaporanKegiatanFileSourceEnum::RAPAT)->where('type',LaporanKegiatanFileTypeEnum::MATERI)->first();
        if(empty($file)){
            return null;
        }
        return route('file.show', ['id' => Crypt::encrypt($file->id), 'model' => 'LaporanKegiatanFile']);
    }
}
