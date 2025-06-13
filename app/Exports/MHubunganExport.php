<?php

namespace App\Exports;

use App\Models\MHubungan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class MHubunganExport implements FromCollection, WithHeadings

{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $data = MHubungan::all();
        $numberedData = $data->map(function ($item, $index) {
            return [
                'No' => $index + 1,
                'Hubungan Dengan Keluarga' => $item->name,
                'Status' => $item->is_active ? 'Aktif' : 'Tidak Aktif',
            ];
        });
    
        return $numberedData; 
    }

    public function headings(): array
   {
       return [
           'No',       
           'Hubungan',    
           'Status',
       ];
   }
    
}
