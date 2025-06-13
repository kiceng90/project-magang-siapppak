<?php

namespace App\Exports;

use App\Models\MJabatanDalamInstansi;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class MJabatanDalamInstansiExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
   public function collection()
   {
       $data = MJabatanDalamInstansi::all();
   
       $numberedData = $data->map(function ($item, $index) {
           return [
               'No' => $index + 1,
               'Jabatan Dalam Instansi' => $item->name,
               'Status' => $item->is_active ? 'Aktif' : 'Tidak Aktif',
           ];
       });
   
       return $numberedData;
   }
   
   public function headings(): array
   {
       return [
           'No',       
           'Jabatan Dalam Instansi',    
           'Status',
       ];
   }
}
