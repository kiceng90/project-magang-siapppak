<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;
use Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Illuminate\Support\Facades\File;

class PsikologVolunteerFile extends Model
{
    use HasFactory, Userstamps, SoftDeletes, SoftCascadeTrait;
    protected $table = 'psikolog_volunteer_file';
    protected $softCascade = [];
    protected $guarded = [
        'id',
        'created_at', 'updated_at', 'deleted_at',
        'created_by', 'updated_by', 'deleted_by',
    ];
    protected $hidden = [
        'created_at', 'updated_at', 'deleted_at',
        'created_by', 'updated_by', 'deleted_by',
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
