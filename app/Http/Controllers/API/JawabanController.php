<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Jawaban;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class   JawabanController extends Controller
{
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            // Verifikasi pengguna dari token
            $user = auth()->user(); // Pengguna yang login saat ini
            if (!$user) {
                return response()->json([
                    'code' => 401,
                    'message' => 'Unauthorized',
                ], 401);
            }

            // Validasi input (tanpa id_user karena sudah dari token)
            $rules = [
                'id_materi' => 'required|exists:materi,id',
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json([
                    'code' => 422,
                    'message' => $validator->errors()->first(),
                    'errors' => $validator->errors()
                ], 422);
            }

            // Data jawaban
            $jawabanData = [
                'id_user' => $user->id, // Dari token
                'id_materi' => $request->id_materi,
                'jenis_materi' => $request->jenis_materi,
            ];

            // Simpan ke database
            $jawaban = Jawaban::create($jawabanData);
            DB::commit();
            return response()->json([
                'code' => 201,
                'data' => $jawaban,
                'message' => 'Jawaban created successfully'
            ], 201);
        } catch (\Exception $e) {
            DB::rollback();

            return response()->json([
                'code' => 500,
                'message' => 'An error occurred: ' . $e->getMessage()
            ], 500);
        }
    }
}
