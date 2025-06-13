<?php

namespace App\Exports;

use App\Models\Mitra;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class MitraExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
   public function collection()
   {
       $data = Mitra::all();
   
       $numberedData = $data->map(function ($item, $index) {
           return [
               'No' => $index + 1,
               'Kategori Mitra' => $item->kategoriMitra->name,
               'Mitra' => $item->name,
               'Alamat' => $item->address,
               'No Hp' => $item->phone,
               'Status' => $item->is_active ? 'Aktif' : 'Tidak Aktif',
           ];
       });
   
       return $numberedData;
   }
   
   public function headings(): array
   {
       return [
           'No',       
           'Kategori Mitra',
           'Mitra',
           'Alamat', 
           'No Hp',     
           'Status',
       ];
   }
}
