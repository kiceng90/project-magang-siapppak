<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class MLayananTableSeeder extends Seeder
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
                    'name' => 'Pendampingan Psikologis',
                ],
                [
                    'id' => 2,
                    'name' => 'Pendampingan Medis',
                ],
                [
                    'id' => 3,
                    'name' => 'Pendampingan Hukum',
                ],
                [
                    'id' => 4,
                    'name' => 'Psikososial',
                ],
                [
                    'id' => 5,
                    'name' => 'Shelter LSM/LKSA/Fasilitas Lainnya',
                ],
                // [
                //     'id' => 5,
                //     'name' => 'Rumah Aman (Shelter)',
                // ],
                [
                    'id' => 6,
                    'name' => 'Koordinasi Lintas Sektor',
                ],
            ];

            foreach ($data as $key => $value) {
                DB::table('m_pelayanan')->updateOrInsert(['id' => $value['id']], [
                    'name' => $value['name'],
                ]);
            }

            $lastId = DB::table('m_pelayanan')->orderBy('id', 'desc')->first();
            if(!empty($lastId))
            {
                $newLastId = $lastId->id + 1;
                DB::update(DB::raw("ALTER SEQUENCE m_pelayanan_id_seq RESTART WITH {$newLastId}"));
            }

            DB::commit();
        } catch (\Exception $ex) {
            DB::rollBack();
            echo $ex->getMessage();
        }
    }
}
