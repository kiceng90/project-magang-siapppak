<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class DKonselorSheetExport implements FromCollection, WithHeadings, WithEvents, WithTitle, WithMultipleSheets
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
                // $sheet->setCellValue('B23', "Untuk list id kabupaten yang tersedia bisa di lihat pada sheet *data kabupaten*");

                // $sheet->mergeCells('B24:J24');
                // $sheet->setCellValue('B24', "Untuk list id pendidikan terakhir yang tersedia bisa di lihat pada sheet *data pendidikan terkahir*");

                // $sheet->mergeCells('B25:J25');
                // $sheet->setCellValue('B25', "Untuk list id jurusan yang tersedia bisa di lihat pada sheet *data jurusan*");

                // $sheet->mergeCells('B26:J26');
                // $sheet->setCellValue('B26', "Untuk list id instansi pendidikan yang tersedia bisa di lihat pada sheet *data instansi pendidikan*");

                // $sheet->mergeCells('B27:J27');
                // $sheet->setCellValue('B27', "Note : Jangan merubah title Header");
                // $sheet->getDelegate()->getStyle('B27:J27')->getFont()->setBold(true);
                
                $styleArray = [
                    'borders' => [
                        'outline' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                    ]
                ];
                // $sheet->getDelegate()->getStyle('B27:J27')->applyFromArray($styleArray);

                //allBorders
                $cellRange = 'A1:Q20'; // All headers
                $sheet->getDelegate()->getStyle($cellRange)->applyFromArray($styleArray);
                $sheet->getDelegate()->getStyle('A1:Q1')->getFont()->setBold(true);
                foreach(range('A','Q') as $columnID) {
                    $sheet->getColumnDimension($columnID)->setAutoSize(true);
                }
                
                $sheet->getStyle('A1:Q1')->applyFromArray([
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
            "NIK",
            // "Nama Lengkap",
            'ID Master Konselor',
            'TMT Tugas',
            'Alamat Domisili',
            'ID Kelurahan Domisili',
            'RW Domisili',
            'RT Domisili',
            'Alamat KTP',
            'ID Kelurahan KTP',
            'RW KTP',
            'RT KTP',
            // 'NO HP',
            'ID Kabupaten Lahir',
            'Tanggal Lahir',
            'ID Pendidikan Terakhir',
            'ID Jurusan',
            'ID Instansi Pendidikan',
            'Status',
        ];
    }

    public function sheets(): array
    {
        return [
            $this,
            new MKonselorSheetExport,
            new MKelurahanSheetExport,
            new MKabupatenSheetExport,
            new MPendidikanTerakhirSheetExport,
            new MJurusanSheetExport,
            new MInstansiPendidikaSheetExport,
        ];
    }
}
