<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PsikologVolunteerSheetExport;
use App\Exports\DatabaseExport;
use App\Imports\PsikologVolunteerSheetImport;

use App\Models\PsikologVolunteer;
use App\Models\PsikologVolunteerFile;
use App\Models\MKelurahan;
use App\Models\MKecamatan;

use DB;
use PDF;
use Validator;
use Image;

class PsikologVolunteerController extends Controller
{
    public function model()
    {
        return new PsikologVolunteer();
    }

    public function modelFile()
    {
        return new PsikologVolunteerFile();
    }

    private function rules()
    {
        return [
            'nama_lengkap' => 'nullable|string',
            'nik' => 'nullable|numeric|digits:16|unique:App\Models\PuspagaRw,nik',

            'id_kelurahan_domisili' => 'nullable|exists:App\Models\MKelurahan,id,deleted_at,NULL',
            'alamat_domisili' => 'nullable|string',
            'rt_domisili' => 'nullable|numeric',
            'rw_domisili' => 'nullable|numeric',
            'id_kelurahan_ktp' => 'nullable|exists:App\Models\MKelurahan,id,deleted_at,NULL',
            'alamat_ktp' => 'nullable|string',
            'rt_ktp' => 'nullable|numeric',
            'rw_ktp' => 'nullable|numeric',

            'no_hp' => 'nullable|numeric',
            'id_kabupaten_lahir' => 'nullable|exists:m_kabupaten,id,deleted_at,NULL',
            'tanggal_lahir' => 'nullable|date',
            'id_pendidikan_terakhir' => 'nullable|exists:m_pendidikan_terakhir,id,deleted_at,NULL',
            'id_jurusan' => 'nullable|exists:m_jurusan,id,deleted_at,NULL',
            'id_instansi_pendidikan' => 'nullable|exists:m_instansi_pendidikan,id,deleted_at,NULL',
            'kompetensi' => 'nullable|string',
            'foto' => 'nullable|mimes:png,jpg,jpeg',
        ];
    }

    private function select()
    {
        return $this->model()::select([
            'psikolog_volunteer.*', DB::raw('f.id as foto'), 'f.path AS foto_path',
            DB::raw('kec_dom.id as kecamatan_domisili_id'), DB::raw('kec_dom.name as kecamatan_domisili_name'),
            DB::raw('kel_dom.name as kelurahan_domisili_name'),
            DB::raw('kec_ktp.id as kecamatan_ktp_id'), DB::raw('kec_ktp.name as kecamatan_ktp_name'),
            DB::raw('kel_ktp.name as kelurahan_ktp_name'),
            'kabupaten_lahir.name AS nama_kabupaten_lahir',
            'm_pendidikan_terakhir.name AS nama_pendidikan_terakhir',
            'm_jurusan.name AS nama_jurusan',
            'm_instansi_pendidikan.name AS nama_instansi_pendidikan',
            'creator.id AS creator_id', 'creator.name AS creator_name', 'creator.username AS creator_username',
        ])
            ->leftJoin('psikolog_volunteer_file as f', function ($j) {
                $j->on('psikolog_volunteer.id', '=', 'f.id_psikolog_volunteer');
            })
            ->leftJoin('m_kelurahan as kel_dom', 'kel_dom.id', '=', 'psikolog_volunteer.id_kelurahan_domisili')
            ->leftJoin('m_kecamatan as kec_dom', 'kec_dom.id', '=', 'kel_dom.id_kecamatan')
            ->leftJoin('m_kelurahan as kel_ktp', 'kel_ktp.id', '=', 'psikolog_volunteer.id_kelurahan_ktp')
            ->leftJoin('m_kecamatan as kec_ktp', 'kec_ktp.id', '=', 'kel_ktp.id_kecamatan')
            ->leftJoin('m_kabupaten AS kabupaten_lahir', 'kabupaten_lahir.id', '=', 'psikolog_volunteer.id_kabupaten_lahir')
            ->leftJoin('m_jurusan', 'm_jurusan.id', '=', 'psikolog_volunteer.id_jurusan')
            ->leftJoin('m_pendidikan_terakhir', 'm_pendidikan_terakhir.id', '=', 'psikolog_volunteer.id_pendidikan_terakhir')
            ->leftJoin('m_instansi_pendidikan', 'm_instansi_pendidikan.id', '=', 'psikolog_volunteer.id_instansi_pendidikan')
            ->leftJoin('m_user AS creator', 'creator.id', '=', 'psikolog_volunteer.created_by');
    }

    public function index(Request $req)
    {
        try {
            $limit = $req->limit ? intval($req->limit) : 10;
            if ($limit > 100) $limit = 100;

            $order = Str::lower($req->order) == 'asc' ? 'asc' : 'desc';
            $sortby = $req->sortby ? $req->sortby : 'id';

            $model = $this->select();
            if ($req->filled('id_kelurahan')) {
                $model->where('psikolog_volunteer.id_kelurahan_domisili', $req->id_kelurahan);
            } else if ($req->filled('id_kecamatan')) {
                $model->where('kec_dom.id', $req->id_kecamatan);
            }

            if ($req->filled('search')) {
                $model->where(function ($q) use ($req) {
                    $s = $req->search;
                    $q->where('psikolog_volunteer.name', 'ILIKE', '%' . $s . '%');
                    $q->orWhere('psikolog_volunteer.nik', 'ILIKE', '%' . $s . '%');
                    // $q->orWhere('psikolog_volunteer.sk_number', 'ILIKE', '%'. $s .'%');
                    // $q->orWhere('psikolog_volunteer.rw', 'ILIKE', '%'. $s .'%');
                    // $q->orWhere('psikolog_volunteer.instansi_position', 'ILIKE', '%'. $s .'%');
                    // $q->orWhere('psikolog_volunteer.sk_position', 'ILIKE', '%'. $s .'%');
                    $q->orWhere('kec_dom.name', 'ILIKE', '%' . $s . '%');
                    $q->orWhere('kel_dom.name', 'ILIKE', '%' . $s . '%');
                    // $q->orWhere('kec_ktp.name', 'ILIKE', '%'. $s .'%');
                    // $q->orWhere('kel_ktp.name', 'ILIKE', '%'. $s .'%');
                });
            }

            $model = $model->orderBy($sortby, $order)->paginate($limit);

            $this->saveLog($model);
            return $model;
        } catch (\Exception $e) {
            $this->responseCode = 500;
            $this->responseMessage = $e->getMessage() . ' ' . $e->getLine();
            return response()->json($this->getResponse(), $this->responseCode);
        }
    }

    public function store(Request $req)
    {
        $this->authorize('create', PsikologVolunteer::class);

        try {
            DB::beginTransaction();

            $validator = Validator::make($req->all(), $this->rules());
            if ($validator->fails()) {
                $this->responseCode = 422;
                $this->responseMessage = $validator->errors()->first();
                $this->responseData = $validator->errors();
                return response()->json($this->getResponse(), $this->responseCode);
            }

            $model = $this->model()::create([
                'name' => $req->nama_lengkap,
                'nik' => $req->nik,
                'id_kelurahan_domisili' => $req->id_kelurahan_domisili,
                'alamat_domisili' => $req->alamat_domisili,
                'rt_domisili' => $req->rt_domisili,
                'rw_domisili' => $req->rw_domisili,
                'id_kelurahan_ktp' => $req->id_kelurahan_ktp,
                'alamat_ktp' => $req->alamat_ktp,
                'rt_ktp' => $req->rt_ktp,
                'rw_ktp' => $req->rw_ktp,
                'no_hp' => $req->no_hp,
                'id_kabupaten_lahir' => $req->id_kabupaten_lahir,
                'tanggal_lahir' => $req->tanggal_lahir,
                'id_pendidikan_terakhir' => $req->id_pendidikan_terakhir,
                'id_jurusan' => $req->id_jurusan,
                'id_instansi_pendidikan' => $req->id_instansi_pendidikan,
                'kompetensi' => $req->kompetensi,
            ]);

            if ($req->hasFile('foto')) {
                $file = $req->foto;
                $changedName = time() . random_int(100, 999) . '.' . $file->getClientOriginalExtension();
                $is_image = substr($file->getClientMimeType(), 0, 5) == 'image' ?? false;

                $path = 'private/psikolog_velunteer/' . $model->id . '/foto';
                $file->storeAs($path, $changedName);

                $canvas = Image::canvas(400, 600, '#ffffff');
                $img = Image::make($file->getRealPath());
                $height = $img->height();
                $width = $img->width();
                $img->resize($width > $height ? 400 : null, $height >= $width ? 600 : null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
                $canvas->insert($img, 'center');
                $canvas->save(storage_path('app/' . $path . '/' . $changedName));

                $modelFile = $this->modelFile();
                $modelFile->id_psikolog_volunteer = $model->id;
                $modelFile->name = $file->getClientOriginalName();
                $modelFile->path = $path . '/' . $changedName;
                $modelFile->size = $file->getSize();
                $modelFile->ext = $file->getClientOriginalExtension();
                $modelFile->is_image = $is_image;
                $modelFile->save();
            }

            DB::commit();
            $this->responseCode = 201;
            return response()->json($this->getResponse(), $this->responseCode);
        } catch (\Exception $e) {
            DB::rollback();
            $this->responseCode = 500;
            $this->responseMessage = $e->getMessage() . ' ' . $e->getLine();
            return response()->json($this->getResponse(), $this->responseCode);
        }
    }

    public function show($id)
    {
        $id = intval($id);
        $model = $this->select()->where('psikolog_volunteer.id', $id)->first();
        if (!$model) {
            $this->responseCode = 404;
            $this->responseMessage = 'Data tidak ditemukan';
            return response()->json($this->getResponse(), $this->responseCode);
        }

        try {
            $this->responseCode = 200;
            $this->responseData = ($model);
            return response()->json($this->getResponse(), $this->responseCode);
        } catch (\Exception $e) {
            $this->responseCode = 500;
            $this->responseMessage = $e->getMessage() . ' ' . $e->getLine();
            return response()->json($this->getResponse(), $this->responseCode);
        }
    }

    public function update(Request $req, $id)
    {
        $id = intval($id);
        $model = $this->model()::find($id);
        if (!$model) {
            $this->responseCode = 404;
            $this->responseMessage = 'Data tidak ditemukan';
            return response()->json($this->getResponse(), $this->responseCode);
        }

        $this->authorize('update', $model);

        try {
            DB::beginTransaction();

            $rules = $this->rules();
            $validator = Validator::make($req->all(), $rules);
            if ($validator->fails()) {
                $this->responseCode = 422;
                $this->responseMessage = $validator->errors()->first();
                $this->responseData = $validator->errors();
                return response()->json($this->getResponse(), $this->responseCode);
            }

            $model->name = $req->nama_lengkap;
            $model->nik = $req->nik;
            $model->id_kelurahan_domisili = $req->id_kelurahan_domisili;
            $model->alamat_domisili = $req->alamat_domisili;
            $model->rt_domisili = $req->rt_domisili;
            $model->rw_domisili = $req->rw_domisili;
            $model->id_kelurahan_ktp = $req->id_kelurahan_ktp;
            $model->alamat_ktp = $req->alamat_ktp;
            $model->rt_ktp = $req->rt_ktp;
            $model->rw_ktp = $req->rw_ktp;
            $model->no_hp = $req->no_hp;
            $model->id_kabupaten_lahir = $req->id_kabupaten_lahir;
            $model->tanggal_lahir = $req->tanggal_lahir;
            $model->id_pendidikan_terakhir = $req->id_pendidikan_terakhir;
            $model->id_jurusan = $req->id_jurusan;
            $model->id_instansi_pendidikan = $req->id_instansi_pendidikan;
            $model->kompetensi = $req->kompetensi;

            $model->save();

            if ($req->hasFile('foto')) {
                $fotoOld = $model->fotoFile;
                if ($fotoOld) {
                    $fotoOld->forceDelete();
                }

                $file = $req->foto;
                $changedName = time() . random_int(100, 999) . '.' . $file->getClientOriginalExtension();
                $is_image = substr($file->getClientMimeType(), 0, 5) == 'image' ?? false;

                $path = 'private/psikolog_volunteer/' . $model->id . '/foto';
                $file->storeAs($path, $changedName);

                $canvas = Image::canvas(400, 600, '#ffffff');
                $img = Image::make($file->getRealPath());
                $height = $img->height();
                $width = $img->width();
                $img->resize($width > $height ? 400 : null, $height >= $width ? 600 : null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
                $canvas->insert($img, 'center');
                $canvas->save(storage_path('app/' . $path . '/' . $changedName));

                $modelFile = $this->modelFile();
                $modelFile->id_psikolog_volunteer = $model->id;
                $modelFile->name = $file->getClientOriginalName();
                $modelFile->path = $path . '/' . $changedName;
                $modelFile->size = $file->getSize();
                $modelFile->ext = $file->getClientOriginalExtension();
                $modelFile->is_image = $is_image;
                $modelFile->save();
            }

            DB::commit();
            $this->responseCode = 200;
            return response()->json($this->getResponse(), $this->responseCode);
        } catch (\Exception $e) {
            DB::rollback();
            $this->responseCode = 500;
            $this->responseMessage = $e->getMessage() . ' ' . $e->getLine();
            return response()->json($this->getResponse(), $this->responseCode);
        }
    }

    public function switchStatus($id)
    {
        $model = $this->model()::find($id);
        if (!$model) {
            $this->responseCode = 404;
            $this->responseMessage = 'Data tidak ditemukan';
            return response()->json($this->getResponse(), $this->responseCode);
        }

        $this->authorize('update', $model);

        try {
            $model->update([
                'is_active' => !$model->is_active,
            ]);

            DB::commit();
            $this->responseCode = 200;
            $this->responseMessage = boolval($model->is_active) ? 'Data telah diaktifkan' : 'Data telah dinonaktifkan';
            return response()->json($this->getResponse(), $this->responseCode);
        } catch (\Exception $e) {
            DB::rollback();
            $this->responseCode = 500;
            $this->responseMessage = $e->getMessage() . ' ' . $e->getLine();
            return response()->json($this->getResponse(), $this->responseCode);
        }
    }

    public function summary()
    {
        try {
            $data = [
                'anggota' => $this->model()::count(),
                'kelurahan' => MKelurahan::whereHas('psikologVolunteer')->count(),
                'kecamatan' => MKecamatan::whereHas('kelurahan.psikologVolunteer')->count(),
            ];

            $this->responseCode = 200;
            $this->responseData = $data;
            return response()->json($this->getResponse(), $this->responseCode);
        } catch (\Exception $e) {
            $this->responseCode = 500;
            $this->responseMessage = $e->getMessage() . ' ' . $e->getLine();
            return response()->json($this->getResponse(), $this->responseCode);
        }
    }

    public function downloadFormat()
    {
        return Excel::download(new PsikologVolunteerSheetExport, 'PsikologVolunteerFormatExport.xlsx');
    }

    public function import(Request $req)
    {
        try {
            $rules = [
                'file' => 'required|mimes:xls,xlsx',
            ];
            $validator = Validator::make($req->all(), $rules);
            if ($validator->fails()) {
                $this->responseCode = 422;
                $this->responseMessage = $validator->errors()->first();
                $this->responseData = $validator->errors();
                return response()->json($this->getResponse(), $this->responseCode);
            }

            Excel::import(new PsikologVolunteerSheetImport, $req->file('file'));
            $this->responseCode = 200;
            return response()->json($this->getResponse(), $this->responseCode);
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $this->responseCode = 422;
            $this->responseMessage = 'Error validation';
            $this->responseData = $e->failures();
            return response()->json($this->getResponse(), $this->responseCode);
        }
    }

    public function cetakPdf($id)
    {
        $id = intval($id);
        $model = $this->select()->where('psikolog_volunteer.id', $id)->first();
        if (!$model) {
            $this->responseCode = 404;
            $this->responseMessage = 'Data tidak ditemukan';
            return response()->json($this->getResponse(), $this->responseCode);
        }

        $pdf = PDF::loadView('pdf.cetakPsikologVolunteer', ['data' => json_decode(json_encode($model))]);

        $this->saveLog();
        return $pdf->download('cetak_psikolog_volunteer-' . $id . '.pdf');
    }

    public function export(Request $req)
    {
        ini_set('memory_limit', -1);
        return Excel::download(new DatabaseExport((json_decode($this->select()->get())), 'exports.psikologVolunteer'), 'PsikologVolunteer.xlsx');
    }

    public function lists(Request $request)
    {
        $this->authorize('lists', PsikologVolunteer::class);

        try {
            $limit = $request->limit ? intval($request->limit) : 10;
            if ($limit > 100) $limit = 100;

            $psikologvolunteer = PsikologVolunteer::select('*');
            if ($request->filled('search')) {
                $psikologvolunteer->where(DB::raw('lower(name)'), 'like', '%' . strtolower($request->search) . '%');
            }
            $psikologvolunteer = $psikologvolunteer->where('psikolog_volunteer.is_active', true)->take($limit)->orderBy('name', 'ASC')->get();

            $this->responseCode = 200;
            $this->responseData = $psikologvolunteer;
            return response()->json($this->getResponse(), $this->responseCode);
        } catch (\Exception $e) {
            $this->responseCode = 500;
            $this->responseMessage = $e->getMessage();
            return response()->json($this->getResponse(), $this->responseCode);
        }
    }

    public function hasScheduleLists(Request $request)
    {
        try {
            $limit = $request->limit ? intval($request->limit) : 10;

            $psikologvolunteer = PsikologVolunteer::select('*')->has('jadwalActive');
            if ($request->filled('search')) {
                $psikologvolunteer->where(DB::raw('lower(name)'), 'like', '%' . strtolower($request->search) . '%');
            }
            $psikologvolunteer = $psikologvolunteer->where('psikolog_volunteer.is_active', true)->take($limit)->orderBy('name', 'ASC')->get();

            $this->responseCode = 200;
            $this->responseData = $psikologvolunteer;
            return response()->json($this->getResponse(), $this->responseCode);
        } catch (\Exception $e) {
            $this->responseCode = 500;
            $this->responseMessage = $e->getMessage();
            return response()->json($this->getResponse(), $this->responseCode);
        }
    }
}
