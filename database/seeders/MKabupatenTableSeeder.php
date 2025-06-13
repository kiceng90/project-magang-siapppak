<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use \DB;

class MKabupatenTableSeeder extends Seeder
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
            $data = [1 => "Surabaya","Gresik","Mojokerto","Pasuruan","Probolinggo","Ponorogo","Ambon","Kediri","Blitar","Nganjuk","Bandung","Blora","Surakarta","Sumenep","Bojonegoro","Sidoarjo","Malang","Tuban","Lamongan","Tulungagung","Madiun","Sampang","Pati","Sukoharjo","Kudus","Magetan","Martapura","Jember","Trenggalek","Banyuwangi","Pacitan","Medan","Ngawi","Atameua","Dili","Bangkalan","Magelang","Jayapura","Cilacap","Jombang","Jambi","Balikpapan","Kota Baru","Ujung Pandang","Samarinda","Palembang","Batang","Pangkalan Bun","Pontianak","Sleman","Jakarta Timur","Bengkalis","Semarang","Porong","Watampone","Jakarta","Pamekasan","Baebunta","Yogyakarta","Lumajang","Maumere","Wainaking","Brebes","Madura","Situbondo","Wonogiri","Alindau","Denpasar","Purworejo","Seririt","Kebumen","Klaten","Palu","Kalabahi","Sragen","Bekasi","Sebulu","Indramayu","Tanah Merah","Subang","Banyumas","Tangerang","Pahang Malaysia","Mataram","Siajam","Mella","Cimahi"];

            foreach ($data as $key => $value) {
                DB::table('m_kabupaten')->updateOrInsert(['id' => $key], [
                    'name' => $value,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ]);
            }

            $lastId = DB::table('m_kabupaten')->orderBy('id', 'desc')->first();
            if(!empty($lastId))
            {
                $newLastId = $lastId->id + 1;
                DB::update(DB::raw("ALTER SEQUENCE m_kabupaten_id_seq RESTART WITH {$newLastId}"));
            }

            DB::commit();
        } catch (\Exception $ex) {
            DB::rollBack();
            echo $ex->getMessage();
        }
    }
}
