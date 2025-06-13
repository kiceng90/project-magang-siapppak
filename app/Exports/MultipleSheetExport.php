<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class MultipleSheetExport implements WithMultipleSheets
{
    public function sheets(): array
    {
        return [
            new KonsultasiExport(),
            new PiketExport(),
        ];
    }
}

