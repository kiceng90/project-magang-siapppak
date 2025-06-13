<?php

namespace App\Exports;

use App\Models\BukuTamu;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class LaporanBukuTamuExport implements FromCollection, WithHeadings, WithEvents
{
    protected $id_layanan;
    protected $search;
    protected $periode;
    protected $start_date;
    protected $end_date;

    public function __construct($id_layanan = null, $search = null, $periode = null, $start_date = null, $end_date = null)
    {
        $this->id_layanan = $id_layanan;
        $this->search = $search;
        $this->periode = $periode;
        $this->start_date = $start_date ? Carbon::parse($start_date)->startOfDay() : null;
        $this->end_date = $end_date ? Carbon::parse($end_date)->endOfDay() : null;
    }

    public function collection()
    {
        $query = BukuTamu::with(['mKebutuhanLayanan']);

        switch ($this->periode) {
            case 1:
                $query->whereBetween('created_at', [
                    now()->startOfMonth()->toDateTimeString(),
                    now()->endOfMonth()->toDateTimeString(),
                ]);
                break;
            case 2:
                $query->whereBetween('created_at', [
                    now()->subMonths(2)->startOfMonth()->toDateTimeString(),
                    now()->endOfMonth()->toDateTimeString(),
                ]);
                break;
            case 3:
                $query->whereBetween('created_at', [
                    now()->startOfYear()->toDateTimeString(),
                    now()->endOfYear()->toDateTimeString(),
                ]);
                break;
            case 4:
                if ($this->start_date && $this->end_date) {
                    $query->whereBetween('created_at', [
                        $this->start_date->toDateTimeString(),
                        $this->end_date->toDateTimeString(),
                    ]);
                }
                break;
            default:
                break;
        }

        if ($this->id_layanan) {
            $query->whereHas('mKebutuhanLayanan', function ($q) {
                $q->where('m_kebutuhan_layanan_id', $this->id_layanan);
            });
        }

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('nama', 'LIKE', '%' . $this->search . '%')
                    ->orWhere('nik', 'LIKE', '%' . $this->search . '%')
                    ->orWhere('alamat_ktp', 'LIKE', '%' . $this->search . '%')
                    ->orWhere('kecamatan_ktp', 'LIKE', '%' . $this->search . '%')
                    ->orWhere('kel_desa_ktp', 'LIKE', '%' . $this->search . '%');
            });
        }

        $data = $query->orderBy('created_at', 'DESC')->get();

        $dataFormatted = $data->map(function ($item, $key) {
            // Dapatkan kebutuhan layanan
            if ($item->mKebutuhanLayanan && $item->mKebutuhanLayanan->count() > 0) {
                // Jika filter ID layanan diterapkan, hanya tampilkan layanan dengan ID tersebut
                if ($this->id_layanan) {
                    $filteredLayanan = $item->mKebutuhanLayanan->filter(function ($layanan) {
                        return $layanan->id == $this->id_layanan;
                    });
                    $kebutuhanLayanan = $filteredLayanan->pluck('name')->implode(', ');
                } else {
                    // Jika tidak ada filter, tampilkan semua layanan
                    $kebutuhanLayanan = $item->mKebutuhanLayanan->pluck('name')->implode(', ');
                }

                // Jika string kosong (tidak ada layanan yang cocok dengan filter), kembalikan tanda strip
                $kebutuhanLayanan = !empty($kebutuhanLayanan) ? $kebutuhanLayanan : '-';
            } else {
                $kebutuhanLayanan = '-';
            }

            return [
                'no' => $key + 1,
                'nomor_pendaftaran' => $item->nomor_pendaftaran ?: '-',
                'nik' => $item->nik,
                'nama' => $item->nama,
                'tempat_lahir' => $item->tempat_lahir,
                'tanggal_lahir' => $item->tanggal_lahir,
                'usia' => $item->usia,
                'jenis_kelamin' => $item->jenis_kelamin,
                'alamat_ktp' => $item->alamat_ktp,
                'rt_ktp' => $item->rt_ktp,
                'rw_ktp' => $item->rw_ktp,
                'kel_desa_ktp' => $item->kel_desa_ktp,
                'kecamatan_ktp' => $item->kecamatan_ktp,
                'kota_kabupaten_ktp' => $item->kota_kabupaten_ktp,
                'provinsi' => $item->provinsi,
                'agama' => $item->agama,
                'status_perkawinan' => $item->status_perkawinan,
                'kebutuhan_layanan' => $kebutuhanLayanan,
                'disposisi' => $item->disposisi ? 'Ya' : 'Tidak',
                'tanggal' => $item->created_at ? $item->created_at->format('d-m-Y H:i:s') : '-',
            ];
        });

        return $dataFormatted;
    }

    public function headings(): array
    {
        return [
            [
                'No',
                'Nomor Pendaftaran',
                'NIK',
                'Nama',
                'Tempat Lahir',
                'Tanggal Lahir',
                'Usia',
                'Jenis Kelamin',
                'Alamat KTP',
                'RT',
                'RW',
                'Kelurahan/Desa',
                'Kecamatan',
                'Kota/Kabupaten',
                'Provinsi',
                'Agama',
                'Status Perkawinan',
                'Kebutuhan Layanan',
                'Disposisi',
                'Tanggal Pembuatan',
            ],
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                // Format NIK sebagai text
                $event->sheet->getStyle('C2:C' . ($event->sheet->getHighestRow()))
                    ->getNumberFormat()
                    ->setFormatCode('@');

                // Style untuk heading informasi pribadi
                $event->sheet->getStyle('A1:Q1')->applyFromArray([
                    'font' => ['bold' => true],
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'startColor' => ['argb' => 'FFCCE5FF'],
                    ],
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        ],
                    ],
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    ],
                ]);

                // Style untuk heading informasi layanan
                $event->sheet->getStyle('R1:T1')->applyFromArray([
                    'font' => ['bold' => true],
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'startColor' => ['argb' => 'FFFFE699'],
                    ],
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        ],
                    ],
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    ],
                ]);

                // Memastikan NIK diperlakukan sebagai teks
                $event->sheet->getStyle('C2:C' . ($event->sheet->getHighestRow()))
                    ->getNumberFormat()
                    ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_TEXT);

                // Set lebar kolom
                $event->sheet->getColumnDimension('A')->setWidth(5);
                $event->sheet->getColumnDimension('B')->setWidth(20);
                $event->sheet->getColumnDimension('C')->setWidth(20);
                $event->sheet->getColumnDimension('D')->setWidth(25);
                $event->sheet->getColumnDimension('E')->setWidth(15);
                $event->sheet->getColumnDimension('F')->setWidth(15);
                $event->sheet->getColumnDimension('G')->setWidth(8);
                $event->sheet->getColumnDimension('H')->setWidth(15);
                $event->sheet->getColumnDimension('I')->setWidth(30);
                $event->sheet->getColumnDimension('J')->setWidth(5);
                $event->sheet->getColumnDimension('K')->setWidth(5);
                $event->sheet->getColumnDimension('L')->setWidth(20);
                $event->sheet->getColumnDimension('M')->setWidth(20);
                $event->sheet->getColumnDimension('N')->setWidth(20);
                $event->sheet->getColumnDimension('O')->setWidth(15);
                $event->sheet->getColumnDimension('P')->setWidth(15);
                $event->sheet->getColumnDimension('Q')->setWidth(20);
                $event->sheet->getColumnDimension('R')->setWidth(30);
                $event->sheet->getColumnDimension('S')->setWidth(10);
                $event->sheet->getColumnDimension('T')->setWidth(20);
            },
        ];
    }
}
