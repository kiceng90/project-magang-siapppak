<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Date;

class MKegiatanPuspagaSeeder extends Seeder
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
            // Ambil semua id dari tabel terkait
            $programIds = DB::table('m_program_kegiatan')->pluck('id');
            $jenisIds = DB::table('m_jenis_kegiatan')->pluck('id');
            $bentukIds = DB::table('m_bentuk_kegiatan')->pluck('id');

            if ($programIds->isEmpty() || $jenisIds->isEmpty() || $bentukIds->isEmpty()) {
                throw new \Exception("Data master tidak ditemukan. Pastikan seeder m_program_kegiatan, m_jenis_kegiatan, dan m_bentuk_kegiatan sudah dijalankan.");
            }

            $data = [
                [
                    'id_program_kegiatan' => $programIds->random(),
                    'id_jenis_kegiatan' => $jenisIds->random(),
                    'id_bentuk_kegiatan' => $bentukIds->random(),
                    'tanggal_kegiatan' => Date::today()->addDays(rand(1, 30)),
                    'jam_kegiatan' => '09:00',
                    'jenis_kelas' => 'online',
                    'link_kelas' => 'https://zoom.us/j/1234567890', 
                    'judul_kegiatan' => 'Parenting Class: Komunikasi Efektif dengan Anak',
                    'sasaran_kegiatan' => 'Orang tua dengan anak usia 3-12 tahun',
                    'tempat_kegiatan' => null,
                    'narasumber' => 'Dr. Maya Putri, M.Psi',
                    'is_active' => true,
                ],
                [
                    'id_program_kegiatan' => $programIds->random(),
                    'id_jenis_kegiatan' => $jenisIds->random(),
                    'id_bentuk_kegiatan' => $bentukIds->random(),
                    'tanggal_kegiatan' => Date::today()->addDays(rand(1, 30)),
                    'jam_kegiatan' => '13:00',
                    'jenis_kelas' => 'offline',
                    'link_kelas' => null,
                    'judul_kegiatan' => 'Workshop Teknik Fasilitasi Kelompok Ibu Hamil',
                    'sasaran_kegiatan' => 'Kader PKK dan Bidan Desa',
                    'tempat_kegiatan' => 'Aula Kantor Kelurahan Sukodono',
                    'narasumber' => 'Siti Aminah, S.ST., MPH',
                    'is_active' => true,
                ],
                [
                    'id_program_kegiatan' => $programIds->random(),
                    'id_jenis_kegiatan' => $jenisIds->random(),
                    'id_bentuk_kegiatan' => $bentukIds->random(),
                    'tanggal_kegiatan' => Date::today()->addDays(rand(1, 30)),
                    'jam_kegiatan' => '10:00',
                    'jenis_kelas' => 'online',
                    'link_kelas' => 'https://meet.google.com/abc-def-ghi', 
                    'judul_kegiatan' => 'Edukasi Gizi Balita',
                    'sasaran_kegiatan' => 'Ibu menyusui dan balita',
                    'tempat_kegiatan' => null,
                    'narasumber' => 'Rina Kartika, S.Gz',
                    'is_active' => true,
                ],
            ];

            foreach ($data as $kegiatan) {
                DB::table('m_kegiatan_puspaga')->insert($kegiatan);
            }

            // Update sequence jika pakai PostgreSQL
            $lastId = DB::table('m_kegiatan_puspaga')->orderBy('id', 'desc')->first();
            if (!empty($lastId)) {
                $newLastId = $lastId->id + 1;
                DB::update(DB::raw("ALTER SEQUENCE m_kegiatan_puspaga_id_seq RESTART WITH {$newLastId}"));
            }

            DB::commit();
        } catch (\Exception $ex) {
            DB::rollBack();
            echo $ex->getMessage();
        }
    }
}
