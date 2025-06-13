<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use \DB;

class MSumberKeluhanTableSeeder extends Seeder
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
            $data = [1 => "SUARA SURABAYA","JAWA POS","SATPOL PP","RADAR SURABAYA","SURYA","KECAMATAN","DISPOSISI SURAT","TEMUAN WALIKOTA","TARUNA WALIKOTA","COMMAND CENTER","HOTLINE PPTP2A","LSM / JEJARING","TATAP MUKA","PUSPAGA","POLSEK","POLRESTABES","POLRES KP3 TJ PERAK","POLDA JATIM","KEJARI SURABAYA","KEJAKSAAN TJ. PERAK","KEJAKSAAN SUKOMANUNGGAL","BNN","PUSKESMAS","OPD","ASISTEN","KELURAHAN","WARGA","SEKOLAH","KEMENTRIAN PPA","KPAI","DP3A JATIM","APLIKASI WARGAKU","DPRD","UPT PPA JATIM","DEWAN PENDIDIKAN","DETIK","SOSIAL MEDIA","SAPA WARGA","BAKSOS","LAINNYA"];

            foreach ($data as $key => $value) {
                DB::table('m_sumber_keluhan')->updateOrInsert(['id' => $key], [
                    'name' => $value,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ]);
            }

            $lastId = DB::table('m_sumber_keluhan')->orderBy('id', 'desc')->first();
            if(!empty($lastId))
            {
                $newLastId = $lastId->id + 1;
                DB::update(DB::raw("ALTER SEQUENCE m_sumber_keluhan_id_seq RESTART WITH {$newLastId}"));
            }

            DB::commit();
        } catch (\Exception $ex) {
            DB::rollBack();
            echo $ex->getMessage();
        }
    }
}
