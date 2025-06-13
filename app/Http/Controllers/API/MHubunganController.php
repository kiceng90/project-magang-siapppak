<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\MHubungan;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\MHubunganExport;

class MHubunganController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $limit = $request->limit ? intval($request->limit) : 10;
            $order = $request->order ? $request->order : 'DESC';
            $sortby = $request->sortby ? $request->sortby : 'id';

            $hubungan = MHubungan::select('*');
            if ($request->filled('search')) {
                $hubungan->where(DB::raw('lower(name)'), 'like', '%' . strtolower($request->search) . '%');
            }
            $hubungan = $hubungan->orderBy($sortby, $order)->paginate($limit);

            $this->saveLog($hubungan);
            return $hubungan;
        } catch (\Exception $e) {
            $this->responseCode = 500;
            $this->responseMessage = $e->getMessage();
            return response()->json($this->getResponse(), $this->responseCode);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            $rules = [
                'name' => 'required|string|iunique:m_hubungan,name',
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $this->responseCode = 422;
                $this->responseMessage = $validator->errors()->first();
                $this->responseData = $validator->errors();
                return response()->json($this->getResponse(), $this->responseCode);
            }

            $hubungan = MHubungan::create([
                'name' => ($request->name),
            ]);

            DB::commit();
            $this->responseCode = 201;
            $this->responseData = $hubungan;
            return response()->json($this->getResponse(), $this->responseCode);
        } catch (\Exception $e) {
            $this->responseCode = 500;
            $this->responseMessage = $e->getMessage();
            DB::rollback();
            return response()->json($this->getResponse(), $this->responseCode);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $id = intval($id);
            $hubungan = MHubungan::find($id);
            if (!$hubungan) {
                $this->responseCode = 404;
                $this->responseMessage = 'Data tidak di temukan';
                return response()->json($this->getResponse(), $this->responseCode);
            }

            $this->responseCode = 200;
            $this->responseData = $hubungan;
            return response()->json($this->getResponse(), $this->responseCode);
        } catch (\Exception $e) {
            $this->responseCode = 500;
            $this->responseMessage = $e->getMessage();
            return response()->json($this->getResponse(), $this->responseCode);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            $id = intval($id);
            $hubungan = MHubungan::find($id);
            if (!$hubungan) {
                $this->responseCode = 404;
                $this->responseMessage = 'Data tidak di temukan';
                return response()->json($this->getResponse(), $this->responseCode);
            }

            $rules = ['name' => 'required|string|iunique:m_hubungan,name,' . $id];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $this->responseCode = 422;
                $this->responseMessage = $validator->errors()->first();
                $this->responseData = $validator->errors();
                return response()->json($this->getResponse(), $this->responseCode);
            }

            $hubungan->name = ($request->name);
            $hubungan->save();

            DB::commit();
            $this->responseCode = 200;
            $this->responseData = $hubungan;
            return response()->json($this->getResponse(), $this->responseCode);
        } catch (\Exception $e) {
            $this->responseCode = 500;
            $this->responseMessage = $e->getMessage();
            DB::rollback();
            return response()->json($this->getResponse(), $this->responseCode);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            $id = intval($id);
            $hubungan = MHubungan::find($id);
            if (!$hubungan) {
                $this->responseCode = 404;
                $this->responseMessage = 'Data tidak di temukan';
                return response()->json($this->getResponse(), $this->responseCode);
            }

            $hubungan->delete();

            $this->responseCode = 200;
            $this->responseMessage = 'Berhasil menghapus data';
            $this->responseData = $hubungan;
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

            $hubungan = MHubungan::select('*');
            if ($request->filled('search')) {
                $hubungan->where(DB::raw('lower(name)'), 'like', '%' . strtolower($request->search) . '%');
            }
            $hubungan = $hubungan->where('m_hubungan.is_active', true)->take($limit)->orderBy('name', 'ASC')->get();

            $this->responseCode = 200;
            $this->responseData = $hubungan;
            return response()->json($this->getResponse(), $this->responseCode);
        } catch (\Exception $e) {
            $this->responseCode = 500;
            $this->responseMessage = $e->getMessage();
            return response()->json($this->getResponse(), $this->responseCode);
        }
    }

    public function switchStatus($id)
    {
        try {
            $id = intval($id);
            $hubungan = MHubungan::find($id);
            if (!$hubungan) {
                $this->responseCode = 404;
                $this->responseMessage = 'Data tidak di temukan';
                return response()->json($this->getResponse(), $this->responseCode);
            }

            DB::beginTransaction();

            $hubungan->update([
                'is_active' => !$hubungan->is_active
            ]);

            $this->responseCode = 200;
            $this->responseMessage = boolval($hubungan->is_active) ? 'Hubungan telah diaktifkan' : 'Hubungan telah dinonaktifkan';
            $this->responseData = $hubungan;
            DB::commit();
            return response()->json($this->getResponse(), $this->responseCode);
        } catch (\Exception $e) {
            $this->responseCode = 500;
            $this->responseMessage = $e->getMessage();
            DB::rollback();
            return response()->json($this->getResponse(), $this->responseCode);
        }
    }

    public function listsPublic(Request $request)
    {
        try {

            $hubungan = MHubungan::select('*');
            $hubungan = $hubungan->where('m_hubungan.is_active', true)->orderBy('name', 'ASC')->get();

            $this->responseCode = 200;
            $this->responseData = $hubungan;
            return response()->json($this->getResponse(), $this->responseCode);
        } catch (\Exception $e) {
            $this->responseCode = 500;
            $this->responseMessage = $e->getMessage();
            return response()->json($this->getResponse(), $this->responseCode);
        }
    }

    public function export(Request $req)
    {
        return Excel::download(new MHubunganExport, 'Master Agama.xlsx');    
    }

}
