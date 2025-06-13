<?php

namespace App\Exports;

use App\Models\MIntervensi;
use App\Models\MSumberKeluhan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;


class IntervensiExport implements FromCollection, WithHeadings, WithEvents
{
    /**
     * Mengambil data koleksi dari model MSumberKeluhan.
     *
     * @return \Illuminate\Support\Collection
     */
    public function collection()
{
    // Lakukan left join untuk mengambil nama OPD berdasarkan id_opd
    $data = MIntervensi::leftJoin('m_opd', 'm_intervensi.id_opd', '=', 'm_opd.id')
                ->select('m_opd.name as opd_name', 'm_intervensi.name', 'm_intervensi.is_active')
                ->get();

    // Buat koleksi baru dengan nomor urut dan ubah 'is_active' menjadi 'Aktif' atau 'Tidak Aktif'
    $dataWithStatus = $data->map(function($item, $key) {
        return [
            'no' => $key + 1,  // Nomor urut
            'opd_name' => $item->opd_name,  // Nama OPD
            'name' => $item->name,  // Nama intervensi
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
            'OPD',
            'Keperluan', 
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
                $event->sheet->getColumnDimension('B')->setWidth(40); // Nama Sumber
                $event->sheet->getColumnDimension('C')->setWidth(50); // Status
                $event->sheet->getColumnDimension('D')->setWidth(12); // Status
            },
        ];
    }
}
