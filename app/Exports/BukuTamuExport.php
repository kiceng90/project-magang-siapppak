<?php

namespace App\Exports;

use App\Models\BukuTamu;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class BukuTamuExport implements FromCollection, WithHeadings, WithEvents, WithColumnFormatting
{
    public function collection()
    {
        $data = BukuTamu::with('mKebutuhanLayanan')->get();

        return $data->map(function ($item, $key) {
            $kebutuhanLayanan = $item->mKebutuhanLayanan->pluck('name')->implode(', ');
            $layananStatus = $item->mKebutuhanLayanan->map(function ($layanan) {
                return $layanan->name . ' (' . ($layanan->pivot->is_filled ? 'Terisi' : 'Belum Terisi') . ')';
            })->implode(', ');

            return [
                'No' => $key + 1,
                'NIK' => $item->nik . '‎',
                'Nama' => $item->nama,
                'Tempat Lahir' => $item->tempat_lahir,
                'Tanggal Lahir' => \Carbon\Carbon::parse($item->tanggal_lahir)->format('d-F-Y'),
                'Usia' => $item->usia,
                'Jenis Kelamin' => $item->jenis_kelamin,
                'Alamat KTP' => $item->alamat_ktp,
                'RT' => $item->rt_ktp,
                'RW' => $item->rw_ktp,
                'Kelurahan' => $item->kel_desa_ktp,
                'Kecamatan' => $item->kecamatan_ktp,
                'Kota/Kabupaten' => $item->kota_kabupaten_ktp,
                'Provinsi' => $item->provinsi,
                'Agama' => $item->agama,
                'Status Perkawinan' => $item->status_perkawinan,
                'Kewarganegaraan' => $item->kewarganegaraan,
                'Disposisi' => $item->disposisi ? 'Segera Tindaklanjuti' : 'Segera Tindaklanjuti dengan ketentuan',
                'Kebutuhan Layanan' => $kebutuhanLayanan,
                'Detail Layanan' => $layananStatus,
                'Tanggal Daftar' => $item->created_at->format('Y-m-d H:i:s')
                /* round(25569 + strtotime($item->created_at) / 86400, 0) */,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'No',
            'NIK',
            'Nama',
            'Tempat Lahir',
            'Tanggal Lahir',
            'Usia',
            'Jenis Kelamin',
            'Alamat KTP',
            'RT',
            'RW',
            'Kelurahan',
            'Kecamatan',
            'Kota/Kabupaten',
            'Provinsi',
            'Agama',
            'Status Perkawinan',
            'Kewarganegaraan',
            'Disposisi',
            'Kebutuhan Layanan',
            'Detail Layanan',
            'Tanggal Daftar/Layanan',

        ];
    }

    public function columnFormats(): array
    {
        return [
            'B' => NumberFormat::FORMAT_TEXT,
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $lastColumn = 'U';
                $event->sheet->getStyle('A1:' . $lastColumn . '1')->applyFromArray([
                    'font' => ['bold' => true],
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['argb' => 'FFD700'],
                    ],
                    'borders' => [
                        'allBorders' => ['borderStyle' => Border::BORDER_THIN],
                    ],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                ]);

                foreach (range('A', $lastColumn) as $column) {
                    $event->sheet->getColumnDimension($column)->setAutoSize(true);
                }
            },
        ];
    }
}
