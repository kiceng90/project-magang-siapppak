<?php

namespace App\Exports;

use App\Models\MAgama;
use App\Models\MHubungan;
use App\Models\MJurusan;
use App\Models\MKecamatan;
use App\Models\MSumberKeluhan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;


class KecamatanExport implements FromCollection, WithHeadings, WithEvents
{
    /**
     * Mengambil data koleksi dari model MSumberKeluhan.
     *
     * @return \Illuminate\Support\Collection
     */

     
    public function collection()
{
    // Lakukan left join untuk mengambil nama kabupaten dan wilayah berdasarkan id_kabupaten dan id_wilayah
    $data = MKecamatan::leftJoin('m_kabupaten', 'm_kecamatan.id_kabupaten', '=', 'm_kabupaten.id')
                      ->leftJoin('m_wilayah', 'm_kecamatan.id_wilayah', '=', 'm_wilayah.id')
                      ->select('m_kecamatan.name', 'm_kecamatan.is_active', 'm_kabupaten.name as kabupaten_name', 'm_wilayah.name as wilayah_name')
                      ->get();

    // Buat koleksi baru dengan nomor urut dan ubah 'is_active' menjadi 'Aktif' atau 'Tidak Aktif'
    $dataWithStatus = $data->map(function($item, $key) {
        return [
            'no' => $key + 1,  // Nomor urut
            'name' => $item->name,  // Nama Kecamatan
            'wilayah_name' => $item->wilayah_name,  // Nama Wilayah
            'kabupaten_name' => $item->kabupaten_name,  // Nama Kabupaten
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
            'Kecamatan', 
            'Wilayah', 
            'Kabupaten/Kota', 
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
                $event->sheet->getColumnDimension('B')->setWidth(25); // Nama Sumber
                $event->sheet->getColumnDimension('C')->setWidth(20); // Status
                $event->sheet->getColumnDimension('D')->setWidth(25);
                $event->sheet->getColumnDimension('E')->setWidth(12);
            },
        ];
    }
}
