<?php

namespace App\Exports;

use App\Models\MAgama;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class MAgamaExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
   public function collection()
   {
       $data = MAgama::all();
   
       $numberedData = $data->map(function ($item, $index) {
           return [
               'No' => $index + 1,
               'Agama' => $item->name,
               'Status' => $item->is_active ? 'Aktif' : 'Tidak Aktif',
           ];
       });
   
       return $numberedData;
   }
   
   public function headings(): array
   {
       return [
           'No',       
           'Agama',    
           'Status',
       ];
   }
   }
