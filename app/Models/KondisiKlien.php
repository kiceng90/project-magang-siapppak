<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;
use Askedio\SoftCascade\Traits\SoftCascadeTrait;

class KondisiKlien extends Model
{
    use HasFactory, Userstamps, SoftDeletes, SoftCascadeTrait;
    protected $table = 'kondisi_klien';
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

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }
}
