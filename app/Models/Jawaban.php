<?php

namespace App\Models;

use Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class Jawaban extends Model
{
    use HasFactory, Userstamps, SoftDeletes, SoftCascadeTrait;
    protected $table = 'jawaban';
    protected $softCascade = [];
    protected $guarded = [
        'created_at', 'updated_at', 'deleted_at',
        'created_by', 'updated_by', 'deleted_by',
    ];
    protected $hidden = [
        'updated_at', 'deleted_at',
        'created_by', 'updated_by', 'deleted_by',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }

    public function materi()
    {
        return $this->belongsTo(Materi::class, 'id_materi', 'id');
    }
}
