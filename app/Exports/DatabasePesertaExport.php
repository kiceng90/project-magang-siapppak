<?php

namespace App\Exports;

use App\Models\ProgresSubkategori;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class DatabasePesertaExport implements FromCollection, WithHeadings, WithEvents
{
    protected $kategori;
    protected $subkategori;
    protected $search;
    protected $startdate;
    protected $enddate;

    public function __construct($kategori = null, $subkategori = null, $search = null, $startdate = null, $enddate = null)
    {
        $this->kategori = $kategori;
        $this->subkategori = $subkategori;
        $this->search = $search;
        $this->startdate = $startdate;
        $this->enddate = $enddate;
    }

    public function collection()
    {
        $query = ProgresSubkategori::with('user.role', 'subKategori.kategori');
        if ($this->kategori) {
            $query->whereHas('subKategori.kategori', function($q) {
                $q->where('id', $this->kategori);
            });
        }
        if ($this->subkategori) {
            $query->whereHas('subKategori', function($q) {
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
        if ($this->startdate && $this->enddate) {
            $query->whereBetween('updated_at', [$this->startdate, $this->enddate]);
        }

        $query->where('is_completed', true);
        $data = $query->get();

        $dataWithStatus = $data->map(function($item, $key) {
            return [
                'no' => $key + 1,
                'id_user' => $item->user->name,
                'id_role' => $item->user->role->name,
                'id_kategori' => $item->subKategori->kategori->name,
                'id_sub_kategori' => $item->subKategori->name,
                'tanggal' => $item->updated_at->translatedFormat('j F Y'),
                'waktu' => $item->updated_at->toTimeString(),
            ];
        });

        return $dataWithStatus;
    }

    public function headings(): array
    {
        return [
            'No',
            'Nama',
            'Role',
            'Kategori',
            'Sub Kategori',
            'Tanggal Selesai',
            'Waktu Selesai',
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
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

                $event->sheet->getStyle('F2:F' . $event->sheet->getHighestRow())->getNumberFormat()->setFormatCode('[$-id-ID]d mmmm yyyy');
                $event->sheet->getStyle('G2:G' . $event->sheet->getHighestRow())->getNumberFormat()->setFormatCode('hh:mm:ss');

                $event->sheet->getColumnDimension('A')->setWidth(5);
                $event->sheet->getColumnDimension('B')->setWidth(30);
                $event->sheet->getColumnDimension('C')->setWidth(20);
                $event->sheet->getColumnDimension('D')->setWidth(25);
                $event->sheet->getColumnDimension('E')->setWidth(35);
                $event->sheet->getColumnDimension('F')->setWidth(25);
                $event->sheet->getColumnDimension('G')->setWidth(15);
            },
        ];
    }
}