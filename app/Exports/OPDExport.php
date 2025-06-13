<?php

namespace App\Exports;

use App\Models\MLokasiKejadian;
use App\Models\MOpd;
use App\Models\MPekerjaan;
use App\Models\MSumberKeluhan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;


class OPDExport implements FromCollection, WithHeadings, WithEvents
{
    /**
     * Mengambil data koleksi dari model MSumberKeluhan.
     *
     * @return \Illuminate\Support\Collection
     */
    public function collection()
{
    // Ambil data dari tabel dengan 'name', 'pic_name', 'pic_number', dan 'is_active'
    $data = MOpd::select('name', 'pic_name', 'pic_number', 'is_active')->get();

    // Buat koleksi baru dengan nomor urut dan ubah 'is_active' menjadi 'Aktif' atau 'Tidak Aktif'
    $dataWithStatus = $data->map(function($item, $key) {
        return [
            'no' => $key + 1,  // Nomor urut
            'name' => $item->name,  // Nama OPD
            'pic_name' => $item->pic_name,  // Nama PIC
            'pic_number' => $item->pic_number,  // Nomor Telepon PIC
            'is_active' => $item->is_active ? 'Aktif' : 'Tidak Aktif'  // Ubah nilai true/false menjadi Aktif/Tidak Aktif
        ];
    });

    return $dataWithStatus;
}


    /**
     * Menentukan heading untuk file Excel.
     *
     * @return array
     */
    public function headings(): array
    {
        return [
            'No',
            'Nama OPD', 
            'PIC', 
            'Nomor HP', 
            'Status', 
        ];
    }

     /**
     * Menangani event untuk mengatur gaya dan lebar kolom.
     *
     * @return array
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                // Mengatur warna heading, font tebal, dan border
                $event->sheet->getStyle('A1:E1')->applyFromArray([
                    'font' => [
                        'bold' => true,
                    ],
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'startColor' => [
                            'argb' => 'FFFF00', // Warna kuning untuk heading
                        ]
                    ],
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        ],
                    ],
                ]);

                // Mengatur lebar kolom secara manual
                $event->sheet->getColumnDimension('A')->setWidth(5);  // No
                $event->sheet->getColumnDimension('B')->setWidth(50); // Nama Sumber
                $event->sheet->getColumnDimension('C')->setWidth(20); // Status
                $event->sheet->getColumnDimension('D')->setWidth(20);
                $event->sheet->getColumnDimension('E')->setWidth(12);
            },
        ];
    }
}
