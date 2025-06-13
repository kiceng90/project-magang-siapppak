<?php

namespace Database\Seeders;

use App\Enums\LaporanMonevKuesionerInputTypeEnum;
use App\Models\MKategoriLaporanMonev;
use App\Models\MKuesionerLaporanMonev;
use App\Models\MSubKategoriLaporanMonev;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KuesionerLaporanMonevSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        try{
            DB::beginTransaction();
            // TODO : Generate untuk pertanyaan kuesioner laporan monev dan kategorinya
            $kategori_arr = [
                [
                    'id' => 1,
                    'name' => 'Kelembagaan',
                    'order' => 1,
                    'sub' => [
                        [
                            'id' => 1,
                            'name' => 'Administrasi Pendukung',
                            'order' => 1,
                            'kuesioner' => [
                                [
                                    'id' => 1,
                                    'key' => 'has_sk_pembentukan',
                                    'question' => 'SK Pembentukan PUSPAGA Balai RW',
                                    'input_type' => LaporanMonevKuesionerInputTypeEnum::RADIO,
                                    'input_options' => json_encode([
                                        [
                                            'label' => 'Ada',
                                            'value' => 'ada'
                                        ],
                                        [
                                            'label' => 'Tidak Ada',
                                            'value' => 'tidak ada'
                                        ],
                                    ]),
                                    'validation_rules' => 'required|string',
                                    'order' => 1
                                ],
                                [
                                    'id' => 2,
                                    'key' => 'has_surat_perintah',
                                    'question' => 'Surat Perintah Tugas dari Kecamatan',
                                    'input_type' => LaporanMonevKuesionerInputTypeEnum::RADIO,
                                    'input_options' => json_encode([
                                        [
                                            'label' => 'Ada',
                                            'value' => 'ada'
                                        ],
                                        [
                                            'label' => 'Tidak Ada',
                                            'value' => 'tidak ada'
                                        ],
                                    ]),
                                    'validation_rules' => 'required|string',
                                    'order' => 2
                                ],
                                [
                                    'id' => 3,
                                    'key' => 'has_alur_pelayanan',
                                    'question' => 'Alur Pelayanan Puspaga Balai RW',
                                    'input_type' => LaporanMonevKuesionerInputTypeEnum::RADIO,
                                    'input_options' => json_encode([
                                        [
                                            'label' => 'Ada',
                                            'value' => 'ada'
                                        ],
                                        [
                                            'label' => 'Tidak Ada',
                                            'value' => 'tidak ada'
                                        ],
                                    ]),
                                    'validation_rules' => 'required|string',
                                    'order' => 3
                                ],
                            ]
                        ],
                        [
                            'id' => 2,
                            'name' => 'Program Kegiatan',
                            'order' => 2,
                            'kuesioner' => [
                                [
                                    'id' => 4,
                                    'key' => 'has_program_sosialisasi',
                                    'question' => 'Program/Kegiatan Sosialisasi di Puspaga Balai RW',
                                    'input_type' => LaporanMonevKuesionerInputTypeEnum::RADIO,
                                    'input_options' => json_encode([
                                        [
                                            'label' => 'Ada',
                                            'value' => 'ada'
                                        ],
                                        [
                                            'label' => 'Tidak Ada',
                                            'value' => 'tidak ada'
                                        ],
                                    ]),
                                    'validation_rules' => 'required|string',
                                    'order' => 1
                                ],
                                [
                                    'id' => 5,
                                    'key' => 'has_materi_sosialisasi',
                                    'question' => 'Memiliki Materi Sosialisasi / Edukasi',
                                    'input_type' => LaporanMonevKuesionerInputTypeEnum::RADIO,
                                    'input_options' => json_encode([
                                        [
                                            'label' => 'Ada',
                                            'value' => 'ada'
                                        ],
                                        [
                                            'label' => 'Tidak Ada',
                                            'value' => 'tidak ada'
                                        ],
                                    ]),
                                    'validation_rules' => 'required|string',
                                    'order' => 2
                                ],
                            ]
                        ],
                        [
                            'id' => 3,
                            'name' => 'Pemanfaatan Balai RW',
                            'order' => 3,
                            'kuesioner' => [
                                [
                                    'id' => 6,
                                    'key' => 'has_only_puspaga',
                                    'question' => 'Hanya Puspaga RW',
                                    'input_type' => LaporanMonevKuesionerInputTypeEnum::RADIO,
                                    'input_options' => json_encode([
                                        [
                                            'label' => 'Ada',
                                            'value' => 'ada'
                                        ],
                                        [
                                            'label' => 'Tidak Ada',
                                            'value' => 'tidak ada'
                                        ],
                                    ]),
                                    'validation_rules' => 'required|string',
                                    'order' => 1
                                ],
                                [

                                    'id' => 7,
                                    'key' => 'has_satuan_paud',
                                    'question' => 'Satuan PAUD (TK RW/PPT)',
                                    'input_type' => LaporanMonevKuesionerInputTypeEnum::RADIO,
                                    'input_options' => json_encode([
                                        [
                                            'label' => 'Ada',
                                            'value' => 'ada'
                                        ],
                                        [
                                            'label' => 'Tidak Ada',
                                            'value' => 'tidak ada'
                                        ],
                                    ]),
                                    'validation_rules' => 'required|string',
                                    'order' => 2
                                ],
                                [
                                    'id' => 8,
                                    'key' => 'has_tpq',
                                    'question' => 'TPQ',
                                    'input_type' => LaporanMonevKuesionerInputTypeEnum::RADIO,
                                    'input_options' => json_encode([
                                        [
                                            'label' => 'Ada',
                                            'value' => 'ada'
                                        ],
                                        [
                                            'label' => 'Tidak Ada',
                                            'value' => 'tidak ada'
                                        ],
                                    ]),
                                    'validation_rules' => 'required|string',
                                    'order' => 3
                                ],
                                [
                                    'id' => 9,
                                    'key' => 'has_kegiatan_olahraga',
                                    'question' => 'Kegiatan Olahraga',
                                    'input_type' => LaporanMonevKuesionerInputTypeEnum::RADIO,
                                    'input_options' => json_encode([
                                        [
                                            'label' => 'Ada',
                                            'value' => 'ada'
                                        ],
                                        [
                                            'label' => 'Tidak Ada',
                                            'value' => 'tidak ada'
                                        ],
                                    ]),
                                    'validation_rules' => 'required|string',
                                    'order' => 4
                                ],
                                [
                                    'id' => 10,
                                    'key' => 'has_pertemuan_rutin',
                                    'question' => 'Pertemuan Rutin',
                                    'input_type' => LaporanMonevKuesionerInputTypeEnum::RADIO,
                                    'input_options' => json_encode([
                                        [
                                            'label' => 'Ada',
                                            'value' => 'ada'
                                        ],
                                        [
                                            'label' => 'Tidak Ada',
                                            'value' => 'tidak ada'
                                        ],
                                    ]),
                                    'validation_rules' => 'required|string',
                                    'order' => 5
                                ],
                                [
                                    'id' => 11,
                                    'key' => 'has_pengajian',
                                    'question' => 'Pengajian',
                                    'input_type' => LaporanMonevKuesionerInputTypeEnum::RADIO,
                                    'input_options' => json_encode([
                                        [
                                            'label' => 'Ada',
                                            'value' => 'ada'
                                        ],
                                        [
                                            'label' => 'Tidak Ada',
                                            'value' => 'tidak ada'
                                        ],
                                    ]),
                                    'validation_rules' => 'required|string',
                                    'order' => 6
                                ],
                                [
                                    'id' => 12,
                                    'key' => 'other',
                                    'question' => 'Lainnya',
                                    'input_type' => LaporanMonevKuesionerInputTypeEnum::TEXT,
                                    'validation_rules' => 'required|string',
                                    'order' => 7
                                ],
                            ]
                        ],
                    ],
                ],
                [
                    'id' => 2,
                    'name' => 'Pelaksanaan Layanan PUSPAGA Balai RW',
                    'order' => 2,
                    'sub' => [
                        [
                            'id' => 4,
                            'name' => 'Layanan Puspaga Balai RW',
                            'order' => 1,
                            'kuesioner' => [

                                [
                                    'id' => 13,
                                    'key' => 'has_konseling',
                                    'question' => 'Apakah dilaksanakan Kegiatan Konseling/Konsultasi PUSPAGA Balai RW dalam 1 minggu terakhir?',
                                    'input_type' => LaporanMonevKuesionerInputTypeEnum::RADIO,
                                    'input_options' => json_encode([
                                        [
                                            'label' => 'Ya',
                                            'value' => 'ya'
                                        ],
                                        [
                                            'label' => 'Tidak',
                                            'value' => 'tidak'
                                        ],
                                    ]),
                                    'validation_rules' => 'required|string',
                                    'order' => 1
                                ],
                                [
                                    'id' => 14,
                                    'key' => 'has_sosialisasi',
                                    'question' => 'Apakah dilaksanakan Kegiatan Sosialisasi / Parenting / Pembelajaran Keluarga / Promosi / Edukasi dalam 1 minggu terakhir ?',
                                    'input_type' => LaporanMonevKuesionerInputTypeEnum::RADIO,
                                    'input_options' => json_encode([
                                        [
                                            'label' => 'Ya',
                                            'value' => 'ya'
                                        ],
                                        [
                                            'label' => 'Tidak',
                                            'value' => 'tidak'
                                        ],
                                    ]),
                                    'validation_rules' => 'required|string',
                                    'order' => 2
                                ],
                                [
                                    'id' => 15,
                                    'key' => 'has_rapat',
                                    'question' => 'Apakah dilaksanakan Kegiatan Rapat / Koordinasi dalam 1 minggu terakhir ?',
                                    'input_type' => LaporanMonevKuesionerInputTypeEnum::RADIO,
                                    'input_options' => json_encode([
                                        [
                                            'label' => 'Ya',
                                            'value' => 'ya'
                                        ],
                                        [
                                            'label' => 'Tidak',
                                            'value' => 'tidak'
                                        ],
                                    ]),
                                    'validation_rules' => 'required|string',
                                    'order' => 3
                                ],
                            ]
                        ]
                    ]
                ],
                [
                    'id' => 3,
                    'name' => 'Sarana dan Prasarana PUSPAGA Balai RW',
                    'order' => 3,
                    'sub' => [
                        [
                            'id' => 5,
                            'name' => 'Media Promosi',
                            'order' => 1,
                            'kuesioner' => [
                                [
                                    'id' => 16,
                                    'key' => 'has_spanduk',
                                    'question' => 'Papan Nama/Spanduk',
                                    'input_type' => LaporanMonevKuesionerInputTypeEnum::RADIO,
                                    'input_options' => json_encode([
                                        [
                                            'label' => 'Ada',
                                            'value' => 'ada'
                                        ],
                                        [
                                            'label' => 'Tidak Ada',
                                            'value' => 'tidak ada'
                                        ],
                                    ]),
                                    'validation_rules' => 'required|string',
                                    'order' => 1
                                ],
                                [
                                    'id' => 17,
                                    'key' => 'has_roll_banner',
                                    'question' => 'X Banner / Roll Banner',
                                    'input_type' => LaporanMonevKuesionerInputTypeEnum::RADIO,
                                    'input_options' => json_encode([
                                        [
                                            'label' => 'Ada',
                                            'value' => 'ada'
                                        ],
                                        [
                                            'label' => 'Tidak Ada',
                                            'value' => 'tidak ada'
                                        ],
                                    ]),
                                    'validation_rules' => 'required|string',
                                    'order' => 2
                                ],
                                [
                                    'id' => 18,
                                    'key' => 'has_flyer',
                                    'question' => 'Flyer/Brosur/Leafleat/Poster',
                                    'input_type' => LaporanMonevKuesionerInputTypeEnum::RADIO,
                                    'input_options' => json_encode([
                                        [
                                            'label' => 'Ada',
                                            'value' => 'ada'
                                        ],
                                        [
                                            'label' => 'Tidak Ada',
                                            'value' => 'tidak ada'
                                        ],
                                    ]),
                                    'validation_rules' => 'required|string',
                                    'order' => 3
                                ],
                                [
                                    'id' => 19,
                                    'key' => 'has_id_card',
                                    'question' => 'Rompi Petugas/ID Card',
                                    'input_type' => LaporanMonevKuesionerInputTypeEnum::RADIO,
                                    'input_options' => json_encode([
                                        [
                                            'label' => 'Ada',
                                            'value' => 'ada'
                                        ],
                                        [
                                            'label' => 'Tidak Ada',
                                            'value' => 'tidak ada'
                                        ],
                                    ]),
                                    'validation_rules' => 'required|string',
                                    'order' => 4
                                ],
                            ]
                        ],
                        [
                            'id' => 6,
                            'name' => 'Dokumen Administrasi',
                            'order' => 2,
                            'kuesioner' => [
                                [
                                    'id' => 20,
                                    'key' => 'has_guest_book',
                                    'question' => 'Buku Tamu',
                                    'input_type' => LaporanMonevKuesionerInputTypeEnum::RADIO,
                                    'input_options' => json_encode([
                                        [
                                            'label' => 'Ada',
                                            'value' => 'ada'
                                        ],
                                        [
                                            'label' => 'Tidak Ada',
                                            'value' => 'tidak ada'
                                        ],
                                    ]),
                                    'validation_rules' => 'required|string',
                                    'order' => 1
                                ],
                                [
                                    'id' => 21,
                                    'key' => 'has_sosialisasi_book',
                                    'question' => 'Buku Sosialisasi',
                                    'input_type' => LaporanMonevKuesionerInputTypeEnum::RADIO,
                                    'input_options' => json_encode([
                                        [
                                            'label' => 'Ada',
                                            'value' => 'ada'
                                        ],
                                        [
                                            'label' => 'Tidak Ada',
                                            'value' => 'tidak ada'
                                        ],
                                    ]),
                                    'validation_rules' => 'required|string',
                                    'order' => 2
                                ],
                                [
                                    'id' => 22,
                                    'key' => 'has_konsultasi_book',
                                    'question' => 'Buku Konsultasi',
                                    'input_type' => LaporanMonevKuesionerInputTypeEnum::RADIO,
                                    'input_options' => json_encode([
                                        [
                                            'label' => 'Ada',
                                            'value' => 'ada'
                                        ],
                                        [
                                            'label' => 'Tidak Ada',
                                            'value' => 'tidak ada'
                                        ],
                                    ]),
                                    'validation_rules' => 'required|string',
                                    'order' => 3
                                ],
                                [
                                    'id' => 23,
                                    'key' => 'has_surat_consent',
                                    'question' => 'Surat Pernyataan kesediaan Klien (Informed Consent)',
                                    'input_type' => LaporanMonevKuesionerInputTypeEnum::RADIO,
                                    'input_options' => json_encode([
                                        [
                                            'label' => 'Ada',
                                            'value' => 'ada'
                                        ],
                                        [
                                            'label' => 'Tidak Ada',
                                            'value' => 'tidak ada'
                                        ],
                                    ]),
                                    'validation_rules' => 'required|string',
                                    'order' => 4
                                ],
                                [
                                    'id' => 24,
                                    'key' => 'has_konseling_form',
                                    'question' => 'Formulir Layanan Konseling',
                                    'input_type' => LaporanMonevKuesionerInputTypeEnum::RADIO,
                                    'input_options' => json_encode([
                                        [
                                            'label' => 'Ada',
                                            'value' => 'ada'
                                        ],
                                        [
                                            'label' => 'Tidak Ada',
                                            'value' => 'tidak ada'
                                        ],
                                    ]),
                                    'validation_rules' => 'required|string',
                                    'order' => 5
                                ],
                                [
                                    'id' => 25,
                                    'key' => 'has_bac_klien',
                                    'question' => 'Berita Acara Pendampingan Klien',
                                    'input_type' => LaporanMonevKuesionerInputTypeEnum::RADIO,
                                    'input_options' => json_encode([
                                        [
                                            'label' => 'Ada',
                                            'value' => 'ada'
                                        ],
                                        [
                                            'label' => 'Tidak Ada',
                                            'value' => 'tidak ada'
                                        ],
                                    ]),
                                    'validation_rules' => 'required|string',
                                    'order' => 6
                                ],
                                [
                                    'id' => 26,
                                    'key' => 'has_selesai_pendampingan',
                                    'question' => 'Surat Pernyataan Telah Selesai Dilaksanakan Pendampingan',
                                    'input_type' => LaporanMonevKuesionerInputTypeEnum::RADIO,
                                    'input_options' => json_encode([
                                        [
                                            'label' => 'Ada',
                                            'value' => 'ada'
                                        ],
                                        [
                                            'label' => 'Tidak Ada',
                                            'value' => 'tidak ada'
                                        ],
                                    ]),
                                    'validation_rules' => 'required|string',
                                    'order' => 7
                                ],
                                [
                                    'id' => 27,
                                    'key' => 'has_surat_rujukan',
                                    'question' => 'Surat Rujukan',
                                    'input_type' => LaporanMonevKuesionerInputTypeEnum::RADIO,
                                    'input_options' => json_encode([
                                        [
                                            'label' => 'Ada',
                                            'value' => 'ada'
                                        ],
                                        [
                                            'label' => 'Tidak Ada',
                                            'value' => 'tidak ada'
                                        ],
                                    ]),
                                    'validation_rules' => 'required|string',
                                    'order' => 8
                                ],
                            ]
                        ],
                        [
                            'id' => 7,
                            'name' => 'Sarana Prasarana',
                            'order' => 3,
                            'kuesioner' => [
                                [
                                    'id' => 28,
                                    'key' => 'has_konseling_room',
                                    'question' => 'Ruang Konseling/Konsultasi',
                                    'input_type' => LaporanMonevKuesionerInputTypeEnum::RADIO,
                                    'input_options' => json_encode([
                                        [
                                            'label' => 'Ada',
                                            'value' => 'ada'
                                        ],
                                        [
                                            'label' => 'Tidak Ada',
                                            'value' => 'tidak ada'
                                        ],
                                    ]),
                                    'validation_rules' => 'required|string',
                                    'order' => 1
                                ],
                                [
                                    'id' => 29,
                                    'key' => 'has_meeting_room',
                                    'question' => 'Ruang Pertemuan',
                                    'input_type' => LaporanMonevKuesionerInputTypeEnum::RADIO,
                                    'input_options' => json_encode([
                                        [
                                            'label' => 'Ada',
                                            'value' => 'ada'
                                        ],
                                        [
                                            'label' => 'Tidak Ada',
                                            'value' => 'tidak ada'
                                        ],
                                    ]),
                                    'validation_rules' => 'required|string',
                                    'order' => 2
                                ],
                                [
                                    'id' => 30,
                                    'key' => 'has_furniture_konseling',
                                    'question' => 'Meja dan Kursi Konseling/Konsultasi',
                                    'input_type' => LaporanMonevKuesionerInputTypeEnum::RADIO,
                                    'input_options' => json_encode([
                                        [
                                            'label' => 'Ada',
                                            'value' => 'ada'
                                        ],
                                        [
                                            'label' => 'Tidak Ada',
                                            'value' => 'tidak ada'
                                        ],
                                    ]),
                                    'validation_rules' => 'required|string',
                                    'order' => 3
                                ],
                                [
                                    'id' => 31,
                                    'key' => 'has_screen_projector',
                                    'question' => 'Screen dan LCD Projector',
                                    'input_type' => LaporanMonevKuesionerInputTypeEnum::RADIO,
                                    'input_options' => json_encode([
                                        [
                                            'label' => 'Ada',
                                            'value' => 'ada'
                                        ],
                                        [
                                            'label' => 'Tidak Ada',
                                            'value' => 'tidak ada'
                                        ],
                                    ]),
                                    'validation_rules' => 'required|string',
                                    'order' => 4
                                ],
                                [
                                    'id' => 32,
                                    'key' => 'has_whiteboard',
                                    'question' => 'Papan Tulis/Whiteboard',
                                    'input_type' => LaporanMonevKuesionerInputTypeEnum::RADIO,
                                    'input_options' => json_encode([
                                        [
                                            'label' => 'Ada',
                                            'value' => 'ada'
                                        ],
                                        [
                                            'label' => 'Tidak Ada',
                                            'value' => 'tidak ada'
                                        ],
                                    ]),
                                    'validation_rules' => 'required|string',
                                    'order' => 5
                                ],
                                [
                                    'id' => 33,
                                    'key' => 'has_laptop',
                                    'question' => 'Laptop/Komputer dan Printer',
                                    'input_type' => LaporanMonevKuesionerInputTypeEnum::RADIO,
                                    'input_options' => json_encode([
                                        [
                                            'label' => 'Ada',
                                            'value' => 'ada'
                                        ],
                                        [
                                            'label' => 'Tidak Ada',
                                            'value' => 'tidak ada'
                                        ],
                                    ]),
                                    'validation_rules' => 'required|string',
                                    'order' => 6
                                ],
                                [
                                    'id' => 34,
                                    'key' => 'has_lemari',
                                    'question' => 'Lemari/Rak Buku',
                                    'input_type' => LaporanMonevKuesionerInputTypeEnum::RADIO,
                                    'input_options' => json_encode([
                                        [
                                            'label' => 'Ada',
                                            'value' => 'ada'
                                        ],
                                        [
                                            'label' => 'Tidak Ada',
                                            'value' => 'tidak ada'
                                        ],
                                    ]),
                                    'validation_rules' => 'required|string',
                                    'order' => 7
                                ],
                                [
                                    'id' => 35,
                                    'key' => 'has_wifi',
                                    'question' => 'Wifi/Internet',
                                    'input_type' => LaporanMonevKuesionerInputTypeEnum::RADIO,
                                    'input_options' => json_encode([
                                        [
                                            'label' => 'Ada',
                                            'value' => 'ada'
                                        ],
                                        [
                                            'label' => 'Tidak Ada',
                                            'value' => 'tidak ada'
                                        ],
                                    ]),
                                    'validation_rules' => 'required|string',
                                    'order' => 8
                                ],
                                [
                                    'id' => 36,
                                    'key' => 'has_ac',
                                    'question' => 'Kipas Angin/AC',
                                    'input_type' => LaporanMonevKuesionerInputTypeEnum::RADIO,
                                    'input_options' => json_encode([
                                        [
                                            'label' => 'Ada',
                                            'value' => 'ada'
                                        ],
                                        [
                                            'label' => 'Tidak Ada',
                                            'value' => 'tidak ada'
                                        ],
                                    ]),
                                    'validation_rules' => 'required|string',
                                    'order' => 9
                                ],
                                [
                                    'id' => 37,
                                    'key' => 'has_sound_system',
                                    'question' => 'Sound System/Toa',
                                    'input_type' => LaporanMonevKuesionerInputTypeEnum::RADIO,
                                    'input_options' => json_encode([
                                        [
                                            'label' => 'Ada',
                                            'value' => 'ada'
                                        ],
                                        [
                                            'label' => 'Tidak Ada',
                                            'value' => 'tidak ada'
                                        ],
                                    ]),
                                    'validation_rules' => 'required|string',
                                    'order' => 10
                                ],
                                [
                                    'id' => 38,
                                    'key' => 'has_dispenser',
                                    'question' => 'Dispenser/Galon Air Mineral',
                                    'input_type' => LaporanMonevKuesionerInputTypeEnum::RADIO,
                                    'input_options' => json_encode([
                                        [
                                            'label' => 'Ada',
                                            'value' => 'ada'
                                        ],
                                        [
                                            'label' => 'Tidak Ada',
                                            'value' => 'tidak ada'
                                        ],
                                    ]),
                                    'validation_rules' => 'required|string',
                                    'order' => 11
                                ],
                                [
                                    'id' => 39,
                                    'key' => 'has_lahan_parkir',
                                    'question' => 'Lahan Parkir',
                                    'input_type' => LaporanMonevKuesionerInputTypeEnum::RADIO,
                                    'input_options' => json_encode([
                                        [
                                            'label' => 'Ada',
                                            'value' => 'ada'
                                        ],
                                        [
                                            'label' => 'Tidak Ada',
                                            'value' => 'tidak ada'
                                        ],
                                    ]),
                                    'validation_rules' => 'required|string',
                                    'order' => 12
                                ],
                            ]
                        ],
                    ]
                ],
                [
                    'id' => 4,
                    'name' => 'Saran dan Masukan',
                    'order' => 4,
                    'sub' => [
                        [
                            'id' => 8,
                            'name' => 'Petugas Monev',
                            'order' => 1,
                            'kuesioner' => [
                                [
                                    'id' => 40,
                                    'key' => 'kendala',
                                    'question' => 'Kendala',
                                    'input_type' => LaporanMonevKuesionerInputTypeEnum::TEXT,
                                    'validation_rules' => 'required|string',
                                    'order' => 1
                                ],
                                [
                                    'id' => 41,
                                    'key' => 'feedback',
                                    'question' => 'Saran Masukan',
                                    'input_type' => LaporanMonevKuesionerInputTypeEnum::TEXT,
                                    'validation_rules' => 'required|string',
                                    'order' => 2
                                ],
                            ]
                        ],
                        [
                            'id' => 9,
                            'name' => 'Penanggung Jawab Kecamatan / Kelurahan',
                            'order' => 2,
                            'kuesioner' => [
                                [
                                    'id' => 42,
                                    'key' => 'nama_lengkap',
                                    'question' => 'Nama Lengkap',
                                    'input_type' => LaporanMonevKuesionerInputTypeEnum::TEXT,
                                    'validation_rules' => 'required|string',
                                    'order' => 1
                                ],
                                [
                                    'id' => 43,
                                    'key' => 'no_hp',
                                    'question' => 'Nomor Hp (Whatsapp)',
                                    'input_type' => LaporanMonevKuesionerInputTypeEnum::TEXT,
                                    'validation_rules' => 'required|string',
                                    'order' => 2
                                ],
                            ]
                        ],
                    ]
                ],
                [
                    'id' => 5,
                    'name' => 'Dokumentasi',
                    'order' => 5,
                    'sub' => [
                        [
                            'id' => 10,
                            'name' => 'Kegiatan',
                            'order' => 1,
                            'kuesioner' => [
                                [
                                    'id' => 44,
                                    'key' => 'documentation_pelayanan',
                                    'question' => 'Pada Saat Pelayanan',
                                    'input_type' => LaporanMonevKuesionerInputTypeEnum::FILE,
                                    'validation_rules' => 'required|mimes:png,jpg,jpeg|max:3072',
                                    'is_excluded_export' => true,
                                    'order' => 1
                                ],
                            ],
                        ],
                        [
                            'id' => 11,
                            'name' => 'Gedung Bangunan',
                            'order' => 2,
                            'kuesioner' => [
                                [
                                    'id' => 45,
                                    'key' => 'documentation_bld_luar',
                                    'question' => 'Tampak Luar',
                                    'input_type' => LaporanMonevKuesionerInputTypeEnum::FILE,
                                    'validation_rules' => 'required|mimes:png,jpg,jpeg|max:3072',
                                    'is_excluded_export' => true,
                                    'order' => 1
                                ],
                                [
                                    'id' => 46,
                                    'key' => 'documentation_bld_dalam',
                                    'question' => 'Tampak Dalam',
                                    'input_type' => LaporanMonevKuesionerInputTypeEnum::FILE,
                                    'validation_rules' => 'required|mimes:png,jpg,jpeg|max:3072',
                                    'is_excluded_export' => true,
                                    'order' => 2
                                ],
                            ],
                        ],
                    ]
                ],
            ];
            // foreach($kategori_arr as $arr){
            //     $kategori = new MKategoriLaporanMonev();
            //     $kategori->name = $arr['name'];
            //     $kategori->order = $arr['order'];
            //     $kategori->save();

            //     foreach($arr['sub'] as $arr2){
            //         $sub_kategori = new MSubKategoriLaporanMonev();
            //         $sub_kategori->name = $arr2['name'];
            //         $sub_kategori->order = $arr2['order'];
            //         $sub_kategori->id_kategori_laporan_monev = $kategori->id;
            //         $sub_kategori->save();
            //         foreach($arr2['kuesioner'] as $arr3){
            //             $kuesioner = new MKuesionerLaporanMonev();
            //             $kuesioner->key = $arr3['key'];
            //             $kuesioner->question = $arr3['question'];
            //             $kuesioner->input_type = $arr3['input_type'];
            //             if(!empty($arr3['input_options'])){
            //                 $kuesioner->input_options = $arr3['input_options'];
            //             }
            //             $kuesioner->validation_rules = $arr3['validation_rules'];
            //             $kuesioner->order = $arr3['order'];
            //             $kuesioner->id_sub_kategori_laporan_monev = $sub_kategori->id;
            //             $kuesioner->save();
            //         }
            //     }
            // }
            foreach($kategori_arr as $arr){
                DB::table('m_kategori_laporan_monev')->updateOrInsert(['id' => $arr['id']], [
                    'name' => $arr['name'],
                    'order' => $arr['order'],
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ]);

                foreach($arr['sub'] as $arr2){
                    DB::table('m_sub_kategori_laporan_monev')->updateOrInsert(['id' => $arr2['id']], [
                        'name' => $arr2['name'],
                        'order' => $arr2['order'],
                        'id_kategori_laporan_monev' => $arr['id'],
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s')
                    ]);
                    foreach($arr2['kuesioner'] as $arr3){
                        $input_options = null;
                        $is_excluded_export = false;
                        if(!empty($arr3['is_excluded_export']) && $arr3['is_excluded_export'] == true){
                            $is_excluded_export = true;
                        }
                        if(!empty($arr3['input_options'])){
                            $input_options = $arr3['input_options'];
                        }
                        DB::table('m_kuesioner_laporan_monev')->updateOrInsert(['id' => $arr3['id']], [
                            'key' => $arr3['key'],
                            'question' => $arr3['question'],
                            'input_type' => $arr3['input_type'],
                            'input_options' => $input_options,
                            'validation_rules' => $arr3['validation_rules'],
                            'order' => $arr3['order'],
                            'id_sub_kategori_laporan_monev' => $arr2['id'],
                            'is_excluded_export' => $is_excluded_export,
                            'created_at' => date('Y-m-d H:i:s'),
                            'updated_at' => date('Y-m-d H:i:s')
                        ]);
                    }
                }
            }
            DB::commit();
        }catch(\Exception $e){
            DB::rollBack();
            echo $e->getMessage();
        }
    }
}
