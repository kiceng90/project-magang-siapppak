<?php

namespace App\Models;

use App\Enums\KieJenisEnum;
use Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Crypt;
use Wildside\Userstamps\Userstamps;

class Kie extends Model
{
    use HasFactory, Userstamps, SoftDeletes, SoftCascadeTrait;
    protected $table = 'kie';
    protected $appends = ['file_image','file_pdf','file_thumbnail','type_string'];
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

    
    public function getFileImageAttribute()
    {
        $file = KieFile::where('id_kie',$this->id)->where('is_image',true)->where('type','content')->first();
        if(empty($file)){
            return null;
        }
        return route('file.show', ['id' => Crypt::encrypt($file->id), 'model' => 'KieFile']);
        
    }
    public function getFilePdfAttribute()
    {
        $file = KieFile::where('id_kie',$this->id)->where('is_image',false)->first();
        if(empty($file)){
            return null;
        }
        return route('file.show', ['id' => Crypt::encrypt($file->id), 'model' => 'KieFile']);
        
    }
    public function getFileThumbnailAttribute()
    {
        $file = KieFile::where('id_kie',$this->id)->where('is_image',true)->where('type','thumbnail')->first();
        if(empty($file)){
            return null;
        }
        return route('file.show', ['id' => Crypt::encrypt($file->id), 'model' => 'KieFile']);
        
    }
    public function fileImageFile()
    {
        return $this->hasOne(KieFile::class, 'id_kie', 'id')->where('is_image',true)->where('type','content');
    }
    public function filePdfFile()
    {
        return $this->hasOne(KieFile::class, 'id_kie', 'id')->where('is_image',false)->where('type','content');
    }
    public function fileThumbnailFile()
    {
        return $this->hasOne(KieFile::class, 'id_kie', 'id')->where('is_image',true)->where('type','thumbnail');
    }
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
    public function getTypeStringAttribute()
    {
        return KieJenisEnum::label($this->type);
    }
}
