<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MBentukKegiatanSeeder extends Seeder
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
            // Ambil ID jenis kegiatan terlebih dahulu
            $jenisKegiatans = DB::table('m_jenis_kegiatan')->pluck('id', 'name');

            $data = [
                'Kelas Calon Pengantin' => [
                    'Kelas Calon Pengantin',
                ],
                'Kegiatan Penyadaran' => [
                    'Training of Trainer / Bimbingan Teknik Fasilitator',
                    'Capacity Building',
                    'Webinar Kelas Parenting',
                    'Talkshow / Podcast',
                    'Konsultasi/Konseling',
                    'Instagram Live',
                    'Kelas Inspirasi',
                    'Media Sosial',
                    'Kelas Parenting Bersama POKJA PAUD',
                    'Kelas Parenting Ayah',
                    'Puspaga Goes to School',
                ],
                'Bimbingan Masyarakat' => [
                    'Sekolah Orang Tua Hebat (SOTH)',
                    'Musrenbang',
                    'Kelurahan Ramah Perempuan dan Peduli Anak (KRPPA)',
                    'Edukasi/Sosialisasi / Parenting',
                    'Sambar Warga',
                ],
                'Layanan Penjagaan Kljen' => [
                    'penjangkauan klien'
                ],
                'Rujukan' => [
                    'Rujukan Klien',
                ],
                'Internal PuspaGa' => [
                    'Poster 32 Hak Anak Puspaga RW',
                    'Media Sosial',
                ],
                'Bersama Jejaring Mitra' => [
                    'Surabaya Great Expo',
                    'Duta Tantribum',
                    'Cangkruan Areek Surobatyo (CAS)',
                ],
                'Koordinasi Internal' => [
                    'Rapat',
                    
                ],
                'Koordinasi Eksternal' => [
                    'Audit',
                    'Monitoring / Evaluasi',
                ],
            ];

            foreach ($data as $jenisKegiatanName => $bentukList) {
                $jenisKegiatanId = $jenisKegiatans[$jenisKegiatanName];
                foreach ($bentukList as $bentuk) {
                    DB::table('m_bentuk_kegiatan')->insert([
                        'id_jenis_kegiatan' => $jenisKegiatanId,
                        'name'              => $bentuk,
                        'is_active'         => true,
                        'created_at'        => now(),
                        'updated_at'        => now(),
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
