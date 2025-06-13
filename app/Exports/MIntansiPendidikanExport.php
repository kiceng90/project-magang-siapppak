<?php

namespace App\Exports;

use App\Models\MInstansiPendidikan;
use App\Controller\MInstansiPendidikanController;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class MInstansiPendidikanExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
   public function collection()
   {
       $data = MInstansiPendidikan::all();
   
       $numberedData = $data->map(function ($item, $index) {
           return [
               'No' => $index + 1,
               'Instansi Pendidikan' => $item->name,
               'Status' => $item->is_active ? 'Aktif' : 'Tidak Aktif',
           ];
       });
   
       return $numberedData;
   }
   
   public function headings(): array
   {
       return [
           'No',       
           'Instansi Pendidikan',    
           'Status',
       ];
   }
   }
