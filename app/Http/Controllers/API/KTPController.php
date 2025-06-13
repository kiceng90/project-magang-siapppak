<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\KTP;
use DateTime;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class KTPController extends Controller
{
    public function store(Request $request)
    {
        // 1. Validasi upload
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg|max:5120',
        ]);

        DB::beginTransaction();
        try {
            // 2. Simpan gambar
            $image = $request->file('image');
            $imagePath = $image->store('ktp_images', 'public');
            $fullPath = storage_path("app/public/{$imagePath}");

            // 3. Panggil OCR.Space via Laravel HTTP Client
            $response = Http::withHeaders([
                'apikey' => env('OCR_API_KEY'),
            ])->attach(
                'file',
                file_get_contents($fullPath),
                $image->getClientOriginalName()
            )->post('https://api.ocr.space/parse/image', [
                'language' => 'eng',
                'isOverlayRequired' => 'false',
                'OCREngine' => '2',
                'detectOrientation' => 'true',
                'scale' => 'true',
            ]);

            // Log full response untuk debug
            Log::info('OCR.Space full response: ' . $response->body());

            if ($response->failed()) {
                Log::error('OCR.Space error (HTTP fail): ' . $response->body());
                return response()->json([
                    'message' => 'Gagal memanggil OCR API (HTTP error)',
                    'error' => $response->body(),
                ], 422);
            }

            // Verifikasi hasil OCR terdapat error
            $responseJson = $response->json();
            if (isset($responseJson['IsErroredOnProcessing']) && $responseJson['IsErroredOnProcessing'] == true) {
                Log::error('OCR.Space error (Processing): ' . json_encode($responseJson));
                return response()->json([
                    'message' => 'Gagal memproses gambar OCR',
                    'error' => $responseJson['ErrorMessage'] ?? 'Unknown OCR processing error',
                ], 422);
            }

            // Verifikasi apakah hasil OCR ada
            if (!isset($responseJson['ParsedResults']) || empty($responseJson['ParsedResults'])) {
                Log::error('OCR.Space no results: ' . json_encode($responseJson));
                return response()->json([
                    'message' => 'OCR tidak menghasilkan teks yang dapat dibaca',
                    'error' => 'No parsed results',
                ], 422);
            }

            $parsedText = data_get($responseJson, 'ParsedResults.0.ParsedText', '');

            // Verifikasi bahwa teks hasil OCR tidak kosong
            if (empty(trim($parsedText))) {
                Log::error('OCR.Space empty text result');
                return response()->json([
                    'message' => 'OCR tidak mendeteksi teks pada gambar',
                    'error' => 'Empty OCR result',
                ], 422);
            }

            // Sanitize OCR text - remove non-ASCII characters that can cause issues
            $parsedText = preg_replace('/[^\x20-\x7E\r\n]/', '', $parsedText);

            // Log text result untuk debugging
            Log::info('OCR Text Result: ' . $parsedText);

            // 4. Simpan teks OCR ke file sementara dengan encoding ASCII
            $tmpDir = storage_path('app/ocr_tmp');
            if (!is_dir($tmpDir)) {
                mkdir($tmpDir, 0755, true);
            }
            $tmpFile = $tmpDir . '/' . uniqid('ocr_') . '.txt';
            file_put_contents($tmpFile, $parsedText);

            // 5. Panggil skrip Python untuk ekstraksi field
            $pythonPath = env('PYTHON_PATH');
            $scriptPath = public_path('python/process_ktp.py');

            Log::info("Running Python extraction: {$pythonPath} {$scriptPath} {$tmpFile}");

            $process = new Process([$pythonPath, $scriptPath, $tmpFile]);
            $process->setTimeout(60); // Berikan waktu lebih lama (60 detik)
            $process->run();

            // Check jika proses Python berhasil
            if (!$process->isSuccessful()) {
                Log::error('Python process failed: ' . $process->getErrorOutput());
                throw new ProcessFailedException($process);
            }

            $output = $process->getOutput();

            // Verifikasi output Python tidak kosong
            if (empty(trim($output))) {
                Log::error('Python process returned empty output');
                return response()->json([
                    'message' => 'Proses Python tidak menghasilkan output',
                    'error' => 'Empty Python output',
                ], 422);
            }

            Log::info('Python output: ' . $output);

            // Clean output - remove BOM and other non-UTF8 characters
            $cleanOutput = preg_replace('/[\x00-\x08\x0B\x0C\x0E-\x1F\x80-\x9F]/u', '', $output);

            // Try to decode JSON with options to handle malformed UTF-8
            $ktpData = json_decode($cleanOutput, true, 512, JSON_INVALID_UTF8_SUBSTITUTE);

            // Cek apakah json_decode berhasil
            if (is_null($ktpData)) {
                Log::error('Failed to decode Python output as JSON: ' . $cleanOutput);
                Log::error('JSON error: ' . json_last_error_msg());

                // Fallback - sanitize the output completely to ASCII
                $asciiOutput = preg_replace('/[^\x20-\x7E]/', '', $output);
                $ktpData = json_decode($asciiOutput, true);

                if (is_null($ktpData)) {
                    return response()->json([
                        'message' => 'Gagal memproses output Python sebagai JSON',
                        'error' => json_last_error_msg(),
                    ], 422);
                }
            }

            if (isset($ktpData['error'])) {
                Log::error('Python OCR Error: ' . $ktpData['error']);
                return response()->json([
                    'message' => 'Gagal memproses data OCR',
                    'error' => $ktpData['error'],
                ], 422);
            }

            // 6. Format tanggal lahir (jika ada)
            $tanggal_lahir = null;
            if (!empty($ktpData['tanggal_lahir'])) {
                // Support multiple date formats
                $dateFormats = ['d-m-Y', 'd/m/Y'];

                foreach ($dateFormats as $format) {
                    $date = \DateTime::createFromFormat($format, $ktpData['tanggal_lahir']);
                    if ($date && (
                        $date->format($format) === $ktpData['tanggal_lahir'] ||
                        // Handle slash vs hyphen difference
                        $date->format(str_replace('-', '/', $format)) === $ktpData['tanggal_lahir'] ||
                        $date->format(str_replace('/', '-', $format)) === $ktpData['tanggal_lahir']
                    )) {
                        $tanggal_lahir = $date->format('Y-m-d');
                        break;
                    }
                }
            }

            // Pastikan raw_data selalu berisi nilai valid (minimal {})
            $rawData = !empty($ktpData) ? json_encode($ktpData, JSON_INVALID_UTF8_SUBSTITUTE) : '{}';

            // 7. Simpan ke DB
            $ktp = KTP::create([
                'nik'                  => $ktpData['nik']                  ?? null,
                'nama'                 => $ktpData['nama']                 ?? null,
                'tempat_lahir'         => $ktpData['tempat_lahir']         ?? null,
                'tanggal_lahir'        => $tanggal_lahir,
                'jenis_kelamin'        => $ktpData['jenis_kelamin']        ?? null,
                'alamat_ktp'           => $ktpData['alamat_ktp']           ?? null,
                'rt_ktp'               => $ktpData['rt_ktp']               ?? null,
                'rw_ktp'               => $ktpData['rw_ktp']               ?? null,
                'kel_desa_ktp'         => $ktpData['kel_desa_ktp']         ?? null,
                'kecamatan_ktp'        => $ktpData['kecamatan_ktp']        ?? null,
                'kota_kabupaten_ktp'   => $ktpData['kota_kabupaten_ktp']   ?? null,
                'provinsi'             => $ktpData['provinsi']             ?? null,
                'agama'                => $ktpData['agama']                ?? null,
                'status_perkawinan'    => $ktpData['status_perkawinan']    ?? null,
                'pekerjaan'            => $ktpData['pekerjaan']            ?? null,
                'kewarganegaraan'      => $ktpData['kewarganegaraan']      ?? null,
                'image_path'           => $imagePath,
                'raw_data'             => $rawData,
            ]);

            DB::commit();

            return response()->json([
                'message' => 'Data pengunjung berhasil disimpan.',
                'data'    => $ktp,
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error storing KTP data: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            return response()->json([
                'message' => 'Terjadi kesalahan saat menyimpan data',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }


    public function show($id)
    {
        try {
            $ktp = KTP::findOrFail($id);

            $image_path = null;
            if ($ktp->image_path) {
                $image_path = str_replace('public/', '', $ktp->image_path);
            }

            $data = [
                'nama' => $ktp->nama,
                'nik' => $ktp->nik,
                'tempat_lahir' => $ktp->tempat_lahir,
                'tanggal_lahir' => $ktp->tanggal_lahir,
                'alamat_ktp' => $ktp->alamat_ktp,
                'rt_ktp' => $ktp->rt_ktp,
                'rw_ktp' => $ktp->rw_ktp,
                'kel_desa_ktp' => $ktp->kel_desa_ktp,
                'kecamatan_ktp' => $ktp->kecamatan_ktp,
                'kota_kabupaten_ktp' => $ktp->kota_kabupaten_ktp,
                'provinsi' => $ktp->provinsi,
                'agama' => $ktp->agama,
                'pekerjaan' => $ktp->pekerjaan,
                'status_perkawinan' => $ktp->status_perkawinan,
                'kewarganegaraan' => $ktp->kewarganegaraan,
                'jenis_kelamin' => $ktp->jenis_kelamin,
                'foto_ktp_url' => $image_path,
            ];

            return response()->json([
                'message' => 'Data KTP ditemukan.',
                'data' => $data,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Data KTP tidak ditemukan.',
                'error' => $e->getMessage(),
            ], 404);
        }
    }
}
