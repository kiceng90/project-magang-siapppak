<?php

namespace App\Http\Controllers\API;

use Intervention\Image\Facades\Image;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\Kategori;
use Illuminate\Support\Facades\Storage;

class KategoriController extends Controller
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

            $kategori = Kategori::select('*')
                ->when($request->filled('search'), function ($query) use ($request) {
                    $query->where(DB::raw('lower(name)'), 'like', '%' . strtolower($request->search) . '%');
                })
                ->orderBy($sortby, $order)
                ->paginate($limit);

            $kategori->getCollection()->transform(function ($item) {
                $item->image = $item->image
                    ? asset('storage/' . $item->image)
                    : asset('private/kategori/image');
                return $item;
            });

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
                'kutipan' => 'nullable|string',
                'deskripsi' => 'nullable|string',
                'image' => 'nullable|image|mimes:jpg,png,jpeg|max:5120'
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json([
                    'code' => 422,
                    'message' => $validator->errors()->first(),
                    'errors' => $validator->errors()
                ], 422);
            }

            $kategoriData = [
                'name' => $request->name,
                'kutipan' => $request->kutipan,
                'deskripsi' => $request->deskripsi,
                'image' => null
            ];

            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $changedName = time() . random_int(100, 999) . '.' . $file->getClientOriginalExtension();
                $path = 'public/kategori/image';
                $pathFileName = 'kategori/image';

                $file->storeAs($path, $changedName);

                $canvas = Image::canvas(600, 600, '#ffffff');
                $img = Image::make($file->getRealPath());
                $img->resize(600, 600, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
                $canvas->insert($img, 'center');
                $canvas->save(storage_path('app/' . $path . '/' . $changedName));

                $kategoriData['image'] = $pathFileName . '/' . $changedName;
            }

            $kategori = Kategori::create($kategoriData);

            DB::commit();
            return response()->json([
                'code' => 201,
                'data' => $kategori,
                'message' => 'Kategori created successfully'
            ], 201);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'code' => 500,
                'message' => 'An error occurred: ' . $e->getMessage()
            ], 500);
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
            $kategori = Kategori::find($id);
            if (!$kategori) {
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

            // Find the Kategori by ID
            $kategori = Kategori::find($id);
            if (!$kategori) {
                return response()->json([
                    'code' => 404,
                    'message' => 'Data tidak ditemukan'
                ], 404);
            }

            // Define validation rules
            $rules = [
                'name' => 'required|string|unique:kategori,name,' . $id,
                'kutipan' => 'nullable|string',
                'deskripsi' => 'nullable|string',
                'image' => 'nullable|image|mimes:jpg,png,jpeg|max:5120'
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json([
                    'code' => 422,
                    'message' => $validator->errors()->first(),
                    'errors' => $validator->errors()
                ], 422);
            }

            // Update the Kategori fields
            $kategori->name = $request->name;
            $kategori->kutipan = $request->kutipan;
            $kategori->deskripsi = $request->deskripsi;

            // Handle image upload if a new image is provided
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $changedName = time() . random_int(100, 999) . '.' . $file->getClientOriginalExtension();
                $path = 'public/kategori/image';
                $pathFileName = 'kategori/image';

                // Store the new image
                $file->storeAs($path, $changedName);

                // Resize and save the image
                $canvas = Image::canvas(600, 600, '#ffffff');
                $img = Image::make($file->getRealPath());
                $img->resize(600, 600, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
                $canvas->insert($img, 'center');
                $canvas->save(storage_path('app/' . $path . '/' . $changedName));

                // Delete the old image if it exists
                if ($kategori->image) {
                    Storage::delete($kategori->image);
                }

                // Update the image path in the Kategori record
                $kategori->image = $pathFileName . '/' . $changedName;
            }

            // Save the updated Kategori record
            $kategori->save();

            DB::commit();
            return response()->json([
                'code' => 200,
                'data' => $kategori,
                'message' => 'Kategori updated successfully'
            ], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'code' => 500,
                'message' => 'An error occurred: ' . $e->getMessage()
            ], 500);
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
            $kategori = Kategori::find($id);
            if (!$kategori) {
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

    public function lists(Request $request)
    {
        try {
            $limit = $request->limit ? intval($request->limit) : 10;

            $kategori = Kategori::select('*');
            if ($request->filled('search')) {
                $kategori->where(DB::raw('lower(name)'), 'like', '%' . strtolower($request->search) . '%');
            }
            $kategori = $kategori->take($limit)->orderBy('id', 'ASC')->get();

            $this->responseCode = 200;
            $this->responseData = $kategori;
            return response()->json($this->getResponse(), $this->responseCode);
        } catch (\Exception $e) {
            $this->responseCode = 500;
            $this->responseMessage = $e->getMessage();
            return response()->json($this->getResponse(), $this->responseCode);
        }
    }

    public function listsDB(Request $request)
    {
        try {
            $limit = $request->limit ? intval($request->limit) : 10;

            $kategori = Kategori::select('*');
            if ($request->filled('search')) {
                $kategori->where(DB::raw('lower(name)'), 'like', '%' . strtolower($request->search) . '%');
            }
            $kategori = $kategori->where('kategori.is_active', true)->take($limit)->orderBy('id', 'ASC')->get();

            $this->responseCode = 200;
            $this->responseData = $kategori;
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
            $kategori = Kategori::find($id);
            if (!$kategori) {
                $this->responseCode = 404;
                $this->responseMessage = 'Data tidak di temukan';
                return response()->json($this->getResponse(), $this->responseCode);
            }

            DB::beginTransaction();

            $kategori->update([
                'is_active' => !$kategori->is_active
            ]);

            $this->responseCode = 200;
            $this->responseMessage = boolval($kategori->is_active) ? 'Sumber kategori telah diaktifkan' : 'Sumber kategori telah dinonaktifkan';
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

    public function getKategoris(Request $request)
    {
        $userId = $request->user()->id;
        $categories = Kategori::where('is_active', true)
            ->with([
                'subKategoris' => function ($query) {
                    $query->where('is_active', true);
                },
                'subKategoris.progresSubKategori' => function ($query) use ($userId) {
                    $query->where('id_user', $userId);
                }
            ])
            ->orderBy('id', 'asc')
            ->get();

        $isPreviousCompleted = true;
        $firstCategoryId = $categories->first()?->id;

        $result = $categories->map(function ($category) use (&$isPreviousCompleted, $firstCategoryId) {
            $allCompleted = $category->subKategoris->isNotEmpty() && $category->subKategoris->every(function ($subKategori) {
                $progres = $subKategori->progresSubKategori->first();
                return $progres && $progres->is_completed;
            });

            $totalSubCategories = $category->subKategoris->count();
            $totalCompleteSubCategories = $category->subKategoris->filter(function ($subKategori) {
                return $subKategori->progresSubKategori->first()?->is_completed === true;
            })->count();

            $progress = $totalSubCategories > 0
                ? ($totalCompleteSubCategories / $totalSubCategories) * 100
                : 0;
            $progress = round($progress);

            $isDisabled = $category->id !== $firstCategoryId && !$isPreviousCompleted;
            $isPreviousCompleted = $allCompleted;

            return [
                'id' => $category->id,
                'name' => $category->name,
                'deskripsi' => $category->deskripsi,
                'kutipan' => $category->kutipan,
                'progress' => $progress,
                'image' => $category->image,
                'is_completed' => $allCompleted,
                'is_disabled' => $isDisabled,
            ];
        });

        return response()->json($result);
    }

    public function getKategori($id)
    {
        $kategori = Kategori::where('id', $id)->first();
        return response()->json($kategori);
    }
}
