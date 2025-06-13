<?php

namespace App\Models;

use Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Crypt;

class LaporanMonevJawaban extends Model
{
    use HasFactory, SoftDeletes, SoftCascadeTrait;
    protected $table = 'laporan_monev_jawaban';
    protected $softCascade = [];
    protected $guarded = [
        'created_at', 'updated_at', 'deleted_at'
    ];
    protected $hidden = [
        'created_at', 'updated_at', 'deleted_at'
    ];
    public function kuesioner(){
        return $this->hasOne(MKuesionerLaporanMonev::class,'id','id_kuesioner_laporan_monev');
    }
    public function file_model(){
        return $this->hasOne(LaporanMonevJawabanFile::class,'id_laporan_monev_jawaban','id');
    }
    public function getFileUrlAttribute(){
        
        $file = LaporanMonevJawabanFile::where('id_laporan_monev_jawaban',$this->id)->where('is_image',true)->first();
        if(empty($file)){
            return null;
        }
        return route('file.show', ['id' => Crypt::encrypt($file->id), 'model' => 'LaporanMonevJawabanFile']);
    }
}
