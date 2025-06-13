<?php

namespace App\Http\Controllers\API;

use App\Enums\artikelJenisEnum;
use App\Http\Controllers\Controller;
use App\Models\Artikel;
use App\Models\ArtikelFile;
use App\Models\DMahasiswa;
use App\Models\MahasiswaBalaiPuspagaRW;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Intervention\Image\Facades\Image;

class ArtikelController extends Controller
{

    public function index(Request $request)
    {
        try {
            $user = auth()->user(); 
            $limit = $request->limit ? intval($request->limit) : 10;
            $order = $request->order ? $request->order : 'DESC';
            $sortby = $request->sortby ? $request->sortby : 'id';

            $artikel = Artikel::query();

            if ($user->id_role !== 1) {
                $artikel->where('created_by', $user->id);
            }

            if ($request->filled('search')) {
                $artikel->where(function ($q) use ($request) {
                    $s = $request->search;
                    $q->where('title', 'ILIKE', '%' . $s . '%')
                    ->orWhere('description', 'ILIKE', '%' . $s . '%');
                });
            }

            $artikel = $artikel->orderBy($sortby, $order)->paginate($limit);
            
            return response()->json($artikel);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            $rules = [
                'title' => 'required|string',
                'description' => 'string',
                'nim' => 'string',
                'nama_mahasiswa' => 'string',
                'kecamatan_puspaga' => 'string',
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

            $artikel = Artikel::create([
                'title' => $request->title,
                'description' => strip_tags($request->description),
                'nim' => $request->nim,
                'nama_mahasiswa' => $request->nama_mahasiswa,
                'kecamatan_puspaga' => $request->kecamatan_puspaga,
                'is_active' => $request->is_active
            ]);

            if ($request->hasFile('file_thumbnail')) {
                $file = $request->file_thumbnail;
                $changedName = time() . random_int(100, 999) . '.' . $file->getClientOriginalExtension();
                $is_image = substr($file->getClientMimeType(), 0, 5) == 'image' ?? false;

                $path = 'private/artikel/' . $artikel->id . '/foto';
                $file->storeAs($path, $changedName);

                $canvas = Image::canvas(300, 300, '#ffffff');
                $img = Image::make($file->getRealPath());
                $height = $img->height();
                $width = $img->width();
                $img->resize($width > $height ? 300 : null, $height >= $width ? 300 : null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
                $canvas->insert($img, 'center');
                $canvas->save(storage_path('app/' . $path . '/' . $changedName));

                $modelFile = new ArtikelFile();
                $modelFile->id_artikel = $artikel->id;
                $modelFile->name = $file->getClientOriginalName();
                $modelFile->path = $path . '/' . $changedName;
                $modelFile->size = $file->getSize();
                $modelFile->ext = $file->getClientOriginalExtension();
                $modelFile->is_image = $is_image;
                $modelFile->save();
            }
            DB::commit();
            $this->responseCode = 201;
            $this->responseData = $artikel;
            return response()->json($this->getResponse(), $this->responseCode);
        } catch (\Exception $e) {
            $this->responseCode = 500;
            $this->responseMessage = $e->getMessage();
            DB::rollback();
            return response()->json($this->getResponse(), $this->responseCode);
        }
    }

    public function show($id)
    {

        try {
            $id = intval($id);
            $artikel = Artikel::where('id', $id)->first();
            if (!$artikel) {
                $this->responseCode = 404;
                $this->responseMessage = 'Data tidak di temukan';
                return response()->json($this->getResponse(), $this->responseCode);
            }

            $this->responseCode = 200;
            $this->responseData = $artikel;
            return response()->json($this->getResponse(), $this->responseCode);
        } catch (\Exception $e) {
            $this->responseCode = 500;
            $this->responseMessage = $e->getMessage();
            return response()->json($this->getResponse(), $this->responseCode);
        }
    }

    public function update(Request $request, $id)
    {

        try {
            DB::beginTransaction();

            $id = intval($id);
            $artikel = Artikel::find($id);
            if (!$artikel) {
                $this->responseCode = 404;
                $this->responseMessage = 'Data tidak di temukan';
                return response()->json($this->getResponse(), $this->responseCode);
            }

            $rules = [
                'title' => 'required|string',
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
            $artikel->title = $request->title;
            $artikel->description =strip_tags($request->description);
            $artikel->is_active = $request->is_active;
            $artikel->save();

            if ($request->hasFile('file_thumbnail')) {
                $fileOld = $artikel->fileThumbnailFile;
                if ($fileOld) {
                    $fileOld->forceDelete();
                }
                $file = $request->file_thumbnail;
                $changedName = time() . random_int(100, 999) . '.' . $file->getClientOriginalExtension();
                $is_image = substr($file->getClientMimeType(), 0, 5) == 'image' ?? false;

                $path = 'private/artikel/' . $artikel->id . '/foto';
                $file->storeAs($path, $changedName);

                $canvas = Image::canvas(300, 300, '#ffffff');
                $img = Image::make($file->getRealPath());
                $height = $img->height();
                $width = $img->width();
                $img->resize($width > $height ? 300 : null, $height >= $width ? 300 : null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
                $canvas->insert($img, 'center');
                $canvas->save(storage_path('app/' . $path . '/' . $changedName));

                $modelFile = new ArtikelFile();
                $modelFile->id_artikel = $artikel->id;
                $modelFile->name = $file->getClientOriginalName();
                $modelFile->path = $path . '/' . $changedName;
                $modelFile->size = $file->getSize();
                $modelFile->ext = $file->getClientOriginalExtension();
                $modelFile->is_image = $is_image;
                $modelFile->save();
            }
            DB::commit();
            $this->responseCode = 201;
            $this->responseData = $artikel;
            return response()->json($this->getResponse(), $this->responseCode);
        } catch (\Exception $e) {
            $this->responseCode = 500;
            $this->responseMessage = $e->getMessage();
            DB::rollback();
            return response()->json($this->getResponse(), $this->responseCode);
        }
    }

    public function destroy($id)
    {

        try {
            DB::beginTransaction();
            $id = intval($id);
            $artikel = Artikel::find($id);
            if (!$artikel) {
                $this->responseCode = 404;
                $this->responseMessage = 'Data tidak di temukan';
                return response()->json($this->getResponse(), $this->responseCode);
            }

            $artikel->delete();

            $this->responseCode = 200;
            $this->responseMessage = 'Berhasil menghapus data';
            $this->responseData = $artikel;
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
        if (!$artikel = Artikel::find(intval($id))) {
            $this->responseCode = 404;
            $this->responseMessage = 'Data tidak di temukan';
            return response()->json($this->getResponse(), $this->responseCode);
        }

        DB::transaction(function () use ($artikel) {
            $artikel->is_active = !$artikel->is_active;
            $artikel->save();
        });

        $this->responseCode = 200;
        $this->responseMessage = boolval($artikel->is_active) ? 'Data telah diaktifkan' : 'Data telah dinonaktifkan';
        $this->responseData = $artikel;
        return response()->json($this->getResponse(), $this->responseCode);
    }

    public function recent(Request $request)
    {
        try {
            $query = Artikel::orderBy('created_at', 'DESC');
    
            if ($request->has('is_active')) {
                $query->where('is_active', true); 
            }
    
            $artikel = $query->take(4)->get();
    
            $this->saveLog($artikel);
    
            return response()->json($artikel, 200);
        } catch (\Exception $e) {
            $this->responseCode = 500;
            $this->responseMessage = $e->getMessage();
            return response()->json($this->getResponse(), $this->responseCode);
        }
    }
    
    public function indexPublic(Request $request)
    {
        try {
            
            $limit = $request->limit ? intval($request->limit) : 10;
            $order = $request->order ? $request->order : 'DESC';
            $sortby = $request->sortby ? $request->sortby : 'created_at';
            $type = $request->type;

            $artikel = Artikel::query();
            if ($type) {
                $artikel = $artikel->where('title', $type);
            }
            if ($request->has('is_active')) {
                $artikel->where('is_active', true);
            }
            if ($request->has('search') && !empty($request->search)) {
                $search = $request->search;
                $artikel->where('title', 'ILIKE', "%{$search}%");
            }    
    
            $artikel = $artikel->orderBy($sortby, $order)->paginate($limit);

            $this->saveLog($artikel);
            return $artikel;
        } catch (\Exception $e) {
            $this->responseCode = 500;
            $this->responseMessage = $e->getMessage();
            return response()->json($this->getResponse(), $this->responseCode);
        }
    }

    public function getMahasiswaByNIM(Request $request)
    {
        $nim = $request->get('nim');

        if (!$nim) {
            return response()->json([
                'success' => false,
                'message' => 'NIM tidak boleh kosong.',
            ], 400);
        }

        // Cari data mahasiswa berdasarkan NIM
        $mahasiswa = DMahasiswa::with([
            'puspaga_rw.balai_puspaga.kelurahan', // Relasi ke kecamatan melalui puspaga
        ])->where('nim', $nim)->first();

        if (!$mahasiswa) {
            return response()->json([
                'success' => false,
                'message' => 'Mahasiswa tidak ditemukan.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'nama_mahasiswa' => $mahasiswa->name ?? '-',
                'kecamatan_puspaga' => $mahasiswa->puspaga_rw->balai_puspaga->kelurahan->kecamatan->name ?? '-',
            ],
        ]);
    }
}