<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            MInstansiPendidikanSeeder::class,
            MJabatanDalamInstansiSeeder::class,
            MKedudukanDalamTimSeeder::class,
            MSumberKeluhanTableSeeder::class,
            MLokasiKejadianTableSeeder::class,
            MAgamaTableSeeder::class,
            MHubunganTableSeeder::class,
            MKabupatenTableSeeder::class,
            MStatusPernikahanTableSeeder::class,
            MPendidikanTerakhirTableSeeder::class,
            MRoleTableSeeder::class,
            MUserTableSeeder::class,
            StatusTableSeeder::class,
            MLayananTableSeeder::class,
            MKebutuhanTableSeeder::class,
            MKategoriMitraSeeder::class,
            KuesionerLaporanMonevSeeder::class,
            MJasaPelayananSeeder::class,
        ]);
    }
}
