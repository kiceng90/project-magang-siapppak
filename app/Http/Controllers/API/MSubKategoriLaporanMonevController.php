<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\MSubKategoriLaporanMonev;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class MSubKategoriLaporanMonevController extends Controller
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
            $sortby = $request->sortby ? $request->sortby : 'order';

            $kategori = MSubKategoriLaporanMonev::query();
            // if($request->filled('search')){
            //     $kategori->where(DB::raw('lower(m_sub_kategori_laporan_monev.name)'), 'like', '%' . strtolower($request->search) . '%')
            //     ->orWhere('name', 'ILIKE', '%' . strtolower($request->search) . '%');
            // }
            $kategori->with('kategori');
            $kategori->with('kuesioner');

            if ($request->filled('search')) {
                $kategori->where(function ($q) use ($request) {
                    $s = $request->search;
                    $q->where('name', 'ILIKE', '%' . $s . '%');
                    $q->orWhereHas('kategori', function ($q) use ($s) {
                        $q->where('name', 'ILIKE', '%' . $s . '%');
                    });
                    // $q->orWhere('pic_name', 'ILIKE', '%' . $s . '%');
                });
            }

            
            $kategori = $kategori->orderBy('order', 'ASC')->orderBy('id', 'ASC')->paginate($limit);

            $this->saveLog($kategori);
            return $kategori;
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
                'name' => 'required|string',
                'order' => 'nullable|numeric',
                'id_kategori_laporan_monev' => 'required|exists:App\Models\MKategoriLaporanMonev,id,deleted_at,NULL',
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $this->responseCode = 422;
                $this->responseMessage = $validator->errors()->first();
                $this->responseData = $validator->errors();
                return response()->json($this->getResponse(), $this->responseCode);
            }
            $order = 0;
            if(!$request->filled('order')){
                $last = MSubKategoriLaporanMonev::query()->where('id_kategori_laporan_monev',$request->id_kategori_laporan_monev)->orderBy('order','DESC')->first();
                if($last){
                    $order = $last->order+1;
                }
            }
            else{
                $order = $request->order;
            }
            $kategori = MSubKategoriLaporanMonev::create([
                'name' => $request->name,
                'order' => $order,
                'id_kategori_laporan_monev' => $request->id_kategori_laporan_monev
            ]);

            DB::commit();
            $this->responseCode = 201;
            $this->responseData = $kategori;
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
            $kategori = MSubKategoriLaporanMonev::with('kategori')->with('kuesioner')->where('id', $id)->first();
            if(!$kategori){
                $this->responseCode = 404;
                $this->responseMessage = 'Data tidak di temukan';
                return response()->json($this->getResponse(), $this->responseCode);
            }

            $this->responseCode = 200;
            $this->responseData = $kategori;
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
            $kategori = MSubKategoriLaporanMonev::find($id);
            if(!$kategori){
                $this->responseCode = 404;
                $this->responseMessage = 'Data tidak di temukan';
                return response()->json($this->getResponse(), $this->responseCode);
            }

            $rules = [
                'name' => 'required|string',
                'order' => 'required|numeric',
                'id_kategori_laporan_monev' => 'required|exists:App\Models\MKategoriLaporanMonev,id,deleted_at,NULL',
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $this->responseCode = 422;
                $this->responseMessage = $validator->errors()->first();
                $this->responseData = $validator->errors();
                return response()->json($this->getResponse(), $this->responseCode);
            }

            $kategori->name = $request->name;
            $kategori->order = $request->order;
            $kategori->id_kategori_laporan_monev = $request->id_kategori_laporan_monev;
            $kategori->save();

            DB::commit();
            $this->responseCode = 200;
            $this->responseData = $kategori;
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
            $kategori = MSubKategoriLaporanMonev::find($id);
            if(!$kategori){
                $this->responseCode = 404;
                $this->responseMessage = 'Data tidak di temukan';
                return response()->json($this->getResponse(), $this->responseCode);
            }

            $kategori->delete();

            $this->responseCode = 200;
            $this->responseMessage = 'Berhasil menghapus data';
            $this->responseData = $kategori;
            DB::commit();
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
        if(!$data = MSubKategoriLaporanMonev::find(intval($id))){
            $this->responseCode = 404;
            $this->responseMessage = 'Data tidak di temukan';
            return response()->json($this->getResponse(), $this->responseCode);
        }

        DB::transaction(function () use($data) {
            $data->is_active = !$data->is_active;
            $data->save();
        });
        
        $this->responseCode = 200;
        $this->responseMessage = boolval($data->is_active) ? 'Data telah diaktifkan' : 'Data telah dinonaktifkan';
        $this->responseData = $data;
        return response()->json($this->getResponse(), $this->responseCode);
    }
    
    public function lists(Request $request)
    {
        try {            
            $list = MSubKategoriLaporanMonev::select('*')->with('kuesioner', 'kategori');
            if($request->filled('search')){
                $list->where(DB::raw('lower(name)'), 'like', '%' . strtolower($request->search) . '%');
            }
            if($request->filled('id_kategori_laporan_monev')){
                $list->where('id_kategori_laporan_monev',$request->id_kategori_laporan_monev);
            }
            $list = $list->where('is_active', true)->orderBy('order', 'ASC')->get();

            $this->responseCode = 200;
            $this->responseData = $list;
            return response()->json($this->getResponse(), $this->responseCode);
        } catch (\Exception $e) {
            $this->responseCode = 500;
            $this->responseMessage = $e->getMessage();
            return response()->json($this->getResponse(), $this->responseCode);
        }
    }
}
