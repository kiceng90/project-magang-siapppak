<?php

namespace App\Exports;

use App\Models\ProgresSubkategori;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class LaporanElearningExport implements FromCollection, WithHeadings, WithEvents
{
    protected $kategori;
    protected $subkategori;
    protected $search;
    protected $periode;
    protected $start_date;
    protected $end_date;

    public function __construct($kategori = null, $subkategori = null, $search = null, $periode = null, $start_date = null, $end_date = null)
    {
        $this->kategori = $kategori;
        $this->subkategori = $subkategori;
        $this->search = $search;
        $this->periode = $periode;
        $this->start_date = $start_date ? Carbon::parse($start_date)->startOfDay() : null;
        $this->end_date = $end_date ? Carbon::parse($end_date)->endOfDay() : null;
    }

    public function collection()
    {
        $query = ProgresSubkategori::with(['user' => function ($query) {
            $roleMahasiswaId = env('ROLE_MAHASISWA_ID');
            $roleKlienId = env('ROLE_KLIEN_ID');
            
            $query->when(Auth::user()->id_role == $roleMahasiswaId, function ($query) {
                $query->with('mahasiswa.kelurahan_kk.kecamatan');
            })
            ->when(Auth::user()->id_role == $roleKlienId, function ($query) {
                $query->with('klienKonseling.kelurahan.kecamatan');
            });
        }, 'subKategori.kategori']);

        if ($this->periode == 4) {
            $query->whereBetween('updated_at', [
                $this->start_date->toDateTimeString(),
                $this->end_date->toDateTimeString(),
            ]);
        } elseif ($this->periode == 1) {
            $query->whereBetween('updated_at', [
                now()->startOfMonth()->toDateTimeString(),
                now()->endOfMonth()->toDateTimeString(),
            ]);
        } elseif ($this->periode == 2) {
            $query->whereBetween('updated_at', [
                now()->subMonths(2)->startOfMonth()->toDateTimeString(),
                now()->endOfMonth()->toDateTimeString(),
            ]);
        } elseif ($this->periode == 3) {
            $query->whereBetween('updated_at', [
                now()->startOfYear()->toDateTimeString(),
                now()->endOfYear()->toDateTimeString(),
            ]);
        }

        if ($this->kategori) {
            $query->whereHas('subKategori.kategori', function ($q) {
                $q->where('id', $this->kategori);
            });
        }
        if ($this->subkategori) {
            $query->whereHas('subKategori', function ($q) {
                $q->where('id', $this->subkategori);
            });
        }
        if ($this->search) {
            $query->where(function ($q) {
                $q->whereHas('user', function ($userQuery) {
                    $userQuery->whereRaw('LOWER(name) LIKE ?', ['%' . strtolower($this->search) . '%']);
                })
                ->orWhereHas('subKategori', function ($subQuery) {
                    $subQuery->whereRaw('LOWER(name) LIKE ?', ['%' . strtolower($this->search) . '%']);
                })
                ->orWhereHas('subKategori.kategori', function ($catQuery) {
                    $catQuery->whereRaw('LOWER(name) LIKE ?', ['%' . strtolower($this->search) . '%']);
                });
            });
        }

        $data = $query->get();

        $dataWithStatus = $data->map(function ($item, $key) {
            $mahasiswa = optional($item->user->mahasiswa);
            $klienKonseling = optional($item->user->klienKonseling);

            $kelurahan_kk_mahasiswa = optional($mahasiswa->kelurahan_kk);
            $kelurahan_kk_klien = optional($klienKonseling->kelurahan);

            $kecamatan_mahasiswa = optional($kelurahan_kk_mahasiswa->kecamatan)->name;
            $kecamatan_klien = optional(optional($kelurahan_kk_klien)->kecamatan)->name;
            
            return [
                'no' => $key + 1,
                'name' => $item->user->name,
                'role' => $item->user->role->name,
                'nik' => strval(optional($item->user->mahasiswa)->nik ?: optional($klienKonseling)->nik) . ' ',
                'alamat_ktp' => $mahasiswa->kk_address ?: $klienKonseling->address,
                'kecamatan' => $kecamatan_mahasiswa ?: $kecamatan_klien,
                'kelurahan' => optional($kelurahan_kk_mahasiswa)->name 
                                ?: optional($kelurahan_kk_klien)->name,
                'kategori' => $item->subKategori->kategori->name,
                'sub_kategori' => $item->subKategori->name,
                'status' => $item->is_completed ? 'Selesai' : 'Belum',
                'tanggal' => $item->is_completed && !empty($item->updated_at) 
                                ? round(25569 + strtotime($item->updated_at) / 86400, 0)
                                : '',
            ];
        });

        return $dataWithStatus;
    }

    public function headings(): array
    {
        return [
            [
                'No',
                'Nama',
                'Role',
                'NIK',
                'Alamat KTP',
                'Kecamatan KTP',
                'Kelurahan KTP',
                'Kategori',
                'Sub Kategori',
                'Status',
                'Tanggal Selesai',
            ],
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $event->sheet->getStyle('D2:D' . ($event->sheet->getHighestRow()))
                ->getNumberFormat()
                ->setFormatCode('@');
                // Style for User Information Heading
                $event->sheet->getStyle('A1:G1')->applyFromArray([
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

                // Style for Category Information Heading
                $event->sheet->getStyle('H1:K1')->applyFromArray([
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

                $event->sheet->getStyle('D2:D' . ($event->sheet->getHighestRow()))
                ->getNumberFormat()
                ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_TEXT);


                // Set column widths
                $event->sheet->getColumnDimension('A')->setWidth(5);
                $event->sheet->getColumnDimension('B')->setWidth(35);
                $event->sheet->getColumnDimension('C')->setWidth(15);
                $event->sheet->getColumnDimension('D')->setWidth(25);
                $event->sheet->getColumnDimension('E')->setWidth(35);
                $event->sheet->getColumnDimension('F')->setWidth(25);
                $event->sheet->getColumnDimension('G')->setWidth(25);
                $event->sheet->getColumnDimension('H')->setWidth(18);
                $event->sheet->getColumnDimension('I')->setWidth(35);
                $event->sheet->getColumnDimension('J')->setWidth(15);
                $event->sheet->getColumnDimension('K')->setWidth(20);
            },
        ];
    }
}
