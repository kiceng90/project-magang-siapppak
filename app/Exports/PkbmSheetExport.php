<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class PkbmSheetExport implements FromCollection, WithHeadings, WithEvents, WithTitle, WithMultipleSheets
{
    public function title(): string
    {
        return 'export';
    }

    public function collection()
    {
        return new Collection();
    }

    public function registerEvents(): array {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                /** @var Sheet $sheet */
                $sheet = $event->sheet;

                // $sheet->mergeCells('B22:J22');
                // $sheet->setCellValue('B22', "Untuk list id kelurahan yang tersedia bisa di lihat pada sheet *data kelurahan*");

                // $sheet->mergeCells('B23:J23');
                // $sheet->setCellValue('B23', "Untuk list id jabatan dalam instansi yang tersedia bisa di lihat pada sheet *data jabatan dalam instansi*");

                // $sheet->mergeCells('B24:J24');
                // $sheet->setCellValue('B24', "Untuk list id kedudukan dalam tim yang tersedia bisa di lihat pada sheet *data kedudukan dalam tim*");

                // $sheet->mergeCells('B25:J25');
                // $sheet->setCellValue('B25', "Note : Jangan merubah title Header");
                // $sheet->getDelegate()->getStyle('B25:J25')->getFont()->setBold(true);
                
                $styleArray = [
                    'borders' => [
                        'outline' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                    ]
                ];
                // $sheet->getDelegate()->getStyle('B25:J25')->applyFromArray($styleArray);

                //allBorders
                $cellRange = 'A1:P20'; // All headers
                $sheet->getDelegate()->getStyle($cellRange)->applyFromArray($styleArray);
                $sheet->getDelegate()->getStyle('A1:P1')->getFont()->setBold(true);
                foreach(range('A','P') as $columnID) {
                    $sheet->getColumnDimension($columnID)->setAutoSize(true);
                }
                
                $sheet->getStyle('A1:P1')->applyFromArray([
                    'borders' => [
                        'alignment' => [
                            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                        ],
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ]);
            },
        ];
    }

    public function headings(): array
    {
        return [
            "Nama",
            "NIK",
            'Nomor SK',
            'Tanggal SK',
            // 'Puspaga RW',
            'ID Jabatan Dalam Instansi',
            'ID Kedudukan Dalam Tim',
            'Alamat Domisili',
            'ID Kelurahan Domisili',
            'RW Domisili',
            'RT Domisili',
            'Alamat KTP',
            'ID Kelurahan KTP',
            'RW KTP',
            'RT KTP',
            'NO HP',
            'Email',
        ];
    }

    public function sheets(): array
    {
        return [
            $this,
            new MKelurahanSheetExport,
            new MJabatanDalamInstansiSheetExport,
            new MKedudukanDalamTimSheetExport,
        ];
    }
}
