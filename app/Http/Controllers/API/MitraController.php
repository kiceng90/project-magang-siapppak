<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Mitra;
use App\Models\MitraFile;
use App\Models\MKategoriMitra;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\MitraExport;


use Image;

class MitraController extends Controller
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

            $mitra = Mitra::query();
            if($request->filled('search')){
                $mitra->where(DB::raw('lower(mitra.name)'), 'like', '%' . strtolower($request->search) . '%');
            }
            $mitra->with('kategoriMitra');
            $mitra = $mitra->orderBy($sortby, $order)->paginate($limit);
            $this->saveLog($mitra);
            return $mitra;
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
                'address' => 'nullable|string',
                'phone' => 'nullable|string',
                'id_kategori_mitra' => 'required|exists:App\Models\MKategoriMitra,id,deleted_at,NULL',
                'is_active' => 'required|boolean',
                'foto' => 'image|mimes:jpg,png,jpeg|max:5120'
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $this->responseCode = 422;
                $this->responseMessage = $validator->errors()->first();
                $this->responseData = $validator->errors();
                return response()->json($this->getResponse(), $this->responseCode);
            }

            $mitra = Mitra::create([
                'name' => $request->name,
                'address' => $request->address,
                'phone' => $request->phone,
                'id_kategori_mitra' => $request->id_kategori_mitra,
                'is_active' => $request->is_active
            ]);
            
            if($request->hasFile('foto')){
                $file = $request->foto;
                $changedName = time() . random_int(100, 999). '.' .$file->getClientOriginalExtension();
                $is_image = substr($file->getClientMimeType(), 0, 5) == 'image' ?? false;

                $path = 'private/mitra/' . $request->id_kategori_mitra . '/foto';
                $file->storeAs($path, $changedName);

                $canvas = Image::canvas(400, 600, '#ffffff');
                $img = Image::make($file->getRealPath());
                $height = $img->height();
                $width = $img->width();
                $img->resize($width > $height ? 400 : null, $height >= $width ? 600 : null, function ($constraint){
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
                $canvas->insert($img, 'center');
                $canvas->save(storage_path('app/'.$path. '/' . $changedName));

                $modelFile = new MitraFile();
                $modelFile->id_mitra = $mitra->id;
                $modelFile->name = $file->getClientOriginalName();
                $modelFile->path = $path . '/' . $changedName;
                $modelFile->size = $file->getSize();
                $modelFile->ext = $file->getClientOriginalExtension();
                $modelFile->is_image = $is_image;
                $modelFile->save();
            }
            DB::commit();
            $this->responseCode = 201;
            $this->responseData = $mitra;
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
            $mitra = Mitra::where('id', $id)->first();
            if(!$mitra){
                $this->responseCode = 404;
                $this->responseMessage = 'Data tidak di temukan';
                return response()->json($this->getResponse(), $this->responseCode);
            }
            
            $mitra->with('kategoriMitra');
            $this->responseCode = 200;
            $this->responseData = $mitra;
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
            $mitra = Mitra::find($id);
            if(!$mitra){
                $this->responseCode = 404;
                $this->responseMessage = 'Data tidak di temukan';
                return response()->json($this->getResponse(), $this->responseCode);
            }

            $rules = [
                'name' => 'required|string',
                'address' => 'nullable|string',
                'phone' => 'nullable|string',
                'is_active' => 'required|boolean',
                'foto' => 'image|mimes:jpg,png,jpeg|max:5120',
                'id_kategori_mitra' => 'required|exists:App\Models\MKategoriMitra,id,deleted_at,NULL',
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $this->responseCode = 422;
                $this->responseMessage = $validator->errors()->first();
                $this->responseData = $validator->errors();
                return response()->json($this->getResponse(), $this->responseCode);
            }
            $mitra->name = $request->name;
            $mitra->address = $request->address;
            $mitra->phone = $request->phone;
            $mitra->is_active = $request->is_active;
            $mitra->save();

            
            if($request->hasFile('foto')){
                $fotoOld = $mitra->fotoFile;
                if($fotoOld){
                    $fotoOld->forceDelete();
                }

                $file = $request->foto;
                $changedName = time() . random_int(100, 999). '.' .$file->getClientOriginalExtension();
                $is_image = substr($file->getClientMimeType(), 0, 5) == 'image' ?? false;

                $path = 'private/mitra/' . $mitra->id_kategori_mitra . '/foto';
                $file->storeAs($path, $changedName);

                $canvas = Image::canvas(400, 600, '#ffffff');
                $img = Image::make($file->getRealPath());
                $height = $img->height();
                $width = $img->width();
                $img->resize($width > $height ? 400 : null, $height >= $width ? 600 : null, function ($constraint){
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
                $canvas->insert($img, 'center');
                $canvas->save(storage_path('app/'.$path. '/' . $changedName));

                $modelFile = new MitraFile();
                $modelFile->id_mitra = $mitra->id;
                $modelFile->name = $file->getClientOriginalName();
                $modelFile->path = $path . '/' . $changedName;
                $modelFile->size = $file->getSize();
                $modelFile->ext = $file->getClientOriginalExtension();
                $modelFile->is_image = $is_image;
                $modelFile->save();
            }

            DB::commit();
            $this->responseCode = 201;
            $this->responseData = $mitra;
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
            $mitra = Mitra::find($id);
            if(!$mitra){
                $this->responseCode = 404;
                $this->responseMessage = 'Data tidak di temukan';
                return response()->json($this->getResponse(), $this->responseCode);
            }

            $mitra->delete();

            $this->responseCode = 200;
            $this->responseMessage = 'Berhasil menghapus data';
            $this->responseData = $mitra;
            DB::commit();
            return response()->json($this->getResponse(), $this->responseCode);
        } catch (\Exception $e) {
            $this->responseCode = 500;
            $this->responseMessage = $e->getMessage();
            DB::rollback();
            return response()->json($this->getResponse(), $this->responseCode);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexPublic($slug, Request $request)
    {
        $rules = [
            'slug' => 'required|string',
        ];
        $validator = Validator::make(['slug' => $slug], $rules);

        if ($validator->fails()) {
            $this->responseCode = 422;
            $this->responseMessage = $validator->errors()->first();
            $this->responseData = $validator->errors();
            return response()->json($this->getResponse(), $this->responseCode);
        }

        try {
            $limit = $request->limit ? intval($request->limit) : 10;
            $order = $request->order ? $request->order : 'DESC';
            $sortby = $request->sortby ? $request->sortby : 'id';

            $mitra = Mitra::query();
            $mitra->whereHas('kategoriMitra', function($query) use($slug) {
                $query->where('slug', $slug);
            });
            if($request->filled('search')){
                $mitra->where(DB::raw('lower(mitra.name)'), 'like', '%' . strtolower($request->search) . '%');
            }
            $mitra = $mitra->orderBy($sortby, $order)->paginate($limit);

            $this->saveLog($mitra);
            return $mitra;
        } catch (\Exception $e) {
            $this->responseCode = 500;
            $this->responseMessage = $e->getMessage();
            return response()->json($this->getResponse(), $this->responseCode);
        }
    }
    public function switchStatus($id)
    {
        if(!$mitra = Mitra::find(intval($id))){
            $this->responseCode = 404;
            $this->responseMessage = 'Data tidak di temukan';
            return response()->json($this->getResponse(), $this->responseCode);
        }

        DB::transaction(function () use($mitra) {
            $mitra->is_active = !$mitra->is_active;
            $mitra->save();
        });
        
        $this->responseCode = 200;
        $this->responseMessage = boolval($mitra->is_active) ? 'Data telah diaktifkan' : 'Data telah dinonaktifkan';
        $this->responseData = $mitra;
        return response()->json($this->getResponse(), $this->responseCode);
    }

    public function export(Request $req)
    {
        return Excel::download(new MitraExport, 'Master Mitra.xlsx');    
    }
}
