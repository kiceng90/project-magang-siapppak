<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RumahPerubahanDetailJawaban;
use App\Models\RumahPerubahanJawaban;
use App\Models\MRumahPerubahanMateri;
use App\Models\MRumahPerubahanPilihanJawaban;
use App\Models\ProgresSubkategori;
use App\Models\MRumahPerubahanSoal;
use Illuminate\Support\Facades\Log;

class RumahPerubahanJawabanDetailController extends Controller
{
    public function submitAnswers(Request $request)
    {
        $request->validate([
            'id_jawaban' => 'required|exists:rumah_perubahan_jawaban,id',
            'answers' => 'nullable',
            'answers.*.id_soal' => 'required|exists:m_rumah_perubahan_soal,id',
            'answers.*.id_pilihan_jawaban' => 'required|exists:m_rumah_perubahan_pilihan_jawaban,id',
            'answers.*.skor' => 'nullable|integer',
        ]);

        $idJawaban = $request->input('id_jawaban');
        $answers = $request->input('answers');

        $jawabanDetails = [];
        if ($answers) {
            foreach ($answers as $answer) {
                $pilihanJawaban = MRumahPerubahanPilihanJawaban::where('id', $answer['id_pilihan_jawaban'])
                    ->where('id_soal', $answer['id_soal'])
                    ->first();

                if (!$pilihanJawaban) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Pilihan jawaban tidak valid.',
                    ], 400);
                }

                $skor = 0;
                if ($pilihanJawaban->is_active) {
                    $soal = MRumahPerubahanSoal::find($answer['id_soal']);
                    if ($soal) {
                        $skor = $soal->skor;
                    }
                }

                $jawabanDetails[] = [
                    'id_jawaban' => $idJawaban,
                    'id_soal' => $answer['id_soal'],
                    'id_pilihan_jawaban' => $answer['id_pilihan_jawaban'],
                    'skor' => $skor,
                ];
            }
            RumahPerubahanDetailJawaban::insert($jawabanDetails);
        }
        return $this->updateJawabanSkor($idJawaban);
    }

    // public function updateJawabanSkor($idJawaban)
    // {
    //     // Hitung skor untuk jawaban yang sedang diperbarui
    //     $totalSkorJawaban = RumahPerubahanDetailJawaban::where('id_jawaban', $idJawaban)->sum('skor');
    //     $jawaban = RumahPerubahanJawaban::find($idJawaban);
    //     $totalSkorSoal = MRumahPerubahanSoal::where('id_materi', $jawaban->id_materi)->sum('skor');

    //     if ($totalSkorSoal == 0) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Total skor soal tidak valid.',
    //         ], 400);
    //     }

    //     $finalSkor = ($totalSkorJawaban / $totalSkorSoal) * 100;
    //     $finalSkor = (intval($finalSkor) == $finalSkor) ? intval($finalSkor) : number_format($finalSkor, 2);
    //     $jawaban->skor = $finalSkor;
    //     $jawaban->is_done = true;
    //     $jawaban->is_selesai = $finalSkor >= 80;
    //     $jawaban->save();

    //     // Cek atau buat progres_subkategori untuk user dan subkategori terkait
    //     $materi = MRumahPerubahanMateri::find($jawaban->id_materi);
    //     $materiId = $materi->id_sub_kategori;

    //     $progresSubKategori = ProgresSubKategori::firstOrCreate(
    //         [
    //             'id_user' => $jawaban->id_user,
    //             'id_materi' => $materiId,
    //         ],
    //         [
    //             'is_completed' => false, // Default saat pertama kali dibuat
    //         ]
    //     );

    //     // Cek status pengerjaan semua materi dalam subkategori oleh user terkait
    //     $allMateri = MRumahPerubahanMateri::where('id_sub_kategori', $materiId)->where('is_active', true)->get();
    //     $allMateriCompleted = true; // Asumsikan semua selesai

    //     foreach ($allMateri as $materi) {
    //         // Cari jawaban user untuk materi ini dengan skor tertinggi
    //         $highestScore = RumahPerubahanJawaban::where('id_user', $jawaban->id_user)
    //             ->where('id_materi', $materi->id)
    //             ->orderByDesc('skor')
    //             ->value('is_selesai');

    //         // Jika tidak ada jawaban atau skor tidak memenuhi, set is_completed ke false
    //         if (!$highestScore) {
    //             $allMateriCompleted = false;
    //             break;
    //         }
    //     }

    //     // Update status is_completed pada progres_subkategori
    //     $progresSubKategori->is_completed = $allMateriCompleted;
    //     $progresSubKategori->save();

    //     return response()->json([
    //         'success' => true,
    //         'message' => 'RumahPerubahanJawaban berhasil diperbarui.',
    //         'data' => $jawaban,
    //     ]);
    // }

    public function updateJawabanSkor($idJawaban)
    {
        // Hitung skor untuk jawaban yang sedang diperbarui
        $totalSkorJawaban = RumahPerubahanDetailJawaban::where('id_jawaban', $idJawaban)->sum('skor');
        $jawaban = RumahPerubahanJawaban::find($idJawaban);
        $totalSkorSoal = MRumahPerubahanSoal::where('id_materi', $jawaban->id_materi)->sum('skor');

        if ($totalSkorSoal == 0) {
            return response()->json([
                'success' => false,
                'message' => 'Total skor soal tidak valid.',
            ], 400);
        }

        $finalSkor = ($totalSkorJawaban / $totalSkorSoal) * 100;
        $finalSkor = (intval($finalSkor) == $finalSkor) ? intval($finalSkor) : number_format($finalSkor, 2);
        $jawaban->skor = $finalSkor;
        $jawaban->is_done = true;
        $jawaban->is_selesai = $finalSkor >= 80;
        $jawaban->save();

        return response()->json([
            'success' => true,
            'message' => 'Jawaban berhasil diperbarui.',
            'data' => $jawaban,
        ]);
    }


    public function hasilLatihanSoal($id)
    {
        $hasil = RumahPerubahanJawaban::where('id', $id)->first();
        return response()->json($hasil);
    }

    public function historyLatihanSoal($id)
    {
        $hasil = RumahPerubahanJawaban::where('id', $id)->first();
        $history = RumahPerubahanJawaban::where('id_materi', $hasil->id_materi)->where('id_user', $hasil->id_user)->orderBy('id', 'desc')->get();
        return response()->json($history);
    }

    // public function navigateToLearning($id)
    // {
    //     $jawaban = RumahPerubahanJawaban::with('kategori.materi')->find($id);
    //     if (!$jawaban || !$jawaban->materi || !$jawaban->materi->kategori) {
    //         return response()->json(['message' => 'Data tidak ditemukan'], 404);
    //     }
    //     return response()->json([
    //         'id' => $jawaban->materi->kategori->id,
    //     ]);
    // }
    public function navigateToLearning($id)
    {
        try {
            $jawaban = RumahPerubahanJawaban::with('materi.kategori')->find($id);
            
            if (!$jawaban) {
                return response()->json(['message' => 'Jawaban tidak ditemukan'], 404);
            }
            
            if (!$jawaban->materi) {
                return response()->json(['message' => 'Materi terkait tidak ditemukan'], 404);
            }
            
            return response()->json([
                'id_materi' => $jawaban->materi->id,
                'id_kategori' => $jawaban->materi->kategori ? $jawaban->materi->kategori->id : null,
                'nama_materi' => $jawaban->materi->name
            ]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Terjadi kesalahan: ' . $e->getMessage()], 500);
        }
    }
}
