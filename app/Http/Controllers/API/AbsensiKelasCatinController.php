<?php

namespace App\Http\Controllers\API;

use App\Models\AbsensiKelasCatin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class AbsensiKelasCatinController extends Controller
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

            $query = AbsensiKelasCatin::withTrashed(); // Include soft-deleted data jika perlu

            if ($request->filled('search')) {
                $query->where(DB::raw('lower(name)'), 'like', '%' . strtolower($request->search) . '%');
            }

            $catinList = $query->orderBy($sortby, $order)->paginate($limit);

            $this->responseCode = 200;
            $this->responseData = $catinList;
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
                'nik' => 'required|digits:16|unique:absensi_kelas_catin,nik',
                'alamat' => 'required|string',
                'kecamatan_ktp' => 'required|string|max:255',
                'kelurahan_ktp' => 'required|string|max:255',
                'tanggal_lahir' => 'required|date',
                'nomor_hp' => 'required|string|max:15',
                'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
                'pendidikan_terakhir' => 'required|string|max:255',
                'jenis_kelas' => 'required|in:Online,Offline',
                'alamat_email' => 'nullable|email|max:255',
                'unggah_foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'unggah_ktp' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'tanda_tangan' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'rating_kegiatan' => 'nullable|string',
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
                $fotoPath = $this->compressAndStoreImage($foto, 'foto_diri_absensi_catin');
                $validated['unggah_foto'] = $fotoPath;
            }

            // Upload dan kompres KTP
            if ($request->hasFile('unggah_ktp')) {
                $ktp = $request->file('unggah_ktp');
                $ktpPath = $this->compressAndStoreImage($ktp, 'ktp_absensi_catin');
                $validated['unggah_ktp'] = $ktpPath;
            }

            // Upload dan kompres tanda tangan
            if ($request->hasFile('tanda_tangan')) {
                $ttd = $request->file('tanda_tangan');
                $ttdPath = $this->compressAndStoreImage($ttd, 'tanda_tangan_absensi_catin');
                $validated['tanda_tangan'] = $ttdPath;
            }

            $catin = AbsensiKelasCatin::create($validated);

            DB::commit();
            $this->responseCode = 201;
            $this->responseData = $catin;
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
            $catin = AbsensiKelasCatin::withTrashed()->find($id);

            if (!$catin) {
                $this->responseCode = 404;
                $this->responseMessage = 'Data tidak ditemukan';
                return response()->json($this->getResponse(), $this->responseCode);
            }

            $this->responseCode = 200;
            $this->responseData = $catin;
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
            $catin = AbsensiKelasCatin::withTrashed()->find($id);

            if (!$catin) {
                $this->responseCode = 404;
                $this->responseMessage = 'Data tidak ditemukan';
                return response()->json($this->getResponse(), $this->responseCode);
            }

            $rules = [
                'name' => 'sometimes|required|string|max:255',
                'nik' => 'sometimes|required|digits:16|unique:absensi_kelas_catin,nik,'.$id,
                'alamat' => 'sometimes|required|string',
                'kecamatan_ktp' => 'sometimes|required|string|max:255',
                'kelurahan_ktp' => 'sometimes|required|string|max:255',
                'tanggal_lahir' => 'sometimes|required|date',
                'nomor_hp' => 'sometimes|required|string|max:15',
                'jenis_kelamin' => 'sometimes|required|in:Laki-laki,Perempuan',
                'pendidikan_terakhir' => 'sometimes|required|string|max:255',
                'jenis_kelas' => 'sometimes|required|in:Online,Offline',
                'alamat_email' => 'nullable|email|max:255',
                'unggah_foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'unggah_ktp' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'tanda_tangan' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'rating_kegiatan' => 'nullable|string',
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
                if ($catin->unggah_foto) Storage::delete($catin->unggah_foto);
                $foto = $request->file('unggah_foto');
                $fotoPath = $this->compressAndStoreImage($foto, 'foto_diri_absensi_catin');
                $validated['unggah_foto'] = $fotoPath;
            }

            // Update KTP
            if ($request->hasFile('unggah_ktp')) {
                if ($catin->unggah_ktp) Storage::delete($catin->unggah_ktp);
                $ktp = $request->file('unggah_ktp');
                $ktpPath = $this->compressAndStoreImage($ktp, 'ktp_absensi_catin');
                $validated['unggah_ktp'] = $ktpPath;
            }

            // Update tanda tangan
            if ($request->hasFile('tanda_tangan')) {
                if ($catin->tanda_tangan) Storage::delete($catin->tanda_tangan);
                $ttd = $request->file('tanda_tangan');
                $ttdPath = $this->compressAndStoreImage($ttd, 'tanda_tangan_absensi_catin');
                $validated['tanda_tangan'] = $ttdPath;
            }

            $catin->update($validated);

            DB::commit();
            $this->responseCode = 200;
            $this->responseData = $catin;
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
            $catin = AbsensiKelasCatin::find($id);

            if (!$catin) {
                $this->responseCode = 404;
                $this->responseMessage = 'Data tidak ditemukan';
                return response()->json($this->getResponse(), $this->responseCode);
            }

            $catin->delete();

            DB::commit();
            $this->responseCode = 200;
            $this->responseMessage = 'Berhasil menghapus data';
            $this->responseData = $catin;
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
            $catin = AbsensiKelasCatin::onlyTrashed()->find($id);

            if (!$catin) {
                $this->responseCode = 404;
                $this->responseMessage = 'Data tidak ditemukan atau belum dihapus';
                return response()->json($this->getResponse(), $this->responseCode);
            }

            $catin->restore();

            $this->responseCode = 200;
            $this->responseMessage = 'Data berhasil dipulihkan';
            $this->responseData = $catin;
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
            $catin = AbsensiKelasCatin::withTrashed()->find($id);

            if (!$catin) {
                $this->responseCode = 404;
                $this->responseMessage = 'Data tidak ditemukan';
                return response()->json($this->getResponse(), $this->responseCode);
            }

            $catin->update([
                'is_active' => !$catin->is_active
            ]);

            $this->responseCode = 200;
            $this->responseMessage = boolval($catin->is_active) ? 'Data telah diaktifkan' : 'Data telah dinonaktifkan';
            $this->responseData = $catin;
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

            $catin = AbsensiKelasCatin::where('is_active', true);

            if ($request->filled('search')) {
                $catin->where(DB::raw('lower(name)'), 'like', '%' . strtolower($request->search) . '%');
            }

            $catin = $catin->take($limit)->orderBy('name', 'ASC')->get();

            $this->responseCode = 200;
            $this->responseData = $catin;
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
            $catin = AbsensiKelasCatin::where('is_active', true)->orderBy('name', 'ASC')->get();

            $this->responseCode = 200;
            $this->responseData = $catin;
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