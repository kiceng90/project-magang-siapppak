<?php

namespace App\Models;

use Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Crypt;
use Wildside\Userstamps\Userstamps;

class Artikel extends Model
{
    use HasFactory, Userstamps, SoftDeletes, SoftCascadeTrait;
    protected $table = 'artikel';
    protected $appends = ['file_thumbnail'];
    protected $softCascade = [
    ];
    protected $guarded = [
        'created_at', 'updated_at', 'deleted_at',
        'created_by', 'updated_by', 'deleted_by',
    ];
    protected $hidden = [
        'updated_at', 'deleted_at',
        'created_by', 'updated_by', 'deleted_by',
    ];
    
    
    public function getFileThumbnailAttribute()
    {
        $file = ArtikelFile::where('id_artikel',$this->id)->where('is_image',true)->first();
        if(empty($file)){
            return null;
        }
        return route('file.show', ['id' => Crypt::encrypt($file->id), 'model' => 'ArtikelFile']);
        
    }
    public function getCreatedAtAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->format('Y-m-d H:i:s');
    }

    public function fileImageFile()
    {
        return $this->hasOne(ArtikelFile::class, 'id_artikel', 'id')->where('is_image',true)->first();
    }
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
    public function fileThumbnailFile()
    {
        return $this->hasOne(ArtikelFile::class, 'id_artikel', 'id')->where('is_image',true);
    }
    

    
}
