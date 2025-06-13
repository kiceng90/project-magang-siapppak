<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\MInstansiPendidikan;
use App\Models\MJabatanDalamInstansi;
use App\Models\MKedudukanDalamTim;

use DB;

class SelectListController extends Controller
{
    public function MInstansiPendidikan(Request $req)
    {
        try {
            $limit = $req->limit ? intval($req->limit) : MInstansiPendidikan::count();
            $model = MInstansiPendidikan::select('*')->where('is_active', true);
            if($req->filled('search')){
                $model->where('name', 'ILIKE', '%' . $req->search . '%');
            }

            $this->responseCode = 200;
            $this->responseData = $model->take($limit)->get();
            return response()->json($this->getResponse(), $this->responseCode);
        } catch (\Exception $e) {
            $this->responseCode = 500;
            $this->responseMessage = $e->getMessage();
            return response()->json($this->getResponse(), $this->responseCode);
        }
    }

    public function MJabatanDalamInstansi(Request $req)
    {
        try {
            $limit = $req->limit ? intval($req->limit) : MJabatanDalamInstansi::count();
            $model = MJabatanDalamInstansi::select('*')->where('is_active', true);
            if($req->filled('search')){
                $model->where('name', 'ILIKE', '%' . $req->search . '%');
            }

            $this->responseCode = 200;
            $this->responseData = $model->take($limit)->get();
            return response()->json($this->getResponse(), $this->responseCode);
        } catch (\Exception $e) {
            $this->responseCode = 500;
            $this->responseMessage = $e->getMessage();
            return response()->json($this->getResponse(), $this->responseCode);
        }
    }

    public function MKedudukanDalamTim(Request $req)
    {
        try {
            $limit = $req->limit ? intval($req->limit) : MKedudukanDalamTim::count();
            $model = MKedudukanDalamTim::select('*')->where('is_active', true);
            if($req->filled('search')){
                $model->where('name', 'ILIKE', '%' . $req->search . '%');
            }

            $this->responseCode = 200;
            $this->responseData = $model->take($limit)->get();
            return response()->json($this->getResponse(), $this->responseCode);
        } catch (\Exception $e) {
            $this->responseCode = 500;
            $this->responseMessage = $e->getMessage();
            return response()->json($this->getResponse(), $this->responseCode);
        }
    }
}
