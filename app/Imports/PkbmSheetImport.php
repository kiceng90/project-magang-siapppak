<?php

namespace App\Imports;

use \Carbon\Carbon;
use App\Models\Pkbm;
use Maatwebsite\Excel\Concerns\ToModel;
use \PhpOffice\PhpSpreadsheet\Shared\Date;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class PkbmSheetImport implements ToModel, WithHeadingRow, WithValidation, SkipsEmptyRows, WithMultipleSheets
{
    public function model(array $row)
    {
        return new Pkbm([
            'name' => $row['nama'],
            'nik' => $row['nik'],
            'sk_number' => $row['nomor_sk'],
            'sk_date' => Carbon::instance(Date::excelToDateTimeObject(intval($row['tanggal_sk'])))->format('Y-m-d'),
            'id_jabatan_dalam_instansi' => $row['id_jabatan_dalam_instansi'],
            'id_kedudukan_dalam_tim' => $row['id_kedudukan_dalam_tim'],
            'id_kelurahan_domisili' => $row['id_kelurahan_domisili'],
            'alamat_domisili' => $row['alamat_domisili'],
            'rt_domisili' => $row['rt_domisili'],
            'rw_domisili' => $row['rw_domisili'],
            'id_kelurahan_ktp' => $row['id_kelurahan_ktp'],
            'alamat_ktp' => $row['alamat_ktp'],
            'rt_ktp' => $row['rt_ktp'],
            'rw_ktp' => $row['rw_ktp'],
            'no_hp' => $row['no_hp'],
            'email' => $row['email'],
        ]);
    }

    public function rules(): array
    {
        return [
            'nama' => 'required|string',
            'nik' => 'required|numeric|digits:16|unique:App\Models\Pkbm,nik',
            'nomor_sk' => 'required',
            'tanggal_sk' => [
                'required',
                function($attribute, $value, $onFailure) {
                    if (!is_numeric($value)) {
                        $onFailure($attribute.' harus berupa tanggal yang valid (Contoh: 02/03/2022)');
                    }
                }
            ],
            'id_jabatan_dalam_instansi' => 'required|exists:App\Models\MJabatanDalamInstansi,id,deleted_at,NULL',
            'id_kedudukan_dalam_tim' => 'required|exists:App\Models\MKedudukanDalamTim,id,deleted_at,NULL',
            'alamat_domisili' => 'required|string',
            'id_kelurahan_domisili' => 'required|exists:App\Models\MKelurahan,id,deleted_at,NULL',
            'rw_domisili' => 'required',
            'rt_domisili' => 'required',
            'alamat_ktp' => 'required|string',
            'id_kelurahan_ktp' => 'required|exists:App\Models\MKelurahan,id,deleted_at,NULL',
            'rw_ktp' => 'required',
            'rt_ktp' => 'required',
            'no_hp' => 'required',
            'email' => 'required|email',
        ];
    }

    public function sheets(): array
    {
        return [
            0 => $this,
        ];
    }

    public function customValidationAttributes()
    {
        return [
            'nama' => 'Nama',
            'nik' => 'NIK',
            'nomor_sk' => 'Nomor SK',
            'tanggal_sk' => 'Tanggal SK',
            'id_jabatan_dalam_instansi' => 'ID Jabatan Dalam Instansi',
            'id_kedudukan_dalam_tim' => 'ID Kedudukan Dalam Tim',
            'alamat_domisili' => 'Alamat Domisili',
            'id_kelurahan_domisili' => 'ID Kelurahan Domisili',
            'rw_domisili' => 'RW Domisili',
            'rt_domisili' => 'RT Domisili',
            'alamat_ktp' => 'Alamat KTP',
            'id_kelurahan_ktp' => 'ID Kelurahan KTP',
            'rw_ktp' => 'RW KTP',
            'rt_ktp' => 'RT KTP',
            'no_hp' => 'NO HP',
            'email' => 'Email',
        ];
    }
}
