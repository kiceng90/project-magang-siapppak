<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class PiketExport implements FromView
{
    public $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function view(): View
    {
        return view('laporanKegiatanMhsV1Piket', [
            'data' => $this->data,
        ]);
    }
}
