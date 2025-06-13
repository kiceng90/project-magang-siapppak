<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;

use App\Models\MPendidikanTerakhir;
use DB;

class MPendidikanTerakhirSheetExport implements FromCollection, WithHeadings, WithEvents, WithTitle, WithCustomStartCell
{
    public function title(): string
    {
        return 'data pendidikan terakhir';
    }

    public function startCell(): string
    {
        return 'A3';
    }

    public $data;

    public function __construct()
    {
        $this->data = MPendidikanTerakhir::select(['id', 'name'])->where('is_active', true)->orderBy('name', 'ASC')->get();
    }

    public function collection()
    {
        return $this->data;
    }

    public function headings(): array
    {
        return [
            'ID',
            'Nama Pendidikan',
        ];
    }

    public function registerEvents(): array {
        
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $sheet = $event->sheet;
                $sheet->mergeCells('A2:B2');
                $sheet->setCellValue('A2', "Pendidikan Terakhir");
                $sheet->getStyle('A2')->applyFromArray([
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                    ],
                ]);
                $sheet->getDelegate()->getStyle('A2:B3')->getFont()->setBold(true);
                foreach(range('A','B') as $columnID) {
                    $sheet->getColumnDimension($columnID)->setAutoSize(true);
                }
                $sheet->getStyle('A3:B3')->applyFromArray([
                    'alignment' => [
                        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                    ],
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ]);

                $styleArray = [
                    'borders' => [
                        'outline' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                    ]
                ];
                $event->sheet->getDelegate()->getStyle('A2:B'.(count($this->data) + 3))->applyFromArray($styleArray);
            },
        ];
    }
}
