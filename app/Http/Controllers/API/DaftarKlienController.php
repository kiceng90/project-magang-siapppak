<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

use App\Http\Resources\HistoriPenangananResource;

use App\Models\DaftarKlien;
use App\Models\Pengaduan;
use App\Models\LangkahDilakukan;
use App\Models\MKonselor;

use DB;
use Validator;

class DaftarKlienController extends Controller
{
    public $daftarKlien, $query, $query2;

    public function __construct(Request $req)
    {
        $this->query = "(CASE is_has_nik WHEN TRUE THEN nik_number ELSE identity_number END)";
        $this->query2 = DB::raw("(CASE is_has_nik WHEN TRUE THEN 'NIK' ELSE 'Nomor Identitas' END) AS label_nik");

        $this->daftarKlien = DaftarKlien::select([
            'daftar_klien.id', 'daftar_klien.name', DB::raw($this->query . 'AS nik'),
            $this->query2, DB::raw('daftar_klien.is_surabaya_resident AS warga_surabaya'),
            DB::raw('daftar_klien.residence_address AS alamat'), 'daftar_klien.phone_number',
            'daftar_klien.id_kabupaten_tinggal', DB::raw('m_kabupaten.name AS kabupaten_name'),
            DB::raw('m_kecamatan.id AS kecamatan_id'), DB::raw('m_kecamatan.name AS kecamatan_name'),
            'daftar_klien.id_kelurahan_tinggal', DB::raw('m_kelurahan.name AS kelurahan_name'),
            DB::raw('klien_history.age_category as kategori'),
            DB::raw('(select id as id_pengaduan from pengaduan where pengaduan.id_klien = daftar_klien.id order by pengaduan.complaint_date desc limit 1)')
        ])
            ->leftJoin('m_kabupaten', 'm_kabupaten.id', '=', 'daftar_klien.id_kabupaten_tinggal')
            ->leftJoin('m_kelurahan', 'm_kelurahan.id', '=', 'daftar_klien.id_kelurahan_tinggal')
            ->leftJoin('m_kecamatan', 'm_kecamatan.id', '=', 'm_kelurahan.id_kecamatan')
            ->leftJoin('klien_history', 'klien_history.id_daftar_klien', '=', 'daftar_klien.id');

        parent::__construct($req);
    }

    public function index(Request $req)
    {
        $this->authorize('viewAny', DaftarKlien::class);

        try {
            $limit = $req->limit ? intval($req->limit) : 10;
            if ($limit > 100) $limit = 100;

            $order = Str::lower($req->order) == 'asc' ? 'asc' : 'desc';
            $sortby = $req->sortby ? $req->sortby : 'daftar_klien.id';

            $daftarKlien = $this->daftarKlien;
            if ($req->filled('search')) {
                $daftarKlien
                    ->where('daftar_klien.name', 'ILIKE', '%' . $req->search . '%')
                    ->orWhere(DB::raw($this->query), 'ILIKE', '%' . $req->search . '%')
                    ->orWhere('daftar_klien.residence_address', 'ILIKE', '%' . $req->search . '%')
                    ->orWhere('m_kabupaten.name', 'ILIKE', '%' . $req->search . '%')
                    ->orWhere('m_kecamatan.name', 'ILIKE', '%' . $req->search . '%')
                    ->orWhere('m_kelurahan.name', 'ILIKE', '%' . $req->search . '%')
                    ->orWhere('daftar_klien.phone_number', 'ILIKE', '%' . $req->search . '%');
            }
            $daftarKlien = $daftarKlien->orderBy($sortby, $order)->paginate($limit);
            foreach ($daftarKlien as $d) {
                $d->konselor = MKonselor::select(['id', 'name'])->whereHas('penjangkauan', function ($q) use ($d) {
                    $q->whereHas('pengaduan', function ($q) use ($d) {
                        $q->where('id_klien', $d->id)->orderBy('created_at', 'DESC')->take(1);
                    });
                })->get();
            }

            $this->saveLog($daftarKlien);
            return $daftarKlien;
        } catch (\Exception $e) {
            $this->responseCode = 500;
            $this->responseMessage = $e->getMessage();
            return response()->json($this->getResponse(), $this->responseCode);
        }
    }

    public function lists(Request $req)
    {
        $this->authorize('viewAny', DaftarKlien::class);

        try {
            $limit = $req->limit ? intval($req->limit) : 10;
            if ($limit > 100) $limit = 100;

            $query = "(CASE is_has_nik WHEN TRUE THEN nik_number ELSE identity_number END)";

            $klien = DaftarKlien::select('id', 'name', 'initial_name', DB::raw($query . 'AS nik'));
            if ($req->filled('search')) {
                $klien->where(DB::raw('lower(name)'), 'like', '%' . strtolower($req->search) . '%')
                    ->orWhere('initial_name', 'ILIKE', '%' . $req->search . '%')
                    ->orWhere(DB::raw($query), 'ILIKE', '%' . $req->search . '%');
            }
            $klien = $klien->take($limit)->orderBy('name', 'ASC')->get();

            $this->responseCode = 200;
            $this->responseData = $klien;
            return response()->json($this->getResponse(), $this->responseCode);
        } catch (\Exception $e) {
            $this->responseCode = 500;
            $this->responseMessage = $e->getMessage();
            return response()->json($this->getResponse(), $this->responseCode);
        }
    }

    public function show($id)
    {
        $id = intval($id);
        $klien = $this->daftarKlien->where('daftar_klien.id', $id)->first();
        if (!$klien) {
            $this->responseCode = 404;
            $this->responseMessage = 'Data tidak di temukan';
            return response()->json($this->getResponse(), $this->responseCode);
        }

        $this->authorize('view', $klien);

        try {
            $this->responseCode = 200;
            $this->responseData = $klien;
            return response()->json($this->getResponse(), $this->responseCode);
        } catch (\Exception $e) {
            $this->responseCode = 500;
            $this->responseMessage = $e->getMessage();
            return response()->json($this->getResponse(), $this->responseCode);
        }
    }

    public function historiPengaduan($id)
    {
        $id = intval($id);
        $klien = DaftarKlien::find($id);
        if (!$klien) {
            $this->responseCode = 404;
            $this->responseMessage = 'Data tidak di temukan';
            return response()->json($this->getResponse(), $this->responseCode);
        }

        $this->authorize('historiPengaduan', $klien);

        try {
            $historiPengaduan = Pengaduan::select('id', DB::raw('complaint_date AS date'))
                ->where('id_klien', $klien->id)
                // ->where('id_status', 10)
                ->orderBy('complaint_date', 'DESC')
                ->get();

            $this->responseCode = 200;
            $this->responseData = $historiPengaduan;
            return response()->json($this->getResponse(), $this->responseCode);
        } catch (\Exception $e) {
            $this->responseCode = 500;
            $this->responseMessage = $e->getMessage();
            return response()->json($this->getResponse(), $this->responseCode);
        }
    }

    public function historiPenanganan($id)
    {
        $id = intval($id);
        $klien = DaftarKlien::find($id);
        if (!$klien) {
            $this->responseCode = 404;
            $this->responseMessage = 'Data tidak di temukan';
            return response()->json($this->getResponse(), $this->responseCode);
        }

        $this->authorize('historiPenanganan', $klien);

        try {
            $historiPenanganan = collect();
            $pengaduan = $klien->pengaduan;
            foreach ($pengaduan as $p) {
                if ($p->penjangkauan) {
                    foreach ($p->penjangkauan->rencanaIntervensi as $r) {
                        $historiPenanganan->push($r);
                    }
                    foreach ($p->penjangkauan->langkahDilakukan as $l) {
                        $historiPenanganan->push($l);
                    }
                }
            }

            foreach (LangkahDilakukan::where('id_daftar_klien', $klien->id)->get() as $l) {
                $historiPenanganan->push($l);
            }

            $this->responseCode = 200;
            $this->responseData = $historiPenanganan ? collect(HistoriPenangananResource::collection($historiPenanganan))->sortByDesc('tanggal_pelayanan')->values()->all() : null;
            return response()->json($this->getResponse(), $this->responseCode);
        } catch (\Exception $e) {
            $this->responseCode = 500;
            $this->responseMessage = $e->getMessage() . ' ' . $e->getLine();
            return response()->json($this->getResponse(), $this->responseCode);
        }
    }
}
