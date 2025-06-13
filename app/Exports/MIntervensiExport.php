<?php

namespace App\Exports;

use App\Models\MIntervensi;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class MIntervensiExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
   public function collection()
   {
       $data = MIntervensi::all();
   
       $numberedData = $data->map(function ($item, $index) {
           return [
               'No' => $index + 1,
               'OPD' => $item->opd->name,
               'Intervensi' =>$item->name,
               'Status' => $item->is_active ? 'Aktif' : 'Tidak Aktif',
           ];
       });
   
       return $numberedData;
   }
   
   public function headings(): array
   {
       return [
           'No',       
           'OPD',
           'Intervensi',    
           'Status',
       ];
   }

}
