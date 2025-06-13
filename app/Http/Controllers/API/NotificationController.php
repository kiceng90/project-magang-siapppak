<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function getNotif(Request $req)
    {
        try {
            $limit = $req->limit ? intval($req->limit) : 10;
            $order = $req->order ? $req->order : 'DESC';
            $sortby = $req->sortby ? $req->sortby : 'created_at';

            $notif = Auth::user()->notifications()->select('id', 'data', 'read_at', 'created_at')->orderBy($sortby, $order)->paginate($limit);
            
            $this->saveLog($notif);
            return $notif;
        } catch (\Exception $e) {
            $this->responseCode = 500;
            $this->responseMessage = $e->getMessage();
            return response()->json($this->getResponse(), $this->responseCode);
        }
    }

    public function read($id = null)
    {
        try {
            Auth::user()
                ->unreadNotifications
                ->when($id, function ($query) use ($id) {
                    return $query->where('id', $id);
                })
                ->markAsRead();

            $this->responseCode = 200;
        } catch (\Exception $e) {
            $this->responseCode = 500;
            $this->responseMessage = $e->getMessage();
        }
        return response()->json($this->getResponse(), $this->responseCode);
    }

    public function check()
    {
        try {
            $count = Auth::user()->unreadNotifications->count();
            $this->saveLog($count);
            return $count;
        } catch (\Exception $e) {
            $this->responseCode = 500;
            $this->responseMessage = $e->getMessage();
            return response()->json($this->getResponse(), $this->responseCode);
        }
    }
}
