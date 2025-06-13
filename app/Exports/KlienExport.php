<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class KlienExport implements FromView, WithEvents, WithColumnFormatting, WithTitle, ShouldAutoSize
{
    public $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function title(): string
    {
        return 'Klien';
    }

    public function view(): View
    {
        $data = $this->data;
        return view('exports.klien', [
            'data' => $data,
        ]);
    }

    public function registerEvents(): array {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $sheet = $event->sheet;
                $sheet->getDelegate()->getStyle('A1:AW'. (count($this->data) + 2))->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                    ]
                ]);

                // $cellIterator = $sheet->getRowIterator()->current()->getCellIterator();
                // $cellIterator->setIterateOnlyExistingCells(true);
                // foreach ($cellIterator as $cell) {
                //     $sheet->getColumnDimension($cell->getColumn())->setAutoSize(true);
                // }
            }
        ];
    }

    public function columnFormats(): array {
        return [
            'A' => NumberFormat::FORMAT_NUMBER,
            'E' => NumberFormat::FORMAT_NUMBER,
            'F' => NumberFormat::FORMAT_NUMBER,
            'R' => NumberFormat::FORMAT_DATE_DDMMYYYY,
            'AO' => NumberFormat::FORMAT_DATE_DATETIME,
            'AQ' => NumberFormat::FORMAT_DATE_DATETIME,
            'AR' => NumberFormat::FORMAT_DATE_DATETIME,
            'AS' => NumberFormat::FORMAT_DATE_DATETIME,
        ];
    }
}
