<?php

namespace App\Exports;

use DateTime;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;

class RekapBulananBukuTamuExport implements FromCollection, WithHeadings, WithEvents
{
    protected $id_layanan;
    protected $bulan_awal;
    protected $bulan_akhir;

    public function __construct($id_layanan = null, $bulan_awal = null, $bulan_akhir = null)
    {
        $this->id_layanan = $id_layanan;
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

        // Menggunakan query builder untuk menggabungkan tabel
        $query = DB::table('buku_tamu_kebutuhan_layanan')
            ->join('buku_tamu', 'buku_tamu.id', '=', 'buku_tamu_kebutuhan_layanan.buku_tamu_id')
            ->join('m_kebutuhan_layanan', 'm_kebutuhan_layanan.id', '=', 'buku_tamu_kebutuhan_layanan.m_kebutuhan_layanan_id')
            ->select(
                'buku_tamu_kebutuhan_layanan.*',
                'm_kebutuhan_layanan.name as layanan_name',
                'buku_tamu_kebutuhan_layanan.created_at'
            )
            ->whereYear('buku_tamu_kebutuhan_layanan.created_at', '>=', $awal[0])
            ->whereMonth('buku_tamu_kebutuhan_layanan.created_at', '>=', $awal[1])
            ->whereYear('buku_tamu_kebutuhan_layanan.created_at', '<=', $akhir[0])
            ->whereMonth('buku_tamu_kebutuhan_layanan.created_at', '<=', $akhir[1])
            ->whereNull('buku_tamu_kebutuhan_layanan.deleted_at');

        // Filter berdasarkan layanan jika disediakan
        if (!empty($this->id_layanan)) {
            $query->where('m_kebutuhan_layanan_id', $this->id_layanan);
        }

        $data = $query->get();

        // Menyusun data rekap
        $rekap = [];
        foreach ($data as $item) {
            $layanan_name = $item->layanan_name;
            $created_at = new DateTime($item->created_at);
            $month_year = $this->getMonthName($created_at->format('n')) . ' ' . $created_at->format('Y');

            if (!isset($rekap[$layanan_name])) {
                $rekap[$layanan_name] = array_fill_keys($bulan, 0);
            }

            $rekap[$layanan_name][$month_year]++;
        }

        $exportData = [];
        foreach ($rekap as $layanan => $bulan_data) {
            $row = [
                'Layanan' => $layanan,
            ];

            $total = 0;

            foreach ($bulan as $month) {
                $value = $bulan_data[$month] ?? 0;
                $row[$month] = $value;
                $total += $value;
            }

            $row['Total'] = $total;
            $exportData[] = $row;
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
            ['Layanan'], 
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

                $event->sheet->getColumnDimension('A')->setWidth(35);
                
                $startColumn = 'B';
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