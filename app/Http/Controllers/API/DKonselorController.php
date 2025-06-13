<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


use Maatwebsite\Excel\Facades\Excel;
use App\Exports\DKonselorSheetExport;
use App\Exports\DatabaseExport;
use App\Imports\DKonselorSheetImport;

use App\Models\DKonselor;
use App\Models\DKonselorFile;
use App\Models\MKelurahan;
use App\Models\MKecamatan;

use DB;
use PDF;
use Validator;
use Image;

class DKonselorController extends Controller
{
    public function rules()
    {
        return [
            'id_m_konselor' => 'required|exists:m_konselor,id,deleted_at,NULL',
            'nik' => 'nullable|numeric|digits:16|unique:App\Models\DKonselor,nik',
            'tmt_tugas' => 'nullable|date',
            'id_kelurahan_domisili' => 'nullable|exists:m_kelurahan,id,deleted_at,NULL',
            'alamat_domisili' => 'nullable|string',
            'rt_domisili' => 'nullable|numeric',
            'rw_domisili' => 'nullable|numeric',
            'id_kelurahan_ktp' => 'nullable|exists:m_kelurahan,id,deleted_at,NULL',
            'alamat_ktp' => 'nullable|string',
            'rt_ktp' => 'nullable|numeric',
            'rw_ktp' => 'nullable|numeric',
            'id_kabupaten_lahir' => 'nullable|exists:m_kabupaten,id,deleted_at,NULL',
            'tanggal_lahir' => 'nullable|date',
            'id_pendidikan_terakhir' => 'nullable|exists:m_pendidikan_terakhir,id,deleted_at,NULL',
            'id_jurusan' => 'nullable|exists:m_jurusan,id,deleted_at,NULL',
            'id_instansi_pendidikan' => 'nullable|exists:m_instansi_pendidikan,id,deleted_at,NULL',
            'status' => 'nullable|in:konselor,psikolog',
            'foto' => 'nullable|mimes:png,jpg,jpeg',
        ];
    }

    public function select()
    {
        return DKonselor::select([
            'd_konselor.*', 'm_konselor.id AS id_m_konselor', 'm_konselor.name AS nama_m_konselor',
            'm_konselor.phone_number AS phone_number_m_konselor', 'f.id as foto', 'f.path AS foto_path',
            'kelurahan_dom.name AS nama_kelurahan_domisili',
            'kecamatan_dom.id AS id_kecamatan_domisili', 'kecamatan_dom.name AS nama_kecamatan_domisili',
            'kelurahan_ktp.name AS nama_kelurahan_ktp',
            'kecamatan_ktp.id AS id_kecamatan_ktp', 'kecamatan_ktp.name AS nama_kecamatan_ktp',
            'kabupaten_lahir.name AS nama_kabupaten_lahir',
            'm_pendidikan_terakhir.name AS nama_pendidikan_terakhir',
            'm_jurusan.name AS nama_jurusan',
            'm_instansi_pendidikan.name AS nama_instansi_pendidikan',
            'creator.id AS creator_id', 'creator.name AS creator_name', 'creator.username AS creator_username',
        ])
            ->leftJoin('m_konselor', 'm_konselor.id', '=', 'd_konselor.id_m_konselor')
            ->leftJoin('d_konselor_file as f', 'd_konselor.id', '=', 'f.id_d_konselor')
            ->leftJoin('m_kelurahan AS kelurahan_dom', 'kelurahan_dom.id', '=', 'd_konselor.id_kelurahan_domisili')
            ->leftJoin('m_kecamatan AS kecamatan_dom', 'kecamatan_dom.id', '=', 'kelurahan_dom.id_kecamatan')
            ->leftJoin('m_kelurahan AS kelurahan_ktp', 'kelurahan_ktp.id', '=', 'd_konselor.id_kelurahan_ktp')
            ->leftJoin('m_kecamatan AS kecamatan_ktp', 'kecamatan_ktp.id', '=', 'kelurahan_ktp.id_kecamatan')
            ->leftJoin('m_kabupaten AS kabupaten_lahir', 'kabupaten_lahir.id', '=', 'd_konselor.id_kabupaten_lahir')
            ->leftJoin('m_pendidikan_terakhir', 'm_pendidikan_terakhir.id', '=', 'd_konselor.id_pendidikan_terakhir')
            ->leftJoin('m_jurusan', 'm_jurusan.id', '=', 'd_konselor.id_jurusan')
            ->leftJoin('m_instansi_pendidikan', 'm_instansi_pendidikan.id', '=', 'd_konselor.id_instansi_pendidikan')
            ->leftJoin('m_user AS creator', 'creator.id', '=', 'd_konselor.created_by');
    }

    public function index(Request $req)
    {
        $this->authorize('viewAny', DKonselor::class);

        try {
            $limit = $req->limit ? intval($req->limit) : 10;
            if ($limit > 100) $limit = 100;

            $order = Str::lower($req->order) == 'asc' ? 'asc' : 'desc';
            $sortby = $req->sortby ? $req->sortby : 'id';

            $konselor = $this->select();

            if ($req->filled('search')) {
                $konselor->where(function ($q) use ($req) {
                    $search = [
                        'd_konselor.nik', 'm_konselor.name',
                        'kelurahan_dom.name', 'kecamatan_dom.name',
                        // 'd_konselor.alamat_domisili',
                        // 'd_konselor.alamat_ktp', 'd_konselor.status',
                        // 'm_konselor.phone_number',
                        // 'kelurahan_ktp.name', 'kecamatan_ktp.name',
                        // 'kabupaten_lahir.name', 'm_pendidikan_terakhir.name',
                        // 'm_instansi_pendidikan.name',
                    ];
                    foreach ($search as $key => $val) {
                        if ($key == 0) {
                            $q->where($val, 'ILIKE', "%$req->search%");
                        } else {
                            $q->orWhere($val, 'ILIKE', "%$req->search%");
                        }
                    }
                });
            }

            $konselor = $konselor->orderBy($sortby, $order)->paginate($limit);

            $this->saveLog($konselor);
            return $konselor;
        } catch (\Exception $e) {
            $this->responseCode = 500;
            $this->responseMessage = $e->getMessage();
            return response()->json($this->getResponse(), $this->responseCode);
        }
    }

    public function store(Request $req)
    {
        $this->authorize('create', DKonselor::class);

        try {
            $validator = Validator::make($req->all(), $this->rules());
            if ($validator->fails()) {
                $this->responseCode = 422;
                $this->responseMessage = $validator->errors()->first();
                $this->responseData = $validator->errors();
                return response()->json($this->getResponse(), $this->responseCode);
            }

            DB::beginTransaction();
            $konselor = DKonselor::create($req->all());

            if ($req->hasFile('foto')) {
                $file = $req->foto;
                $changedName = time() . random_int(100, 999) . '.' . $file->getClientOriginalExtension();
                $is_image = substr($file->getClientMimeType(), 0, 5) == 'image' ?? false;

                $path = 'private/d_konselor/' . $konselor->id . '/foto';
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

                $modelFile = new DKonselorFile();
                $modelFile->id_d_konselor = $konselor->id;
                $modelFile->name = $file->getClientOriginalName();
                $modelFile->path = $path . '/' . $changedName;
                $modelFile->size = $file->getSize();
                $modelFile->ext = $file->getClientOriginalExtension();
                $modelFile->is_image = $is_image;
                $modelFile->save();
            }
            DB::commit();

            $this->responseCode = 201;
            $this->responseData = $konselor;
            return response()->json($this->getResponse(), $this->responseCode);
        } catch (\Exception $e) {
            DB::rollback();
            $this->responseCode = 500;
            $this->responseMessage = $e->getMessage();
            return response()->json($this->getResponse(), $this->responseCode);
        }
    }

    public function show($id)
    {
        if (!$konselor = $this->select()->where('d_konselor.id', intval($id))->first()) {
            $this->responseCode = 404;
            $this->responseMessage = 'Data tidak di temukan';
            return response()->json($this->getResponse(), $this->responseCode);
        }

        $this->authorize('view', $konselor);

        try {
            $this->responseCode = 200;
            $this->responseData = $konselor;
            return response()->json($this->getResponse(), $this->responseCode);
        } catch (\Exception $e) {
            $this->responseCode = 500;
            $this->responseMessage = $e->getMessage();
            return response()->json($this->getResponse(), $this->responseCode);
        }
    }

    public function update(Request $req, $id)
    {
        if (!$konselor = DKonselor::find(intval($id))) {
            $this->responseCode = 404;
            $this->responseMessage = 'Data tidak di temukan';
            return response()->json($this->getResponse(), $this->responseCode);
        }

        $this->authorize('update', $konselor);

        try {
            $rules = $this->rules();
            $rules['nik'] .= ',' . intval($id);
            $validator = Validator::make($req->all(), $rules);
            if ($validator->fails()) {
                $this->responseCode = 422;
                $this->responseMessage = $validator->errors()->first();
                $this->responseData = $validator->errors();
                return response()->json($this->getResponse(), $this->responseCode);
            }
            DB::beginTransaction();
            $konselor->update($req->all());
            if ($req->hasFile('foto')) {
                $fotoOld = $konselor->fotoFile;
                if ($fotoOld) {
                    $fotoOld->forceDelete();
                }

                $file = $req->foto;
                $changedName = time() . random_int(100, 999) . '.' . $file->getClientOriginalExtension();
                $is_image = substr($file->getClientMimeType(), 0, 5) == 'image' ?? false;

                $path = 'private/d_konselor/' . $konselor->id . '/foto';
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

                $modelFile = new DKonselorFile();
                $modelFile->id_d_konselor = $konselor->id;
                $modelFile->name = $file->getClientOriginalName();
                $modelFile->path = $path . '/' . $changedName;
                $modelFile->size = $file->getSize();
                $modelFile->ext = $file->getClientOriginalExtension();
                $modelFile->is_image = $is_image;
                $modelFile->save();
            }
            DB::commit();

            $this->responseCode = 200;
            $this->responseData = $konselor;
            return response()->json($this->getResponse(), $this->responseCode);
        } catch (\Exception $e) {
            DB::rollback();
            $this->responseCode = 500;
            $this->responseMessage = $e->getMessage();
            return response()->json($this->getResponse(), $this->responseCode);
        }
    }

    public function switchStatus($id)
    {
        if (!$konselor = DKonselor::find(intval($id))) {
            $this->responseCode = 404;
            $this->responseMessage = 'Data tidak di temukan';
            return response()->json($this->getResponse(), $this->responseCode);
        }

        $this->authorize('update', $konselor);

        try {
            $konselor->update(['is_active' => !$konselor->is_active]);

            $this->responseCode = 200;
            $this->responseData = $konselor;
            $this->responseMessage = boolval($konselor->is_active) ? 'Konselor telah diaktifkan' : 'Konselor telah dinonaktifkan';
        } catch (\Exception $e) {
            $this->responseCode = 500;
            $this->responseMessage = $e->getMessage();
        }

        return response()->json($this->getResponse(), $this->responseCode);
    }

    public function summary()
    {
        $this->authorize('summary', DKonselor::class);

        try {
            $data = [
                'anggota' => DKonselor::count(),
                'kelurahan' => MKelurahan::whereHas('dKonselor')->count(),
                'kecamatan' => MKecamatan::whereHas('kelurahan.dKonselor')->count(),
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
        $this->authorize('import', DKonselor::class);

        return Excel::download(new DKonselorSheetExport, 'DatabaseKonselorFormatExport.xlsx');
    }

    public function import(Request $req)
    {
        $this->authorize('import', DKonselor::class);

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

            Excel::import(new DKonselorSheetImport, $req->file('file'));
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
        $model = $this->select()->where('d_konselor.id', $id)->first();
        if (!$model) {
            $this->responseCode = 404;
            $this->responseMessage = 'Data tidak ditemukan';
            return response()->json($this->getResponse(), $this->responseCode);
        }

        $this->authorize('cetakPdf', $model);

        $pdf = PDF::loadView('pdf.cetakDKonselor', ['data' => json_decode(json_encode($model))]);

        $this->saveLog();
        return $pdf->download('cetak_databse_konselor-' . $id . '.pdf');
    }

    public function export(Request $req)
    {
        $this->authorize('export', DKonselor::class);

        ini_set('memory_limit', -1);
        return Excel::download(new DatabaseExport((json_decode($this->select()->get())), 'exports.dKonselor'), 'DatabaseKonselor.xlsx');
    }
}
