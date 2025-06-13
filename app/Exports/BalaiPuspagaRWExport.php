<?php

namespace App\Exports;

use App\Models\DBalaiPuspagaRW;
use App\Models\MSumberKeluhan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;


class BalaiPuspagaRWExport implements FromCollection, WithHeadings, WithEvents
{
    /**
     * Mengambil data koleksi dari model MSumberKeluhan.
     *
     * @return \Illuminate\Support\Collection
     */
    public function collection()
{
    
        // Ambil data dari tabel dengan relasi yang dibutuhkan
        $data = DBalaiPuspagaRW::leftJoin('m_wilayah', 'dbalai_puspaga_rw.id_wilayah', '=', 'm_wilayah.id')
                       ->leftJoin('m_kelurahan', 'dbalai_puspaga_rw.id_kelurahan', '=', 'm_kelurahan.id')
                       ->leftJoin('m_konselor', 'dbalai_puspaga_rw.id_konselor', '=', 'm_konselor.id')
                       ->select(
                           'dbalai_puspaga_rw.name as balai_rw_name', 
                           'm_kelurahan.name as kelurahan_name', 
                           'm_wilayah.name as wilayah_name', 
                           'm_konselor.name as konselor_name',
                           'dbalai_puspaga_rw.rw',
                           'dbalai_puspaga_rw.address',
                           'dbalai_puspaga_rw.operational_day',
                           'dbalai_puspaga_rw.operational_start_time',
                           'dbalai_puspaga_rw.operational_end_time',
                           'dbalai_puspaga_rw.inauguration_year',
                           'dbalai_puspaga_rw.rw_name',
                           'dbalai_puspaga_rw.rw_phone',
                           'dbalai_puspaga_rw.is_active'
                       )
                       ->get();

        // Maping data sesuai kebutuhan kolom tanpa kata-kata tambahan
        $dataWithStatus = $data->map(function($item, $key) {
            return [
                'no' => $key + 1,  // Nomor urut
                'name' => "{$item->rw}\n{$item->inauguration_year}\n{$item->rw_name}\n{$item->rw_phone}",
                'address' => "{$item->address}\n{$item->kelurahan_name}\n{$item->wilayah_name}",
                'operational_day' => "{$item->operational_day}\n{$item->operational_start_time} - {$item->operational_end_time}",
                'konselor_name' => $item->konselor_name,
                'is_active' => $item->is_active ? 'Aktif' : 'Tidak Aktif'
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
            'Balai RW', 
            'Alamat Balai RW', 
            'Waktu Pelaksanaan', 
            'Petugas Monev', 
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
                $event->sheet->getStyle('A1:F1')->applyFromArray([
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
                $event->sheet->getColumnDimension('C')->setWidth(30); // Status
                $event->sheet->getColumnDimension('D')->setWidth(30); // Status
                $event->sheet->getColumnDimension('E')->setWidth(30); // Status
                $event->sheet->getColumnDimension('F')->setWidth(12); // Status
            },
        ];
    }
}
