<?php

namespace App\Imports;

use App\Models\PsikologVolunteer;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Carbon\Carbon;

class PsikologVolunteerSheetImport implements ToModel, WithHeadingRow, WithValidation, SkipsEmptyRows, WithMultipleSheets
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new PsikologVolunteer([
            'nik' => $row['nik'],
            'name' => $row['nama_lengkap'],
            'alamat_domisili' => $row['alamat_domisili'],
            'id_kelurahan_domisili' => $row['id_kelurahan_domisili'],
            'rw_domisili' => $row['rw_domisili'],
            'rt_domisili' => $row['rt_domisili'],
            'id_kelurahan_ktp' => $row['id_kelurahan_ktp'],
            'alamat_ktp' => $row['alamat_ktp'],
            'rw_ktp' => $row['rw_ktp'],
            'rt_ktp' => $row['rt_ktp'],
            'no_hp' => $row['no_hp'],
            'id_kabupaten_lahir' => $row['id_kabupaten_lahir'],
            'tanggal_lahir' => Carbon::instance(Date::excelToDateTimeObject(intval($row['tanggal_lahir'])))->format('Y-m-d'),
            'id_pendidikan_terakhir' => $row['id_pendidikan_terakhir'],
            'id_jurusan' => $row['id_jurusan'],
            'id_instansi_pendidikan' => $row['id_instansi_pendidikan'],
            'kompetensi' => $row['kompetensi'],
        ]);
    }

    public function rules(): array
    {
        return [
            'nik' => 'required|numeric|digits:16|unique:App\Models\PuspagaRw,nik',
            'nama_lengkap' => 'required|string',
            'alamat_domisili' => 'required|string',
            'id_kelurahan_domisili' => 'required|exists:App\Models\MKelurahan,id,deleted_at,NULL',
            'rw_domisili' => 'required',
            'rt_domisili' => 'required',
            'alamat_ktp' => 'required|string',
            'id_kelurahan_ktp' => 'required|exists:App\Models\MKelurahan,id,deleted_at,NULL',
            'rw_ktp' => 'required',
            'rt_ktp' => 'required',
            'no_hp' => 'required',
            'id_kabupaten_lahir' => 'required|exists:App\Models\MKabupaten,id,deleted_at,NULL',
            'tanggal_lahir' => [
                'required',
                function($attribute, $value, $onFailure) {
                    if (!is_numeric($value)) {
                        $onFailure('Tanggal SK harus berupa tanggal yang valid (Contoh: 02/03/2022)');
                    }
                }
            ],
            'id_pendidikan_terakhir' => 'required|exists:App\Models\MPendidikanTerakhir,id,deleted_at,NULL',
            'id_jurusan' => 'required|exists:App\Models\MJurusan,id,deleted_at,NULL',
            'id_instansi_pendidikan' => 'required|exists:App\Models\MInstansiPendidikan,id,deleted_at,NULL',
            'kompetensi' => 'required|string',
        ];
    }

    public function sheets(): array
    {
        return [$this];
    }

    public function customValidationAttributes()
    {
        return [
            'nik' => 'NIK',
            'nama' => 'Nama',
            'nomor_sk' => 'Nomor SK',
            'alamat_domisili' => 'Alamat Domisili',
            'id_kelurahan_domisili' => 'ID Kelurahan Domisili',
            'rw_domisili' => 'RW Domisili',
            'rt_domisili' => 'RT Domisili',
            'alamat_ktp' => 'Alamat KTP',
            'id_kelurahan_ktp' => 'ID Kelurahan KTP',
            'rw_ktp' => 'RW KTP',
            'rt_ktp' => 'RT KTP',
            'no_hp' => 'NO HP',
            'id_kabupaten_lahir' => 'ID Kabupaten Lahir',
            'tanggal_lahir' => 'Tanggal Lahir',
            'id_pendidikan_terakhir' => 'ID Pendidikan Terakhir',
            'id_jurusan' => 'ID Jurusan',
            'id_instansi_pendidikan' => 'ID Instansi Pendidikan',
            'kompetensi' => 'Kompetensi',
        ];
    }
}
