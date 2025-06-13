<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MJabatanDalamInstansi;
use DB;

class MJabatanDalamInstansiSeeder extends Seeder
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

            $data = ["Camat","Kepala Kepolisian Sektor","Kepala Komando Rayon Militer","Lurah","Bhayangkara Pembina Keamanan Ketertiban Masyarakat (Bhabinkamtibmas)","Bintara Pembina Desa (Babinsa)","Ketua RW","Koordinator Relawan Satuan Tugas Pusat Krisis Berbasis Masyarakat (Satgas PKBM)","Ketua RT","Unsur Pengurus RW/RT","Unsur Kader Tim Penggerak Pemberdayaan Kesejahteraan Keluarga (TP PKK) ","Unsur Kader Surabaya Hebat (KSH)","Unsur Relawan Pusat Krisis Berbasis Masyarakat (PKBM)","Unsur Relawan Satuan Tugas Perlindungan Perempuan dan Anak (SATGAS PPA)","Unsur Karang Taruna"];
            foreach($data as $key => $val){
                MJabatanDalamInstansi::updateOrCreate(['id' => $key +1], [
                    'name' => $val,
                ]);
            }

            $lastId = DB::table('m_jabatan_dalam_instansi')->orderBy('id', 'desc')->first();
            if(!empty($lastId))
            {
                $newLastId = $lastId->id + 1;
                DB::update(DB::raw("ALTER SEQUENCE m_jabatan_dalam_instansi_id_seq RESTART WITH {$newLastId}"));
            }

            DB::commit();
        } catch (\Exception $ex) {
            DB::rollBack();
            echo $ex->getMessage();
        }
    }
}
