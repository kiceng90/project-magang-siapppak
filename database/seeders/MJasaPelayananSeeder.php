<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use \DB;

class MJasaPelayananSeeder extends Seeder
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
            $data = [1 => "Ketua Lembaga Pemberdayaan Masyarakat Kelurahan","Ketua Rukun Warga", "Ketua Rukun Tetangga", "Penghafal Al-Qur’an", "Modin Perawat Jenazah", "Petugas Makam Desa", "Petugas Penjaga Makam Cagar Budaya/Bangunan Cagar Budaya", "Tenaga Pendidik Keagamaan", "Tenaga Pendidik Kesetaraan", 
            "Tenaga Pendidik PAUD dan Taman Kanak-Kanak (TK)/Kelompok Bermain (KB)/Taman penitipan Anak (TPA)/Satuan Paud Sejenis (SPS)/Raudhatul Athfal (RA)", "Tenaga Pendidik yang belum mendapatkan sertifikasi dan/atau tunjangan fungsional dari Pemerintah", 
            "Tenaga Pendidik Sekolah Luar Biasa", "Tenaga Pendidik dan Kependidikan Sekolah Formal Jenjang Pendidikan Dasar, Menengah, Kejuruan Dan Sederajat yang diselenggarakan oleh Masyarakat atau Pemerintah", 
            "Ketua Karang Werda", "Ketua Panti Asuhan", "Ketua Ikatan Pekerja Sosial Masyarakat di Kelurahan", "Veteran", "Kader Surabaya Hebat" ];

            foreach ($data as $key => $value) {
                DB::table('m_jasa_pelayanan')->updateOrInsert(['id' => $key], [
                    'name' => $value,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ]);
            }

            $lastId = DB::table('m_jasa_pelayanan')->orderBy('id', 'desc')->first();
            if(!empty($lastId))
            {
                $newLastId = $lastId->id + 1;
                DB::update(DB::raw("ALTER SEQUENCE m_jasa_pelayanan_id_seq RESTART WITH {$newLastId}"));
            }

            DB::commit();
        } catch (\Exception $ex) {
            DB::rollBack();
            echo $ex->getMessage();
        }
    }
}
