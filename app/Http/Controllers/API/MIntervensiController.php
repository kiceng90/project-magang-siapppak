<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\MIntervensi;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\MIntervensiExport;

class MIntervensiController extends Controller
{
    public $intervensi;

    public function __construct(Request $request)
    {
        $this->intervensi = MIntervensi::select([
            'm_intervensi.*', DB::raw('m_opd.name AS opd_name'),
        ])
            ->join('m_opd', 'm_opd.id', '=', 'm_intervensi.id_opd');

        parent::__construct($request);
    }
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

            $intervensi = $this->intervensi;
            if ($request->filled('search')) {
                $intervensi->where(DB::raw('lower(m_intervensi.name)'), 'like', '%' . strtolower($request->search) . '%')
                    ->orWhere(DB::raw('lower(m_opd.name)'), 'like', '%' . strtolower($request->search) . '%');
            }
            $intervensi = $intervensi->orderBy($sortby, $order)->paginate($limit);

            $this->saveLog($intervensi);
            return $intervensi;
        } catch (\Exception $e) {
            $this->responseCode = 500;
            $this->responseMessage = $e->getMessage() . ' ' . $e->getLine();
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
                'id_opd' => 'required|exists:App\Models\MOpd,id,deleted_at,NULL',
                'name' => 'required|string|iunique:m_intervensi,name',
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $this->responseCode = 422;
                $this->responseMessage = $validator->errors()->first();
                $this->responseData = $validator->errors();
                return response()->json($this->getResponse(), $this->responseCode);
            }

            $intervensi = MIntervensi::create([
                'id_opd' => $request->id_opd,
                'name' => $request->name,
            ]);

            DB::commit();
            $this->responseCode = 201;
            $this->responseData = $this->intervensi->where('m_intervensi.id', $intervensi->id)->first();
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
            $intervensi = $this->intervensi->where('m_intervensi.id', $id)->first();
            if (!$intervensi) {
                $this->responseCode = 404;
                $this->responseMessage = 'Data tidak di temukan';
                return response()->json($this->getResponse(), $this->responseCode);
            }

            $this->responseCode = 200;
            $this->responseData = $intervensi;
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
            $intervensi = MIntervensi::find($id);
            if (!$intervensi) {
                $this->responseCode = 404;
                $this->responseMessage = 'Data tidak di temukan';
                return response()->json($this->getResponse(), $this->responseCode);
            }

            $rules = [
                'id_opd' => 'required|exists:App\Models\MOpd,id,deleted_at,NULL',
                'name' => 'required|string|iunique:m_intervensi,name,' . $id,
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $this->responseCode = 422;
                $this->responseMessage = $validator->errors()->first();
                $this->responseData = $validator->errors();
                return response()->json($this->getResponse(), $this->responseCode);
            }

            $intervensi->id_opd = $request->id_opd;
            $intervensi->name = $request->name;
            $intervensi->save();

            DB::commit();
            $this->responseCode = 200;
            $this->responseData = $this->intervensi->where('m_intervensi.id', $id)->first();
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
            $intervensi = $this->intervensi->where('m_intervensi.id', $id)->first();
            if (!$intervensi) {
                $this->responseCode = 404;
                $this->responseMessage = 'Data tidak di temukan';
                return response()->json($this->getResponse(), $this->responseCode);
            }

            $intervensi->delete();

            $this->responseCode = 200;
            $this->responseMessage = 'Berhasil menghapus data';
            $this->responseData = $intervensi;
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

            $intervensi = $this->intervensi;
            if ($request->filled('search')) {
                $intervensi->where(DB::raw('lower(m_intervensi.name)'), 'like', '%' . strtolower($request->search) . '%');
            }
            if ($request->filled('id_opd')) {
                $intervensi->where('id_opd', $request->id_opd);
            }

            $intervensi = $intervensi->where('m_intervensi.is_active', true)->take($limit)->orderBy('m_intervensi.name', 'ASC')->get();

            $this->responseCode = 200;
            $this->responseData = $intervensi;
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
            $intervensi = MIntervensi::find($id);
            if (!$intervensi) {
                $this->responseCode = 404;
                $this->responseMessage = 'Data tidak di temukan';
                return response()->json($this->getResponse(), $this->responseCode);
            }

            DB::beginTransaction();

            $intervensi->update([
                'is_active' => !$intervensi->is_active
            ]);

            $this->responseCode = 200;
            $this->responseMessage = boolval($intervensi->is_active) ? 'Intervensi telah diaktifkan' : 'Intervensi telah dinonaktifkan';
            $this->responseData = $this->intervensi->where('m_intervensi.id', $id)->first();
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
            $intervensi = MIntervensi::select('*');
            $intervensi = $intervensi->where('m_intervensi.is_active', true)->orderBy('m_intervensi.name', 'ASC')->get();

            $this->responseCode = 200;
            $this->responseData = $intervensi;
            return response()->json($this->getResponse(), $this->responseCode);
        } catch (\Exception $e) {
            $this->responseCode = 500;
            $this->responseMessage = $e->getMessage();
            return response()->json($this->getResponse(), $this->responseCode);
        }
    }

    public function export(Request $req)
    {
        return Excel::download(new MIntervensiExport, 'Master Intervensi.xlsx');    
    }

}
