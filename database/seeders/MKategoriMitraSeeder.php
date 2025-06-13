<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class MKategoriMitraSeeder extends Seeder
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
                    'name' => 'LSM/NGO',
                ],
                [
                    'id' => 2,
                    'name' => 'Perguruan Tinggi',
                ],
                [
                    'id' => 3,
                    'name' => 'Dunia Usaha',
                ],
                [
                    'id' => 4,
                    'name' => 'Organisasi Anak dan Perempuan',
                ],
                [
                    'id' => 5,
                    'name' => 'Instansi/OPD Terkait',
                ],
                [
                    'id' => 6,
                    'name' => 'Aparat Penegak Hukum',
                ],
            ];

            foreach ($data as $value) {
                DB::table('m_kategori_mitra')->updateOrInsert(['id' => $value['id']], [
                    'name' => $value['name'],
                    'slug' => Str::slug($value['name']),
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ]);
            }

            $lastId = DB::table('m_kategori_mitra')->orderBy('id', 'desc')->first();
            if(!empty($lastId)) {
                $newLastId = $lastId->id + 1;
                DB::update(DB::raw("ALTER SEQUENCE m_kategori_mitra_id_seq RESTART WITH {$newLastId}"));
            }

            DB::commit();
        } 
        catch (\Exception $ex) {
            DB::rollBack();
            echo $ex->getMessage();
        }
    }
}
