<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\MKebutuhanLayanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class MKebutuhanLayananController extends Controller
{
    public function index(Request $request)
    {
        try {
            $limit = $request->limit ? intval($request->limit) : 10;
            $order = $request->order ? $request->order : 'DESC';
            $sortby = $request->sortby ? $request->sortby : 'id';

            $layanan = MKebutuhanLayanan::select('*');
            if ($request->filled('search')) {
                $layanan->where(DB::raw('lower(name)'), 'like', '%' . strtolower($request->search) . '%');
            }
            $layanan = $layanan->orderBy($sortby, $order)->paginate($limit);

            $this->saveLog($layanan);
            return $layanan;
        } catch (\Exception $e) {
            $this->responseCode = 500;
            $this->responseMessage = $e->getMessage();
            return response()->json($this->getResponse(), $this->responseCode);
        }
    }
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            $rules = [
                'name' => 'required|string|iunique:m_kebutuhan_layanan,name',
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $this->responseCode = 422;
                $this->responseMessage = $validator->errors()->first();
                $this->responseData = $validator->errors();
                return response()->json($this->getResponse(), $this->responseCode);
            }

            $layanan = MKebutuhanLayanan::create([
                'name' => ($request->name),
            ]);

            DB::commit();
            $this->responseCode = 201;
            $this->responseData = $layanan;
            return response()->json($this->getResponse(), $this->responseCode);
        } catch (\Exception $e) {
            $this->responseCode = 500;
            $this->responseMessage = $e->getMessage();
            DB::rollback();
            return response()->json($this->getResponse(), $this->responseCode);
        }
    }
    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            $id = intval($id);
            $layanan = MKebutuhanLayanan::find($id);
            if (!$layanan) {
                $this->responseCode = 404;
                $this->responseMessage = 'Data tidak di temukan';
                return response()->json($this->getResponse(), $this->responseCode);
            }

            $rules = ['name' => 'required|string|iunique:m_kebutuhan_layanan,name,' . $id];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $this->responseCode = 422;
                $this->responseMessage = $validator->errors()->first();
                $this->responseData = $validator->errors();
                return response()->json($this->getResponse(), $this->responseCode);
            }

            $layanan->name = ($request->name);
            $layanan->save();

            DB::commit();
            $this->responseCode = 200;
            $this->responseData = $layanan;
            return response()->json($this->getResponse(), $this->responseCode);
        } catch (\Exception $e) {
            $this->responseCode = 500;
            $this->responseMessage = $e->getMessage();
            DB::rollback();
            return response()->json($this->getResponse(), $this->responseCode);
        }
    }
    public function switchStatus($id)
    {
        try {
            $id = intval($id);
            $layanan = MKebutuhanLayanan::find($id);
            if (!$layanan) {
                $this->responseCode = 404;
                $this->responseMessage = 'Data tidak di temukan';
                return response()->json($this->getResponse(), $this->responseCode);
            }

            DB::beginTransaction();

            $layanan->update([
                'is_active' => !$layanan->is_active
            ]);

            $this->responseCode = 200;
            $this->responseMessage = boolval($layanan->is_active) ? 'Kebutuhan layanan telah diaktifkan' : 'Kebutuhan layanan telah dinonaktifkan';
            $this->responseData = $layanan;
            DB::commit();
            return response()->json($this->getResponse(), $this->responseCode);
        } catch (\Exception $e) {
            $this->responseCode = 500;
            $this->responseMessage = $e->getMessage();
            DB::rollback();
            return response()->json($this->getResponse(), $this->responseCode);
        }
    }
    public function lists(Request $request)
    {
        try {
            $limit = $request->limit ? intval($request->limit) : 10;

            $layanan = MKebutuhanLayanan::select('*');
            if ($request->filled('search')) {
                $layanan->where(DB::raw('lower(name)'), 'like', '%' . strtolower($request->search) . '%');
            }
            $layanan = $layanan->take($limit)->orderBy('id', 'ASC')->get();

            $this->responseCode = 200;
            $this->responseData = $layanan;
            return response()->json($this->getResponse(), $this->responseCode);
        } catch (\Exception $e) {
            $this->responseCode = 500;
            $this->responseMessage = $e->getMessage();
            return response()->json($this->getResponse(), $this->responseCode);
        }
    }
    public function listsPublic(Request $request)
    {
        try {
            $layanan = MKebutuhanLayanan::select('*');
            $layanan = $layanan->where('m_kebutuhan_layanan.is_active', true)->orderBy('name', 'ASC')->get();

            $this->responseCode = 200;
            $this->responseData = $layanan;
            return response()->json($this->getResponse(), $this->responseCode);
        } catch (\Exception $e) {
            $this->responseCode = 500;
            $this->responseMessage = $e->getMessage();
            return response()->json($this->getResponse(), $this->responseCode);
        }
    }
}
