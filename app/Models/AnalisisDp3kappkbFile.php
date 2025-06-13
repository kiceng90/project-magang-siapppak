<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;
use Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Illuminate\Support\Facades\File;

class AnalisisDp3kappkbFile extends Model
{
    use HasFactory, Userstamps, SoftDeletes, SoftCascadeTrait;
    protected $table = 'analisis_dp3kappkb_file';
    protected $softCascade = [];
    protected $guarded = [
        'created_at', 'updated_at', 'deleted_at',
        'created_by', 'updated_by', 'deleted_by',
    ];
    protected $hidden = [
        'created_at', 'updated_at', 'deleted_at',
        'created_by', 'updated_by', 'deleted_by',

        'residence_address', 'id_kabupaten_tinggal', 'id_kelurahan_tinggal',
    ];

    protected static function boot(){
        parent::boot();
        static::deleting(function($file) {
            if($file->isForceDeleting()){
                if(File::exists(storage_path('app/'. $file->path))){
                    File::delete(storage_path('app/'. $file->path));
                }
            }
        });
    }
}
