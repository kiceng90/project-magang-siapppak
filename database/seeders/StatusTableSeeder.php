<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use \DB;

class StatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::beginTransaction();
        try {
            $data = [
                [
                    'id' => 1,
                    'status' => 'Perlu Penanganan (hotline)',
                ],
                [
                    'id' => 2,
                    'status' => 'Pengaduan dirujuk (hotline)',
                ],
                [
                    'id' => 3,
                    'status' => 'Perlu Verifikasi Pengaduan (subkord)',
                ],
                [
                    'id' => 4,
                    'status' => 'Perlu Verifikasi Pengaduan (kabid)',
                ],
                [
                    'id' => 5,
                    'status' => 'Proses Penjangkauan (konselor)',
                ],
                [
                    'id' => 6,
                    'status' => 'Proses Revisi',
                ],
                [
                    'id' => 7,
                    'status' => 'Perlu Verifikasi Penjangkauan (subkord)',
                ],
                [
                    'id' => 8,
                    'status' => 'Perlu Verifikasi Penjangkauan (kabid)',
                ],
                [
                    'id' => 9,
                    'status' => 'Perlu Verifikasi Penjangkauan (kadis)',
                ],
                [
                    'id' => 10,
                    'status' => 'Selesai',
                ],
            ];

            foreach ($data as $key => $value) {
                DB::table('status')->updateOrInsert(['id' => $value['id']], [
                    'status' => $value['status'],
                ]);
            }

            $lastId = DB::table('status')->orderBy('id', 'desc')->first();
            if(!empty($lastId))
            {
                $newLastId = $lastId->id + 1;
                DB::update(DB::raw("ALTER SEQUENCE status_id_seq RESTART WITH {$newLastId}"));
            }

            DB::commit();
        } catch (\Exception $ex) {
            DB::rollBack();
            echo $ex->getMessage();
        }
    
    }
}
