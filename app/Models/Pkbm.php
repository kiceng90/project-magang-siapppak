<?php

namespace App\Models;

use App\Notifications\DatabaseNotification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Notification;
use Symfony\Component\VarDumper\Cloner\Data;
use Wildside\Userstamps\Userstamps;
use Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Illuminate\Support\Facades\Crypt;

class Pkbm extends Model
{
    use HasFactory, Userstamps, SoftDeletes, SoftCascadeTrait;
    protected $table = 'pkbm';
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

    public function getFotoAttribute($value)
    {
        if($value){
            return route('file.show', ['id' => Crypt::encrypt($value), 'model' => 'PkbmFile']);
        }
        return null;
    }

    public function getKtpLinkAttribute($value)
    {
        if($value){
            return route('file.show', ['id' => Crypt::encrypt($value), 'model' => 'PkbmFile']);
        }
        return null;
    }

    public function foto()
    {
        return $this->hasOne(PkbmFile::class, 'id_pkbm', 'id')->where('type', 1);
    }

    public function fileSk()
    {
        return $this->hasMany(PkbmFile::class, 'id_pkbm', 'id')->where('type', 2);
    }

    public function ktp()
    {
        return $this->hasOne(PkbmFile::class, 'id_pkbm', 'id')->where('type', 3);
    }

    public function jasaPelayanan()
    {
        return $this->belongTo(MJasaPelayanan::class, 'id_jasa_pelayanan', 'id');
    }

    public static function boot()
    {
        parent::boot();
        self::created(function ($model){
            Notification::send(User::where('id_role', config('env.role.admin'))->get(),
            new DatabaseNotification([
                'title' => 'Ada PKBM baru dibuat',
                'description' => 'User ' .auth()->user()->name .' menambahkan data pkbm baru',
                'type' => 0,
                'to' => 'pkbm',
                'id_pkbm' => $model->id
            ])
            );
        });
    }
}
