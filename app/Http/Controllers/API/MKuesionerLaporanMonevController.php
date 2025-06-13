<?php

namespace App\Http\Controllers\API;

use App\Enums\LaporanMonevKuesionerInputTypeEnum;
use App\Http\Controllers\Controller;
use App\Models\MKuesionerLaporanMonev;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class MKuesionerLaporanMonevController extends Controller
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

            $kuesioner = MKuesionerLaporanMonev::query();
            // if($request->filled('search')){
            //     $kuesioner->where(DB::raw('lower(m_kuesioner_laporan_monev.question)'), 'like', '%' . strtolower($request->search) . '%');
            // }
            $kuesioner->with('sub_kategori.kategori');
            
            if ($request->filled('search')) {
                $kuesioner->where(function ($q) use ($request) {
                    $s = $request->search;
                    $q->where('question', 'ILIKE', '%' . $s . '%');
                    $q->orWhereHas('sub_kategori', function ($q) use ($s) {
                        $q->where('name', 'ILIKE', '%' . $s . '%');
                    });
                    $q->orWhereHas('sub_kategori.kategori', function ($q) use ($s) {
                        $q->where('name', 'ILIKE', '%' . $s . '%');
                    });
                });
            }
            $kategori = $kuesioner->orderBy('order', 'ASC')->orderBy('id', 'ASC')->paginate($limit);

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
                'question' => 'required|string',
                'input_type' => ['required', Rule::in(LaporanMonevKuesionerInputTypeEnum::getValues())],
                'input_options' => 'nullable|string',
                'validation_rules' => 'required|string',
                'order' => 'nullable|numeric',
                'is_excluded_export' => 'required|boolean',
                'key' => 'required|unique:App\Models\MKuesionerLaporanMonev,key',
                'id_sub_kategori_laporan_monev' => 'required|exists:App\Models\MSubKategoriLaporanMonev,id,deleted_at,NULL',
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
                $last = MKuesionerLaporanMonev::query()->where('id_sub_kategori_laporan_monev',$request->id_sub_kategori_laporan_monev)->orderBy('order','DESC')->first();
                if($last){
                    $order = $last->order+1;
                }
            }
            else{
                $order = $request->order;
            }
            $kuesioner = MKuesionerLaporanMonev::create([
                'question' => $request->question,
                'input_type' => $request->input_type,
                'input_options' => $request->input_options,
                'validation_rules' => $request->validation_rules,
                'order' => $order,
                'key' => $request->key,
                'id_sub_kategori_laporan_monev' => $request->id_sub_kategori_laporan_monev
            ]);

            DB::commit();
            $this->responseCode = 201;
            $this->responseData = $kuesioner;
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
            $kuesioner = MKuesionerLaporanMonev::with('sub_kategori.kategori')->where('id', $id)->first();
            if(!$kuesioner){
                $this->responseCode = 404;
                $this->responseMessage = 'Data tidak di temukan';
                return response()->json($this->getResponse(), $this->responseCode);
            }

            $this->responseCode = 200;
            $this->responseData = $kuesioner;
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
            $kuesioner = MKuesionerLaporanMonev::find($id);
            if(!$kuesioner){
                $this->responseCode = 404;
                $this->responseMessage = 'Data tidak di temukan';
                return response()->json($this->getResponse(), $this->responseCode);
            }

            $rules = [
                'question' => 'required|string',
                'input_type' => ['required', Rule::in(LaporanMonevKuesionerInputTypeEnum::getValues())],
                'input_options' => 'nullable|string',
                'validation_rules' => 'required|string',
                'order' => 'required|numeric',
                'is_excluded_export' => 'required|boolean',
                'key' => ['required',Rule::unique('m_kuesioner_laporan_monev')->ignore($kuesioner->id)],
                'id_sub_kategori_laporan_monev' => 'required|exists:App\Models\MSubKategoriLaporanMonev,id,deleted_at,NULL',
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $this->responseCode = 422;
                $this->responseMessage = $validator->errors()->first();
                $this->responseData = $validator->errors();
                return response()->json($this->getResponse(), $this->responseCode);
            }

            $kuesioner->question = $request->question;
            $kuesioner->input_type = $request->input_type;
            $kuesioner->input_options = $request->input_options;
            $kuesioner->validation_rules = $request->validation_rules;
            $kuesioner->order = $request->order;
            $kuesioner->key = $request->key;
            $kuesioner->id_sub_kategori_laporan_monev = $request->id_sub_kategori_laporan_monev;
            $kuesioner->save();

            DB::commit();
            $this->responseCode = 200;
            $this->responseData = $kuesioner;
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
            $kuesioner = MKuesionerLaporanMonev::find($id);
            if(!$kuesioner){
                $this->responseCode = 404;
                $this->responseMessage = 'Data tidak di temukan';
                return response()->json($this->getResponse(), $this->responseCode);
            }

            $kuesioner->delete();

            $this->responseCode = 200;
            $this->responseMessage = 'Berhasil menghapus data';
            $this->responseData = $kuesioner;
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
        if(!$data = MKuesionerLaporanMonev::find(intval($id))){
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
            $data = MKuesionerLaporanMonev::select('*')->with('sub_kategori.kategori');
            if($request->filled('search')){
                $data->where(DB::raw('lower(question)'), 'like', '%' . strtolower($request->search) . '%');
            }
            if($request->filled('id_sub_kategori_laporan_monev')){
                $data->where('id_sub_kategori_laporan_monev', $request->id_sub_kategori_laporan_monev);
            }
            $data = $data->where('is_active', true)->orderBy('order', 'ASC')->get();

            $this->responseCode = 200;
            $this->responseData = $data;
            return response()->json($this->getResponse(), $this->responseCode);
        } catch (\Exception $e) {
            $this->responseCode = 500;
            $this->responseMessage = $e->getMessage();
            return response()->json($this->getResponse(), $this->responseCode);
        }
    }
}
