<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithEvents;

class RekapBulananExport implements FromView, WithEvents
{
    public $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function view(): View
    {
        return view('exports.rekapBulanan', [
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
                    $bulan = [];
                    $awal = explode("-",request()->bulan_awal);
                    $akhir = explode("-",request()->bulan_akhir);
                    $range = $akhir[0] - $awal[0];
                    for ($i = (int)$awal[0]; $i <= $akhir[0]; $i++) {

                        $start = 1;
                        $end = 12;

                        if($range && ($i == $awal[0])){
                            $start = $awal[1];
                        }
                        if($range && ($i == $akhir[0])){
                            $end = $akhir[1];
                        }

                        if(!$range){
                            $start = $awal[1];
                            $end = $akhir[1];
                        }

                        for ($j = $start; $j <= $end; $j++) { 
                            $bulan[] = [
                                'tahun' => $i,
                                'bulan' => $j,
                            ];
                        }
                    }

                    $column = count($bulan) - 1;
                    $columnOther = (int) floor($column / 26);
                    $until = $column > 25 ? $alphabet[$columnOther - 1]. $alphabet[(int) fmod($column, 26) + 2] : $alphabet[$column + 2];

                    $row = 3;
                    foreach($this->data as $d){
                        $row++;
                        if(isset($d->anak)){
                            $row++;
                            $sheet->getStyle('A'.$row)->getAlignment()->setIndent(1);
                            foreach($d->anak->kategori_kasus as $k){
                                $row++;
                                $sheet->getStyle('A'.$row)->getAlignment()->setIndent(2);
                                foreach($k->jenis_kasus as $j){
                                    $row++;
                                    $sheet->getStyle('A'.$row)->getAlignment()->setIndent(3);
                                }
                            }
                        }
                        if(isset($d->dewasa)){
                            $row++;
                            $sheet->getStyle('A'.$row)->getAlignment()->setIndent(1);
                            foreach($d->dewasa->kategori_kasus as $k){
                                $row++;
                                $sheet->getStyle('A'.$row)->getAlignment()->setIndent(2);
                                foreach($k->jenis_kasus as $j){
                                    $row++;
                                    $sheet->getStyle('A'.$row)->getAlignment()->setIndent(3);
                                }
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
