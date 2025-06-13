<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class MKebutuhanTableSeeder extends Seeder
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
                    'name' => 'Ekonomi',
                ],
                [
                    'id' => 2,
                    'name' => 'Pendidikan',
                ],
                [
                    'id' => 3,
                    'name' => 'Sosial',
                ],
                [
                    'id' => 4,
                    'name' => 'Kesehatan',
                ],
                [
                    'id' => 5,
                    'name' => 'Hukum',
                ],
            ];

            foreach ($data as $key => $value) {
                DB::table('m_kebutuhan')->updateOrInsert(['id' => $value['id']], [
                    'name' => $value['name'],
                ]);
            }

            $lastId = DB::table('m_kebutuhan')->orderBy('id', 'desc')->first();
            if(!empty($lastId))
            {
                $newLastId = $lastId->id + 1;
                DB::update(DB::raw("ALTER SEQUENCE m_kebutuhan_id_seq RESTART WITH {$newLastId}"));
            }

            DB::commit();
        } catch (\Exception $ex) {
            DB::rollBack();
            echo $ex->getMessage();
        }
    }
}
