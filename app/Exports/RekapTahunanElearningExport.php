<?php

namespace App\Exports;

use App\Models\ProgresSubkategori;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class RekapTahunanElearningExport implements FromCollection, WithHeadings, WithEvents
{
    protected $kategori;
    protected $subkategori;
    protected $tahun_awal;
    protected $tahun_akhir;

    public function __construct($kategori = null, $subkategori = null, $tahun_awal = null, $tahun_akhir = null)
    {
        $this->kategori = $kategori;
        $this->subkategori = $subkategori;
        $this->tahun_awal = $tahun_awal;
        $this->tahun_akhir = $tahun_akhir;
    }

    public function collection()
    {
        $tahun = range($this->tahun_awal, $this->tahun_akhir);

        $query = ProgresSubkategori::with('subKategori.kategori')
            ->whereYear('updated_at', '>=', $this->tahun_awal)
            ->whereYear('updated_at', '<=', $this->tahun_akhir);

        if (!empty($this->kategori)) {
            $query->whereHas('subKategori.kategori', function ($q) {
                $q->where('id', $this->kategori);
            });
        }

        if (!empty($this->subkategori)) {
            $query->whereHas('subKategori', function ($q) {
                $q->where('id', $this->subkategori);
            });
        }

        $data = $query->get();

        $rekap = [];
        foreach ($data as $item) {
            $kategori_name = $item->subKategori->kategori->name;
            $subkategori_name = $item->subKategori->name;
            $year = $item->updated_at->year;

            if (!isset($rekap[$kategori_name])) {
                $rekap[$kategori_name] = [];
            }
            if (!isset($rekap[$kategori_name][$subkategori_name])) {
                $rekap[$kategori_name][$subkategori_name] = array_fill_keys($tahun, '0');
            }

            $rekap[$kategori_name][$subkategori_name][$year]++;
        }

        $exportData = [];
        foreach ($rekap as $kategori => $subcategories) {
            foreach ($subcategories as $subkategori => $tahun_data) {
                $row = [
                    'Kategori' => $kategori,
                    'Sub Kategori' => $subkategori,
                ];

                $total = 0;

                foreach ($tahun as $year) {
                    $value = $tahun_data[$year];
                    $row['Tahun ' . $year] = $value;
                    $total += $value;
                }

                $row['Total'] = $total;
                $exportData[] = $row;
            }
        }

        return collect($exportData);
    }

    public function headings(): array
    {
        $tahun = range($this->tahun_awal, $this->tahun_akhir);

        return array_merge(
            ['Kategori', 'Sub Kategori'],
            array_map(function ($year) {
                return 'Tahun ' . $year;
            }, $tahun),
            ['Total']
        );
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $event->sheet->getStyle('A1:' . $event->sheet->getHighestColumn() . '1')->applyFromArray([
                    'font' => ['bold' => true,
                    'color' => ['argb' => 'FFFFFFFF'],
                ],
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'startColor' => ['argb' => '666666'],
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

                $event->sheet->getColumnDimension('A')->setWidth(22);
                $event->sheet->getColumnDimension('B')->setWidth(35);

                $startColumn = 'C';
                $highestColumn = $event->sheet->getHighestColumn();

                $highestColumnIndex = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($highestColumn);
                $totalColumn = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($highestColumnIndex);

                for ($col = $startColumn; $col < $totalColumn; $col++) {
                    $event->sheet->getColumnDimension($col)->setWidth(20);
                    $event->sheet->getStyle($col . '2:' . $col . $event->sheet->getHighestRow())->getAlignment()->setHorizontal('center');
                }

                $event->sheet->getColumnDimension($totalColumn)->setWidth(15);
                $event->sheet->getStyle($totalColumn . '2:' . $totalColumn . $event->sheet->getHighestRow())
                ->getAlignment()->setHorizontal('center');

                $event->sheet->getStyle('A1:' . $event->sheet->getHighestColumn() . $event->sheet->getHighestRow())
                    ->applyFromArray([
                        'borders' => [
                            'allBorders' => [
                                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            ],
                        ],
                    ]);
            }
        ];
    }
}
