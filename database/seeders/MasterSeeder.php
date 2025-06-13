<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use \DB;
use Faker\Factory as Faker;
use App\Models\MTipePermasalahan;
use App\Models\MKategoriKasus;
use App\Models\MJenisKasus;
use App\Models\MKabupaten;
use App\Models\MKecamatan;
use App\Models\MKelurahan;

class MasterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('id_ID');
        $faker2 = Faker::create();

        try {
            DB::beginTransaction();

            $agama = [
                [
                    'id' => 1,
                    'name' => 'Islam',
                ],
                [
                    'id' => 2,
                    'name' => 'Kristen Protestan',
                ],
                [
                    'id' => 3,
                    'name' => 'Kristen Katolik',
                ],
                [
                    'id' => 4,
                    'name' => 'Islam KTP',
                ],
                [
                    'id' => 5,
                    'name' => 'Konghucu',
                ]
            ];
            foreach ($agama as $key => $value) {
                DB::table('m_agama')->updateOrInsert(['id' => $value['id']], [
                    'name' => $value['name'],
                ]);
            }

            $lastId = DB::table('m_agama')->orderBy('id', 'desc')->first();
            if(!empty($lastId))
            {
                $newLastId = $lastId->id + 1;
                DB::update(DB::raw("ALTER SEQUENCE m_agama_id_seq RESTART WITH {$newLastId}"));
            }

            $wilayah = [
                [
                    'id' => 1,
                    'name' => 'Luar Surabaya',
                ],
                [
                    'id' => 2,
                    'name' => 'Surabaya Barat',
                ],
                [
                    'id' => 3,
                    'name' => 'Surabaya Timur',
                ],
                [
                    'id' => 4,
                    'name' => 'Surabaya Utara',
                ],
                [
                    'id' => 5,
                    'name' => 'Surabaya Selatan',
                ],
                [
                    'id' => 6,
                    'name' => 'Surabaya Pusat',
                ],
            ];
            foreach ($wilayah as $key => $value) {
                DB::table('m_wilayah')->updateOrInsert(['id' => $value['id']], [
                    'name' => $value['name'],
                ]);
            }

            $lastId = DB::table('m_wilayah')->orderBy('id', 'desc')->first();
            if(!empty($lastId))
            {
                $newLastId = $lastId->id + 1;
                DB::update(DB::raw("ALTER SEQUENCE m_wilayah_id_seq RESTART WITH {$newLastId}"));
            }
            
            for($i = 1; $i <= 10; $i++){
                DB::table('m_hubungan')->updateOrInsert(['id' => $i], [
                    'name' => $faker->word
                ]);
                DB::table('m_sumber_keluhan')->updateOrInsert(['id' => $i], [
                    'name' => $faker->word
                ]);

                $permasalahan = MTipePermasalahan::updateOrCreate(['id' => $i], [
                    'name' => $faker->word,
                ]);
                $kategoriKasus = MKategoriKasus::updateOrCreate(['id' => $i], [
                    'id_tipe_permasalahan' => $permasalahan->id,
                    'name' => $faker->word,
                ]);
                $jenisKasus = MJenisKasus::updateOrCreate(['id' => $i], [
                    'id_kategori_kasus' => $kategoriKasus->id,
                    'name' => $faker->word,
                ]);

                DB::table('m_lokasi_kejadian')->updateOrInsert(['id' => $i], [
                    'name' => $faker->word
                ]);
                DB::table('m_status_pernikahan')->updateOrInsert(['id' => $i], [
                    'name' => $faker->word
                ]);
                DB::table('m_pekerjaan')->updateOrInsert(['id' => $i], [
                    'name' => $faker2->jobTitle,
                ]);
                DB::table('m_pendidikan_terakhir')->updateOrInsert(['id' => $i], [
                    'name' => $faker->word
                ]);
                DB::table('m_jurusan')->updateOrInsert(['id' => $i], [
                    'name' => $faker->word
                ]);

                $kabupaten = MKabupaten::updateOrCreate(['id' => $i], [
                    'name' => $faker->city,
                ]);
                $kecamatan = MKecamatan::updateOrCreate(['id' => $i], [
                    'name' => $faker->streetName,
                    'id_kabupaten' => $faker->numberBetween(1, $i),
                    'id_wilayah' => $faker->numberBetween(1, count($wilayah))
                ]);
                $kelurahan = MKelurahan::updateOrCreate(['id' => $i], [
                    'name' => $faker->streetName,
                    'id_kecamatan' => $faker->numberBetween(1, $i),
                ]);

                DB::table('m_opd')->updateOrInsert(['id' => $i], [
                    'name' => $faker->words(rand(2, 5), true),
                    'pic_name' => $faker->name,
                    'pic_number' => $faker->e164PhoneNumber,
                ]);
                DB::table('m_intervensi')->updateOrInsert(['id' => $i], [
                    'name' => $faker->words(rand(2, 4), true),
                    'id_opd' => $faker->numberBetween(1, $i),
                ]);
                DB::table('m_konselor')->updateOrInsert(['id' => $i], [
                    'name' => $faker->name,
                    'phone_number' => $faker->e164PhoneNumber,
                ]);
            }

            $lastId = DB::table('m_hubungan')->orderBy('id', 'desc')->first();
            if(!empty($lastId))
            {
                $newLastId = $lastId->id + 1;
                DB::update(DB::raw("ALTER SEQUENCE m_hubungan_id_seq RESTART WITH {$newLastId}"));
            }

            $lastId = DB::table('m_sumber_keluhan')->orderBy('id', 'desc')->first();
            if(!empty($lastId))
            {
                $newLastId = $lastId->id + 1;
                DB::update(DB::raw("ALTER SEQUENCE m_sumber_keluhan_id_seq RESTART WITH {$newLastId}"));
            }

            $lastId = DB::table('m_tipe_permasalahan')->orderBy('id', 'desc')->first();
            if(!empty($lastId))
            {
                $newLastId = $lastId->id + 1;
                DB::update(DB::raw("ALTER SEQUENCE m_tipe_permasalahan_id_seq RESTART WITH {$newLastId}"));
            }

            $lastId = DB::table('m_kategori_kasus')->orderBy('id', 'desc')->first();
            if(!empty($lastId))
            {
                $newLastId = $lastId->id + 1;
                DB::update(DB::raw("ALTER SEQUENCE m_kategori_kasus_id_seq RESTART WITH {$newLastId}"));
            }

            $lastId = DB::table('m_jenis_kasus')->orderBy('id', 'desc')->first();
            if(!empty($lastId))
            {
                $newLastId = $lastId->id + 1;
                DB::update(DB::raw("ALTER SEQUENCE m_jenis_kasus_id_seq RESTART WITH {$newLastId}"));
            }

            $lastId = DB::table('m_lokasi_kejadian')->orderBy('id', 'desc')->first();
            if(!empty($lastId))
            {
                $newLastId = $lastId->id + 1;
                DB::update(DB::raw("ALTER SEQUENCE m_lokasi_kejadian_id_seq RESTART WITH {$newLastId}"));
            }

            $lastId = DB::table('m_status_pernikahan')->orderBy('id', 'desc')->first();
            if(!empty($lastId))
            {
                $newLastId = $lastId->id + 1;
                DB::update(DB::raw("ALTER SEQUENCE m_status_pernikahan_id_seq RESTART WITH {$newLastId}"));
            }

            $lastId = DB::table('m_pekerjaan')->orderBy('id', 'desc')->first();
            if(!empty($lastId))
            {
                $newLastId = $lastId->id + 1;
                DB::update(DB::raw("ALTER SEQUENCE m_pekerjaan_id_seq RESTART WITH {$newLastId}"));
            }

            $lastId = DB::table('m_pendidikan_terakhir')->orderBy('id', 'desc')->first();
            if(!empty($lastId))
            {
                $newLastId = $lastId->id + 1;
                DB::update(DB::raw("ALTER SEQUENCE m_pendidikan_terakhir_id_seq RESTART WITH {$newLastId}"));
            }

            $lastId = DB::table('m_jurusan')->orderBy('id', 'desc')->first();
            if(!empty($lastId))
            {
                $newLastId = $lastId->id + 1;
                DB::update(DB::raw("ALTER SEQUENCE m_jurusan_id_seq RESTART WITH {$newLastId}"));
            }

            $lastId = DB::table('m_kabupaten')->orderBy('id', 'desc')->first();
            if(!empty($lastId))
            {
                $newLastId = $lastId->id + 1;
                DB::update(DB::raw("ALTER SEQUENCE m_kabupaten_id_seq RESTART WITH {$newLastId}"));
            }

            $lastId = DB::table('m_kecamatan')->orderBy('id', 'desc')->first();
            if(!empty($lastId))
            {
                $newLastId = $lastId->id + 1;
                DB::update(DB::raw("ALTER SEQUENCE m_kecamatan_id_seq RESTART WITH {$newLastId}"));
            }

            $lastId = DB::table('m_kelurahan')->orderBy('id', 'desc')->first();
            if(!empty($lastId))
            {
                $newLastId = $lastId->id + 1;
                DB::update(DB::raw("ALTER SEQUENCE m_kelurahan_id_seq RESTART WITH {$newLastId}"));
            }

            $lastId = DB::table('m_opd')->orderBy('id', 'desc')->first();
            if(!empty($lastId))
            {
                $newLastId = $lastId->id + 1;
                DB::update(DB::raw("ALTER SEQUENCE m_opd_id_seq RESTART WITH {$newLastId}"));
            }

            $lastId = DB::table('m_intervensi')->orderBy('id', 'desc')->first();
            if(!empty($lastId))
            {
                $newLastId = $lastId->id + 1;
                DB::update(DB::raw("ALTER SEQUENCE m_intervensi_id_seq RESTART WITH {$newLastId}"));
            }

            $lastId = DB::table('m_konselor')->orderBy('id', 'desc')->first();
            if(!empty($lastId))
            {
                $newLastId = $lastId->id + 1;
                DB::update(DB::raw("ALTER SEQUENCE m_konselor_id_seq RESTART WITH {$newLastId}"));
            }
            
            DB::commit();
        } catch (\Exception $ex) {
            DB::rollBack();
            echo $ex->getMessage();
        }
    }
}
