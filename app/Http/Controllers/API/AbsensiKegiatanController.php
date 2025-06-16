<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\AbsensiKegiatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;

class AbsensiKegiatanController extends Controller
{ 

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $limit = $request->limit ? intval($request->limit) : 10;
            $order = $request->order ?: 'DESC';
            $sortby = $request->sortby ?: 'id';

            $query = AbsensiKegiatan::withTrashed(); // Include soft-deleted data jika perlu

            if ($request->filled('search')) {
                $query->where(DB::raw('lower(name)'), 'like', '%' . strtolower($request->search) . '%');
            }

            $absensiList = $query->orderBy($sortby, $order)->paginate($limit);

            $this->responseCode = 200;
            $this->responseData = $absensiList;
            return response()->json($this->getResponse(), $this->responseCode);
        } catch (\Exception $e) {
            $this->responseCode = 500;
            $this->responseMessage = $e->getMessage();
            return response()->json($this->getResponse(), $this->responseCode);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            $rules = [
                'name' => 'required|string|max:255',
                'nik' => 'required|digits:16|unique:absensi_kegiatan,nik',
                'alamat_email' => 'nullable|email|max:255',
                'alamat' => 'required|string',
                'kecamatan_ktp' => 'required|string|max:255',
                'kelurahan_ktp' => 'required|string|max:255',
                'tanggal_lahir' => 'required|date',
                'nomor_hp' => 'required|string|max:15',
                'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
                'pendidikan_terakhir' => 'required|string|max:255',
                'jenis_kelas' => 'required|in:Online,Offline',
                'instansi' => 'required|string|max:255',
                'alamat_domisili' => 'required|string',
                'kecamatan_domisili' => 'required|string|max:255',
                'kelurahan_domisili' => 'required|string|max:255',
                'unggah_foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'unggah_ktp' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'tanda_tangan' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
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

            $validated = $request->except(['unggah_foto', 'unggah_ktp', 'tanda_tangan']);

            // Upload dan kompres foto diri
            if ($request->hasFile('unggah_foto')) {
                $foto = $request->file('unggah_foto');
                $fotoPath = $this->compressAndStoreImage($foto, 'foto_diri_absensi_kegiatans');
                $validated['unggah_foto'] = $fotoPath;
            }

            // Upload dan kompres KTP
            if ($request->hasFile('unggah_ktp')) {
                $ktp = $request->file('unggah_ktp');
                $ktpPath = $this->compressAndStoreImage($ktp, 'ktp_absensi_kegiatans');
                $validated['unggah_ktp'] = $ktpPath;
            }

            // Upload dan kompres tanda tangan
            if ($request->hasFile('tanda_tangan')) {
                $ttd = $request->file('tanda_tangan');
                $ttdPath = $this->compressAndStoreImage($ttd, 'tanda_tangan_absensi_kegiatans');
                $validated['tanda_tangan'] = $ttdPath;
            }

            $absensi = AbsensiKegiatan::create($validated);

            DB::commit();
            $this->responseCode = 201;
            $this->responseData = $absensi;
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
     */
    public function show($id)
    {
        try {
            $id = intval($id);
            $absensi = AbsensiKegiatan::withTrashed()->find($id);

            if (!$absensi) {
                $this->responseCode = 404;
                $this->responseMessage = 'Data tidak ditemukan';
                return response()->json($this->getResponse(), $this->responseCode);
            }

            $this->responseCode = 200;
            $this->responseData = $absensi;
            return response()->json($this->getResponse(), $this->responseCode);
        } catch (\Exception $e) {
            $this->responseCode = 500;
            $this->responseMessage = $e->getMessage();
            return response()->json($this->getResponse(), $this->responseCode);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            $id = intval($id);
            $absensi = AbsensiKegiatan::withTrashed()->find($id);

            if (!$absensi) {
                $this->responseCode = 404;
                $this->responseMessage = 'Data tidak ditemukan';
                return response()->json($this->getResponse(), $this->responseCode);
            }

            $rules = [
                'name' => 'sometimes|required|string|max:255',
                'nik' => 'sometimes|required|digits:16|unique:absensi_kegiatan,nik,'.$id,
                'alamat_email' => 'nullable|email|max:255',
                'alamat' => 'sometimes|required|string',
                'kecamatan_ktp' => 'sometimes|required|string|max:255',
                'kelurahan_ktp' => 'sometimes|required|string|max:255',
                'tanggal_lahir' => 'sometimes|required|date',
                'nomor_hp' => 'sometimes|required|string|max:15',
                'jenis_kelamin' => 'sometimes|required|in:Laki-laki,Perempuan',
                'pendidikan_terakhir' => 'sometimes|required|string|max:255',
                'jenis_kelas' => 'sometimes|required|in:Online,Offline',
                'instansi' => 'sometimes|required|string|max:255',
                'alamat_domisili' => 'sometimes|required|string',
                'kecamatan_domisili' => 'sometimes|required|string|max:255',
                'kelurahan_domisili' => 'sometimes|required|string|max:255',
                'unggah_foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'unggah_ktp' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'tanda_tangan' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
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

            $validated = $request->except(['unggah_foto', 'unggah_ktp', 'tanda_tangan']);

            // Update foto diri
            if ($request->hasFile('unggah_foto')) {
                if ($absensi->unggah_foto) Storage::delete($absensi->unggah_foto);
                $foto = $request->file('unggah_foto');
                $fotoPath = $this->compressAndStoreImage($foto, 'foto_diri_absensi_kegiatans');
                $validated['unggah_foto'] = $fotoPath;
            }

            // Update KTP
            if ($request->hasFile('unggah_ktp')) {
                if ($absensi->unggah_ktp) Storage::delete($absensi->unggah_ktp);
                $ktp = $request->file('unggah_ktp');
                $ktpPath = $this->compressAndStoreImage($ktp, 'ktp_absensi_kegiatans');
                $validated['unggah_ktp'] = $ktpPath;
            }

            // Update tanda tangan
            if ($request->hasFile('tanda_tangan')) {
                if ($absensi->tanda_tangan) Storage::delete($absensi->tanda_tangan);
                $ttd = $request->file('tanda_tangan');
                $ttdPath = $this->compressAndStoreImage($ttd, 'tanda_tangan_absensi_kegiatans');
                $validated['tanda_tangan'] = $ttdPath;
            }

            $absensi->update($validated);

            DB::commit();
            $this->responseCode = 200;
            $this->responseData = $absensi;
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
     */
    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            $id = intval($id);
            $absensi = AbsensiKegiatan::find($id);

            if (!$absensi) {
                $this->responseCode = 404;
                $this->responseMessage = 'Data tidak ditemukan';
                return response()->json($this->getResponse(), $this->responseCode);
            }

            $absensi->delete();

            DB::commit();
            $this->responseCode = 200;
            $this->responseMessage = 'Berhasil menghapus data';
            $this->responseData = $absensi;
            return response()->json($this->getResponse(), $this->responseCode);
        } catch (\Exception $e) {
            $this->responseCode = 500;
            $this->responseMessage = $e->getMessage();
            DB::rollback();
            return response()->json($this->getResponse(), $this->responseCode);
        }
    }

    /**
     * Restore soft deleted record
     */
    /* public function restore($id)
    {
        try {
            $id = intval($id);
            $absensi = AbsensiKegiatan::onlyTrashed()->find($id);

            if (!$absensi) {
                $this->responseCode = 404;
                $this->responseMessage = 'Data tidak ditemukan atau belum dihapus';
                return response()->json($this->getResponse(), $this->responseCode);
            }

            $absensi->restore();

            $this->responseCode = 200;
            $this->responseMessage = 'Data berhasil dipulihkan';
            $this->responseData = $absensi;
            return response()->json($this->getResponse(), $this->responseCode);
        } catch (\Exception $e) {
            $this->responseCode = 500;
            $this->responseMessage = $e->getMessage();
            return response()->json($this->getResponse(), $this->responseCode);
        }
    } */

    /**
     * Switch status is_active
     */
    public function switchStatus($id)
    {
        try {
            DB::beginTransaction();

            $id = intval($id);
            $absensi = AbsensiKegiatan::withTrashed()->find($id);

            if (!$absensi) {
                $this->responseCode = 404;
                $this->responseMessage = 'Data tidak ditemukan';
                return response()->json($this->getResponse(), $this->responseCode);
            }

            $absensi->update([
                'is_active' => !$absensi->is_active
            ]);

            $this->responseCode = 200;
            $this->responseMessage = boolval($absensi->is_active) ? 'Data telah diaktifkan' : 'Data telah dinonaktifkan';
            $this->responseData = $absensi;
            DB::commit();
            return response()->json($this->getResponse(), $this->responseCode);
        } catch (\Exception $e) {
            $this->responseCode = 500;
            $this->responseMessage = $e->getMessage();
            DB::rollback();
            return response()->json($this->getResponse(), $this->responseCode);
        }
    }

    /**
     * List active records for select/dropdown
     */
    public function lists(Request $request)
    {
        try {
            $limit = $request->limit ? intval($request->limit) : 10;

            $absensi = AbsensiKegiatan::where('is_active', true);

            if ($request->filled('search')) {
                $absensi->where(DB::raw('lower(name)'), 'like', '%' . strtolower($request->search) . '%');
            }

            $absensi = $absensi->take($limit)->orderBy('name', 'ASC')->get();

            $this->responseCode = 200;
            $this->responseData = $absensi;
            return response()->json($this->getResponse(), $this->responseCode);
        } catch (\Exception $e) {
            $this->responseCode = 500;
            $this->responseMessage = $e->getMessage();
            return response()->json($this->getResponse(), $this->responseCode);
        }
    }

    /**
     * Public list without auth maybe
     */
    public function listsPublic(Request $request)
    {
        try {
            $absensi = AbsensiKegiatan::where('is_active', true)->orderBy('name', 'ASC')->get();

            $this->responseCode = 200;
            $this->responseData = $absensi;
            return response()->json($this->getResponse(), $this->responseCode);
        } catch (\Exception $e) {
            $this->responseCode = 500;
            $this->responseMessage = $e->getMessage();
            return response()->json($this->getResponse(), $this->responseCode);
        }
    }


    /**
     * Fungsi untuk kompresi dan simpan gambar
     */
    private function compressAndStoreImage($image, $folder)
    {
        $img = Image::make($image->getRealPath());
        $img->resize(800, null, function ($constraint) {
            $constraint->aspectRatio();
        });
        $img->encode('jpg', 75); // Kompresi ke kualitas 75%

        $fileName = time() . '_' . uniqid() . '.jpg';
        Storage::put("public/{$folder}/{$fileName}", (string)$img->encode());

        return "storage/{$folder}/{$fileName}";
    }
}