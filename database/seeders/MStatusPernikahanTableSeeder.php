<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use \DB;

class MStatusPernikahanTableSeeder extends Seeder
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
            $data = [1 => "Menikah","Belum Menikah","Duda","Janda Cerai","Janda Ditinggal Mati","Menikah Siri","Plogami Siri","Poligami Resmi"];

            foreach ($data as $key => $value) {
                DB::table('m_status_pernikahan')->updateOrInsert(['id' => $key], [
                    'name' => $value,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ]);
            }

            $lastId = DB::table('m_status_pernikahan')->orderBy('id', 'desc')->first();
            if(!empty($lastId))
            {
                $newLastId = $lastId->id + 1;
                DB::update(DB::raw("ALTER SEQUENCE m_status_pernikahan_id_seq RESTART WITH {$newLastId}"));
            }

            DB::commit();
        } catch (\Exception $ex) {
            DB::rollBack();
            echo $ex->getMessage();
        }
    }
}
