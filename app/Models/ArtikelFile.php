<?php

namespace App\Models;

use Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\File;
use Wildside\Userstamps\Userstamps;

class ArtikelFile extends Model
{
    use HasFactory, Userstamps, SoftDeletes, SoftCascadeTrait;
    protected $table = 'artikel_file';
    protected $softCascade = [];
    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
        'deleted_at',
        'created_by',
        'updated_by',
        'deleted_by',
    ];
    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected static function boot()
    {
        parent::boot();
        static::deleting(function ($file) {
            if ($file->isForceDeleting()) {
                if (File::exists(storage_path('app/' . $file->path))) {
                    File::delete(storage_path('app/' . $file->path));
                }
            }
        });
    }

    public function article()
    {
        return $this->belongsTo(Artikel::class, 'id_artikel');
    }
}
