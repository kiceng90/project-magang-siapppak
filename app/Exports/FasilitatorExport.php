<?php
namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class FasilitatorExport implements WithMultipleSheets
{
    protected $data;
    
    public function __construct($data)
    {
        $this->data = $data;
    }

    public function sheets(): array
    {
        $sheets = [];
      
        $sheets[] = new DatabaseExport ($this->data['piket'], 'exports.laporanKegiatanFasilitatorV1', 'piket');
        $sheets[] = new DatabaseExport ($this->data['konseling'], 'exports.laporanKegiatanFasilitatorV1', 'konseling');
        $sheets[] = new DatabaseExport ($this->data['sosialisasi'], 'exports.laporanKegiatanFasilitatorV1', 'sosialisasi');
        $sheets[] = new DatabaseExport ($this->data['rapat'], 'exports.laporanKegiatanFasilitatorV1', 'rapat');
        $sheets[] = new DatabaseExport ($this->data['publikasi_kie'], 'exports.laporanKegiatanFasilitatorV1', 'Publikasi Kie');

        return $sheets;
    }
}
