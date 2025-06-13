<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\MKonselor;
use App\Models\MKonselorFile;

class MKonselorController extends Controller
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

            $konselor = MKonselor::select(
                DB::raw('f.id as foto'), 'm_konselor.*'
            )->leftJoin('m_konselor_file as f', function($j){
                $j->on('m_konselor.id', '=', 'f.id_m_konselor');
            });
            if($request->filled('search')){
                $konselor->where(DB::raw('lower(m_konselor.name)'), 'like', '%' . strtolower($request->search) . '%')
                        ->orWhere('phone_number', 'like', '%' . strtolower($request->search) . '%');
            }
            $konselor = $konselor->orderBy($sortby, $order)->paginate($limit);

            $this->saveLog($konselor);
            return $konselor;
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
                'name' => 'required|string|iunique:m_konselor,name',
                'phone_number' => 'required|string',
                'foto' => 'nullable|mimes:png,jpg,jpeg',
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $this->responseCode = 422;
                $this->responseMessage = $validator->errors()->first();
                $this->responseData = $validator->errors();
                return response()->json($this->getResponse(), $this->responseCode);
            }

            $konselor = MKonselor::create([
                'name' => ($request->name),
                'phone_number' => $request->phone_number,
            ]);

            if($request->hasFile('foto')){
                $file = $request->foto;
                $changedName = time() . random_int(100, 999). '.' .$file->getClientOriginalExtension();
                $is_image = substr($file->getClientMimeType(), 0, 5) == 'image' ?? false;

                $path = 'private/m_konselor/' . $konselor->id;
                $file->storeAs($path, $changedName);

                $modelFile = new MKonselorFile();
                $modelFile->id_m_konselor = $konselor->id;
                $modelFile->name = $file->getClientOriginalName();
                $modelFile->path = $path . '/' . $changedName;
                $modelFile->size = $file->getSize();
                $modelFile->ext = $file->getClientOriginalExtension();
                $modelFile->is_image = $is_image;
                $modelFile->save();
            }

            DB::commit();
            $this->responseCode = 201;
            $this->responseData = $konselor;
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
            $konselor = MKonselor::select(
                DB::raw('f.id as foto'), 'm_konselor.*'
            )->leftJoin('m_konselor_file as f', function($j){
                $j->on('m_konselor.id', '=', 'f.id_m_konselor');
            })->with('dkonselor')->where('m_konselor.id', $id)->first();
            if(!$konselor){
                $this->responseCode = 404;
                $this->responseMessage = 'Data tidak di temukan';
                return response()->json($this->getResponse(), $this->responseCode);
            }

            $this->responseCode = 200;
            $this->responseData = $konselor;
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
            $konselor = MKonselor::find($id);
            if(!$konselor){
                $this->responseCode = 404;
                $this->responseMessage = 'Data tidak di temukan';
                return response()->json($this->getResponse(), $this->responseCode);
            }

            $rules = [
                'name' => 'required|string|iunique:m_konselor,name,'. $id,
                'phone_number' => 'required|string',
                'foto' => 'nullable|mimes:png,jpg,jpeg',
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $this->responseCode = 422;
                $this->responseMessage = $validator->errors()->first();
                $this->responseData = $validator->errors();
                return response()->json($this->getResponse(), $this->responseCode);
            }

            $konselor->name = ($request->name);
            $konselor->phone_number = $request->phone_number;
            $konselor->save();

            
            if($request->hasFile('foto')){
                $deleteFile = $konselor->photo;
                if($deleteFile){
                    $deleteFile->forceDelete();
                }
                $file = $request->foto;
                $changedName = time() . random_int(100, 999). '.' .$file->getClientOriginalExtension();
                $is_image = substr($file->getClientMimeType(), 0, 5) == 'image' ?? false;

                $path = 'private/m_konselor/' . $konselor->id;
                $file->storeAs($path, $changedName);

                $modelFile = new MKonselorFile();
                $modelFile->id_m_konselor = $konselor->id;
                $modelFile->name = $file->getClientOriginalName();
                $modelFile->path = $path . '/' . $changedName;
                $modelFile->size = $file->getSize();
                $modelFile->ext = $file->getClientOriginalExtension();
                $modelFile->is_image = $is_image;
                $modelFile->save();
            }

            DB::commit();
            $this->responseCode = 200;
            $this->responseData = $konselor;
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
            $konselor = MKonselor::find($id);
            if(!$konselor){
                $this->responseCode = 404;
                $this->responseMessage = 'Data tidak di temukan';
                return response()->json($this->getResponse(), $this->responseCode);
            }

            $konselor->delete();

            $this->responseCode = 200;
            $this->responseMessage = 'Berhasil menghapus data';
            $this->responseData = $konselor;
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
            
            $konselor = MKonselor::select('*');
            if($request->filled('search')){
                $konselor->where(DB::raw('lower(name)'), 'like', '%' . strtolower($request->search) . '%');
            }
            $konselor = $konselor->where('m_konselor.is_active', true)->take($limit)->orderBy('name', 'ASC')->get();

            $this->responseCode = 200;
            $this->responseData = $konselor;
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
            $konselor = MKonselor::find($id);
            if(!$konselor){
                $this->responseCode = 404;
                $this->responseMessage = 'Data tidak di temukan';
                return response()->json($this->getResponse(), $this->responseCode);
            }

            DB::beginTransaction();

            $konselor->update([
                'is_active' => !$konselor->is_active
            ]);

            $this->responseCode = 200;
            $this->responseMessage = boolval($konselor->is_active) ? 'Konselor telah diaktifkan' : 'Konselor telah dinonaktifkan';
            $this->responseData = $konselor;
            DB::commit();
            return response()->json($this->getResponse(), $this->responseCode);
        } catch (\Exception $e) {
            $this->responseCode = 500;
            $this->responseMessage = $e->getMessage();
            DB::rollback();
            return response()->json($this->getResponse(), $this->responseCode);
        }
    }
}
