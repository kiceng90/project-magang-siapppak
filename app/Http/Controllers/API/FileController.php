<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class FileController extends Controller
{
    public function show($id, $model)
    {
        try {
            $id = Crypt::decrypt($id);
            $model = 'App\\Models\\' . $model;
            $model = $model::find(intval($id));
            if (empty($model)) {
                $this->responseCode = 404;
                $this->responseMessage = 'Data tidak ditemukan';
                return response()->json($this->getResponse(), $this->responseCode);
            }
            $path = storage_path('app/'. $model->path);

            $this->saveLog();
            return response()->file($path);
        } catch (\Exception $e) {
            $this->responseCode = 500;
            $this->responseMessage = $e->getMessage();
            return response()->json($this->getResponse(), $this->responseCode);
        }
    }
}
