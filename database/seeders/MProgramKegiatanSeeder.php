<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MProgramKegiatanSeeder extends Seeder
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
                ['name' => 'Program Layanan'],
                ['name' => 'Program Promosi'],
                ['name' => 'Rapat/Koordinasi'],
            ];

            foreach ($data as $program) {
                DB::table('m_program_kegiatan')->insert([
                    'name'       => $program['name'],
                    'is_active'  => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            DB::commit();
        } catch (\Exception $ex) {
            DB::rollBack();
            echo $ex->getMessage();
        }
    }
}
