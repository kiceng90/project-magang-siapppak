<?php

namespace App\Http\Controllers\API;

use App\Enums\DKlienKonselingFileTypeEnum;
use App\Http\Controllers\Controller;
use App\Models\DKlienKonseling;
use App\Models\DKlienKonselingFile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\File\File as SymfonyFile;
use Illuminate\Http\UploadedFile;

class DKlienKonselingController extends Controller
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
                
                // Klien Data Rules
                'nik' => 'required|string|size:16|unique:App\Models\DKlienKonseling,nik',
                'phone' => 'required|string',
                'email' => 'required|email|unique:App\Models\DKlienKonseling,email',
                'is_active' => 'required|boolean',
                'id_kabupaten' => 'required|exists:App\Models\MKabupaten,id,deleted_at,NULL',
                'id_kelurahan' => 'required|exists:App\Models\MKelurahan,id,deleted_at,NULL',
                'address' => 'required|string',
                'rw' => 'required|numeric',
                'rt' => 'required|numeric',
                'file_ktp' => 'required|image|mimes:jpg,jpeg,png|max:5120',
                'file_kk' => 'required|image|mimes:jpg,jpeg,png|max:5120',
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
                'id_role' => config('env.role.klien'),
                'name' => ($request->name),
                'username' => Str::lower($request->username),
                'password' => Hash::make($request->password),
            ]);
            
            $klien = DKlienKonseling::create([
                'id_user' => $user->id,
                'name' => $user->name,
                'nik' => $request->nik,
                'phone' => $request->phone,
                'email' => $request->email,
                'is_active' => $request->is_active,
                'id_kabupaten' => $request->id_kabupaten,
                'id_kelurahan' => $request->id_kelurahan,
                'address' => $request->address,
                'rw' => $request->rw,
                'rt' => $request->rt
            ]);
            
            if($request->hasFile('file_ktp')){
                $file = $request->file_ktp;
                $changedName = time() . random_int(100, 999). '.' .$file->getClientOriginalExtension();
                $is_image = substr($file->getClientMimeType(), 0, 5) == 'image' ?? false;

                $path = 'private/klien_konseling/' . $klien->id . '/file_ktp';
                $file->storeAs($path, $changedName);

                $modelFile = new DKlienKonselingFile();
                $modelFile->id_klien_konseling = $klien->id;
                $modelFile->name = $file->getClientOriginalName();
                $modelFile->path = $path . '/' . $changedName;
                $modelFile->size = $file->getSize();
                $modelFile->ext = $file->getClientOriginalExtension();
                $modelFile->is_image = $is_image;
                $modelFile->type = DKlienKonselingFileTypeEnum::KTP;
                $modelFile->save();
            }

            if($request->hasFile('file_kk')){
                $file = $request->file_kk;
                $changedName = time() . random_int(100, 999). '.' .$file->getClientOriginalExtension();
                $is_image = substr($file->getClientMimeType(), 0, 5) == 'image' ?? false;

                $path = 'private/klien_konseling/' . $klien->id . '/file_kk';
                $file->storeAs($path, $changedName);

                $modelFile = new DKlienKonselingFile();
                $modelFile->id_klien_konseling = $klien->id;
                $modelFile->name = $file->getClientOriginalName();
                $modelFile->path = $path . '/' . $changedName;
                $modelFile->size = $file->getSize();
                $modelFile->ext = $file->getClientOriginalExtension();
                $modelFile->is_image = $is_image;
                $modelFile->type = DKlienKonselingFileTypeEnum::KK;
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

                $path = 'private/klien_konseling/' . $klien->id . '/file_ttd';
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

                $modelFile = new DKlienKonselingFile();
                $modelFile->id_klien_konseling = $klien->id;
                $modelFile->name = $file->getClientOriginalName();
                $modelFile->path = $path . '/' . $changedName;
                $modelFile->size = $file->getSize();
                $modelFile->ext = 'png';
                $modelFile->is_image = $is_image;
                $modelFile->type = DKlienKonselingFileTypeEnum::TTD;
                $modelFile->save();
            }

            DB::commit();
            $this->responseCode = 201;
            $this->responseData = $klien;
            return response()->json($this->getResponse(), $this->responseCode);
        } catch (\Exception $e) {
            $this->responseCode = 500;
            $this->responseMessage = $e->getMessage();
            DB::rollback();
            return response()->json($this->getResponse(), $this->responseCode);
        }
    }
    public function switchStatus($id)
    {
        if(!$klien = DKlienKonseling::find(intval($id))){
            $this->responseCode = 404;
            $this->responseMessage = 'Data tidak di temukan';
            return response()->json($this->getResponse(), $this->responseCode);
        }

        DB::transaction(function () use($klien) {
            $klien->is_active = !$klien->is_active;
            $klien->save();
        });
        
        $this->responseCode = 200;
        $this->responseMessage = boolval($klien->is_active) ? 'Data telah diaktifkan' : 'Data telah dinonaktifkan';
        $this->responseData = $klien;
        return response()->json($this->getResponse(), $this->responseCode);
    }
}
