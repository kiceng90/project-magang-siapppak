<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use \DB;

class MPosisiMahasiswa extends Seeder
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
            $data = [1 => "Fasilitator Puspaga Balai RW","Social Media Specialist","Broadcasting Team","IT Development"];

            foreach ($data as $key => $value) {
                DB::table('m_posisi_mahasiswa')->updateOrInsert(['id' => $key], [
                    'name' => $value,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ]);
            }

            $lastId = DB::table('m_posisi_mahasiswa')->orderBy('id', 'desc')->first();
            if(!empty($lastId))
            {
                $newLastId = $lastId->id + 1;
                DB::update(DB::raw("ALTER SEQUENCE m_posisi_mahasiswa_id_seq RESTART WITH {$newLastId}"));
            }

            DB::commit();
        } catch (\Exception $ex) {
            DB::rollBack();
            echo $ex->getMessage();
        }
    }
}
