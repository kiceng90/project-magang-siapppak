<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;


class PuspagaRwFormatExport implements WithMultipleSheets
{
    public function sheets(): array
    {
        return [
            new PuspagaRwFormatFirstSheetExport,
            new MKelurahanSheetExport,
            new MJabatanDalamInstansiSheetExport,
            new MKedudukanDalamTimSheetExport,
        ];
    }
}
