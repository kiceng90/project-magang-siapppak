<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\MRumahPerubahanPilihanJawaban;
use App\Models\MRumahPerubahanSoal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class MRumahPerubahanSoalController extends Controller
{
    public function index(Request $request)
    {
        try {
            $limit = $request->limit ? intval($request->limit) : 10;
            $order = $request->order ? $request->order : 'ASC';
            $sortby = $request->sortby ? $request->sortby : 'id';
            $id_materi = $request->id_materi ? $request->id_materi : '';

            // Select questions (soal) with related materi name as materi_name
            $soal = MRumahPerubahanSoal::where('id_materi', $id_materi)->with('materi');

            // Filter by search query on the "soal" text
            if ($request->filled('search')) {
                $soal->where(function ($q) use ($request) {
                    $s = $request->search;
                    $q->where('name', 'ILIKE', '%' . $s . '%');
                });
            }

            $soal = $soal->orderBy($sortby, $order)->paginate($limit);

            // Log the data if needed
            $this->saveLog($soal);

            return $soal;
        } catch (\Exception $e) {
            $this->responseCode = 500;
            $this->responseMessage = $e->getMessage();
            return response()->json($this->getResponse(), $this->responseCode);
        }
    }

    public function store(Request $request)
    {
        // Validasi data yang masuk
        $validatedData = $request->validate([
            'id_materi' => 'required|exists:materi,id',
            'name' => 'required|string',
            'skor' => 'required|numeric',
            'pilihan_jawaban' => 'required|array|min:1',
            'pilihan_jawaban.*.abjad' => 'required|string|max:1', // contoh: A, B, C, dst.
            'pilihan_jawaban.*.pilihan' => 'required|string',
            'pilihan_jawaban.*.is_active' => 'required|boolean', // Menandai apakah jawaban ini benar atau salah
        ]);

        // Mulai transaksi untuk memastikan semuanya tersimpan dengan benar
        DB::beginTransaction();

        try {
            // Simpan data soal
            $soal = MRumahPerubahanSoal::create([
                'id_materi' => $validatedData['id_materi'],
                'name' => $validatedData['name'],
                'skor' => $validatedData['skor'],
            ]);

            // Simpan setiap pilihan jawaban terkait dengan soal yang baru dibuat
            foreach ($validatedData['pilihan_jawaban'] as $jawaban) {
                MRumahPerubahanPilihanJawaban::create([
                    'id_soal' => $soal->id,                // relasi ke soal
                    'abjad' => $jawaban['abjad'],          // abjad untuk pilihan (A, B, C, dll)
                    'pilihan' => $jawaban['pilihan'],      // teks pilihan jawaban
                    'is_active' => $jawaban['is_active'],  // tandai sebagai jawaban benar/salah
                    'created_by' => auth()->id() ?? null,  // ID user yang membuat (gunakan null jika tidak ada autentikasi)
                ]);
            }

            // Komit transaksi jika semua penyimpanan berhasil
            DB::commit();

            return response()->json(['message' => 'MRumahPerubahanSoal dan pilihan jawaban berhasil disimpan'], 201);
        } catch (\Exception $e) {
            // Rollback jika ada error
            DB::rollback();
            return response()->json(['error' => 'Gagal menyimpan data', 'details' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $id)
    {
        // Validasi data input
        $validatedData = $request->validate([
            'id_materi' => 'exists:materi,id', // Jika ada, harus valid
            'name' => 'string|nullable',
            'skor' => 'numeric|nullable',
            'pilihan_jawaban' => 'array|nullable',
            'pilihan_jawaban.*.abjad' => 'string|max:1|nullable',
            'pilihan_jawaban.*.pilihan' => 'string|nullable',
            'pilihan_jawaban.*.is_active' => 'boolean|nullable',
        ]);

        // Dapatkan ID pengguna untuk referensi
        $userId = auth()->id();

        if (!$userId) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        DB::beginTransaction();

        try {
            // Cari soal
            $soal = MRumahPerubahanSoal::findOrFail($id);

            // Update data soal
            $soal->update(array_filter([
                'id_materi' => $validatedData['id_materi'] ?? $soal->id_materi,
                'name' => $validatedData['name'] ?? $soal->name,
                'skor' => $validatedData['skor'] ?? $soal->skor,
            ], fn($value) => !is_null($value)));

            if (!empty($validatedData['pilihan_jawaban'])) {
                // Ambil daftar abjad yang dikirim dari frontend
                $abjadFromRequest = collect($validatedData['pilihan_jawaban'])->pluck('abjad');
                // Hapus jawaban yang tidak ada di daftar abjad
                $soal->pilihanJawaban()->whereNotIn('abjad', $abjadFromRequest)->delete();

                foreach ($validatedData['pilihan_jawaban'] as $jawaban) {
                    // Pastikan pilihan tidak null atau kosong
                    if (empty($jawaban['pilihan'])) {
                        continue; // Abaikan jika pilihan tidak valid
                    }

                    // Cari apakah pilihan jawaban dengan abjad ini sudah ada
                    $pilihanJawaban = $soal->pilihanJawaban()->where('abjad', $jawaban['abjad'])->first();

                    if ($pilihanJawaban) {
                        // Update jika pilihan jawaban sudah ada
                        $pilihanJawaban->update([
                            'pilihan' => $jawaban['pilihan'], // Data pilihan valid
                            'is_active' => $jawaban['is_active'] ?? $pilihanJawaban->is_active,
                            'updated_by' => $userId, // Tambahkan kolom ini jika digunakan
                        ]);
                    } else {
                        // Tambah baru jika pilihan jawaban tidak ditemukan
                        MRumahPerubahanPilihanJawaban::create([
                            'id_soal' => $soal->id,
                            'abjad' => $jawaban['abjad'] ?? null,
                            'pilihan' => $jawaban['pilihan'], // Data pilihan valid
                            'is_active' => $jawaban['is_active'] ?? false,
                            'created_by' => $userId,
                        ]);
                    }
                }
            } else {
                // Hapus semua pilihan jawaban jika tidak ada yang dikirim
                $soal->pilihanJawaban()->delete();
            }


            DB::commit();

            return response()->json(['message' => 'Soal dan pilihan jawaban berhasil diperbarui'], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => 'Gagal memperbarui data', 'details' => $e->getMessage()], 500);
        }
    }

    public function switchStatus($id)
    {
        if (!$data = MRumahPerubahanSoal::find(intval($id))) {
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

    public function show($id)
    {
        try {
            // Cari soal berdasarkan ID
            $soal = MRumahPerubahanSoal::with('pilihanJawaban')->findOrFail($id);

            return response()->json([
                'message' => 'Data soal berhasil ditemukan',
                'data' => [
                    'id' => $soal->id,
                    'id_materi' => $soal->id_materi,
                    'name' => $soal->name,
                    'skor' => $soal->skor,
                    'pilihan_jawaban' => $soal->pilihanJawaban->map(function ($jawaban) {
                        return [
                            'abjad' => $jawaban->abjad,
                            'pilihan' => $jawaban->pilihan,
                            'is_active' => $jawaban->is_active, // True untuk jawaban benar
                        ];
                    }),
                ],
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Data soal tidak ditemukan',
                'details' => $e->getMessage()
            ], 404);
        }
    }

    public function getMRumahPerubahanSoals($id)
    {
        $soal = MRumahPerubahanSoal::with('pilihanJawaban')->where('id_materi', $id)->where('is_active', true)->orderBy('id', 'asc')->get();
        return response()->json($soal);
    }

    public function getSoals($id)
    {
        $soal = MRumahPerubahanSoal::with('pilihanJawaban')->where('id_materi', $id)->where('is_active', true)->orderBy('id', 'asc')->get();
        return response()->json($soal);
    }

}
