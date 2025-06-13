<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Jawaban;
use App\Models\Materi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Image;

class MateriController extends Controller
{
    public function index(Request $request)
    {
        try {
            $limit = $request->limit ? intval($request->limit) : 10;
            $order = $request->order ? $request->order : 'DESC';
            $sortby = $request->sortby ? $request->sortby : 'order';

            $materi = Materi::query();
            // }
            $materi->with('subkategori.kategori');

            if ($request->filled('search')) {
                $materi->where(function ($q) use ($request) {
                    $s = $request->search;
                    $q->where('name', 'ILIKE', '%' . $s . '%');
                    $q->orWhereHas('subkategori', function ($q) use ($s) {
                        $q->where('name', 'ILIKE', '%' . $s . '%');
                    });
                    $q->orWhereHas('subkategori.kategori', function ($q) use ($s) {
                        $q->where('name', 'ILIKE', '%' . $s . '%');
                    });
                });
            }
            if ($request->filled('id_kategori') && $request->id_kategori != "0") {
                $materi->whereHas('subkategori.kategori', function ($query) use ($request) {
                    $query->where('id', $request->id_kategori);
                });
            }
            if ($request->filled('id_subkategori') && $request->id_subkategori != "0") {
                $materi->whereHas('subkategori', function ($query) use ($request) {
                    $query->where('id', $request->id_subkategori);
                });
            }

            $kategori = $materi->orderBy('id', 'ASC')->paginate($limit);

            $this->saveLog($kategori);
            return $kategori;
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
                'id_sub_kategori' => 'nullable|integer',
                'modul' => 'nullable|file',
                'materi' => 'nullable|file',
                'video' => 'nullable|string',
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
                'id_sub_kategori' => $request->id_sub_kategori,
                'video' => $request->video,
            ];

            if ($request->hasFile('modul')) {
                $modul = $request->file('modul');
                $modulName = time() . '_modul.' . $modul->getClientOriginalExtension();
                $modulPath = 'materi/modul';
                $modulPathStorage = 'public/materi/modul';
                $modul->storeAs($modulPathStorage, $modulName);
                $materiData['modul'] = $modulPath . '/' . $modulName;
            }

            if ($request->hasFile('materi')) {
                $materiFile = $request->file('materi');
                $materiName = time() . '_materi.' . $materiFile->getClientOriginalExtension();
                $materiPath = 'materi/materi';
                $materiPathStorage = 'public/materi/materi';
                $materiFile->storeAs($materiPathStorage, $materiName);
                $materiData['materi'] = $materiPath . '/' . $materiName;
            }

            $materi = Materi::create($materiData);

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
                'id_sub_kategori' => 'nullable|integer',
                'modul' => 'nullable|file',
                'materi' => 'nullable|file',
                'video' => 'nullable|string'
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $this->responseCode = 200;
                $this->responseMessage = $validator->errors()->first();
                $this->responseData = $validator->errors();
                return response()->json($this->getResponse(), $this->responseCode);
            }

            $materi = Materi::findOrFail($id);

            $materiData = [
                'name' => $request->name,
                'id_sub_kategori' => $request->id_sub_kategori,
                'video' => $request->video,
            ];

            if ($request->hasFile('modul')) {
                if ($materi->modul) {
                    Storage::delete($materi->modul);
                }

                $modul = $request->file('modul');
                $modulName = time() . '_modul.' . $modul->getClientOriginalExtension();
                $modulPath = 'materi/modul';
                $modulPathStorage = 'public/materi/modul';
                $modul->storeAs($modulPathStorage, $modulName);
                $materiData['modul'] = $modulPath . '/' . $modulName;
            }

            if ($request->hasFile('materi')) {
                if ($materi->materi) {
                    Storage::delete($materi->materi);
                }

                $materiFile = $request->file('materi');
                $materiName = time() . '_materi.' . $materiFile->getClientOriginalExtension();
                $materiPath = 'materi/materi';
                $materiPathStorage = 'public/materi/materi';
                $materiFile->storeAs($materiPathStorage, $materiName);
                $materiData['materi'] = $materiPath . '/' . $materiName;
            }

            $materi->update($materiData);
            DB::commit();
            return response()->json(['data' => $materi, 'message' => 'Materi updated successfully'], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        try {
            // Retrieve the 'Materi' record by ID with its related 'Sub Kategori' and 'Kategori'
            $materi = Materi::with(['subkategori.kategori'])->findOrFail($id);

            // Format the response data
            $data = [
                'name' => $materi->name,
                'subkategori' => [
                    'name' => $materi->subkategori->name,
                    'kategori' => [
                        'name' => $materi->subkategori->kategori->name
                    ]
                ],
                'modul_url' => $materi->modul ? $materi->modul : null,
                'materi_url' => $materi->materi ? $materi->materi : null,
                'video_url' => $materi->video ? $materi->video : null,
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
        if (!$data = Materi::find(intval($id))) {
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

            $materi = Materi::select('*');
            if ($request->filled('search')) {
                $materi->where(DB::raw('lower(name)'), 'like', '%' . strtolower($request->search) . '%');
            }
            $materi = $materi->where('materi.is_active', true)->take($limit)->orderBy('name', 'ASC')->get();

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
        $materi = Materi::where('is_active', true)
            ->where('id_sub_kategori', $id)
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

    public function getMateri($id)
    {
        $materi = Materi::where('id', $id)
            ->with(['subKategori.kategori'])
            ->firstOrFail();

        return response()->json([
            'id' => $materi->id,
            'name' => $materi->name,
            'video' => $materi->video,
            'modul' => $materi->modul,
            'materi' => $materi->materi,
            'sub_kategori' => [
                'id' => $materi->subKategori->id,
                'name' => $materi->subKategori->name,
            ],
            'kategori' => [
                'id' => $materi->subKategori->kategori->id,
                'name' => $materi->subKategori->kategori->name,
            ],
        ]);
    }

    public function getRiwayatLatihanSoal($id)
    {
        return Materi::where('id_sub_kategori', $id)->where('is_active', true)->orderBy('id', 'asc')->get();
    }

    public function getRiwayatLatihanSoal2($id)
    {
        return Jawaban::where('id_materi', $id)->where('id_user', auth()->user()->id)->orderBy('id', 'desc')->get();
    }
}
