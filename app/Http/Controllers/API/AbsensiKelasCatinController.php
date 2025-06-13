<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\AbsensiKelasCatin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AbsensiKelasCatinController extends Controller
{
    protected $responseCode = 200;
    protected $responseMessage = 'Success';
    protected $responseData = null;

    /**
     * Menampilkan semua data absensi kelas catin.
     */
    public function index(Request $request)
    {
        try {
            $query = AbsensiKelasCatin::query();

            if ($request->filled('search')) {
                $query->where('name', 'like', '%' . $request->search . '%');
            }

            $data = $query->paginate(15);

            $this->responseData = $data;
            return response()->json($this->getResponse(), $this->responseCode);
        } catch (\Exception $e) {
            $this->responseCode = 500;
            $this->responseMessage = $e->getMessage();
            return response()->json($this->getResponse(), $this->responseCode);
        }
    }

    /**
     * Menyimpan data baru ke dalam tabel absensi_kelas_catins.
     */
    public function store(Request $request)
    {
        try {
            $rules = [
                'name' => 'required|string|max:255',
                'nik' => 'required|digits:16|unique:absensi_kelas_catins,nik',
                'alamat' => 'required|string',
                'kecamatan_ktp' => 'required|string|max:255',
                'kelurahan_ktp' => 'required|string|max:255',
                'tanggal_lahir' => 'required|date',
                'nomor_hp' => 'required|string|max:15',
                'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
                'pendidikan_terakhir' => 'required|string|max:255',
                'jenis_kelas' => 'required|in:Online,Offline',
                'alamat_email' => 'nullable|email|max:255',
                'unggah_foto' => 'nullable|string',
                'unggah_ktp' => 'nullable|file|mimes:jpeg,png,jpg|max:2048',
                'tanda_tangan' => 'nullable|string',
                'rating_kegiatan' => 'nullable|integer|min:1|max:5',
                'kritik_saran' => 'nullable|string',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                $this->responseCode = 422;
                $this->responseMessage = $validator->errors()->first();
                $this->responseData = $validator->errors();
                return response()->json($this->getResponse(), $this->responseCode);
            }

            $validated = $validator->validated();

            // Simpan foto diri (Base64)
            if ($request->has('unggah_foto')) {
                $fotoBase64 = $request->input('unggah_foto');

                $uploadPath = 'uploads/foto_diri_absensi_kelas_catins/';
                if (!is_dir(public_path($uploadPath))) mkdir(public_path($uploadPath), 0755, true);

                $filePath = $uploadPath . time() . '.jpg';
                $base64Data = preg_replace('/^data:image\/\w+;base64,/', '', $fotoBase64);
                file_put_contents(public_path($filePath), base64_decode($base64Data));
                $validated['unggah_foto'] = $filePath;
            }

            // Simpan KTP (File upload)
            if ($request->hasFile('unggah_ktp')) {
                $ktpPath = $request->file('unggah_ktp')->store('ktp_absensi_kelas_catins', 'public');
                $validated['unggah_ktp'] = $ktpPath;
            }

            $absensi = AbsensiKelasCatin::create($validated);

            $this->responseData = $absensi;
            $this->responseCode = 201;
            $this->responseMessage = 'Data berhasil ditambahkan';

            return response()->json($this->getResponse(), $this->responseCode);
        } catch (\Exception $e) {
            $this->responseCode = 500;
            $this->responseMessage = $e->getMessage();
            return response()->json($this->getResponse(), $this->responseCode);
        }
    }

    /**
     * Menampilkan detail satu data absensi kelas catin.
     */
    public function show($id)
    {
        try {
            $absensi = AbsensiKelasCatin::find($id);

            if (!$absensi) {
                $this->responseCode = 404;
                $this->responseMessage = 'Data tidak ditemukan';
                return response()->json($this->getResponse(), $this->responseCode);
            }

            $this->responseData = $absensi;
            return response()->json($this->getResponse(), $this->responseCode);
        } catch (\Exception $e) {
            $this->responseCode = 500;
            $this->responseMessage = $e->getMessage();
            return response()->json($this->getResponse(), $this->responseCode);
        }
    }

    /**
     * Memperbarui data absensi kelas catin berdasarkan ID.
     */
    public function update(Request $request, $id)
    {
        try {
            $absensi = AbsensiKelasCatin::find($id);

            if (!$absensi) {
                $this->responseCode = 404;
                $this->responseMessage = 'Data tidak ditemukan';
                return response()->json($this->getResponse(), $this->responseCode);
            }

            $rules = [
                'name' => 'sometimes|required|string|max:255',
                'nik' => "sometimes|required|digits:16|unique:absensi_kelas_catins,nik,$id",
                'alamat' => 'sometimes|required|string',
                'kecamatan_ktp' => 'sometimes|required|string|max:255',
                'kelurahan_ktp' => 'sometimes|required|string|max:255',
                'tanggal_lahir' => 'sometimes|required|date',
                'nomor_hp' => 'sometimes|required|string|max:15',
                'jenis_kelamin' => 'sometimes|required|in:Laki-laki,Perempuan',
                'pendidikan_terakhir' => 'sometimes|required|string|max:255',
                'jenis_kelas' => 'sometimes|required|in:Online,Offline',
                'alamat_email' => 'nullable|email|max:255',
                'unggah_foto' => 'nullable|string',
                'unggah_ktp' => 'nullable|file|mimes:jpeg,png,jpg|max:2048',
                'tanda_tangan' => 'nullable|string',
                'rating_kegiatan' => 'nullable|integer|min:1|max:5',
                'kritik_saran' => 'nullable|string',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                $this->responseCode = 422;
                $this->responseMessage = $validator->errors()->first();
                $this->responseData = $validator->errors();
                return response()->json($this->getResponse(), $this->responseCode);
            }

            $validated = $validator->validated();

            // Update foto diri (Base64)
            if ($request->has('unggah_foto')) {
                $fotoBase64 = $request->input('unggah_foto');

                $uploadPath = 'uploads/foto_diri_absensi_kelas_catins/';
                if (!is_dir(public_path($uploadPath))) mkdir(public_path($uploadPath), 0755, true);

                $filePath = $uploadPath . time() . '.jpg';
                $base64Data = preg_replace('/^data:image\/\w+;base64,/', '', $fotoBase64);
                file_put_contents(public_path($filePath), base64_decode($base64Data));
                $validated['unggah_foto'] = $filePath;
            }

            // Update KTP (File upload)
            if ($request->hasFile('unggah_ktp')) {
                $ktpPath = $request->file('unggah_ktp')->store('ktp_absensi_kelas_catins', 'public');
                $validated['unggah_ktp'] = $ktpPath;
            }

            $absensi->update($validated);

            $this->responseData = $absensi;
            $this->responseMessage = 'Data berhasil diperbarui';

            return response()->json($this->getResponse(), $this->responseCode);
        } catch (\Exception $e) {
            $this->responseCode = 500;
            $this->responseMessage = $e->getMessage();
            return response()->json($this->getResponse(), $this->responseCode);
        }
    }

    /**
     * Menghapus data absensi kelas catin berdasarkan ID.
     */
    public function destroy($id)
    {
        try {
            $absensi = AbsensiKelasCatin::find($id);

            if (!$absensi) {
                $this->responseCode = 404;
                $this->responseMessage = 'Data tidak ditemukan';
                return response()->json($this->getResponse(), $this->responseCode);
            }

            $absensi->delete();

            $this->responseMessage = 'Data berhasil dihapus';
            return response()->json($this->getResponse(), $this->responseCode);
        } catch (\Exception $e) {
            $this->responseCode = 500;
            $this->responseMessage = $e->getMessage();
            return response()->json($this->getResponse(), $this->responseCode);
        }
    }

    /**
     * Mengubah status is_active (aktif/non-aktif) berdasarkan ID.
     */
    public function switchStatus($id)
    {
        try {
            // Pastikan ID adalah integer
            $id = intval($id);

            // Cari data berdasarkan ID
            $absensi = AbsensiKelasCatin::find($id);

            // Jika data tidak ditemukan, kembalikan respons 404
            if (!$absensi) {
                $this->responseCode = 404;
                $this->responseMessage = 'Data tidak ditemukan';
                return response()->json($this->getResponse(), $this->responseCode);
            }

            // Mulai transaksi database
            DB::beginTransaction();

            // Toggle status is_active
            $absensi->update([
                'is_active' => !$absensi->is_active
            ]);

            // Tentukan pesan berdasarkan status baru
            $this->responseCode = 200;
            $this->responseMessage = boolval($absensi->is_active) ? 'Data telah diaktifkan' : 'Data telah dinonaktifkan';
            $this->responseData = $absensi;

            // Commit transaksi
            DB::commit();

            // Kembalikan respons JSON
            return response()->json($this->getResponse(), $this->responseCode);
        } catch (\Exception $e) {
            // Rollback transaksi jika terjadi error
            DB::rollback();

            // Kembalikan respons error
            $this->responseCode = 500;
            $this->responseMessage = $e->getMessage();
            return response()->json($this->getResponse(), $this->responseCode);
        }
    }

    /**
     * Ambil data aktif untuk dropdown.
     */
    public function lists()
    {
        try {
            $data = AbsensiKelasCatin::select('id', 'name as nama')
                ->where('is_active', true)
                ->orderBy('name', 'ASC')
                ->get();

            $this->responseData = $data;
            return response()->json($this->getResponse(), $this->responseCode);
        } catch (\Exception $e) {
            $this->responseCode = 500;
            $this->responseMessage = $e->getMessage();
            return response()->json($this->getResponse(), $this->responseCode);
        }
    }

    /**
     * Endpoint untuk listsPublic.
     */
    public function listsPublic()
    {
        try {
            $data = AbsensiKelasCatin::select('id', 'name as nama')
                ->where('is_active', true)
                ->orderBy('name', 'ASC')
                ->get();

            $this->responseData = $data;
            return response()->json($this->getResponse(), $this->responseCode);
        } catch (\Exception $e) {
            $this->responseCode = 500;
            $this->responseMessage = $e->getMessage();
            return response()->json($this->getResponse(), $this->responseCode);
        }
    }
}