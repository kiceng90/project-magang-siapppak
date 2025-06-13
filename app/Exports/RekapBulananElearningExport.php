<?php

namespace App\Exports;

use App\Models\ProgresSubkategori;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class RekapBulananElearningExport implements FromCollection, WithHeadings, WithEvents
{
    protected $kategori;
    protected $subkategori;
    protected $bulan_awal;
    protected $bulan_akhir;

    public function __construct($kategori = null, $subkategori = null, $bulan_awal = null, $bulan_akhir = null)
    {
        $this->kategori = $kategori;
        $this->subkategori = $subkategori;
        $this->bulan_awal = $bulan_awal;
        $this->bulan_akhir = $bulan_akhir;
    }

    public function collection()
    {
        $awal = explode('-', $this->bulan_awal);
        $akhir = explode('-', $this->bulan_akhir);

        $bulan = [];
        $start_year = (int)$awal[0];
        $end_year = (int)$akhir[0];
        $start_month = (int)$awal[1];
        $end_month = (int)$akhir[1];

        for ($year = $start_year; $year <= $end_year; $year++) {
            $start = ($year == $start_year) ? $start_month : 1;
            $end = ($year == $end_year) ? $end_month : 12;

            for ($month = $start; $month <= $end; $month++) {
                $bulan[] = $this->getMonthName($month) . ' ' . $year;
            }
        }

        $query = ProgresSubkategori::with('subKategori.kategori')
            ->whereYear('updated_at', '>=', $awal[0])
            ->whereMonth('updated_at', '>=', $awal[1])
            ->whereYear('updated_at', '<=', $akhir[0])
            ->whereMonth('updated_at', '<=', $akhir[1]);

        if (!empty($this->kategori)) {
            $query->whereHas('subKategori.kategori', function($q) {
                $q->where('id', $this->kategori);
            });
        }

        if (!empty($this->subkategori)) {
            $query->whereHas('subKategori', function($q) {
                $q->where('id', $this->subkategori);
            });
        }

        $data = $query->get();

        $rekap = [];
        foreach ($data as $item) {
            $kategori_name = $item->subKategori->kategori->name;
            $subkategori_name = $item->subKategori->name;
            $month_year = $this->getMonthName($item->updated_at->month) . ' ' . $item->updated_at->year;

            if (!isset($rekap[$kategori_name])) {
                $rekap[$kategori_name] = [];
            }
            if (!isset($rekap[$kategori_name][$subkategori_name])) {
                $rekap[$kategori_name][$subkategori_name] = array_fill_keys($bulan, '0');
            }

            $rekap[$kategori_name][$subkategori_name][$month_year]++;
        }

        $exportData = [];
        foreach ($rekap as $kategori => $subcategories) {
            foreach ($subcategories as $subkategori => $bulan_data) {
                $row = [
                    'Kategori' => $kategori,
                    'Sub Kategori' => $subkategori,
                ];

                $total = 0;

                foreach ($bulan as $month) {
                    $value = $bulan_data[$month];
                    $row[$month] = $value;
                    $total += $value;
                }

                $row['Total'] = $total;
                $exportData[] = $row;
            }
        }

        return collect($exportData);
    }

    private function getMonthName($month)
    {
        $bulan = [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember',
        ];

        return $bulan[$month];
    }

    public function headings(): array
    {
        $bulan = [];
        $start_year = (int)explode('-', $this->bulan_awal)[0];
        $end_year = (int)explode('-', $this->bulan_akhir)[0];
        $start_month = (int)explode('-', $this->bulan_awal)[1];
        $end_month = (int)explode('-', $this->bulan_akhir)[1];

        for ($year = $start_year; $year <= $end_year; $year++) {
            $start = ($year == $start_year) ? $start_month : 1;
            $end = ($year == $end_year) ? $end_month : 12;

            for ($month = $start; $month <= $end; $month++) {
                $bulan[] = $this->getMonthName($month) . ' ' . $year;
            }
        }

        return array_merge(
            ['Kategori', 'Sub Kategori'], 
            $bulan,
            ['Total']
        );
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
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

                for ($col = $startColumn; $col <= $highestColumn; $col++) {
                    $event->sheet->getColumnDimension($col)->setWidth(25);
                    $event->sheet->getStyle($col . '2:' . $col . $event->sheet->getHighestRow())->getAlignment()->setHorizontal('center');
                }

                $event->sheet->getColumnDimension($totalColumn)->setWidth(15);

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
