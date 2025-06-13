<?php

namespace App\Models;

use App\Enums\MahasiswaFileTypeEnum;
use App\Enums\MahasiswaStatusEnum;
use Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Crypt;
use Wildside\Userstamps\Userstamps;

class DMahasiswa extends Model
{
    use HasFactory, SoftDeletes, SoftCascadeTrait;
    protected $table = 'd_mahasiswa';
    protected $appends = ['status_string','tanggal_daftar', 'ktp_url', 'ttd_url', 'foto_url'];
    protected $softCascade = [];
    protected $guarded = [
        'id',
        'created_at', 'updated_at', 'deleted_at',
    ];
    protected $hidden = [
        'created_at', 'updated_at', 'deleted_at',
    ];

    public function getStatusStringAttribute(){
        return MahasiswaStatusEnum::label(intval($this->status));
    }
    public function getTanggalDaftarAttribute(){
        return $this->created_at->translatedFormat('d F Y');
    }
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'id_user');
    }
    public function kabupaten_lahir(){
        return $this->hasOne(MKabupaten::class, 'id', 'id_kabupaten_lahir');    
    }
    public function pendidikan_terakhir(){
        return $this->hasOne(MPendidikanTerakhir::class, 'id', 'id_pendidikan_terakhir');    
    }
    public function jenis_mahasiswa(){
        return $this->hasOne(MJenisMahasiswa::class, 'id', 'id_jenis_mahasiswa');    
    }
    public function jurusan(){
        return $this->hasOne(MJurusan::class, 'id', 'id_jurusan');    
    }
    public function instansi_pendidikan(){
        return $this->hasOne(MInstansiPendidikan::class, 'id', 'id_instansi_pendidikan');    
    }
    public function kelurahan_domisili(){
        return $this->hasOne(MKelurahan::class, 'id', 'id_kelurahan_domisili');    
    }
    public function kelurahan_kk(){
        return $this->hasOne(MKelurahan::class, 'id', 'id_kelurahan_kk');    
    }
    public function files(){
        return $this->hasMany(DMahasiswaFile::class,'id_mahasiswa','id');
    }
    public function file_ktp(){
        return $this->hasOne(DMahasiswaFile::class,'id_mahasiswa','id')->where('type',MahasiswaFileTypeEnum::KTP);
    }
    public function file_foto(){
        return $this->hasOne(DMahasiswaFile::class,'id_mahasiswa','id')->where('type',MahasiswaFileTypeEnum::FOTO);
    }
    public function file_ttd(){
        return $this->hasOne(DMahasiswaFile::class,'id_mahasiswa','id')->where('type',MahasiswaFileTypeEnum::TTD);
    }
    public function getKtpUrlAttribute(){
        
        $file = DMahasiswaFile::where('id_mahasiswa',$this->id)->where('is_image',true)->where('type',MahasiswaFileTypeEnum::KTP)->first();
        if(empty($file)){
            return null;
        }
        return route('file.show', ['id' => Crypt::encrypt($file->id), 'model' => 'DMahasiswaFile']);
    }
    public function getFotoUrlAttribute(){
        
        $file = DMahasiswaFile::where('id_mahasiswa',$this->id)->where('is_image',true)->where('type',MahasiswaFileTypeEnum::FOTO)->first();
        if(empty($file)){
            return null;
        }
        return route('file.show', ['id' => Crypt::encrypt($file->id), 'model' => 'DMahasiswaFile']);
    }
    public function getTtdUrlAttribute(){
        
        $file = DMahasiswaFile::where('id_mahasiswa',$this->id)->where('is_image',true)->where('type',MahasiswaFileTypeEnum::TTD)->first();
        if(empty($file)){
            return null;
        }
        return route('file.show', ['id' => Crypt::encrypt($file->id), 'model' => 'DMahasiswaFile']);
    }
    public function puspaga_rw(){
        return $this->hasOne(MahasiswaBalaiPuspagaRW::class,'id_mahasiswa','id');
    }
}
