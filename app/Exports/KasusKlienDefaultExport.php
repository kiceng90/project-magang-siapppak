<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class KasusKlienDefaultExport implements WithMultipleSheets
{
    public $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function sheets(): array
    {
        return [
            new PelaporExport($this->data->pelapor),
            new KlienExport($this->data->klien),
            new PelakuExport($this->data->pelaku),
            new KeluargaExport($this->data->keluarga),
            new KeteranganExport($this->data->keterangan),
            new RencanaDp3appkbExport($this->data->rencana_dp3appkb), 
            new RencanaRujukanOpd($this->data->intervensi_opd),
            new IntervensiDp3appkbExport($this->data->intervensi_dp3appkb),
            new IntervensiOpdExport($this->data->intervensi_opd),
            new IntervensiAllExport($this->data->intervensi_opd)
        ];
    }
}
