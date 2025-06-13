<?php

namespace App\Http\Controllers\API;

use App\Enums\LaporanMonevStatusEnum;
use App\Exports\DatabaseExport;
use App\Exports\LaporanMonevExport;
use App\Http\Controllers\Controller;
use App\Models\LaporanMonev;
use App\Models\LaporanMonevJawaban;
use App\Models\LaporanMonevJawabanFile;
use App\Models\MKategoriLaporanMonev;
use App\Models\MKuesionerLaporanMonev;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;

class LaporanMonevController extends Controller
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

            $laporan = LaporanMonev::with('jawaban.kuesioner.sub_kategori.kategori', 'balai_puspaga_rw.konselor', 'balai_puspaga_rw.kelurahan.kecamatan.kabupaten', 'jabatan', 'konselor.dkonselor');
            if($request->filled('tanggal_filter')){
                $laporan->whereDate('date',$request->tanggal_filter);
            }
            if($request->filled('start_date')){
                $laporan->where('date','>=',$request->start_date);
                if($request->filled('end_date')){
                    $laporan->where('date','<=',$request->end_date);
                }
            }

            if ($request->filled('search')) {
                $laporan->where(function ($q) use ($request) {
                    $s = $request->search;
                    $q->where('date', 'ILIKE', '%' . $s . '%');
                    $q->orWhere('id_konselor', 'ILIKE', '%' . $s . '%');
                });
            }

            $laporan = $laporan->orderBy($sortby, $order)->paginate($limit);
            $this->responseCode = 200;
            $this->responseData = $laporan;
            return response()->json($this->getResponse(), $this->responseCode);
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
                'id_jabatan_dalam_instansi' => 'required|exists:App\Models\MJabatanDalamInstansi,id,deleted_at,NULL',
                'id_d_balai_puspaga_rw' => 'required|exists:App\Models\DBalaiPuspagaRW,id,deleted_at,NULL',
                'id_konselor' => 'required|exists:App\Models\MKonselor,id,deleted_at,NULL',
                'date' => 'required|date',
                'is_active' => 'required|boolean',
                // 'status' => ['required',Rule::in(LaporanMonevStatusEnum::getValues())],
                'kuesioner' =>'required|array|min:1',
                'kuesioner.*.id_kuesioner' => 'required|exists:App\Models\MKuesionerLaporanMonev,id,deleted_at,NULL',
                'kuesioner.*.answer' => ['required',function($attr, $value, $fail) use ($request){
                        $kuesioner = $request->kuesioner[explode('.', $attr)[1]];
                        $kuesioner = MKuesionerLaporanMonev::find($kuesioner['id_kuesioner']);
                        if(empty($kuesioner)){
                            $fail('id kuesioner not found');
                            return;
                        }
                        $rule = [$kuesioner->key => $kuesioner->validation_rules];
                        $validator = Validator::make([$kuesioner->key => $value], $rule);
                        if ($validator->fails()) {
                            $fail($validator->errors()->first());
                        }
                }]
            ];

            
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $this->responseCode = 422;
                $this->responseMessage = $validator->errors()->first();
                $this->responseData = $validator->errors();
                return response()->json($this->getResponse(), $this->responseCode);
            }

            $laporan = new LaporanMonev();
            $laporan->id_jabatan_dalam_instansi = $request->id_jabatan_dalam_instansi;
            $laporan->id_d_balai_puspaga_rw = $request->id_d_balai_puspaga_rw;
            $laporan->id_konselor = $request->id_konselor;
            $laporan->date = $request->date;
            $laporan->is_active = $request->is_active;
            $laporan->status = LaporanMonevStatusEnum::UNVERIFIED;
            $laporan->save();

            foreach($request->kuesioner as $key => $kuesioner){
                $jawaban = new LaporanMonevJawaban();
                $jawaban->id_laporan_monev = $laporan->id;
                $jawaban->id_kuesioner_laporan_monev = $kuesioner['id_kuesioner'];
                $jawaban->answer = 'temporary_by_system';
                $jawaban->save();
                if($request->hasFile('kuesioner.'.$key.'.answer')){
                    $file = $kuesioner['answer'];
                    $changedName = time() . random_int(100, 999). '.' .$file->getClientOriginalExtension();
                    $is_image = substr($file->getClientMimeType(), 0, 5) == 'image' ?? false;
    
                    $path = 'private/laporan_monev_jawaban/' . $laporan->id;
                    $file->storeAs($path, $changedName);
                    
                    $modelFile = new LaporanMonevJawabanFile();

                    $modelFile->id_laporan_monev_jawaban = $jawaban->id;
                    $modelFile->name = $file->getClientOriginalName();
                    $modelFile->path = $path . '/' . $changedName;
                    $modelFile->size = $file->getSize();
                    $modelFile->ext = $file->getClientOriginalExtension();
                    $modelFile->is_image = $is_image;
                    $modelFile->save();

                    $jawaban->is_file = true;
                    $jawaban->answer = route('file.show', ['id' => Crypt::encrypt($modelFile->id), 'model' => 'LaporanMonevJawabanFile']);
                    $jawaban->save();
                }
                else{
                    $jawaban->answer = $kuesioner['answer'];
                    $jawaban->save();
                }
            }
            DB::commit();
            $result = LaporanMonev::where('id',$laporan->id)->with('jawaban')->first();
            $this->responseCode = 200;
            $this->responseData = $result;
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
    public function show(Request $request, $id)
    {
        try {
            $laporan = LaporanMonev::where('id', $id)->first();
            if(!$laporan){
                $this->responseCode = 404;
                $this->responseMessage = 'Data tidak di temukan';
                return response()->json($this->getResponse(), $this->responseCode);
            }
            $limit = $request->limit ? intval($request->limit) : 10;
            $order = $request->order ? $request->order : 'DESC';
            $sortby = $request->sortby ? $request->sortby : 'id';

            $laporan = LaporanMonev::with('jawaban.kuesioner.sub_kategori.kategori', 'balai_puspaga_rw.konselor', 'balai_puspaga_rw.kelurahan.kecamatan', 'jabatan', 'konselor.dkonselor');
            if($request->filled('tanggal_filter')){
                $laporan->whereDate('date',$request->tanggal_filter);
            }
            $laporan = $laporan->first();
            $this->responseCode = 200;
            $this->responseData = $laporan;
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
            $laporan = LaporanMonev::where('id', $id)->first();
            if(!$laporan){
                $this->responseCode = 404;
                $this->responseMessage = 'Data tidak di temukan';
                return response()->json($this->getResponse(), $this->responseCode);
            }
            DB::beginTransaction();
            $rules = [
                'id_jabatan_dalam_instansi' => 'required|exists:App\Models\MJabatanDalamInstansi,id,deleted_at,NULL',
                'id_d_balai_puspaga_rw' => 'required|exists:App\Models\DBalaiPuspagaRW,id,deleted_at,NULL',
                'id_konselor' => 'required|exists:App\Models\MKonselor,id,deleted_at,NULL',
                'date' => 'required|date',
                'is_active' => 'required|boolean',
                'status' => ['required',Rule::in(LaporanMonevStatusEnum::getValues())],
                'kuesioner' =>'required|array|min:1',
                'kuesioner.*.id_kuesioner' => 'required|exists:App\Models\MKuesionerLaporanMonev,id,deleted_at,NULL',
                'kuesioner.*.answer' => ['required',function($attr, $value, $fail) use ($request){
                        $kuesioner = $request->kuesioner[explode('.', $attr)[1]];
                        $kuesioner = MKuesionerLaporanMonev::find($kuesioner['id_kuesioner']);
                        if(empty($kuesioner)){
                            $fail('id kuesioner not found');
                            return;
                        }
                        $rule = [$kuesioner->key => $kuesioner->validation_rules];
                        $validator = Validator::make([$kuesioner->key => $value], $rule);
                        if ($validator->fails()) {
                            $fail($validator->errors()->first());
                        }
                }]
            ];

            
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $this->responseCode = 422;
                $this->responseMessage = $validator->errors()->first();
                $this->responseData = $validator->errors();
                return response()->json($this->getResponse(), $this->responseCode);
            }

            $laporan->id_jabatan_dalam_instansi = $request->id_jabatan_dalam_instansi;
            $laporan->id_d_balai_puspaga_rw = $request->id_d_balai_puspaga_rw;
            $laporan->id_konselor = $request->id_konselor;
            $laporan->date = $request->date;
            $laporan->is_active = $request->is_active;
            $laporan->status = $request->status;
            $laporan->save();

            foreach($request->kuesioner as $key => $kuesioner){
                if(isset($kuesioner['id_answer'])){
                    // Edit
                    $jawaban = LaporanMonevJawaban::find($kuesioner['id_answer']);
                }else{
                    // Create New
                    $jawaban = new LaporanMonevJawaban();
                    $jawaban->id_laporan_monev = $laporan->id;
                    $jawaban->id_kuesioner_laporan_monev = $kuesioner['id_kuesioner'];
                }
                $jawaban->answer = 'temporary_by_system';
                $jawaban->save();
                if($request->hasFile('kuesioner.'.$key.'.answer')){
                    $fileOld = $jawaban->file_model;
                    if($fileOld){
                        $fileOld->forceDelete();
                    }
                    $file = $kuesioner['answer'];
                    $changedName = time() . random_int(100, 999). '.' .$file->getClientOriginalExtension();
                    $is_image = substr($file->getClientMimeType(), 0, 5) == 'image' ?? false;
    
                    $path = 'private/laporan_monev_jawaban/' . $laporan->id;
                    $file->storeAs($path, $changedName);
                    
                    $modelFile = new LaporanMonevJawabanFile();

                    $modelFile->id_laporan_monev_jawaban = $jawaban->id;
                    $modelFile->name = $file->getClientOriginalName();
                    $modelFile->path = $path . '/' . $changedName;
                    $modelFile->size = $file->getSize();
                    $modelFile->ext = $file->getClientOriginalExtension();
                    $modelFile->is_image = $is_image;
                    $modelFile->save();

                    $jawaban->is_file = true;
                    $jawaban->answer = route('file.show', ['id' => Crypt::encrypt($modelFile->id), 'model' => 'LaporanMonevJawabanFile']);
                    $jawaban->save();
                }
                else{
                    $jawaban->answer = $kuesioner['answer'];
                    $jawaban->save();
                }
            }
            DB::commit();
            $result = LaporanMonev::where('id',$laporan->id)->with('jawaban')->first();
            $this->responseCode = 200;
            $this->responseData = $result;
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
        //
    }

    
    /**
     * Verif certain laporan based on id given
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */    
    public function verif(Request $request,$id)
    {
        
        try{
            $data = LaporanMonev::where('id', $id)->first();
            if(!$data){
                $this->responseCode = 404;
                $this->responseMessage = 'Data tidak di temukan';
                return response()->json($this->getResponse(), $this->responseCode);
            }
            DB::beginTransaction();
            if(Auth::user()->id_role == config('env.role.kabid')){
                $data->status = LaporanMonevStatusEnum::VERIFIED_KABID;
            }
            if(Auth::user()->id_role == config('env.role.subkord')){
                $data->status = LaporanMonevStatusEnum::VERIFIED_SUBKOORD;
            }
            $data->save();
            DB::commit();
            $this->responseCode = 200;
            $this->responseMessage = 'Laporan telah diverifikasi';
            $this->responseData = $data;
            return response()->json($this->getResponse(), $this->responseCode);
        }catch(\Exception $e){
            $this->responseCode = 500;
            $this->responseMessage = $e->getMessage();
            DB::rollback();
            return response()->json($this->getResponse(), $this->responseCode);
        }
    }
    
    public function switchStatus($id)
    {
        if(!$laporan = LaporanMonev::find(intval($id))){
            $this->responseCode = 404;
            $this->responseMessage = 'Data tidak di temukan';
            return response()->json($this->getResponse(), $this->responseCode);
        }

        DB::transaction(function () use($laporan) {
            $laporan->is_active = !$laporan->is_active;
            $laporan->save();
        });
        
        $this->responseCode = 200;
        $this->responseMessage = boolval($laporan->is_active) ? 'Data telah diaktifkan' : 'Data telah dinonaktifkan';
        $this->responseData = $laporan;
        return response()->json($this->getResponse(), $this->responseCode);
    }

    public function export(Request $request){
        
        $laporan = MKategoriLaporanMonev::with(['sub_kategori' => function($query){
            $query->orderBy('order','ASC');
            $query->with(['kuesioner' => function($query){
                $query->orderBy('order','ASC');
                $query->where('is_excluded_export',false);
            }]);
        }])
        ->whereHas('sub_kategori', function($query){
            $query->whereHas('kuesioner', function($query){
                $query->where('is_excluded_export',false);
            });
        })
        ->get();
        $laporan_isian = LaporanMonev::with([
            'balai_puspaga_rw.kelurahan.kecamatan',
            'jabatan',
            'balai_puspaga_rw.konselor.dkonselor',
            'konselor.dkonselor'
        ]);
        if($request->filled('tanggal_filter')){
            $laporan_isian->whereDate('date',$request->tanggal_filter);
        }
        $laporan_isian = $laporan_isian->get();
        $laporan_isian->append('active_string');
        ini_set('memory_limit', -1);
        return Excel::download(new LaporanMonevExport(json_decode($laporan), json_decode($laporan_isian) , 'exports.laporanMonevV1'), 'Laporan Monev V1.xlsx');
    }

    public function exportById(Request $request,$id){
        $laporan = LaporanMonev::where('id', $id)->first();
        if(!$laporan){
            $this->responseCode = 404;
            $this->responseMessage = 'Data tidak di temukan';
            return response()->json($this->getResponse(), $this->responseCode);
        }
        $laporan = MKategoriLaporanMonev::with(['sub_kategori' => function($query){
            $query->orderBy('order','ASC');
            $query->with(['kuesioner' => function($query){
                $query->orderBy('order','ASC');
                $query->where('is_excluded_export',false);
            }]);
        }])
        ->whereHas('sub_kategori', function($query){
            $query->whereHas('kuesioner', function($query){
                $query->where('is_excluded_export',false);
            });
        })
        ->get();
        $laporan_isian = LaporanMonev::with([
            'balai_puspaga_rw.kelurahan.kecamatan',
            'jabatan',
            'balai_puspaga_rw.konselor.dkonselor',
            'konselor.dkonselor'
        ]);
        if($request->filled('tanggal_filter')){
            $laporan_isian->whereDate('date',$request->tanggal_filter);
        }
        $laporan_isian = $laporan_isian->get();
        $laporan_isian->append('active_string');
        ini_set('memory_limit', -1);
        return Excel::download(new LaporanMonevExport(json_decode($laporan), json_decode($laporan_isian) , 'exports.laporanMonevV2'), 'Laporan Monev V2.xlsx');
    }
    
    public function listsKuesioner(Request $request){
        try {
            $list = MKategoriLaporanMonev::with(['sub_kategori' => function($query){
                $query->orderBy('order','ASC');
                $query->with(['kuesioner' => function($query){
                    $query->orderBy('order','ASC');
                }]);
            }])->get();

            $this->responseCode = 200;
            $this->responseData = $list;
            return response()->json($this->getResponse(), $this->responseCode);
        } catch (\Exception $e) {
            $this->responseCode = 500;
            $this->responseMessage = $e->getMessage();
            return response()->json($this->getResponse(), $this->responseCode);
        }
    }

    public function detail($id)
    {
        try {
            $kategori = MKategoriLaporanMonev::with('sub_kategori.kuesioner.jawaban')->whereHas('sub_kategori.kuesioner.jawaban', function ($query) use ($id) {
                $query->where('id_laporan_monev', $id);
            })->orderBy('m_kategori_laporan_monev.order', 'ASC')->get();

            $this->saveLog($kategori);
            return $kategori;
        } 
        catch (\Exception $e) {
            $this->responseCode = 500;
            $this->responseMessage = $e->getMessage();
            return response()->json($this->getResponse(), $this->responseCode);
        }
    }
}
