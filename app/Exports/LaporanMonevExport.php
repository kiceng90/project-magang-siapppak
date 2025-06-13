<?php

namespace App\Exports;

use App\Models\MKuesionerLaporanMonev;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class LaporanMonevExport implements FromView, WithEvents, WithColumnFormatting
{
    public $header, $data, $view;

    public function __construct($header, $data, $view)
    {
        $this->header = $header;
        $this->data = $data;
        $this->view = $view;
    }

    public function view(): View
    {
        return view($this->view, [
            'header' => $this->header,
            'data' => $this->data,
        ]);
    }

    public function registerEvents(): array {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $sheet = $event->sheet;

                $until = 'A';
                if($this->view == 'exports.laporanMonevV1'){
                    $total = MKuesionerLaporanMonev::where('is_excluded_export',false)->count();
                    $total+=11;
                    $until = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($total);
                }
                else{
                    $until = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex(15);
                }
                foreach(range('A',$until) as $columnID) {
                    $sheet->getColumnDimension($columnID)->setAutoSize(true);
                }

                $until .= strval(count($this->data) + 1);
                
                $sheet->getStyle('A1:'.$until."3")->applyFromArray([
                    // 'alignment' => [
                    //     'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                    // ],
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ]);
            },
        ];
    }

    public function columnFormats(): array
    {
        $data = [
            'G' => NumberFormat::FORMAT_DATE_YYYYMMDD,
        ];
        return $data;
    }
}
