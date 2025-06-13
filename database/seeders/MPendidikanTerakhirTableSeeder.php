<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use \DB;

class MPendidikanTerakhirTableSeeder extends Seeder
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
            $data = [1 => "TIDAK SEKOLAH","TK","SD","SMP","SMA","SMK","PAKET C","PAKET B","PAKET A","MI","MTS","MA","D1","D2","D3","D4","S1","S2","S3","SLB","PESANTREN","BELUM SEKOLAH","PAUD","LAINNYA"];

            foreach ($data as $key => $value) {
                DB::table('m_pendidikan_terakhir')->updateOrInsert(['id' => $key], [
                    'name' => $value,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ]);
            }

            $lastId = DB::table('m_pendidikan_terakhir')->orderBy('id', 'desc')->first();
            if(!empty($lastId))
            {
                $newLastId = $lastId->id + 1;
                DB::update(DB::raw("ALTER SEQUENCE m_pendidikan_terakhir_id_seq RESTART WITH {$newLastId}"));
            }

            DB::commit();
        } catch (\Exception $ex) {
            DB::rollBack();
            echo $ex->getMessage();
        }
    }
}
