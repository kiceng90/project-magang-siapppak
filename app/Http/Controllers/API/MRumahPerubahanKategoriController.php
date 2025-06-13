<?php

namespace App\Http\Controllers\API;

use Intervention\Image\Facades\Image;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\MRumahPerubahanKategori;
use Illuminate\Support\Facades\Storage;

class MRumahPerubahanKategoriController extends Controller
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

            $modul = MRumahPerubahanKategori::select('*')
                ->when($request->filled('search'), function ($query) use ($request) {
                    $query->where(DB::raw('lower(name)'), 'like', '%' . strtolower($request->search) . '%');
                })
                ->orderBy($sortby, $order)
                ->paginate($limit);

            $this->saveLog($modul);
            return $modul;
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
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json([
                    'code' => 422,
                    'message' => $validator->errors()->first(),
                    'errors' => $validator->errors()
                ], 422);
            }

            $modulData = [
                'name' => $request->name,
            ];

            $modul = MRumahPerubahanKategori::create($modulData);

            DB::commit();
            return response()->json([
                'code' => 201,
                'data' => $modul,
                'message' => 'Modul berhasil ditambahkan'
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
            $modul = MRumahPerubahanKategori::find($id);
            if (!$modul) {
                $this->responseCode = 404;
                $this->responseMessage = 'Data tidak di temukan';
                return response()->json($this->getResponse(), $this->responseCode);
            }

            $this->responseCode = 200;
            $this->responseData = $modul;
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

            // Find the MRumahPerubahanKategori by ID
            $modul = MRumahPerubahanKategori::find($id);
            if (!$modul) {
                return response()->json([
                    'code' => 404,
                    'message' => 'Data tidak ditemukan'
                ], 404);
            }

            // Define validation rules
            $rules = [
                'name' => 'required|string'
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json([
                    'code' => 422,
                    'message' => $validator->errors()->first(),
                    'errors' => $validator->errors()
                ], 422);
            }

            // Update the MRumahPerubahanKategori fields
            $modul->name = $request->name;

            // Save the updated MRumahPerubahanKategori record
            $modul->save();

            DB::commit();
            return response()->json([
                'code' => 200,
                'data' => $modul,
                'message' => 'Modul berhasil diupdate'
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
            $modul = MRumahPerubahanKategori::find($id);
            if (!$modul) {
                $this->responseCode = 404;
                $this->responseMessage = 'Data tidak di temukan';
                return response()->json($this->getResponse(), $this->responseCode);
            }

            $modul->delete();

            $this->responseCode = 200;
            $this->responseMessage = 'Berhasil menghapus data';
            $this->responseData = $modul;
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

            $modul = MRumahPerubahanKategori::select('*');
            if ($request->filled('search')) {
                $modul->where(DB::raw('lower(name)'), 'like', '%' . strtolower($request->search) . '%');
            }
            $modul = $modul->take($limit)->orderBy('id', 'ASC')->get();

            $this->responseCode = 200;
            $this->responseData = $modul;
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

            $modul = MRumahPerubahanKategori::select('*');
            if ($request->filled('search')) {
                $modul->where(DB::raw('lower(name)'), 'like', '%' . strtolower($request->search) . '%');
            }
            $modul = $modul->where('modul.is_active', true)->take($limit)->orderBy('id', 'ASC')->get();

            $this->responseCode = 200;
            $this->responseData = $modul;
            return response()->json($this->getResponse(), $this->responseCode);
        } catch (\Exception $e) {
            $this->responseCode = 500;
            $this->responseMessage = $e->getMessage();
            return response()->json($this->getResponse(), $this->responseCode);
        }
    }

    public function getKategoris(Request $request)
    {
        $userId = $request->user()->id;
        
        $kategoris = MRumahPerubahanKategori::where('is_active', true)
            ->orderBy('id', 'asc')
            ->get();
    
        $result = $kategoris->map(function ($kategori) {
            return [
                'id' => $kategori->id,
                'name' => $kategori->name,
            ];
        });
    
        return response()->json($result);
    }

    public function getKategori($id)
    {
        $kategori = MRumahPerubahanKategori::where('id', $id)->first();
        return response()->json($kategori);
    }

    public function switchStatus($id)
    {
        try {
            $id = intval($id);
            $modul = MRumahPerubahanKategori::find($id);
            if (!$modul) {
                $this->responseCode = 404;
                $this->responseMessage = 'Data tidak di temukan';
                return response()->json($this->getResponse(), $this->responseCode);
            }

            DB::beginTransaction();

            $modul->update([
                'is_active' => !$modul->is_active
            ]);

            $this->responseCode = 200;
            $this->responseMessage = boolval($modul->is_active) ? 'Sumber modul telah diaktifkan' : 'Sumber modul telah dinonaktifkan';
            $this->responseData = $modul;
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
