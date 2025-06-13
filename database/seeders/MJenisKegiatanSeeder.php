<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MJenisKegiatanSeeder extends Seeder
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
            // Ambil ID program kegiatan terlebih dahulu
            $programs = DB::table('m_program_kegiatan')->pluck('id', 'name');

            $data = [
                'Program Layanan' => [
                    'Kelas Calon Pengantin',
                    'Kegiatan Penyadaran',
                    'Bimbingan Masyarakat',
                    'Layanan Penjagaan Kljen',
                    'Rujukan',
                ],
                'Program Promosi' => [
                    'Internal PuspaGa',
                    'Bersama Jejaring Mitra',
                ],
                'Rapat/Koordinasi' => [
                    'Koordinasi Internal',
                    'Koordinasi Eksternal',
                ],
            ];

            foreach ($data as $programName => $jenisList) {
                $programId = $programs[$programName];
                foreach ($jenisList as $jenis) {
                    DB::table('m_jenis_kegiatan')->insert([
                        'id_program_kegiatan' => $programId,
                        'name'                => $jenis,
                        'is_active'           => true,
                        'created_at'          => now(),
                        'updated_at'          => now(),
                    ]);
                }
            }

            DB::commit();
        } catch (\Exception $ex) {
            DB::rollBack();
            echo $ex->getMessage();
        }
    }
}
