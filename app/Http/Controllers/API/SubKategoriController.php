<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\MSubKategoriLaporanMonev;
use App\Models\ProgresSubkategori;
use App\Models\SubKategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class SubKategoriController extends Controller
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

            // Select subkategori with kategori name as kategori_name
            $subkategori = SubKategori::with('kategori')
                ->select('sub_kategori.*', 'kategori.name as kategori_name')
                ->leftJoin('kategori', 'sub_kategori.id_kategori', '=', 'kategori.id');

            if ($request->filled('search')) {
                $subkategori->where(DB::raw('lower(sub_kategori.name)'), 'like', '%' . strtolower($request->search) . '%');
            }
            if ($request->filled('id_kategori')) {
                $subkategori->where('sub_kategori.id_kategori', $request->id_kategori);
            }

            $subkategori = $subkategori->orderBy($sortby, $order)->paginate($limit);
            $this->saveLog($subkategori);

            return $subkategori;
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
                'id_kategori' => 'required|exists:App\Models\kategori,id,deleted_at,NULL',
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $this->responseCode = 422;
                $this->responseMessage = $validator->errors()->first();
                $this->responseData = $validator->errors();
                return response()->json($this->getResponse(), $this->responseCode);
            }

            $subkategori = SubKategori::create([
                'name' => $request->name,
                'id_kategori' => $request->id_kategori
            ]);

            DB::commit();
            $this->responseCode = 201;
            $this->responseData = $subkategori;
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

            $rules = [
                'name' => 'required|string',
                'id_kategori' => 'required|exists:App\Models\kategori,id,deleted_at,NULL',
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $this->responseCode = 422;
                $this->responseMessage = $validator->errors()->first();
                $this->responseData = $validator->errors();
                return response()->json($this->getResponse(), $this->responseCode);
            }

            $subkategori = SubKategori::findOrFail($id);
            $subkategori->update([
                'name' => $request->name,
                'id_kategori' => $request->id_kategori
            ]);

            DB::commit();
            $this->responseCode = 200;
            $this->responseData = $subkategori;
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

    public function switchStatus($id)
    {
        if (!$data = SubKategori::find(intval($id))) {
            $this->responseCode = 404;
            $this->responseMessage = 'Data tidak di temukan';
            return response()->json($this->getResponse(), $this->responseCode);
        }

        DB::transaction(function () use ($data) {
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
            $limit = $request->limit ? intval($request->limit) : 10;

            $subkategori = SubKategori::select('*');
            if ($request->filled('search')) {
                $subkategori->where(DB::raw('lower(name)'), 'like', '%' . strtolower($request->search) . '%');
            }
            $subkategori = $subkategori->where('id_kategori', $request->id_kategori)->take($limit)->orderBy('name', 'ASC')->get();

            $this->responseCode = 200;
            $this->responseData = $subkategori;
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
            $subkategori = SubKategori::select('*');
            
            if ($request->filled('search')) {
                $subkategori->where(DB::raw('lower(name)'), 'like', '%' . strtolower($request->search) . '%');
            }
            if ($request->filled('id_kategori') && $request->id_kategori != 0) {
                $subkategori->where('id_kategori', $request->id_kategori);
            }

            $subkategori = $subkategori->where('sub_kategori.is_active', true)
                ->take($limit)
                ->orderBy('name', 'ASC')
                ->get();

            $this->responseCode = 200;
            $this->responseData = $subkategori;
            return response()->json($this->getResponse(), $this->responseCode);
        } catch (\Exception $e) {
            $this->responseCode = 500;
            $this->responseMessage = $e->getMessage();
            return response()->json($this->getResponse(), $this->responseCode);
        }
    }

    public function getSubKategoris($id)
    {
        $userId = auth()->id();
        $subkategori = SubKategori::where('is_active', true)
            ->where('id_kategori', $id)
            ->with(['progresSubKategori' => function ($query) use ($userId) {
                $query->where('id_user', $userId);
            }])
            ->orderBy('id', 'asc')
            ->get();

        $result = $subkategori->map(function ($sub) {
            $progres = $sub->progresSubKategori->first();

            $status = 1;
            if ($progres) {
                $status = $progres->is_completed ? 3 : 2;
            }

            return [
                'id' => $sub->id,
                'name' => $sub->name,
                'status' => $status,
            ];
        });

        return response()->json($result);
    }

    public function getSubKategori($id)
    {
        $subkategori = SubKategori::with('kategori')->where('id', $id)->first();
        return response()->json($subkategori);
    }

    public function piagam($id)
    {
        try {
            $progres = ProgresSubkategori::with('user')
                ->where('id_sub_kategori', $id)->where('id_user', auth()->user()->id)
                ->firstOrFail();
            $formattedId = str_pad($progres->id, 4, '0', STR_PAD_LEFT);
            $data = [
                'nosurat' => "NO : 400.9.12.1/$formattedId/436.7.8/2024",
                'username' => $progres->user->name,
                'tanggalSertifikat' => $progres->updated_at->format('d F Y'),
            ];
            return response()->json($data, 200);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
