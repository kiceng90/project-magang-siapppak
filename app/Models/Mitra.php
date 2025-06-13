<?php

namespace App\Models;

use Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Crypt;
use Wildside\Userstamps\Userstamps;

class Mitra extends Model
{
    
    use HasFactory, Userstamps, SoftDeletes, SoftCascadeTrait;
    protected $table = 'mitra';
    protected $appends = ['file_foto'];
    protected $softCascade = [
    ];
    protected $guarded = [
        'created_at', 'updated_at', 'deleted_at',
        'created_by', 'updated_by', 'deleted_by',
    ];
    protected $hidden = [
        'created_at', 'updated_at', 'deleted_at',
        'created_by', 'updated_by', 'deleted_by',
    ];
    public function kategoriMitra()
    {
        return $this->belongsTo(MKategoriMitra::class, 'id_kategori_mitra');
    }
    
    public function getFotoAttribute($value)
    {
        if($value){
            return route('file.show', ['id' => Crypt::encrypt($value), 'model' => 'MitraFile']);
        }
        return null;
    }
    public function getFileFotoAttribute()
    {
        $mitra_file = MitraFile::where('id_mitra',$this->id)->first();
        if(empty($mitra_file)){
            return null;
        }
        return route('file.show', ['id' => Crypt::encrypt($mitra_file->id), 'model' => 'MitraFile']);
        
    }
    public function fotoFile()
    {
        return $this->hasOne(MitraFile::class, 'id_mitra', 'id');
    }
}
