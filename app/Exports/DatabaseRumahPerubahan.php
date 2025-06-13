<?php

namespace App\Exports;

use App\Models\RumahPerubahanJawaban;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class DatabaseRumahPerubahan implements FromCollection, WithHeadings, WithEvents
{
    protected $kategori;
    protected $materi;
    protected $search;
    protected $startdate;
    protected $enddate;

    // Constructor menerima parameter untuk filter
    public function __construct($kategori = null, $materi = null, $search = null, $startdate = null, $enddate = null)
    {
        $this->kategori = $kategori;
        $this->materi = $materi;
        $this->search = $search;
        $this->startdate = $startdate;
        $this->enddate = $enddate;
    }

    // Method untuk mengumpulkan data dengan filter
    public function collection()
    {
        $query = RumahPerubahanJawaban::with('materi.kategori', 'user.role');

        // Filter berdasarkan kategori
        if ($this->kategori) {
            $query->whereHas('materi.kategori', function($q) {
                $q->where('id', $this->kategori);
            });
        }

        // Filter berdasarkan materi
        if ($this->materi) {
            $query->whereHas('materi', function($q) {
                $q->where('id', $this->materi);
            });
        }

        // Filter berdasarkan pencarian
        if ($this->search) {
            $query->where(function ($q) {
                $q->whereHas('user', function ($userQuery) {
                    $userQuery->whereRaw('LOWER(name) LIKE ?', ['%' . strtolower($this->search) . '%']);
                })
                ->orWhereHas('materi', function ($subQuery) {
                    $subQuery->whereRaw('LOWER(name) LIKE ?', ['%' . strtolower($this->search) . '%']);
                })
                ->orWhereHas('materi.kategori', function ($catQuery) {
                    $catQuery->whereRaw('LOWER(name) LIKE ?', ['%' . strtolower($this->search) . '%']);
                });
            });
        }

        // Filter berdasarkan rentang tanggal
        if ($this->startdate && $this->enddate) {
            $query->whereBetween('updated_at', [$this->startdate, $this->enddate]);
        }

        // Mengambil data yang sudah selesai
        $query->where('is_selesai', true);
        $data = $query->get();

        // Menyusun data untuk diekspor
        $dataWithStatus = $data->map(function($item, $key) {
            return [
                'no' => $key + 1,
                'nama' => $item->nama,
                'id_kategori' => $item->materi->kategori->name,
                'id_materi' => $item->materi->name,
                'tanggal' => $item->created_at->translatedFormat('j F Y'),
                'waktu' => $item->created_at->toTimeString(),
                'skor' => $item->skor,
            ];
        });

        return $dataWithStatus;
    }

    // Menentukan header untuk file Excel
    public function headings(): array
    {
        return [
            'No',
            'Nama',
            'Kategori',
            'Materi',
            'Tanggal Pengerjaan',
            'Waktu Pengerjaan',
            'Skor',
        ];
    }

    // Menambahkan custom styling pada sheet Excel
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                // Menerapkan gaya pada header
                $event->sheet->getStyle('A1:G1')->applyFromArray([
                    'font' => ['bold' => true],
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'startColor' => ['argb' => 'ee7b33'],
                    ],
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        ],
                    ],
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    ]
                ]);

                // Format tanggal dan waktu
                $event->sheet->getStyle('F2:F' . $event->sheet->getHighestRow())->getNumberFormat()->setFormatCode('[$-id-ID]d mmmm yyyy');
                $event->sheet->getStyle('G2:G' . $event->sheet->getHighestRow())->getNumberFormat()->setFormatCode('hh:mm:ss');

                // Menyesuaikan lebar kolom
                $event->sheet->getColumnDimension('A')->setWidth(5);
                $event->sheet->getColumnDimension('B')->setWidth(30);
                $event->sheet->getColumnDimension('C')->setWidth(20);
                $event->sheet->getColumnDimension('D')->setWidth(25);
                $event->sheet->getColumnDimension('E')->setWidth(35);
                $event->sheet->getColumnDimension('F')->setWidth(25);
            },
        ];
    }
}
