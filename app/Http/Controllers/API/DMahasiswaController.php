<?php

namespace App\Http\Controllers\API;

use App\Enums\MahasiswaFileTypeEnum;
use App\Enums\MahasiswaStatusEnum;
use App\Exports\DatabaseExport;
use App\Http\Controllers\Controller;
use App\Mail\MahasiswaRegisterNotif;
use App\Models\DMahasiswa;
use App\Models\DMahasiswaFile;
use App\Models\MahasiswaBalaiPuspagaRW;
use App\Models\MInstansiPendidikan;
use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\File\File as SymfonyFile;

class DMahasiswaController extends Controller
{
    /**
     * Public register.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        try {
            DB::beginTransaction();
             // User
            $rules = [
                // User Data Rules
                'name' => 'required|string',
                'username' => 'required|string|unique:App\Models\User,username',
                'password' => 'required|min:6|confirmed',
                
                // Mahasiswa Data Rules
                'id_kabupaten_lahir' => 'required|exists:App\Models\MKabupaten,id,deleted_at,NULL',
                'id_pendidikan_terakhir' => 'required|exists:App\Models\MPendidikanTerakhir,id,deleted_at,NULL',
                'id_jenis_mahasiswa' => 'required|exists:App\Models\MJenisMahasiswa,id,deleted_at,NULL',
                'id_jurusan' => 'required|exists:App\Models\MJurusan,id,deleted_at,NULL',
                'id_instansi_pendidikan' => 'required|exists:App\Models\MInstansiPendidikan,id,deleted_at,NULL',
                'id_kelurahan_domisili' => 'required|exists:App\Models\MKelurahan,id,deleted_at,NULL',
                'id_kelurahan_kk' => 'required|exists:App\Models\MKelurahan,id,deleted_at,NULL',
                'email' => 'required|email:dns,rfc,filter|unique:App\Models\DMahasiswa,email',
                'nim' => 'required|string',
                'nik' => 'required|string|size:16|unique:App\Models\DMahasiswa,nik',
                'birth_date' => 'required|date',
                'phone' => 'required|string',
                'semester' => 'required|numeric',
                'ipk' => 'required|numeric',
                'domicile_address' => 'required|string',
                'domicile_rw' => 'required|numeric',
                'domicile_rt' => 'required|numeric',
                'kk_address' => 'required|string',
                'kk_rw' => 'required|numeric',
                'kk_rt' => 'required|numeric',
                'status' => ['required', Rule::in(MahasiswaStatusEnum::getValues())],
                'is_active' => 'required|boolean',

                // File Mahasiswa
                'file_foto' => 'required|image|mimes:jpg,jpeg,png|max:5120',
                'file_ktp' => 'required|image|mimes:jpg,jpeg,png|max:5120',
                'file_ttd' => 'required|string'
                
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $this->responseCode = 422;
                $this->responseMessage = $validator->errors()->first();
                $this->responseData = $validator->errors();
                return response()->json($this->getResponse(), $this->responseCode);
            }

            // Create the user first
            $user = User::create([
                'id_role' => config('env.role.mahasiswa'),
                'name' => ($request->name),
                'username' => Str::lower($request->username),
                'password' => Hash::make($request->password),
            ]);
            
            $mahasiswa = DMahasiswa::create([
                'id_user' => $user->id,
                'id_kabupaten_lahir' => $request->id_kabupaten_lahir,
                'id_pendidikan_terakhir' => $request->id_pendidikan_terakhir,
                'id_jenis_mahasiswa' => $request->id_jenis_mahasiswa,
                'id_jurusan' => $request->id_jurusan,
                'id_instansi_pendidikan' => $request->id_instansi_pendidikan,
                'id_kelurahan_domisili' => $request->id_kelurahan_domisili,
                'id_kelurahan_kk' => $request->id_kelurahan_kk,
                'name' => $request->name,
                'email' => $request->email,
                'nim' => $request->nim,
                'nik' => $request->nik,
                'birth_date' => $request->birth_date,
                'phone' => $request->phone,
                'semester' => $request->semester,
                'ipk' => $request->ipk,
                'domicile_address' => $request->domicile_address,
                'domicile_rw' => $request->domicile_rw,
                'domicile_rt' => $request->domicile_rt,
                'kk_address' => $request->kk_address,
                'kk_rw' => $request->kk_rw,
                'kk_rt' => $request->kk_rt,
                'status' => $request->status,
            ]);

            $user->id_mahasiswa = $mahasiswa->id;
            $user->save();

            if($request->hasFile('file_foto')){
                $file = $request->file_foto;
                $changedName = time() . random_int(100, 999). '.' .$file->getClientOriginalExtension();
                $is_image = substr($file->getClientMimeType(), 0, 5) == 'image' ?? false;

                $path = 'private/mahasiswa/' . $mahasiswa->id . '/file_foto';
                $file->storeAs($path, $changedName);

                // $canvas = Image::canvas(400, 600, '#ffffff');
                // $img = Image::make($file->getRealPath());
                // $height = $img->height();
                // $width = $img->width();
                // $img->resize($width > $height ? 400 : null, $height >= $width ? 600 : null, function ($constraint){
                //     $constraint->aspectRatio();
                //     $constraint->upsize();
                // });
                // $canvas->insert($img, 'center');
                // $canvas->save(storage_path('app/'.$path. '/' . $changedName));

                $modelFile = new DMahasiswaFile();
                $modelFile->id_mahasiswa = $mahasiswa->id;
                $modelFile->name = $file->getClientOriginalName();
                $modelFile->path = $path . '/' . $changedName;
                $modelFile->size = $file->getSize();
                $modelFile->ext = $file->getClientOriginalExtension();
                $modelFile->is_image = $is_image;
                $modelFile->type = MahasiswaFileTypeEnum::FOTO;
                $modelFile->save();
            }

            if($request->has('file_ttd')){
                $base64File = $request->file_ttd;

                $fileData = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $base64File));

                $tmpFilePath = sys_get_temp_dir() . '/' . Str::uuid()->toString();
                file_put_contents($tmpFilePath, $fileData);

                $tmpfile = new SymfonyFile($tmpFilePath);

                $file = new UploadedFile(
                    $tmpfile->getPathname(),
                    $tmpfile->getFilename(),
                    $tmpfile->getMimeType(),
                    0,
                    true // Mark it as test, since the file isn't from real HTTP POST.
                );

                $changedName = time() . random_int(100, 999). '.png';
                $is_image = substr($file->getClientMimeType(), 0, 5) == 'image' ?? false;

                $path = 'private/mahasiswa/' . $mahasiswa->id . '/file_ttd';
                $file->storeAs($path, $changedName);

                // $image = $request->image;  // your base64 encoded
                // $image = str_replace('data:image/png;base64,', '', $image);
                // $image = str_replace(' ', '+', $image);
                // $imageName = Str::random(10).'.'.'png';
                // $imagePath = storage_path(). '/private/mahasiswa/' . $mahasiswa->id . '/file_ktp/' . $imageName;
                // File::put($imagePath, base64_decode($image));

                // $canvas = Image::canvas(400, 600, '#ffffff');
                // $img = Image::make($file->getRealPath());
                // $height = $img->height();
                // $width = $img->width();
                // $img->resize($width > $height ? 400 : null, $height >= $width ? 600 : null, function ($constraint){
                //     $constraint->aspectRatio();
                //     $constraint->upsize();
                // });
                // $canvas->insert($img, 'center');
                // $canvas->save(storage_path('app/'.$path. '/' . $changedName));

                $modelFile = new DMahasiswaFile();
                $modelFile->id_mahasiswa = $mahasiswa->id;
                $modelFile->name = $file->getClientOriginalName();
                $modelFile->path = $path . '/' . $changedName;
                $modelFile->size = $file->getSize();
                $modelFile->ext = 'png';
                $modelFile->is_image = $is_image;
                $modelFile->type = MahasiswaFileTypeEnum::TTD;
                $modelFile->save();
            }
            if($request->hasFile('file_ktp')){
                $file = $request->file_ktp;
                $changedName = time() . random_int(100, 999). '.' .$file->getClientOriginalExtension();
                $is_image = substr($file->getClientMimeType(), 0, 5) == 'image' ?? false;

                $path = 'private/mahasiswa/' . $mahasiswa->id . '/file_ktp';
                $file->storeAs($path, $changedName);

                // $canvas = Image::canvas(400, 600, '#ffffff');
                // $img = Image::make($file->getRealPath());
                // $height = $img->height();
                // $width = $img->width();
                // $img->resize($width > $height ? 400 : null, $height >= $width ? 600 : null, function ($constraint){
                //     $constraint->aspectRatio();
                //     $constraint->upsize();
                // });
                // $canvas->insert($img, 'center');
                // $canvas->save(storage_path('app/'.$path. '/' . $changedName));

                $modelFile = new DMahasiswaFile();
                $modelFile->id_mahasiswa = $mahasiswa->id;
                $modelFile->name = $file->getClientOriginalName();
                $modelFile->path = $path . '/' . $changedName;
                $modelFile->size = $file->getSize();
                $modelFile->ext = $file->getClientOriginalExtension();
                $modelFile->is_image = $is_image;
                $modelFile->type = MahasiswaFileTypeEnum::KTP;
                $modelFile->save();
            }
            $withs = [
                'user',
                'kabupaten_lahir',
                'pendidikan_terakhir',
                'jenis_mahasiswa',
                'jurusan',
                'instansi_pendidikan',
                'kelurahan_domisili.kecamatan.kabupaten',
                'kelurahan_kk.kecamatan.kabupaten',
                'file_ktp',
                'file_foto',
                'file_ttd'
              ];
            $mahasiswa = DMahasiswa::where('id',$mahasiswa->id)->with($withs)->first();
            
            // Mail::to($mahasiswa->email)->send(new MahasiswaRegisterNotif($mahasiswa));
        
            DB::commit();
            $this->responseCode = 201;
            $this->responseData = $mahasiswa;
            return response()->json($this->getResponse(), $this->responseCode);
        } catch (\Exception $e) {
            $this->responseCode = 500;
            $this->responseMessage = $e->getMessage();
            DB::rollback();
            return response()->json($this->getResponse(), $this->responseCode);
        }
    }

    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
        try {
            $limit = $request->limit ? intval($request->limit) : 10;
            $order = $request->order ? $request->order : 'DESC';
            $sortby = $request->sortby ? $request->sortby : 'id';

            $mahasiswa = DMahasiswa::query();
            if($request->filled('search')){
                $mahasiswa->where(DB::raw('lower(d_mahasiswa.name)'), 'like', '%' . strtolower($request->search) . '%')
                ->orWhere('phone', 'like', '%' . strtolower($request->search) . '%')
                ->orWhere('domicile_address', 'like', '%' . strtolower($request->search) . '%')
                ->orWhere('kk_address', 'like', '%' . strtolower($request->search) . '%');
            }
            $withs = [
                'kabupaten_lahir',
                'pendidikan_terakhir',
                'jenis_mahasiswa',
                'jurusan',
                'instansi_pendidikan',
                'kelurahan_domisili.kecamatan.kabupaten',
                'kelurahan_kk.kecamatan.kabupaten',
                'file_ktp',
                'file_foto',
                'file_ttd',
                'puspaga_rw.balai_puspaga.kelurahan.kecamatan',
                'puspaga_rw.konselor',
            ];
            $mahasiswa->with($withs);
            $mahasiswa = $mahasiswa->orderBy($sortby, $order)->paginate($limit);
            $mahasiswa->append('ktp_url');
            $mahasiswa->append('foto_url');
            $mahasiswa->append('ttd_url');
            $this->saveLog($mahasiswa);
            return $mahasiswa;
        } catch (\Exception $e) {
            $this->responseCode = 500;
            $this->responseMessage = $e->getMessage();
            return response()->json($this->getResponse(), $this->responseCode);
        }
    }
    
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
        try {
            $id = intval($id);
            $mahasiswa = DMahasiswa::where('id', $id)->first();
            if(!$mahasiswa){
                $this->responseCode = 404;
                $this->responseMessage = 'Data tidak di temukan';
                return response()->json($this->getResponse(), $this->responseCode);
            }
            
            $mahasiswa = DMahasiswa::where('id', $id);
            $withs = [
                'kabupaten_lahir',
                'pendidikan_terakhir',
                'jenis_mahasiswa',
                'jurusan',
                'instansi_pendidikan',
                'kelurahan_domisili.kecamatan.kabupaten',
                'kelurahan_kk.kecamatan.kabupaten',
                'file_ktp',
                'file_foto',
                'file_ttd',
                'puspaga_rw.balai_puspaga.kelurahan.kecamatan',
                'puspaga_rw.konselor',
            ];
            $mahasiswa->with($withs);
            $mahasiswa = $mahasiswa->first();
            $mahasiswa->append('ktp_url');
            $mahasiswa->append('foto_url');
            $mahasiswa->append('ttd_url');
            $this->responseCode = 200;
            $this->responseData = $mahasiswa;
            return response()->json($this->getResponse(), $this->responseCode);
        } catch (\Exception $e) {
            $this->responseCode = 500;
            $this->responseMessage = $e->getMessage();
            return response()->json($this->getResponse(), $this->responseCode);
        }
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        
        try {
            DB::beginTransaction();

            $id = intval($id);
            $mahasiswa = DMahasiswa::find($id);
            if(!$mahasiswa){
                $this->responseCode = 404;
                $this->responseMessage = 'Data tidak di temukan';
                return response()->json($this->getResponse(), $this->responseCode);
            }
            $rules = [
                'name' => 'required|string',
                'id_kabupaten_lahir' => 'required|exists:App\Models\MKabupaten,id,deleted_at,NULL',
                'id_pendidikan_terakhir' => 'required|exists:App\Models\MPendidikanTerakhir,id,deleted_at,NULL',
                'id_jenis_mahasiswa' => 'required|exists:App\Models\MJenisMahasiswa,id,deleted_at,NULL',
                'id_jurusan' => 'required|exists:App\Models\MJurusan,id,deleted_at,NULL',
                'id_instansi_pendidikan' => 'required|exists:App\Models\MInstansiPendidikan,id,deleted_at,NULL',
                'id_kelurahan_domisili' => 'required|exists:App\Models\MKelurahan,id,deleted_at,NULL',
                'id_kelurahan_kk' => 'required|exists:App\Models\MKelurahan,id,deleted_at,NULL',
                'nim' => 'required|string',
                // 'nik' => 'required|string|size:16|unique:App\Models\DMahasiswa,nik',
                'nik' => ['required','string','size:16',Rule::unique('d_mahasiswa')->ignore($mahasiswa->id)],
                'birth_date' => 'required|date',
                'phone' => 'required|string',
                'semester' => 'required|numeric',
                'ipk' => 'required|numeric',
                'domicile_address' => 'required|string',
                'domicile_rw' => 'required|numeric',
                'domicile_rt' => 'required|numeric',
                'kk_address' => 'required|string',
                'kk_rw' => 'required|numeric',
                'kk_rt' => 'required|numeric',
                'status' => ['required', Rule::in(MahasiswaStatusEnum::getValues())],

                // File Mahasiswa
                'file_foto' => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
                'file_ktp' => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
                'file_ttd' => 'nullable|string'
                
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $this->responseCode = 422;
                $this->responseMessage = $validator->errors()->first();
                $this->responseData = $validator->errors();
                return response()->json($this->getResponse(), $this->responseCode);
            }
            $mahasiswa->id_kabupaten_lahir = $request->id_kabupaten_lahir;
            $mahasiswa->id_pendidikan_terakhir = $request->id_pendidikan_terakhir;
            $mahasiswa->id_jenis_mahasiswa = $request->id_jenis_mahasiswa;
            $mahasiswa->id_jurusan = $request->id_jurusan;
            $mahasiswa->id_instansi_pendidikan = $request->id_instansi_pendidikan;
            $mahasiswa->id_kelurahan_domisili = $request->id_kelurahan_domisili;
            $mahasiswa->id_kelurahan_kk = $request->id_kelurahan_kk;
            $mahasiswa->name = $request->name;
            $mahasiswa->nim = $request->nim;
            $mahasiswa->nik = $request->nik;
            $mahasiswa->birth_date = $request->birth_date;
            $mahasiswa->phone = $request->phone;
            $mahasiswa->semester = $request->semester;
            $mahasiswa->ipk = $request->ipk;
            $mahasiswa->domicile_address = $request->domicile_address;
            $mahasiswa->domicile_rw = $request->domicile_rw;
            $mahasiswa->domicile_rt = $request->domicile_rt;
            $mahasiswa->kk_address = $request->kk_address;
            $mahasiswa->kk_rw = $request->kk_rw;
            $mahasiswa->kk_rt = $request->kk_rt;
            $mahasiswa->status = $request->status;
            $mahasiswa->save();

            if($request->hasFile('file_foto')){
                $fileOld = $mahasiswa->file_foto;
                if($fileOld){
                    $fileOld->forceDelete();
                }
                $file = $request->file_foto;
                $changedName = time() . random_int(100, 999). '.' .$file->getClientOriginalExtension();
                $is_image = substr($file->getClientMimeType(), 0, 5) == 'image' ?? false;

                $path = 'private/mahasiswa/' . $mahasiswa->id . '/file_foto';
                $file->storeAs($path, $changedName);

                // $canvas = Image::canvas(400, 600, '#ffffff');
                // $img = Image::make($file->getRealPath());
                // $height = $img->height();
                // $width = $img->width();
                // $img->resize($width > $height ? 400 : null, $height >= $width ? 600 : null, function ($constraint){
                //     $constraint->aspectRatio();
                //     $constraint->upsize();
                // });
                // $canvas->insert($img, 'center');
                // $canvas->save(storage_path('app/'.$path. '/' . $changedName));

                $modelFile = new DMahasiswaFile();
                $modelFile->id_mahasiswa = $mahasiswa->id;
                $modelFile->name = $file->getClientOriginalName();
                $modelFile->path = $path . '/' . $changedName;
                $modelFile->size = $file->getSize();
                $modelFile->ext = $file->getClientOriginalExtension();
                $modelFile->is_image = $is_image;
                $modelFile->type = MahasiswaFileTypeEnum::FOTO;
                $modelFile->save();
            }

            if($request->has('file_ttd')){
                $fileOld = $mahasiswa->file_ttd;
                if($fileOld){
                    $fileOld->forceDelete();
                }
                $base64File = $request->file_ttd;

                $fileData = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $base64File));

                $tmpFilePath = sys_get_temp_dir() . '/' . Str::uuid()->toString();
                file_put_contents($tmpFilePath, $fileData);

                $tmpfile = new SymfonyFile($tmpFilePath);

                $file = new UploadedFile(
                    $tmpfile->getPathname(),
                    $tmpfile->getFilename(),
                    $tmpfile->getMimeType(),
                    0,
                    true // Mark it as test, since the file isn't from real HTTP POST.
                );

                $changedName = time() . random_int(100, 999). '.png';
                $is_image = substr($file->getClientMimeType(), 0, 5) == 'image' ?? false;

                $path = 'private/mahasiswa/' . $mahasiswa->id . '/file_ttd';
                $file->storeAs($path, $changedName);

                // $image = $request->image;  // your base64 encoded
                // $image = str_replace('data:image/png;base64,', '', $image);
                // $image = str_replace(' ', '+', $image);
                // $imageName = Str::random(10).'.'.'png';
                // $imagePath = storage_path(). '/private/mahasiswa/' . $mahasiswa->id . '/file_ktp/' . $imageName;
                // File::put($imagePath, base64_decode($image));

                // $canvas = Image::canvas(400, 600, '#ffffff');
                // $img = Image::make($file->getRealPath());
                // $height = $img->height();
                // $width = $img->width();
                // $img->resize($width > $height ? 400 : null, $height >= $width ? 600 : null, function ($constraint){
                //     $constraint->aspectRatio();
                //     $constraint->upsize();
                // });
                // $canvas->insert($img, 'center');
                // $canvas->save(storage_path('app/'.$path. '/' . $changedName));

                $modelFile = new DMahasiswaFile();
                $modelFile->id_mahasiswa = $mahasiswa->id;
                $modelFile->name = $file->getClientOriginalName();
                $modelFile->path = $path . '/' . $changedName;
                $modelFile->size = $file->getSize();
                $modelFile->ext = 'png';
                $modelFile->is_image = $is_image;
                $modelFile->type = MahasiswaFileTypeEnum::TTD;
                $modelFile->save();
            }
            if($request->has('file_ktp')){
                $fileOld = $mahasiswa->file_ktp;
                if($fileOld){
                    $fileOld->forceDelete();
                }
                $file = $request->file_ktp;
                $changedName = time() . random_int(100, 999). '.' .$file->getClientOriginalExtension();
                $is_image = substr($file->getClientMimeType(), 0, 5) == 'image' ?? false;

                $path = 'private/mahasiswa/' . $mahasiswa->id . '/file_ktp';
                $file->storeAs($path, $changedName);

                // $canvas = Image::canvas(400, 600, '#ffffff');
                // $img = Image::make($file->getRealPath());
                // $height = $img->height();
                // $width = $img->width();
                // $img->resize($width > $height ? 400 : null, $height >= $width ? 600 : null, function ($constraint){
                //     $constraint->aspectRatio();
                //     $constraint->upsize();
                // });
                // $canvas->insert($img, 'center');
                // $canvas->save(storage_path('app/'.$path. '/' . $changedName));

                $modelFile = new DMahasiswaFile();
                $modelFile->id_mahasiswa = $mahasiswa->id;
                $modelFile->name = $file->getClientOriginalName();
                $modelFile->path = $path . '/' . $changedName;
                $modelFile->size = $file->getSize();
                $modelFile->ext = $file->getClientOriginalExtension();
                $modelFile->is_image = $is_image;
                $modelFile->type = MahasiswaFileTypeEnum::KTP;
                $modelFile->save();
            }

            DB::commit();
            $this->responseCode = 201;
            $this->responseData = $mahasiswa;
            return response()->json($this->getResponse(), $this->responseCode);
        } catch (\Exception $e) {
            $this->responseCode = 500;
            $this->responseMessage = $e->getMessage();
            DB::rollback();
            return response()->json($this->getResponse(), $this->responseCode);
        }
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexPublic(Request $request)
    {
        
        try {
            $limit = $request->limit ? intval($request->limit) : 10;
            $order = $request->order ? $request->order : 'DESC';
            $sortby = $request->sortby ? $request->sortby : 'id';

            $mahasiswa = DMahasiswa::query();
            if($request->filled('search')){
                $mahasiswa->where(DB::raw('lower(d_mahasiswa.name)'), 'like', '%' . strtolower($request->search) . '%');
            }
            $withs = [
                'jenis_mahasiswa',
                'instansi_pendidikan',
                'pendidikan_terakhir',
                'puspaga_rw.balai_puspaga.kelurahan.kecamatan',
                // 'getStatusStringAttribute',
            ];
            $mahasiswa->with($withs);
            $mahasiswa = $mahasiswa->orderBy($sortby, $order)->paginate($limit);
            $mahasiswa->makeHidden(['birth_date', 'domicile_address', 'domicile_rt', 'domicile_rw', 'email', 'foto_url', 'id_kabupaten_lahir', 'id_kelurahan_domisili', 'id_kelurahan_kk', 'id_user', 'ipk', 'kk_address', 'kk_rt', 'kk_rw', 'ktp_url', 'nik', 'nim', 'phone', 'semester', 'tanggal_daftar', 'ttd_url']);
            $this->saveLog($mahasiswa);
            return $mahasiswa;
        } catch (\Exception $e) {
            $this->responseCode = 500;
            $this->responseMessage = $e->getMessage();
            return response()->json($this->getResponse(), $this->responseCode);
        }
    }
    
    public function switchStatus($id)
    {
        if(!$mahasiswa = DMahasiswa::find(intval($id))){
            $this->responseCode = 404;
            $this->responseMessage = 'Data tidak di temukan';
            return response()->json($this->getResponse(), $this->responseCode);
        }

        DB::transaction(function () use($mahasiswa) {
            $mahasiswa->is_active = !$mahasiswa->is_active;
            $mahasiswa->save();
        });
        
        $this->responseCode = 200;
        $this->responseMessage = boolval($mahasiswa->is_active) ? 'Data telah diaktifkan' : 'Data telah dinonaktifkan';
        $this->responseData = $mahasiswa;
        return response()->json($this->getResponse(), $this->responseCode);
    }
    
    public function export(Request $req)
    {
        $withs = [
            'kabupaten_lahir',
            'pendidikan_terakhir',
            'jenis_mahasiswa',
            'jurusan',
            'instansi_pendidikan',
            'kelurahan_domisili.kecamatan.kabupaten',
            'kelurahan_kk.kecamatan.kabupaten',
            'puspaga_rw.balai_puspaga.kelurahan.kecamatan.kabupaten',
            'puspaga_rw.konselor'
        ];
        $mahasiswa = DMahasiswa::with($withs)->get();
        ini_set('memory_limit', -1);
        return Excel::download(new DatabaseExport(json_decode($mahasiswa), 'exports.dMahasiswa'), 'Mahasiswa.xlsx');
    }
    
    public function assignBalai(Request $request,$id)
    {
        try {
            DB::beginTransaction();
            
            $id = intval($id);
            $mahasiswa = DMahasiswa::find($id);
            if(!$mahasiswa){
                $this->responseCode = 404;
                $this->responseMessage = 'Data tidak di temukan';
                return response()->json($this->getResponse(), $this->responseCode);
            }

            $mahasiswa->status = MahasiswaStatusEnum::ONDUTY;
            $mahasiswa->is_active = true;
            $mahasiswa->save();

            $rules = [
                'id_konselor' => 'required|exists:App\Models\MKonselor,id,deleted_at,NULL',
                'id_balai_puspaga_rw' => 'required|exists:App\Models\DBalaiPuspagaRW,id,deleted_at,NULL',
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $this->responseCode = 422;
                $this->responseMessage = $validator->errors()->first();
                $this->responseData = $validator->errors();
                return response()->json($this->getResponse(), $this->responseCode);
            }

            $penugasan_mahasiswa = MahasiswaBalaiPuspagaRW::create([
                'id_konselor' => $request->id_konselor,
                'id_mahasiswa' => $mahasiswa->id,
                'id_balai_puspaga_rw' => $request->id_balai_puspaga_rw
            ]);

            DB::commit();
            $this->responseCode = 201;
            $this->responseData = $penugasan_mahasiswa;
            return response()->json($this->getResponse(), $this->responseCode);
        } catch (\Exception $e) {
            $this->responseCode = 500;
            $this->responseMessage = $e->getMessage();
            DB::rollback();
            return response()->json($this->getResponse(), $this->responseCode);
        }
    }
    public function assignSwitchStatus(Request $request,$id)
    {
        if (!$penugasan = MahasiswaBalaiPuspagaRW::find(intval($id))) {
            $this->responseCode = 404;
            $this->responseMessage = 'Data tidak ditemukan!';
            return response()->json($this->getResponse(), $this->responseCode);
        }

        DB::transaction(function () use($penugasan) {
            $penugasan->is_active = !$penugasan->is_active;
            $penugasan->save();
        });
        
        $this->responseCode = 200;
        $this->responseMessage = boolval($penugasan->is_active) ? 'Data telah diaktifkan' : 'Data telah dinonaktifkan';
        $this->responseData = $penugasan;
        return response()->json($this->getResponse(), $this->responseCode);
    }

    public function recap(Request $request){
        if(!$request->filled('type')){
            $this->responseCode = 404;
            $this->responseMessage = 'Pilih tipe rekapitulasi!';
            return response()->json($this->getResponse(), $this->responseCode);
        }
        if(!$request->filled('filter')){
            $this->responseCode = 404;
            $this->responseMessage = 'Pilih filter rekapitulasi!';
            return response()->json($this->getResponse(), $this->responseCode);
        }
    }

    public function setInactive($id_mahasiswa)
    {
        if (!$penugasan = MahasiswaBalaiPuspagaRW::where(['is_active' => true, 'id_mahasiswa' => $id_mahasiswa])->first()) {
            $this->responseCode = 404;
            $this->responseMessage = 'Data tidak ditemukan!';
            return response()->json($this->getResponse(), $this->responseCode);
        }

        DB::transaction(function () use ($penugasan) {
            $penugasan->sample_mahasiswa->is_active = false;
            $penugasan->sample_mahasiswa->status = MahasiswaStatusEnum::NONACTIVE;
            $penugasan->sample_mahasiswa->save();

            $penugasan->is_active = false;
            $penugasan->save();
        });

        $this->responseCode = 200;
        $this->responseMessage = 'Data telah dinonaktifkan!';
        $this->responseData = $penugasan;
        return response()->json($this->getResponse(), $this->responseCode);
    }
}
