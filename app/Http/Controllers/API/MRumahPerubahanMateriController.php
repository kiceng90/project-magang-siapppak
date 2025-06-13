<?php

namespace App\Http\Controllers\API;

use Intervention\Image\Facades\Image;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\MRumahPerubahanMateri;
use Illuminate\Support\Facades\Storage;

class MRumahPerubahanMateriController extends Controller
{

    public function index(Request $request)
    {
        try {
            $limit = $request->limit ? intval($request->limit) : 10;
            $order = $request->order ? $request->order : 'DESC';
            $sortby = $request->sortby ? $request->sortby : 'id';

            $query = MRumahPerubahanMateri::with('kategori');
            
            // Apply search filter
            if ($request->filled('search')) {
                $query->where(function ($q) use ($request) {
                    $s = $request->search;
                    $q->where('name', 'ILIKE', '%' . $s . '%');
                });
            }
            
            // Apply kategori filter
            if ($request->filled('id_kategori') && $request->id_kategori != "0") {
                $query->where('id_kategori', $request->id_kategori);
            }

            // Get paginated results
            $materi = $query->orderBy($sortby, $order)->paginate($limit);

            // Log activity if needed
            $this->saveLog($materi);

            // Return consistent response structure
            return response()->json([
                'data' => $materi->items(),
                'total' => $materi->total(),
                'current_page' => $materi->currentPage(),
                'per_page' => $materi->perPage(),
                'last_page' => $materi->lastPage()
            ], $this->responseCode);
        } catch (\Exception $e) {
            $this->responseCode = 500;
            $this->responseMessage = $e->getMessage();
            return response()->json($this->getResponse(), $this->responseCode);
        }
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            $rules = [
                'name' => 'required|string',
                'id_kategori' => 'nullable|integer',
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $this->responseCode = 200;
                $this->responseMessage = $validator->errors()->first();
                $this->responseData = $validator->errors();
                return response()->json($this->getResponse(), $this->responseCode);
            }

            $materiData = [
                'name' => $request->name,
                'id_kategori' => $request->id_kategori,
            ];

            $materi = MRumahPerubahanMateri::create($materiData);

            DB::commit();
            return response()->json(['data' => $materi, 'message' => 'Materi created successfully'], 201);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            $rules = [
                'name' => 'required|string',
                'id_kategori' => 'nullable|integer',
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $this->responseCode = 200;
                $this->responseMessage = $validator->errors()->first();
                $this->responseData = $validator->errors();
                return response()->json($this->getResponse(), $this->responseCode);
            }

            $materi = MRumahPerubahanMateri::findOrFail($id);

            $materiData = [
                'name' => $request->name,
                'id_kategori' => $request->id_kategori,
            ];

            $materi->update($materiData);
            DB::commit();
            return response()->json(['data' => $materi, 'message' => 'Materi berhasil diperbaharui'], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        try {
            // Retrieve the 'MRumahPerubahanMateri' record by ID with its related 'Sub Kategori' and 'Kategori'
            $materi = MRumahPerubahanMateri::with(['subkategori.kategori'])->findOrFail($id);

            // Format the response data
            $data = [
                'name' => $materi->name,
                    'kategori' => [
                        'name' => $materi->kategori->name
                    ]
            ];

            return response()->json([
                'status' => 'success',
                'data' => $data
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to fetch materi details: ' . $e->getMessage()
            ], 500);
        }
    }

    public function switchStatus($id)
    {
        if (!$data = MRumahPerubahanMateri::find(intval($id))) {
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

            $materi = MRumahPerubahanMateri::select('*');
            if ($request->filled('search')) {
                $materi->where(DB::raw('lower(name)'), 'like', '%' . strtolower($request->search) . '%');
            }
            $materi = $materi->where('is_active', true)->take($limit)->orderBy('name', 'ASC')->get();

            $this->responseCode = 200;
            $this->responseData = $materi;
            return response()->json($this->getResponse(), $this->responseCode);
        } catch (\Exception $e) {
            $this->responseCode = 500;
            $this->responseMessage = $e->getMessage();
            return response()->json($this->getResponse(), $this->responseCode);
        }
    }

    public function getMateris($id)
    {
        $materi = MRumahPerubahanMateri::where('is_active', true)
            ->where('id_kategori', $id)
            ->orderBy('id', 'asc')
            ->with(['jawaban' => function ($query) {
                $query->where('is_selesai', true)->where('id_user', auth()->user()->id)->latest('created_at');
            }])
            ->get()
            ->map(function ($materi) {
                $jawabanTerbaru = $materi->jawaban->first();
                return [
                    'id' => $materi->id,
                    'name' => $materi->name,
                    'isCompleted' => $jawabanTerbaru ? true : false,
                    'jawaban' => $jawabanTerbaru ? [
                        'id' => $jawabanTerbaru->id,
                        'tanggal' => $jawabanTerbaru->created_at,
                        'skor' => $jawabanTerbaru->skor,
                    ] : null,
                ];
            });

        return response()->json($materi);
    }

    // public function getMateri($id)
    // {
    //     $materi = MRumahPerubahanMateri::where('id', $id)
    //         ->with(['kategori'])
    //         ->firstOrFail();

    //     return response()->json([
    //         'id' => $materi->id,
    //         'name' => $materi->name,
    //         'kategori' => [
    //             'id' => $materi->kategori->id,
    //             'name' => $materi->kategori->name,
    //         ],
    //     ]);
    // }

    public function getMateri($id)
    {
        $materi = MRumahPerubahanMateri::where('id', $id)
            ->with(['kategori'])
            ->firstOrFail();

        return response()->json([
            'id' => $materi->id,
            'name' => $materi->name,
            'kategori' => [
                'id' => $materi->kategori->id,
                'name' => $materi->kategori->name,
            ],
        ]);
    }


    public function getRiwayatLatihanSoal($id)
    {
        return MRumahPerubahanMateri::where('id_sub_kategori', $id)->where('is_active', true)->orderBy('id', 'asc')->get();
    }

}
