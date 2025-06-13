<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithEvents;

class RekapTahunanExport implements FromView, WithEvents
{
    public $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function view(): View
    {
        // dd(request()->all());
        return view('exports.rekapTahunan', [
            'data' => $this->data,
        ]);
    }

    public function registerEvents(): array {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $alphabet = range('A', 'Z');
                $sheet = $event->sheet;

                $until = 'B3';
                if(count($this->data)){
                    $column = (request()->tahun_akhir - request()->tahun_awal + 1) * 3 - 1;
                    $columnOther = (int) floor($column / 26);
                    $until = $column > 25 ? $alphabet[$columnOther - 1]. $alphabet[(int) fmod($column, 26) + 2] : $alphabet[$column + 2];

                    $row = 3;
                    foreach($this->data as $d){
                        $row++;
                        foreach($d->kategori_kasus as $k){
                            $row++;
                            $sheet->getStyle('A'.$row)->getAlignment()->setIndent(1);
                            foreach($k->jenis_kasus as $j){
                                $row++;
                                $sheet->getStyle('A'.$row)->getAlignment()->setIndent(2);
                            }
                        }
                    }

                    $until .= ($row + 1);
                }

                $sheet->getStyle('A1:'.$until)->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ]);

                $sheet->getStyle('A2')->getAlignment()->setIndent(1);
                $sheet->getStyle('A3')->getAlignment()->setIndent(2);
            }
        ];
    }
}
