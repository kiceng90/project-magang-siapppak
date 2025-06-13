<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MKedudukanDalamTim;
use DB;

class MKedudukanDalamTimSeeder extends Seeder
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

            $data = ["Penanggung Jawab","Pelindung I","Pelindung II","Pengarah I","Pengarah II","Pengarah III","Ketua ","Sekretaris ","Anggota"];
            foreach($data as $key => $val){
                MKedudukanDalamTim::updateOrCreate(['id' => $key +1], [
                    'name' => $val,
                ]);
            }

            $lastId = DB::table('m_kedudukan_dalam_tim')->orderBy('id', 'desc')->first();
            if(!empty($lastId))
            {
                $newLastId = $lastId->id + 1;
                DB::update(DB::raw("ALTER SEQUENCE m_kedudukan_dalam_tim_id_seq RESTART WITH {$newLastId}"));
            }

            DB::commit();
        } catch (\Exception $ex) {
            DB::rollBack();
            echo $ex->getMessage();
        }
    }
}
