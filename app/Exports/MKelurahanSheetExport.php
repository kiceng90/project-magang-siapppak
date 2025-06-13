<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Models\MKelurahan;
use \DB;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;

class MKelurahanSheetExport implements FromCollection, WithHeadings, WithEvents, WithTitle, WithCustomStartCell
{
    public function title(): string
    {
        return 'data kelurahan';
    }

    public function startCell(): string
    {
        return 'A3';
    }

    public $data;

    public function __construct()
    {
        $this->data = MKelurahan::select(
            'm_kelurahan.id', 'm_kelurahan.name', DB::raw('m_kecamatan.name AS kecamatan_name'), DB::raw('m_kabupaten.name AS kabupaten_name'),
        )
        ->join('m_kecamatan', 'm_kecamatan.id', '=', 'm_kelurahan.id_kecamatan')
        ->join('m_kabupaten', 'm_kabupaten.id', '=', 'm_kecamatan.id_kabupaten')
        ->orderBy('m_kelurahan.name', 'ASC')
        ->get()
        ;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return $this->data;
    }

    public function headings(): array
    {
        return [
            'ID',
            'Nama Kelurahan',
            'Nama Kecamatan',
            'Nama Kabupaten',
        ];
    }

    public function registerEvents(): array {
        
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $sheet = $event->sheet;
                $sheet->mergeCells('A2:D2');
                $sheet->setCellValue('A2', "Kelurahan");
                $sheet->getStyle('A2')->applyFromArray([
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                    ],
                ]);
                $sheet->getDelegate()->getStyle('A2:D3')->getFont()->setBold(true);
                foreach(range('A','D') as $columnID) {
                    $sheet->getColumnDimension($columnID)->setAutoSize(true);
                }
                $sheet->getStyle('A3:D3')->applyFromArray([
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
                $event->sheet->getDelegate()->getStyle('A2:D'.(count($this->data) + 3))->applyFromArray($styleArray);
            },
        ];
    }
}
