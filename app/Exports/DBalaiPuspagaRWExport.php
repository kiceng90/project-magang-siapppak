<?php

namespace App\Exports;

use App\Models\DBalaiPuspagaRW;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class DBalaiPuspagaRWExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
   public function collection()
   {
       $data = DBalaiPuspagaRW::all();
   
       $numberedData = $data->map(function ($item, $index) {
           return [
               'No' => $index + 1,
               'Nama Balai RW' => $item->name,
               'Alamat' => $item->address,
               'Kelurahan' => $item->kelurahan->name,
               'Kecamatan' => $item->kelurahan->kecamatan->name,
               'Wilayah' => $item->wilayah->name,
               'Ketua RW' => $item->rw_name,
               'No Telp Ketua RW' => $item->rw_phone,
               'Status' => $item->is_active ? 'Aktif' : 'Tidak Aktif',
           ];
       });
   
       return $numberedData;
   }
   
   public function headings(): array
   {
       return [
           'No',       
           'Nama Balai RW',
           'Alamat',
           'Kelurahan',
           'Kecamatan',
           'Wllayah',
           'Ketua RW',
           'No Telp Ketua RW',    
           'Status',
       ];
   }
}
