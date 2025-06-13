<?php

namespace App\Exports;

use App\Models\MAgama;
use App\Models\MHubungan;
use App\Models\MJurusan;
use App\Models\MKelurahan;
use App\Models\MSumberKeluhan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;


class KelurahanExport implements FromCollection, WithHeadings, WithEvents
{
    /**
     * Mengambil data koleksi dari model MSumberKeluhan.
     *
     * @return \Illuminate\Support\Collection
     */
    public function collection()
{
    // Lakukan left join untuk mengambil nama kecamatan berdasarkan id_kecamatan
    $data = MKelurahan::leftJoin('m_kecamatan', 'm_kelurahan.id_kecamatan', '=', 'm_kecamatan.id')
                      ->select('m_kelurahan.name as kecamatan_name', 'm_kecamatan.name as kelurahan_name', 'm_kelurahan.is_active')
                      ->get();

    // Buat koleksi baru dengan nomor urut dan ubah 'is_active' menjadi 'Aktif' atau 'Tidak Aktif'
    $dataWithStatus = $data->map(function($item, $key) {
        return [
            'no' => $key + 1,  // Nomor urut
            'kecamatan_name' => $item->kecamatan_name,  // Nama Kecamatan
            'kelurahan_name' => $item->kelurahan_name,  // Nama Kelurahan
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
            'Kelurahan', 
            'Kecamatan', 
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
                $event->sheet->getStyle('A1:D1')->applyFromArray([
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
                $event->sheet->getColumnDimension('B')->setWidth(25); // Nama Sumber
                $event->sheet->getColumnDimension('C')->setWidth(25); // Status
                $event->sheet->getColumnDimension('D')->setWidth(12); // Status
            },
        ];
    }
}
