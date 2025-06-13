<?php

namespace App\Http\Controllers\API;

use App\Enums\KieJenisEnum;
use App\Http\Controllers\Controller;
use App\Models\Kie;
use App\Models\KieFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Intervention\Image\Facades\Image;

class KieController extends Controller
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

            $kie = Kie::query();

            if ($request->filled('search')) {
                $kie->where(function ($q) use ($request) {
                    $s = $request->search;
                    $q->where('title', 'ILIKE', '%' . $s . '%');
                    $q->orWhere('description', 'ILIKE', '%' . $s . '%');
                });
            }

            $kie = $kie->orderBy($sortby, $order)->paginate($limit);
            $this->saveLog($kie);
            return $kie;
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
                'title' => 'required|string',
                'type' => ['required',Rule::in(KieJenisEnum::getValues())],
                'file_image' => 'required_if:type,'.KieJenisEnum::GAMBAR.'|image|mimes:jpg,jpeg,png|max:5120',
                'url_video_youtube' => 'required_if:type,'.KieJenisEnum::VIDEO.'|url',
                'pdf' => 'required_if:type,'.KieJenisEnum::PDF.'|mimes:pdf|max:5120',
                'description' => 'string',
                'is_active' => 'required|boolean',
                'file_thumbnail' => 'required|image|mimes:jpg,png,jpeg|max:5120',
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $this->responseCode = 422;
                $this->responseMessage = $validator->errors()->first();
                $this->responseData = $validator->errors();
                return response()->json($this->getResponse(), $this->responseCode);
            }

            $kie = Kie::create([
                'title' => $request->title,
                'type' => $request->type,
                'description' => $request->description,
                'is_active' => $request->is_active
            ]);
            
            if($request->type == KieJenisEnum::GAMBAR && $request->hasFile('file_image')){
                $file = $request->file_image;
                $changedName = time() . random_int(100, 999). '.' .$file->getClientOriginalExtension();
                $is_image = substr($file->getClientMimeType(), 0, 5) == 'image' ?? false;

                $path = 'private/kie/' . $kie->id . '/foto';
                $file->storeAs($path, $changedName);

                // $canvas = Image::canvas(400, 600, '#ffffff');
                // $img = Image::make($file->getRealPath());
                // $height = $img->height();
                // $width = $img->width();
                // $img->resize($width > $height ? 400 : null, $height >= $width ? 600 : null, function ($constraint){
                //     $constraint->aspectRatio();
                //     $constraint->upsize();
                // });
                // $canvas->insert($img, 'center');
                // $canvas->save(storage_path('app/'.$path. '/' . $changedName));

                $modelFile = new KieFile();
                $modelFile->id_kie = $kie->id;
                $modelFile->name = $file->getClientOriginalName();
                $modelFile->path = $path . '/' . $changedName;
                $modelFile->size = $file->getSize();
                $modelFile->ext = $file->getClientOriginalExtension();
                $modelFile->is_image = $is_image;
                $modelFile->type = "content";
                $modelFile->save();
            }
            
            if($request->type == KieJenisEnum::PDF && $request->hasFile('pdf')){
                $file = $request->pdf;
                $changedName = time() . random_int(100, 999). '.' .$file->getClientOriginalExtension();
                $is_image = substr($file->getClientMimeType(), 0, 5) == 'image' ?? false;

                $path = 'private/kie/' . $kie->id . '/foto';
                $file->storeAs($path, $changedName);

                $modelFile = new KieFile();
                $modelFile->id_kie = $kie->id;
                $modelFile->name = $file->getClientOriginalName();
                $modelFile->path = $path . '/' . $changedName;
                $modelFile->size = $file->getSize();
                $modelFile->ext = $file->getClientOriginalExtension();
                $modelFile->is_image = $is_image;
                $modelFile->type = "content";
                $modelFile->save();
            }

            if($request->type == KieJenisEnum::VIDEO && $request->has('url_video_youtube')){
                $kie->url_video_youtube = $request->url_video_youtube;
                $kie->save();
            }

            if($request->hasFile('file_thumbnail')){
                $file = $request->file_thumbnail;
                $changedName = time() . random_int(100, 999). '.' .$file->getClientOriginalExtension();
                $is_image = substr($file->getClientMimeType(), 0, 5) == 'image' ?? false;

                $path = 'private/kie/' . $kie->id . '/foto';
                $file->storeAs($path, $changedName);

                $canvas = Image::canvas(300, 300, '#ffffff');
                $img = Image::make($file->getRealPath());
                $height = $img->height();
                $width = $img->width();
                $img->resize($width > $height ? 300 : null, $height >= $width ? 300 : null, function ($constraint){
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
                $canvas->insert($img, 'center');
                $canvas->save(storage_path('app/'.$path. '/' . $changedName));

                $modelFile = new KieFile();
                $modelFile->id_kie = $kie->id;
                $modelFile->name = $file->getClientOriginalName();
                $modelFile->path = $path . '/' . $changedName;
                $modelFile->size = $file->getSize();
                $modelFile->ext = $file->getClientOriginalExtension();
                $modelFile->is_image = $is_image;
                $modelFile->type = "thumbnail";
                $modelFile->save();
            }
            DB::commit();
            $this->responseCode = 201;
            $this->responseData = $kie;
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
            $kie = Kie::where('id', $id)->first();
            if(!$kie){
                $this->responseCode = 404;
                $this->responseMessage = 'Data tidak di temukan';
                return response()->json($this->getResponse(), $this->responseCode);
            }
            
            $this->responseCode = 200;
            $this->responseData = $kie;
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
            $kie = Kie::find($id);
            if(!$kie){
                $this->responseCode = 404;
                $this->responseMessage = 'Data tidak di temukan';
                return response()->json($this->getResponse(), $this->responseCode);
            }

            $rules = [
                'title' => 'required|string',
                'type' => ['required',Rule::in(KieJenisEnum::getValues())],
                // 'file_image' => 'required_if:type,'.KieJenisEnum::fromName("GAMBAR").'|image|mimes:jpg,jpeg,png|max:5120',
                // 'url_video_youtube' => 'required_if:type,'.KieJenisEnum::fromName("VIDEO").'|url',
                // 'pdf' => 'required_if:type,'.KieJenisEnum::fromName("PDF").'|mimes:pdf|max:5120',
                'file_image' => Rule::requiredIf(function () use ($request,$kie) {
                    return $request->type != $kie->type && $request->type == KieJenisEnum::GAMBAR;
                }),
                'url_video_youtube' => Rule::requiredIf(function () use ($request,$kie) {
                    return $request->type != $kie->type && $request->type == KieJenisEnum::VIDEO;
                }),
                'pdf' => Rule::requiredIf(function () use ($request,$kie) {
                    return $request->type != $kie->type && $request->type == KieJenisEnum::PDF;
                }),
                'description' => 'string',
                'is_active' => 'required|boolean',
                'file_thumbnail' => 'image|mimes:jpg,png,jpeg|max:5120',
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $this->responseCode = 422;
                $this->responseMessage = $validator->errors()->first();
                $this->responseData = $validator->errors();
                return response()->json($this->getResponse(), $this->responseCode);
            }
            $kie->title = $request->title;
            $kie->type = $request->type;
            $kie->description = $request->description;
            $kie->is_active = $request->is_active;
            $kie->save();

            if($request->type == KieJenisEnum::GAMBAR && $request->hasFile('file_image')){
                $fileOld = $kie->fileImageFile;
                if($fileOld){
                    $fileOld->forceDelete();
                }
                $file = $request->file_image;
                $changedName = time() . random_int(100, 999). '.' .$file->getClientOriginalExtension();
                $is_image = substr($file->getClientMimeType(), 0, 5) == 'image' ?? false;

                $path = 'private/kie/' . $kie->id . '/foto';
                $file->storeAs($path, $changedName);

                // $canvas = Image::canvas(400, 600, '#ffffff');
                // $img = Image::make($file->getRealPath());
                // $height = $img->height();
                // $width = $img->width();
                // $img->resize($width > $height ? 400 : null, $height >= $width ? 600 : null, function ($constraint){
                //     $constraint->aspectRatio();
                //     $constraint->upsize();
                // });
                // $canvas->insert($img, 'center');
                // $canvas->save(storage_path('app/'.$path. '/' . $changedName));

                $modelFile = new KieFile();
                $modelFile->id_kie = $kie->id;
                $modelFile->name = $file->getClientOriginalName();
                $modelFile->path = $path . '/' . $changedName;
                $modelFile->size = $file->getSize();
                $modelFile->ext = $file->getClientOriginalExtension();
                $modelFile->is_image = $is_image;
                $modelFile->type = "content";
                $modelFile->save();
            }
            
            if($request->type == KieJenisEnum::PDF && $request->hasFile('pdf')){
                $fileOld = $kie->filePdfFile;
                if($fileOld){
                    $fileOld->forceDelete();
                }
                $file = $request->pdf;
                $changedName = time() . random_int(100, 999). '.' .$file->getClientOriginalExtension();
                $is_image = substr($file->getClientMimeType(), 0, 5) == 'image' ?? false;

                $path = 'private/kie/' . $kie->id . '/foto';
                $file->storeAs($path, $changedName);

                $modelFile = new KieFile();
                $modelFile->id_kie = $kie->id;
                $modelFile->name = $file->getClientOriginalName();
                $modelFile->path = $path . '/' . $changedName;
                $modelFile->size = $file->getSize();
                $modelFile->ext = $file->getClientOriginalExtension();
                $modelFile->is_image = $is_image;
                $modelFile->type = "content";
                $modelFile->save();
            }

            if($request->type == KieJenisEnum::VIDEO && $request->has('url_video_youtube')){
                $kie->url_video_youtube = $request->url_video_youtube;
                $kie->save();
            }

            if($request->hasFile('file_thumbnail')){
                $fileOld = $kie->fileThumbnailFile;
                if($fileOld){
                    $fileOld->forceDelete();
                }
                $file = $request->file_thumbnail;
                $changedName = time() . random_int(100, 999). '.' .$file->getClientOriginalExtension();
                $is_image = substr($file->getClientMimeType(), 0, 5) == 'image' ?? false;

                $path = 'private/kie/' . $kie->id . '/foto';
                $file->storeAs($path, $changedName);

                $canvas = Image::canvas(300, 300, '#ffffff');
                $img = Image::make($file->getRealPath());
                $height = $img->height();
                $width = $img->width();
                $img->resize($width > $height ? 300 : null, $height >= $width ? 300 : null, function ($constraint){
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
                $canvas->insert($img, 'center');
                $canvas->save(storage_path('app/'.$path. '/' . $changedName));

                $modelFile = new KieFile();
                $modelFile->id_kie = $kie->id;
                $modelFile->name = $file->getClientOriginalName();
                $modelFile->path = $path . '/' . $changedName;
                $modelFile->size = $file->getSize();
                $modelFile->ext = $file->getClientOriginalExtension();
                $modelFile->is_image = $is_image;
                $modelFile->type = "thumbnail";
                $modelFile->save();
            }
            DB::commit();
            $this->responseCode = 201;
            $this->responseData = $kie;
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
            $kie = Kie::find($id);
            if(!$kie){
                $this->responseCode = 404;
                $this->responseMessage = 'Data tidak di temukan';
                return response()->json($this->getResponse(), $this->responseCode);
            }

            $kie->delete();

            $this->responseCode = 200;
            $this->responseMessage = 'Berhasil menghapus data';
            $this->responseData = $kie;
            DB::commit();
            return response()->json($this->getResponse(), $this->responseCode);
        } catch (\Exception $e) {
            $this->responseCode = 500;
            $this->responseMessage = $e->getMessage();
            DB::rollback();
            return response()->json($this->getResponse(), $this->responseCode);
        }
    }
    public function getKieTypes(){
        try {
            $data = KieJenisEnum::toObject();
            $this->responseCode = 201;
            $this->responseData = $data;
            return response()->json($this->getResponse(), $this->responseCode);
        } catch (\Exception $e) {
            $this->responseCode = 500;
            $this->responseMessage = $e->getMessage();
            DB::rollback();
            return response()->json($this->getResponse(), $this->responseCode);
        }
    }
    public function getKieByTypes($type,Request $request)
    {
        
        try {
            $limit = $request->limit ? intval($request->limit) : 10;
            $order = $request->order ? $request->order : 'DESC';
            $sortby = $request->sortby ? $request->sortby : 'id';

            $kie = Kie::where('type',$type);
            $kie = $kie->orderBy($sortby, $order)->paginate($limit);
            $this->saveLog($kie);
            return $kie;
        } catch (\Exception $e) {
            $this->responseCode = 500;
            $this->responseMessage = $e->getMessage();
            return response()->json($this->getResponse(), $this->responseCode);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexPublic(Request $request)
    {
        try {
            
            $limit = $request->limit ? intval($request->limit) : 10;
            $order = $request->order ? $request->order : 'DESC';
            $sortby = $request->sortby ? $request->sortby : 'created_at';
            $type = $request->type;

            $kie = Kie::query();
            if ($type) {
                $kie = $kie->where('type', $type);
            }
            $kie = $kie->orderBy($sortby, $order)->paginate($limit);

            $this->saveLog($kie);
            return $kie;
        } catch (\Exception $e) {
            $this->responseCode = 500;
            $this->responseMessage = $e->getMessage();
            return response()->json($this->getResponse(), $this->responseCode);
        }
    }
    public function switchStatus($id)
    {
        if(!$kie = Kie::find(intval($id))){
            $this->responseCode = 404;
            $this->responseMessage = 'Data tidak di temukan';
            return response()->json($this->getResponse(), $this->responseCode);
        }

        DB::transaction(function () use($kie) {
            $kie->is_active = !$kie->is_active;
            $kie->save();
        });
        
        $this->responseCode = 200;
        $this->responseMessage = boolval($kie->is_active) ? 'Data telah diaktifkan' : 'Data telah dinonaktifkan';
        $this->responseData = $kie;
        return response()->json($this->getResponse(), $this->responseCode);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function recent(Request $request)
    {
        try {
            $kie = Kie::orderBy('created_at', 'DESC')->take(4)->get();

            $this->saveLog($kie);
            return $kie;
        } catch (\Exception $e) {
            $this->responseCode = 500;
            $this->responseMessage = $e->getMessage();
            return response()->json($this->getResponse(), $this->responseCode);
        }
    }
}
