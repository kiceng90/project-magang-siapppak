<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MInstansiPendidikan;
use DB;

class MInstansiPendidikanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        try {
            DB::beginTransaction();

            $data = ["Universitas Negeri Sunan Ampel Surabaya","Universitas 17 Agustus Surabaya","Sekolah Tinggi Ilmu Ekonomi Surabaya","Universitas Airlangga Surabaya","Universitas Wijaya Putra Surabaya","Universitas Dr. Soetomo Surabaya","Universitas Hang Tuah Surabaya","Universitas Negeri Surabaya"];
            foreach($data as $key => $val){
                MInstansiPendidikan::updateOrCreate(['id' => $key +1], [
                    'name' => $val,
                ]);
            }

            $lastId = DB::table('m_instansi_pendidikan')->orderBy('id', 'desc')->first();
            if(!empty($lastId))
            {
                $newLastId = $lastId->id + 1;
                DB::update(DB::raw("ALTER SEQUENCE m_instansi_pendidikan_id_seq RESTART WITH {$newLastId}"));
            }

            DB::commit();
        } catch (\Exception $ex) {
            DB::rollBack();
            echo $ex->getMessage();
        }
    }
}
