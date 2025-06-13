<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;
use Askedio\SoftCascade\Traits\SoftCascadeTrait;

class UserLog extends Model
{
    use HasFactory, Userstamps, SoftDeletes, SoftCascadeTrait;
    protected $table = 'user_logs';
    protected $softCascade = [];
    protected $guarded = [
        'created_at', 'updated_at', 'deleted_at',
        'created_by', 'updated_by', 'deleted_by',
    ];
    protected $hidden = [
        'created_at', 'updated_at', 'deleted_at',
        'created_by', 'updated_by', 'deleted_by',
    ];

    public static function saveLog($response = null)
    {
        $userLog = new UserLog();
        $userLog->function_name = \Route::getCurrentRoute()->getActionName();
        $userLog->url = request()->fullUrl();
        $userLog->method = request()->method();
        $userLog->header = json_encode(request()->headers->all()) ?? null;
        $userLog->request = json_encode(request()->except(['password', 'current_password'])) ?? null;
        $userLog->response = ($response) ? json_encode($response) : null;
        $userLog->request_source_type = 1;
        $userLog->request_status_type = !isset($response['status']) ? 1 : (($response['status']['code'] >= 200) && ($response['status']['code'] < 300) ? 1 : 2);
        $userLog->save();

        return $userLog;
    }
}
