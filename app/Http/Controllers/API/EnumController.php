<?php

namespace App\Http\Controllers\API;

use App\Enums\ClientTypeEnum;
use App\Enums\DayEnum;
use App\Enums\DKlienKonselingFileTypeEnum;
use App\Enums\KieJenisEnum;
use App\Enums\LangEnum;
use App\Enums\StatusKonselingEnum;
use App\Enums\JenisKonsultanEnum;
use App\Enums\JenisMahasiswaStatusEnum;
use App\Enums\LaporanKegiatanFileSourceEnum;
use App\Enums\LaporanKegiatanFileTypeEnum;
use App\Enums\LaporanKegiatanKonselingTypeEnum;
use App\Enums\LaporanKegiatanPublikasiKieTypeEnum;
use App\Enums\LaporanKegiatanPublikasiKontenTypeEnum;
use App\Enums\LaporanKegiatanSosialisasiTypeEnum;
use App\Enums\LaporanKegiatanSosialisasiSasaranEnum;
use App\Enums\LaporanKegiatanRapatTypeEnum;
use App\Enums\LaporanKegiatanStatus;
use App\Enums\LaporanMonevKuesionerInputTypeEnum;
use App\Enums\MahasiswaFileTypeEnum;
use App\Enums\MahasiswaStatusEnum;
use App\Enums\PuspagaRwFileTypeEnum;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EnumController extends Controller
{
    public function getDayEnum(Request $request)
    {
        try {
            $data = DayEnum::toObject();
            return $data;
        } catch (\Exception $e) {
            $this->responseCode = 500;
            $this->responseMessage = $e->getMessage();
            return response()->json($this->getResponse(), $this->responseCode);
        }
    }

    public function getKieJenisEnum(Request $request)
    {
        try {
            $data = KieJenisEnum::toObject();
            return $data;
        } catch (\Exception $e) {
            $this->responseCode = 500;
            $this->responseMessage = $e->getMessage();
            return response()->json($this->getResponse(), $this->responseCode);
        }
    }

    public function getLangEnum(Request $request)
    {
        try {
            $data = LangEnum::toObject();
            return $data;
        } catch (\Exception $e) {
            $this->responseCode = 500;
            $this->responseMessage = $e->getMessage();
            return response()->json($this->getResponse(), $this->responseCode);
        }
    }
    public function getStatusKonselingEnum(Request $request)
    {
        try {
            $data = StatusKonselingEnum::toObject();
            return $data;
        } catch (\Exception $e) {
            $this->responseCode = 500;
            $this->responseMessage = $e->getMessage();
            return response()->json($this->getResponse(), $this->responseCode);
        }
    }
    public function getJenisMahasiswaStatus(Request $request)
    {
        try {
            $data = JenisMahasiswaStatusEnum::toObject();
            return $data;
        } catch (\Exception $e) {
            $this->responseCode = 500;
            $this->responseMessage = $e->getMessage();
            return response()->json($this->getResponse(), $this->responseCode);
        }
    }
    public function getLaporanKegiatanFileSource(Request $request)
    {
        try {
            $data = LaporanKegiatanFileSourceEnum::toObject();
            return $data;
        } catch (\Exception $e) {
            $this->responseCode = 500;
            $this->responseMessage = $e->getMessage();
            return response()->json($this->getResponse(), $this->responseCode);
        }
    }
    public function getLaporanKegiatanFileType(Request $request)
    {
        try {
            $data = LaporanKegiatanFileTypeEnum::toObject();
            return $data;
        } catch (\Exception $e) {
            $this->responseCode = 500;
            $this->responseMessage = $e->getMessage();
            return response()->json($this->getResponse(), $this->responseCode);
        }
    }
    public function getLaporanKegiatanKonselingType(Request $request)
    {
        try {
            $data = LaporanKegiatanKonselingTypeEnum::toObject();
            return $data;
        } catch (\Exception $e) {
            $this->responseCode = 500;
            $this->responseMessage = $e->getMessage();
            return response()->json($this->getResponse(), $this->responseCode);
        }
    }
    public function getLaporanKegiatanSosialisasiType(Request $request)
    {
        try {
            $data = LaporanKegiatanSosialisasiTypeEnum::toObject();
            return $data;
        } catch (\Exception $e) {
            $this->responseCode = 500;
            $this->responseMessage = $e->getMessage();
            return response()->json($this->getResponse(), $this->responseCode);
        }
    }
    public function getLaporanKegiatanSosialisasiSasaran(Request $request)
    {
        try {
            $data = LaporanKegiatanSosialisasiSasaranEnum::toObject();
            return $data;
        } catch (\Exception $e) {
            $this->responseCode = 500;
            $this->responseMessage = $e->getMessage();
            return response()->json($this->getResponse(), $this->responseCode);
        }
    }
    public function getLaporanKegiatanRapatTypeEnum(Request $request)
    {
        try {
            $data = LaporanKegiatanRapatTypeEnum::toObject();
            return $data;
        } catch (\Exception $e) {
            $this->responseCode = 500;
            $this->responseMessage = $e->getMessage();
            return response()->json($this->getResponse(), $this->responseCode);
        }
    }
    public function getLaporanKegiatanStatus(Request $request)
    {
        try {
            $data = LaporanKegiatanStatus::toObject();
            return $data;
        } catch (\Exception $e) {
            $this->responseCode = 500;
            $this->responseMessage = $e->getMessage();
            return response()->json($this->getResponse(), $this->responseCode);
        }
    }
    public function getMahasiswaFileType(Request $request)
    {
        try {
            $data = MahasiswaFileTypeEnum::toObject();
            return $data;
        } catch (\Exception $e) {
            $this->responseCode = 500;
            $this->responseMessage = $e->getMessage();
            return response()->json($this->getResponse(), $this->responseCode);
        }
    }
    public function getPuspagaRwFileType(Request $request)
    {
        try {
            $data = PuspagaRwFileTypeEnum::toObject();
            return $data;
        } catch (\Exception $e) {
            $this->responseCode = 500;
            $this->responseMessage = $e->getMessage();
            return response()->json($this->getResponse(), $this->responseCode);
        }
    }
    public function getMahasiswaStatusEnum(Request $request)
    {
        try {
            $data = MahasiswaStatusEnum::toObject();
            return $data;
        } catch (\Exception $e) {
            $this->responseCode = 500;
            $this->responseMessage = $e->getMessage();
            return response()->json($this->getResponse(), $this->responseCode);
        }
    }
    public function getClientTypeEnum(Request $request)
    {
        try {
            $data = ClientTypeEnum::toObject();
            return $data;
        } catch (\Exception $e) {
            $this->responseCode = 500;
            $this->responseMessage = $e->getMessage();
            return response()->json($this->getResponse(), $this->responseCode);
        }
    }
    public function getDKlienKonselingFileTypeEnum(Request $request)
    {
        try {
            $data = DKlienKonselingFileTypeEnum::toObject();
            return $data;
        } catch (\Exception $e) {
            $this->responseCode = 500;
            $this->responseMessage = $e->getMessage();
            return response()->json($this->getResponse(), $this->responseCode);
        }
    }
    public function getLaporanMonevKuesionerInputTypeEnum(Request $request)
    {
        try {
            $data = LaporanMonevKuesionerInputTypeEnum::toObject();
            return $data;
        } catch (\Exception $e) {
            $this->responseCode = 500;
            $this->responseMessage = $e->getMessage();
            return response()->json($this->getResponse(), $this->responseCode);
        }
    }
    public function getLaporanKegiatanPublikasiKieTypeEnum(Request $request)
    {
        try {
            $data = LaporanKegiatanPublikasiKieTypeEnum::toObject();
            return $data;
        } catch (\Exception $e) {
            $this->responseCode = 500;
            $this->responseMessage = $e->getMessage();
            return response()->json($this->getResponse(), $this->responseCode);
        }
    }
    public function getLaporanKegiatanPublikasiKontenTypeEnum(Request $request)
    {
        try {
            $data = LaporanKegiatanPublikasiKontenTypeEnum::toObject();
            return $data;
        } catch (\Exception $e) {
            $this->responseCode = 500;
            $this->responseMessage = $e->getMessage();
            return response()->json($this->getResponse(), $this->responseCode);
        }
    }
    public function getAllEnum(Request $request)
    {
        try {
            $data['clientType'] = ClientTypeEnum::toObject();
            $data['day'] = DayEnum::toObject();
            $data['jenisKonsultan'] = JenisKonsultanEnum::toObject();
            $data['jenisMahasiswaStatus'] = JenisMahasiswaStatusEnum::toObject();
            $data['jenisKie'] = KieJenisEnum::toObject();
            $data['lang'] = LangEnum::toObject();
            $data['laporanKegiatanFileSource'] = LaporanKegiatanFileSourceEnum::toObject();
            $data['laporanKegiatanFileType'] = LaporanKegiatanFileTypeEnum::toObject();
            $data['laporanKegiatanKonselingType'] = LaporanKegiatanKonselingTypeEnum::toObject();
            $data['laporanKegiatanSosialisasiType'] = LaporanKegiatanSosialisasiTypeEnum::toObject();
            $data['laporanKegiatanSosialisasiSasaran'] = LaporanKegiatanSosialisasiSasaranEnum::toObject();
            $data['laporanKegiatanStatus'] = LaporanKegiatanStatus::toObject();
            $data['mahasiswaFileType'] = MahasiswaFileTypeEnum::toObject();
            $data['puspagaRwFileType'] = PuspagaRwFileTypeEnum::toObject();
            $data['mahasiswaStatus'] = MahasiswaStatusEnum::toObject();
            $data['statusKonseling'] = StatusKonselingEnum::toObject();
            $data['dKlienKonselingFileType'] = DKlienKonselingFileTypeEnum::toObject();
            $data['laporanMonevKuesionerInputType'] = LaporanMonevKuesionerInputTypeEnum::toObject();
            $data['laporanKegiatanPublikasiKieType'] = LaporanKegiatanPublikasiKieTypeEnum::toObject();
            $data['laporanKegiatanPublikasiKontenType'] = LaporanKegiatanPublikasiKontenTypeEnum::toObject();
            $data['laporanKegiatanRapatType'] = LaporanKegiatanRapatTypeEnum::toObject();
            return $data;
        } catch (\Exception $e) {
            $this->responseCode = 500;
            $this->responseMessage = $e->getMessage();
            return response()->json($this->getResponse(), $this->responseCode);
        }
    }
}
