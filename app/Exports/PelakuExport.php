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

class PelakuExport implements FromView, WithEvents, WithColumnFormatting, WithTitle, ShouldAutoSize
{
    public $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function title(): string
    {
        return 'Pelaku';
    }

    public function view(): View
    {
        $data = $this->data;
        return view('exports.pelaku', [
            'data' => $data,
        ]);
    }

    public function registerEvents(): array {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $sheet = $event->sheet;
                $sheet->getDelegate()->getStyle('A1:AH'. (count($this->data) + 2))->applyFromArray([
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
            'C' => NumberFormat::FORMAT_NUMBER,
            'E' => NumberFormat::FORMAT_NUMBER,
            'F' => NumberFormat::FORMAT_NUMBER,
            'J' => NumberFormat::FORMAT_NUMBER,
            'P' => NumberFormat::FORMAT_DATE_DDMMYYYY,
            'Q' => NumberFormat::FORMAT_NUMBER,
        ];
    }
}
