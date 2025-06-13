<?php

namespace App\Exports;

use App\Models\ProgresSubkategori;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class RekapTahunanBukuTamuExport implements FromCollection, WithHeadings, WithEvents
{
    protected $id_layanan;
    protected $tahun_awal;
    protected $tahun_akhir;

    public function __construct($id_layanan = null, $tahun_awal = null, $tahun_akhir = null)
    {
        $this->id_layanan = $id_layanan;
        $this->tahun_awal = $tahun_awal;
        $this->tahun_akhir = $tahun_akhir;
    }

    public function collection()
    {
        $tahun = [];
        for ($year = $this->tahun_awal; $year <= $this->tahun_akhir; $year++) {
            $tahun[] = (string)$year;
        }

        // Query buku_tamu_kebutuhan_layanan berdasarkan rentang tahun
        $query = DB::table('buku_tamu_kebutuhan_layanan')
            ->join('buku_tamu', 'buku_tamu.id', '=', 'buku_tamu_kebutuhan_layanan.buku_tamu_id')
            ->join('m_kebutuhan_layanan', 'm_kebutuhan_layanan.id', '=', 'buku_tamu_kebutuhan_layanan.m_kebutuhan_layanan_id')
            ->select(
                'buku_tamu_kebutuhan_layanan.*',
                'm_kebutuhan_layanan.name as layanan_name'
            )
            ->whereYear('buku_tamu_kebutuhan_layanan.created_at', '>=', $this->tahun_awal)
            ->whereYear('buku_tamu_kebutuhan_layanan.created_at', '<=', $this->tahun_akhir)
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
            $year = date('Y', strtotime($item->created_at));

            if (!isset($rekap[$layanan_name])) {
                $rekap[$layanan_name] = array_fill_keys($tahun, 0);
            }

            $rekap[$layanan_name][$year]++;
        }

        $exportData = [];
        foreach ($rekap as $layanan => $tahun_data) {
            $row = [
                'Layanan' => $layanan,
            ];

            $total = 0;

            foreach ($tahun as $year) {
                $value = $tahun_data[$year];
                $row[$year] = $value;
                $total += $value;
            }

            $row['Total'] = $total;
            $exportData[] = $row;
        }

        return collect($exportData);
    }

    public function headings(): array
    {
        $tahun = [];
        for ($year = $this->tahun_awal; $year <= $this->tahun_akhir; $year++) {
            $tahun[] = (string)$year;
        }

        return array_merge(
            ['Layanan'], 
            $tahun,
            ['Total']
        );
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $event->sheet->getStyle('A1:' . $event->sheet->getHighestColumn() . '1')->applyFromArray([
                    'font' => [
                        'bold' => true, 
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
                    $event->sheet->getColumnDimension($col)->setWidth(20);
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
