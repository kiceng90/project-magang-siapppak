<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat\DateFormatter;

class DatabaseExport implements FromView, WithColumnFormatting, WithTitle
{
    public $data, $view,$section,$title;

    public function __construct($data, $view,$section = 1)
    {
        $this->data = $data;
        $this->view = $view;

        $this->section = $section;
        $this->title = $section;
    }

    public function view(): View
    {
        return view($this->view, [
            'data' => $this->data,
            'section' => $this->section,
        ]);
    }
    public function columnFormats(): array
    {
        $data = [
            'B' => NumberFormat::FORMAT_NUMBER,
            'E' => NumberFormat::FORMAT_DATE_DDMMYYYY,
        ];
        $exception_views = [
            'exports.dMahasiswa',
            'exports.laporanKegiatanMhsV1',
            'exports.laporanKegiatanMhsV2',
            'exports.laporanKegiatanFasilitatorV1',
            'exports.laporanKegiatanFasilitatorV2'
        ];
        if(in_array($this->view, $exception_views)){
            $data = [];
        }
        if(in_array($this->view, ['exports.dKonselor', 'exports.psikologVolunteer'])){
            unset($data['E']);
        }
        if(in_array($this->view, ['exports.laporanKegiatanMhsV1', 'exports.laporanKegiatanMhsV2'])){
            $data = [
                'T' => NumberFormat::FORMAT_DATE_YYYYMMDD,
            ];
        }
        if(in_array($this->view, ['exports.laporanKegiatanFasilitatorV1', 'exports.laporanKegiatanFasilitatorV2'])){
            $data = [
                'O' => NumberFormat::FORMAT_DATE_YYYYMMDD,
                'P' => NumberFormat::FORMAT_DATE_YYYYMMDD,
            ];
        }

        return $data;
    }

    public function title(): string
    {
        return $this->title; // Return the title for the sheet
    }
}
