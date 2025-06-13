<?php

namespace App\Exports;

use App\Models\MAgama;
use App\Models\MHubungan;
use App\Models\MJurusan;
use App\Models\MSumberKeluhan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;


class JurusanExport implements FromCollection, WithHeadings, WithEvents
{
    /**
     * Mengambil data koleksi dari model MSumberKeluhan.
     *
     * @return \Illuminate\Support\Collection
     */
    public function collection()
{
    // Ambil data dari tabel
    $data = MJurusan::select('name', 'is_active')->get();

    // Buat koleksi baru dengan nomor urut dan ubah 'is_active' menjadi 'Aktif' atau 'Tidak Aktif'
    $dataWithStatus = $data->map(function($item, $key) {
        return [
            'no' => $key + 1,  // Nomor urut
            'name' => $item->name,  // Nama
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
            'Jurusan Sekolah', 
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
                $event->sheet->getStyle('A1:C1')->applyFromArray([
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
                $event->sheet->getColumnDimension('B')->setWidth(30); // Nama Sumber
                $event->sheet->getColumnDimension('C')->setWidth(12); // Status
            },
        ];
    }
}
