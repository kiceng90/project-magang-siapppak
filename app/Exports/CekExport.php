<?php
namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class CekExport implements WithMultipleSheets
{
    protected $data;
    
    public function __construct($data)
    {
        $this->data = $data;
    }

    public function sheets(): array
    {
        $sheets = [];

        $sheets[] = new DatabaseExport ($this->data['piket'], 'exports.laporanKegiatanMhsV1', 'piket');
        $sheets[] = new DatabaseExport ($this->data['konseling'], 'exports.laporanKegiatanMhsV1', 'konseling');
        $sheets[] = new DatabaseExport ($this->data['sosialisasi'], 'exports.laporanKegiatanMhsV1', 'sosialisasi');
        $sheets[] = new DatabaseExport ($this->data['rapat'], 'exports.laporanKegiatanMhsV1', 'rapat');
        $sheets[] = new DatabaseExport($this->data['publikasi_kie'], 'exports.laporanKegiatanMhsV1', 'publikasi_kie');

        return $sheets;
    }
}
