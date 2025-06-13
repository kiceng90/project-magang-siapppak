<?php

namespace App\Models;

use App\Enums\DKlienKonselingFileTypeEnum;
use Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Crypt;

class DKlienKonseling extends Model
{   
    use HasFactory, SoftDeletes, SoftCascadeTrait;
    protected $table = 'd_klien_konseling';
    protected $softCascade = [];
    protected $guarded = [
        'created_at', 'updated_at', 'deleted_at'
    ];
    protected $hidden = [
        'created_at', 'updated_at', 'deleted_at'
    ];
    protected $appends =[
        'ktp_url',
        'kk_url',
    ];

    public function kabupaten()
    {
        return $this->belongsTo(MKabupaten::class, 'id_kabupaten');
    }

    public function kelurahan()
    {
        return $this->belongsTo(MKelurahan::class, 'id_kelurahan');
    }
    
    public function file_ktp(){
        return $this->hasOne(DKlienKonselingFile::class,'id_klien_konseling','id')->where('type',DKlienKonselingFileTypeEnum::KTP);
    }
    
    public function getKtpUrlAttribute(){
        
        $file = DKlienKonselingFile::where('id_klien_konseling',$this->id)->where('is_image',true)->where('type',DKlienKonselingFileTypeEnum::KTP)->first();
        if (empty($file)) {
            return null;
        }
        return route('file.show', ['id' => Crypt::encrypt($file->id), 'model' => 'DKlienKonselingFile']);
    }

    public function file_kk(){
        return $this->hasOne(DKlienKonselingFile::class,'id_klien_konseling','id')->where('type',DKlienKonselingFileTypeEnum::KK);
    }

    public function getKkUrlAttribute(){
        
        $file = DKlienKonselingFile::where('id_klien_konseling',$this->id)->where('is_image',true)->where('type',DKlienKonselingFileTypeEnum::KK)->first();
        if (empty($file)) {
            return null;
        }
        return route('file.show', ['id' => Crypt::encrypt($file->id), 'model' => 'DKlienKonselingFile']);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
