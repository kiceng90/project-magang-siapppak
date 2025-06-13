<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DetailJawaban;
use App\Models\Jawaban;
use App\Models\Materi;
use App\Models\PilihanJawaban;
use App\Models\ProgresSubkategori;
use App\Models\Soal;
use Illuminate\Support\Facades\Log;

class JawabanDetail extends Controller
{
    public function submitAnswers(Request $request)
    {
        $request->validate([
            'id_jawaban' => 'required|exists:jawaban,id',
            'answers' => 'nullable',
            'answers.*.id_soal' => 'required|exists:soal,id',
            'answers.*.id_pilihan_jawaban' => 'required|exists:pilihan_jawaban,id',
            'answers.*.skor' => 'nullable|integer',
        ]);

        $idJawaban = $request->input('id_jawaban');
        $answers = $request->input('answers');

        $jawabanDetails = [];
        if ($answers) {
            foreach ($answers as $answer) {
                $pilihanJawaban = PilihanJawaban::where('id', $answer['id_pilihan_jawaban'])
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
                    $soal = Soal::find($answer['id_soal']);
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
            DetailJawaban::insert($jawabanDetails);
        }
        return $this->updateJawabanSkor($idJawaban);
    }

    public function updateJawabanSkor($idJawaban)
    {
        $totalSkorJawaban = DetailJawaban::where('id_jawaban', $idJawaban)->sum('skor');
        $jawaban = Jawaban::find($idJawaban);
        $totalSkorSoal = Soal::where('id_materi', $jawaban->id_materi)->sum('skor');

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

        $materi = Materi::find($jawaban->id_materi);
        $subKategoriId = $materi->id_sub_kategori;

        $progresSubKategori = ProgresSubKategori::firstOrCreate(
            [
                'id_user' => $jawaban->id_user,
                'id_sub_kategori' => $subKategoriId,
            ],
            [
                'is_completed' => false,
            ]
        );

        $allMateri = Materi::where('id_sub_kategori', $subKategoriId)->where('is_active', true)->get();
        $allMateriCompleted = true;
        foreach ($allMateri as $materi) {
            $jawabanCount = Jawaban::where('id_user', $jawaban->id_user)
                ->where('id_materi', $materi->id)
                ->count();

            if ($jawabanCount == 0) {
                $allMateriCompleted = false;
                break;
            }

            $highestScore = Jawaban::where('id_user', $jawaban->id_user)
                ->where('id_materi', $materi->id)
                ->whereNotNull('skor')
                ->where('is_selesai', true)
                ->orderByDesc('skor')
                ->value('is_selesai');

            if (!$highestScore) {
                $allMateriCompleted = false;
                break;
            }
        }

        $progresSubKategori->is_completed = $allMateriCompleted;
        $progresSubKategori->save();


        return response()->json([
            'success' => true,
            'message' => 'Jawaban berhasil diperbarui.',
            'data' => $jawaban,
        ]);
    }


    public function hasilLatihanSoal($id)
    {
        $hasil = Jawaban::where('id', $id)->first();
        return response()->json($hasil);
    }

    public function historyLatihanSoal($id)
    {
        $hasil = Jawaban::where('id', $id)->first();
        $history = Jawaban::where('id_materi', $hasil->id_materi)->where('id_user', $hasil->id_user)->orderBy('id', 'desc')->get();
        return response()->json($history);
    }

    public function navigateToLearning($id)
    {
        $jawaban = Jawaban::with('materi.subKategori')->find($id);
        if (!$jawaban || !$jawaban->materi || !$jawaban->materi->subKategori) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }
        return response()->json([
            'id' => $jawaban->materi->subKategori->id,
        ]);
    }
}
