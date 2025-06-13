<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use \DB;

class MLokasiKejadianTableSeeder extends Seeder
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
            $data = [1 => "Rumah Tangga","Tempat Kerja","Sekolah","Taman","Tempat Ibadah","Fasum","Transportasi","Mall","Lainnya"];

            foreach ($data as $key => $value) {
                DB::table('m_lokasi_kejadian')->updateOrInsert(['id' => $key], [
                    'name' => $value,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ]);
            }

            $lastId = DB::table('m_lokasi_kejadian')->orderBy('id', 'desc')->first();
            if(!empty($lastId))
            {
                $newLastId = $lastId->id + 1;
                DB::update(DB::raw("ALTER SEQUENCE m_lokasi_kejadian_id_seq RESTART WITH {$newLastId}"));
            }

            DB::commit();
        } catch (\Exception $ex) {
            DB::rollBack();
            echo $ex->getMessage();
        }
    }
}
