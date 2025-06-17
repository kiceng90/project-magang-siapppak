<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::group(['middleware' => ['jwt.verify']], function () {

    Route::get('/buku-tamu/klien', [API\BukuTamuController::class, 'klien']);
    Route::get('/buku-tamu/laporan-puspaga', [API\BukuTamuController::class, 'laporanPuspaga']);
    Route::get('/buku-tamu/rekap-tahunan', [API\BukuTamuController::class, 'rekapTahunan']);
    Route::get('/buku-tamu/rekap-bulanan', [API\BukuTamuController::class, 'rekapBulanan']);
    Route::get('/buku-tamu/{id}/form-pdf', [API\BukuTamuController::class, 'formPdf']);
    Route::get('/buku-tamu/{id}/identifikasi-pdf', [API\BukuTamuController::class, 'identifikasiPdf']);
    Route::get('/buku-tamu/{id}/penerimaan-pdf', [API\BukuTamuController::class, 'penerimaanPdf']);
    Route::get('/buku-tamu/{id}/cetak-pdf', [API\BukuTamuController::class, 'cetakPdf']);
    Route::get('/buku-tamu/{id}/form-singkat', [API\FormSingkatController::class, 'getFormSingkatByBukuTamu']);
    Route::get('/buku-tamu/{id}/form-rujukan', [API\FormRujukanController::class, 'getFormRujukanByBukuTamu']);
    Route::get('/buku-tamu/{id}/form-telekonsultasi', [API\FormTelekonsultasiController::class, 'getFormTelekonsultasiByBukuTamu']);
    Route::get('/buku-tamu/{id}/layanan', [API\BukuTamuController::class, 'getLayananByBukuTamu']);
    Route::get('/buku-tamu/{id}/Kebutuhan-layanan', [API\BukuTamuController::class, 'getLayananByKebutuhanLayanan']);
    Route::apiResource('buku-tamu', API\BukuTamuController::class)->except(['store']);
    Route::get('export-buku-tamu', [API\BukuTamuController::class, 'export'])->name('buku-tamu.export');
    Route::apiResource('identifikasi-kebutuhan', API\IdentifikasiKebutuhanController::class);
    Route::apiResource('form-rujukan', API\FormRujukanController::class);
    Route::apiResource('form-telekonsultasi', API\FormTelekonsultasiController::class);
    Route::apiResource('form-singkat', API\FormSingkatController::class);
    Route::get('/identifikasi-kebutuhan/buku-tamu/{bukuTamuId}', [API\IdentifikasiKebutuhanController::class, 'showByBukuTamuId']);
    Route::get('kebutuhan-layanan/lists', [API\MKebutuhanLayananController::class, 'lists']);

    Route::prefix('kategori')->group(function () {
        Route::put('{id}/switch-status', [API\KategoriController::class, 'switchStatus']);
        Route::get('lists', [API\KategoriController::class, 'lists']);
        Route::get('listsDB', [API\KategoriController::class, 'listsDB']);
        Route::get('/getKategoris', [API\KategoriController::class, 'getKategoris']);
        Route::get('/getKategori/{id}', [API\KategoriController::class, 'getKategori']);
    });
    Route::apiResource('kategori', API\KategoriController::class);

    Route::prefix('subkategori')->group(function () {
        Route::put('{id}/switch-status', [API\SubKategoriController::class, 'switchStatus']);
        Route::get('lists', [API\SubKategoriController::class, 'lists']);
        Route::get('listsDB', [API\SubKategoriController::class, 'listsDB']);
        Route::get('/getSubKategoris/{id}', [API\SubKategoriController::class, 'getSubKategoris']);
        Route::get('/getSubKategori/{id}', [API\SubKategoriController::class, 'getSubKategori']);
        Route::get('/piagam/{id}', [API\SubKategoriController::class, 'piagam']);
    });
    Route::apiResource('subkategori', API\SubKategoriController::class);

    Route::prefix('materi')->group(function () {
        Route::put('{id}/switch-status', [API\MateriController::class, 'switchStatus']);
        Route::get('lists', [API\MateriController::class, 'lists']);
        Route::get('/getMateris/{id}', [API\MateriController::class, 'getMateris']);
        Route::get('/getMateri/{id}', [API\MateriController::class, 'getMateri']);
        Route::get('/getRiwayatLatihanSoal/{id}', [API\MateriController::class, 'getRiwayatLatihanSoal']);
        Route::get('/getRiwayatLatihanSoal2/{id}', [API\MateriController::class, 'getRiwayatLatihanSoal2']);
    });
    Route::apiResource('materi', API\MateriController::class);

    Route::prefix('databasepeserta')->group(function () {
        Route::put('{id}/switch-status', [API\DatabasePesertaController::class, 'switchStatus']);
        Route::get('lists', [API\DatabasePesertaController::class, 'lists']);
        Route::get('rekap-tahunan', [API\DatabasePesertaController::class, 'rekapTahunan']);
        Route::get('rekap-bulanan', [API\DatabasePesertaController::class, 'rekapBulanan']);
        Route::get('laporan-elearning', [API\DatabasePesertaController::class, 'laporanElearning']);
        Route::get('export', [API\DatabasePesertaController::class, 'export']);
        Route::get('/sertifikat/{id}', [API\DatabasePesertaController::class, 'getSertifikatData']);
    });
    Route::apiResource('databasepeserta', API\DatabasePesertaController::class);

    Route::prefix('soal')->group(function () {
        Route::put('{id}/switch-status', [API\SoalController::class, 'switchStatus']);
        Route::get('lists', [API\SoalController::class, 'lists']);
        Route::get('/latihanSoal/{id}', [API\SoalController::class, 'getSoals']);
    });
    Route::apiResource('soal', API\SoalController::class);

    Route::prefix('pilihan-jawaban')->group(function () {
        Route::put('{id}/switch-status', [API\MateriController::class, 'switchStatus']);
        Route::get('lists', [API\MateriController::class, 'lists']);
    });

    Route::prefix('Detail-jawaban')->group(function () {
        Route::post('submit-answers', [API\JawabanDetail::class, 'submitAnswers']);
        Route::get('hasil-latihan-soal/{id}', [API\JawabanDetail::class, 'hasilLatihanSoal']);
        Route::get('history-latihan-soal/{id}', [API\JawabanDetail::class, 'historyLatihanSoal']);
        Route::get('lanjut-belajar/{id}', [API\JawabanDetail::class, 'navigateToLearning']);
    });
    Route::apiResource('Detail-jawaban', API\JawabanDetail::class);

    Route::apiResource('jawaban', API\JawabanController::class)->middleware('auth:api');

    Route::prefix('m-sumber-keluhan')->group(function () {
        Route::put('{id}/switch-status', [API\MSumberKeluhanController::class, 'switchStatus']);
        Route::get('lists', [API\MSumberKeluhanController::class, 'lists']);
    });
    Route::apiResource('m-sumber-keluhan', API\MSumberKeluhanController::class);

    Route::prefix('m-tipe-permasalahan')->group(function () {
        Route::put('{id}/switch-status', [API\MTipePermasalahanController::class, 'switchStatus']);
        Route::get('lists', [API\MTipePermasalahanController::class, 'lists']);
    });
    Route::apiResource('m-tipe-permasalahan', API\MTipePermasalahanController::class);

    Route::prefix('m-kategori-kasus')->group(function () {
        Route::put('{id}/switch-status', [API\MKategoriKasusController::class, 'switchStatus']);
        Route::get('lists', [API\MKategoriKasusController::class, 'lists']);
    });
    Route::apiResource('m-kategori-kasus', API\MKategoriKasusController::class);

    Route::prefix('m-jenis-kasus')->group(function () {
        Route::put('{id}/switch-status', [API\MJenisKasusController::class, 'switchStatus']);
        Route::get('lists', [API\MJenisKasusController::class, 'lists']);
    });
    Route::apiResource('m-jenis-kasus', API\MJenisKasusController::class);

    Route::prefix('m-intervensi')->group(function () {
        Route::put('{id}/switch-status', [API\MIntervensiController::class, 'switchStatus']);
        Route::get('lists', [API\MIntervensiController::class, 'lists']);
        Route::get('export', [API\MIntervensiController::class, 'export']);
    });
    Route::apiResource('m-intervensi', API\MIntervensiController::class);

    Route::prefix('m-kebutuhan-layanan')->group(function () {
        Route::put('{id}/switch-status', [API\MKebutuhanLayananController::class, 'switchStatus']);
        Route::get('lists', [API\MKebutuhanLayananController::class, 'lists']);
    });
    Route::apiResource('m-kebutuhan-layanan', API\MKebutuhanLayananController::class);

    Route::prefix('m-lokasi-kejadian')->group(function () {
        Route::put('{id}/switch-status', [API\MLokasiKejadianController::class, 'switchStatus']);
        Route::get('lists', [API\MLokasiKejadianController::class, 'lists']);
    });
    Route::apiResource('m-lokasi-kejadian', API\MLokasiKejadianController::class);

    Route::prefix('m-hubungan')->group(function () {
        Route::put('{id}/switch-status', [API\MHubunganController::class, 'switchStatus']);
        Route::get('lists', [API\MHubunganController::class, 'lists']);
        Route::get('export', [API\MhubunganController::class, 'export']);
    });
    Route::apiResource('m-hubungan', API\MHubunganController::class);

    Route::prefix('m-status-pernikahan')->group(function () {
        Route::put('{id}/switch-status', [API\MStatusPernikahanController::class, 'switchStatus']);
        Route::get('lists', [API\MStatusPernikahanController::class, 'lists']);
    });
    Route::apiResource('m-status-pernikahan', API\MStatusPernikahanController::class);

    Route::prefix('m-agama')->group(function () {
        Route::put('{id}/switch-status', [API\MAgamaController::class, 'switchStatus']);
        Route::get('lists', [API\MAgamaController::class, 'lists']);
        Route::get('export', [API\MAgamaController::class, 'export']);
    });
    Route::apiResource('m-agama', API\MAgamaController::class);

    // Program Kegiatan
    Route::prefix('m-program-kegiatan')->group(function () {
        Route::put('{id}/switch-status', [API\MProgramKegiatanController::class, 'switchStatus']);
        Route::get('lists', [API\MProgramKegiatanController::class, 'lists']);
        Route::get('export', [API\MProgramKegiatanController::class, 'export']);
    });
    Route::apiResource('m-program-kegiatan', API\MProgramKegiatanController::class);

    // Jenis Kegiatan
    Route::prefix('m-jenis-kegiatan')->group(function () {
        Route::put('{id}/switch-status', [API\MJenisKegiatanController::class, 'switchStatus']);
        Route::get('lists', [API\MJenisKegiatanController::class, 'lists']);
        Route::get('export', [API\MJenisKegiatanController::class, 'export']);
    });
    Route::apiResource('m-jenis-kegiatan', API\MJenisKegiatanController::class);

    // Bentuk Kegiatan
    Route::prefix('m-bentuk-kegiatan')->group(function () {
        Route::put('{id}/switch-status', [API\MBentukKegiatanController::class, 'switchStatus']);
        Route::get('lists', [API\MBentukKegiatanController::class, 'lists']);
        Route::get('export', [API\MBentukKegiatanController::class, 'export']);
    });
    Route::apiResource('m-bentuk-kegiatan', API\MBentukKegiatanController::class);

    // Kegiatan Puspaga
    Route::prefix('kegiatan-puspaga')->group(function () {
        Route::put('{id}/switch-status', [API\MBentukKegiatanController::class, 'switchStatus']);
        Route::get('lists', [API\MBentukKegiatanController::class, 'lists']);
        Route::get('export', [API\MBentukKegiatanController::class, 'export']);
    });
    Route::apiResource('kegiatan-puspaga', API\MBentukKegiatanController::class);

    Route::prefix('m-pekerjaan')->group(function () {
        Route::put('{id}/switch-status', [API\MPekerjaanController::class, 'switchStatus']);
        Route::get('lists', [API\MPekerjaanController::class, 'lists']);
    });
    Route::apiResource('m-pekerjaan', API\MPekerjaanController::class);

    Route::prefix('m-pendidikan-terakhir')->group(function () {
        Route::put('{id}/switch-status', [API\MPendidikanTerakhirController::class, 'switchStatus']);
        Route::get('lists', [API\MPendidikanTerakhirController::class, 'lists']);
    });
    Route::apiResource('m-pendidikan-terakhir', API\MPendidikanTerakhirController::class);

    Route::prefix('m-jasa-pelayanan')->group(function () {
        Route::put('{id}/switch-status', [API\MJasaPelayananController::class, 'switchStatus']);
        Route::get('lists', [API\MJasaPelayananController::class, 'lists']);
    });
    Route::apiResource('m-jasa-pelayanan', API\MJasaPelayananController::class);

    Route::prefix('m-posisi-mahasiswa')->group(function () {
        Route::put('{id}/switch-status', [API\MPosisiMahasiswaController::class, 'switchStatus']);
        Route::get('lists', [API\MPosisiMahasiswaController::class, 'lists']);
    });
    Route::apiResource('m-posisi-mahasiswa', API\MPosisiMahasiswaController::class);


    Route::prefix('m-jurusan-sekolah')->group(function () {
        Route::put('{id}/switch-status', [API\MJurusanController::class, 'switchStatus']);
        Route::get('lists', [API\MJurusanController::class, 'lists']);
    });
    Route::apiResource('m-jurusan-sekolah', API\MJurusanController::class);

    Route::prefix('m-kabupaten')->group(function () {
        Route::put('{id}/switch-status', [API\MKabupatenController::class, 'switchStatus']);
        Route::get('lists', [API\MKabupatenController::class, 'lists']);
    });
    Route::apiResource('m-kabupaten', API\MKabupatenController::class);

    Route::prefix('m-wilayah')->group(function () {
        Route::put('{id}/switch-status', [API\MWilayahController::class, 'switchStatus']);
        Route::get('lists', [API\MWilayahController::class, 'lists']);
    });
    Route::apiResource('m-wilayah', API\MWilayahController::class);

    Route::prefix('m-kecamatan')->group(function () {
        Route::put('{id}/switch-status', [API\MKecamatanController::class, 'switchStatus']);
        Route::get('lists', [API\MKecamatanController::class, 'lists']);
        Route::get('listsMahasiswa', [API\MKecamatanController::class, 'listsMahasiswa']);
    });
    Route::apiResource('m-kecamatan', API\MKecamatanController::class);

    Route::prefix('m-kelurahan')->group(function () {
        Route::put('{id}/switch-status', [API\MKelurahanController::class, 'switchStatus']);
        Route::get('lists', [API\MKelurahanController::class, 'lists']);
    });
    Route::apiResource('m-kelurahan', API\MKelurahanController::class);

    Route::prefix('m-konselor')->group(function () {
        Route::put('{id}/switch-status', [API\MKonselorController::class, 'switchStatus']);
        Route::get('lists', [API\MKonselorController::class, 'lists']);
    });
    Route::apiResource('m-konselor', API\MKonselorController::class);

    Route::prefix('m-opd')->group(function () {
        Route::put('{id}/switch-status', [API\MOpdController::class, 'switchStatus']);
        Route::get('lists', [API\MOpdController::class, 'lists']);
    });
    Route::apiResource('m-opd', API\MOpdController::class);

    Route::prefix('m-user')->group(function () {
        Route::put('{id}/switch-status', [API\MUserController::class, 'switchStatus']);
        Route::put('{id}/reset-password', [API\MUserController::class, 'resetPassword']);
    });
    Route::apiResource('m-user', API\MUserController::class)->except(['destroy']);

    Route::get('profile', [API\MUserController::class, 'getProfile']);
    Route::post('logout', [API\MUserController::class, 'logout']);
    Route::post('change-password', [API\MUserController::class, 'changePassword']);

    Route::prefix('notif')->group(function () {
        Route::get('/', [API\NotificationController::class, 'getNotif']);
        Route::get('/check', [API\NotificationController::class, 'check']);
        Route::get('/read/{id?}', [API\NotificationController::class, 'read']);
    });


    Route::prefix('pengaduan')->group(function () {
        Route::get('cek', [API\PengaduanController::class, 'timeline']);
        Route::get('/nomor-otomatis', [API\PengaduanController::class, 'getAutoGenerate'])->middleware('role:' . config('env.role.hotline'));
        Route::post('{id}/action', [API\PenangananAwalController::class, 'store'])->middleware('role.hotline');
        Route::get('{id_pengaduan}/penanganan-awal', [API\PenangananAwalController::class, 'show']);
        Route::post('{id_pengaduan}/penanganan-awal', [API\PenangananAwalController::class, 'update']);
        Route::put('{id}/action/kabid', [API\PengaduanController::class, 'KabidApprove'])->middleware('role.kabid');
        Route::put('{id}/approve/subkord', [API\PengaduanController::class, 'subkordApprove'])->middleware('role:' . config('env.role.subkord') . ',' . config('env.role.kabid'));
        Route::put('{id}/approve/kadis', [API\PengaduanController::class, 'kadisApprove'])->middleware('role.kadis');

        Route::post('realisasi-intervensi/{id_rencana}', [API\RealisasiIntervensiController::class, 'store'])->middleware('role:' . config('env.role.opd'));
        Route::get('realisasi-intervensi/{id_rencana}', [API\RealisasiIntervensiController::class, 'index']);
        Route::post('realisasi-intervensi/{id_rencana}/akhiri', [API\RealisasiIntervensiController::class, 'submit'])->middleware('role:' . config('env.role.opd'));

        Route::get('{id}/cetak', [API\PengaduanController::class, 'cetak']);
        Route::get('{id}/cetak-pdf', [API\PengaduanController::class, 'cetakPdf']);
    });
    Route::apiResource('pengaduan', API\PengaduanController::class)->except(['destroy']);

    Route::prefix('penjangkauan')->group(function () {
        Route::get('/{id}', [API\PenjangkauanController::class, 'show']);
        Route::post('/plan', [API\PenjangkauanController::class, 'store_plan']);
        Route::post('/{id}/result', [API\PenjangkauanController::class, 'store_result'])->middleware(
            'role:' . config('env.role.konselor') . ',' . config('env.role.subkord') . ',' . config('env.role.kabid')
        );

        Route::get('/{id}/klien', [API\PenjangkauanController::class, 'get_klien']);
        Route::post('/{id}/klien', [API\PenjangkauanController::class, 'store_klien'])->middleware(
            'role:' . config('env.role.konselor') . ',' .
                config('env.role.subkord') . ',' .
                config('env.role.kabid')
        );

        Route::get('/{id}/keluarga_klien', [API\PenjangkauanController::class, 'get_keluarga_klien']);
        Route::post('/{id}/keluarga_klien', [API\PenjangkauanController::class, 'store_keluarga_klien'])->middleware(
            'role:' . config('env.role.konselor') . ',' .
                config('env.role.subkord') . ',' .
                config('env.role.kabid')
        );

        Route::get('/{id}/rencana_intervensi', [API\PenjangkauanController::class, 'get_rencana_intervensi']);
        Route::post('/{id}/rencana_intervensi', [API\PenjangkauanController::class, 'store_rencana_intervensi'])->middleware(
            'role:' . config('env.role.konselor') . ',' .
                config('env.role.subkord') . ',' .
                config('env.role.kabid')
        );
        Route::delete('/{id}/rencana_intervensi/delete_file', [API\PenjangkauanController::class, 'delete_rencana_intervensi_file']);
    });

    Route::prefix('daftar-klien')->group(function () {
        Route::get('/', [API\DaftarKlienController::class, 'index'])->middleware('role:' . config('env.role.admin') . ',' . config('env.role.konselor') . ',' . config('env.role.kadis'));
        Route::get('lists', [API\DaftarKlienController::class, 'lists']);
        Route::put('penanganan/{id}', [API\LangkahDilakukanController::class, 'update'])->middleware('role:' . config('env.role.opd') . ',' . config('env.role.admin') . ',' . config('env.role.kadis'));
        Route::get('penanganan/{id}', [API\LangkahDilakukanController::class, 'show']);
        Route::get('{id}', [API\DaftarKlienController::class, 'show']);
        Route::get('{id}/histori-pengaduan', [API\DaftarKlienController::class, 'historiPengaduan']);
        Route::get('{id}/histori-penanganan', [API\DaftarKlienController::class, 'historiPenanganan']);

        Route::post('{id}/penanganan-kasus', [API\LangkahDilakukanController::class, 'storeOne'])->middleware('role:' . config('env.role.admin') . ',' . config('env.role.konselor'));;
    });

    Route::prefix('penjangkauan/{id_penjangkauan}')->group(function () {
        Route::post('pelaku', [API\PelakuController::class, 'store'])->middleware(
            'role:' . config('env.role.konselor') . ',' .
                config('env.role.subkord') . ',' .
                config('env.role.kabid')
        );
        Route::get('pelaku', [API\PelakuController::class, 'show']);

        Route::post('situasi-keluarga', [API\SituasiKeluargaController::class, 'store'])->middleware(
            'role:' . config('env.role.konselor') . ',' .
                config('env.role.subkord') . ',' .
                config('env.role.kabid')
        );
        Route::get('situasi-keluarga', [API\SituasiKeluargaController::class, 'show']);

        Route::post('harapan-klien', [API\HarapanKlienController::class, 'store'])->middleware(
            'role:' . config('env.role.konselor') . ',' .
                config('env.role.subkord') . ',' .
                config('env.role.kabid')
        );
        Route::get('harapan-klien', [API\HarapanKlienController::class, 'show']);

        Route::post('kronologi-kejadian', [API\KronologiKejadianController::class, 'store'])->middleware(
            'role:' . config('env.role.konselor') . ',' .
                config('env.role.subkord') . ',' .
                config('env.role.kabid')
        );
        Route::get('kronologi-kejadian', [API\KronologiKejadianController::class, 'show']);

        Route::post('kondisi-klien', [API\KondisiKlienController::class, 'store'])->middleware(
            'role:' . config('env.role.konselor') . ',' .
                config('env.role.subkord') . ',' .
                config('env.role.kabid')
        );
        Route::get('kondisi-klien', [API\KondisiKlienController::class, 'show']);

        Route::post('analis-kebutuhan-klien', [API\AnalisisDp3kappkbController::class, 'store'])->middleware(
            'role:' . config('env.role.konselor') . ',' .
                config('env.role.subkord') . ',' .
                config('env.role.kabid')
        );
        Route::get('analis-kebutuhan-klien', [API\AnalisisDp3kappkbController::class, 'index']);

        Route::post('langkah-telah-dilakukan', [API\LangkahDilakukanController::class, 'store'])->middleware(
            'role:' . config('env.role.konselor') . ',' .
                config('env.role.subkord') . ',' .
                config('env.role.admin') . ',' .
                config('env.role.kabid')
        );
        Route::get('langkah-telah-dilakukan', [API\LangkahDilakukanController::class, 'index']);

        Route::post('dokumen-pendukung', [API\DokumenPendukungController::class, 'store'])->middleware(
            'role:' . config('env.role.konselor') . ',' .
                config('env.role.subkord') . ',' .
                config('env.role.kabid')
        );
        Route::get('dokumen-pendukung', [API\DokumenPendukungController::class, 'show']);

        Route::get('format/{nama_file}', [API\PenjangkauanController::class, 'formatDokumen']);
    });

    Route::get('m-pelayanan/lists', [API\AnalisisDp3kappkbController::class, 'listPelayanan']);
    Route::get('m-kebutuhan/lists', [API\LangkahDilakukanController::class, 'listKebutuhan']);

    Route::prefix('dashboard')->group(function () {
        Route::get('intervention-opd-not-finish', [API\DashboardController::class, 'interventionOpdNotFinish']);
        Route::get('trend-statistic-all', [API\DashboardController::class, 'trendStatisticAll']);
        Route::get('trend-statistic-by-month-problem-type', [API\DashboardController::class, 'trendStatisticByMonthAndProblemType']);
        Route::get('trend-statistic-by-year-problem-type', [API\DashboardController::class, 'trendStatisticByYearAndProblemType']);
        Route::get('trend-kasus-perkecamatan', [API\DashboardController::class, 'trendKasusPerkecamatan']);
        Route::get('ketuntasan-opd', [API\DashboardController::class, 'ketuntasaOPD']);
    });

    Route::prefix('laporan')->group(function () {
        Route::get('kasus-klien', [API\LaporanController::class, 'kasusKlien']);
        Route::get('rekap-tahunan', [API\LaporanController::class, 'rekapTahunan']);
        Route::get('rekap-bulanan', [API\LaporanController::class, 'rekapBulanan']);
        Route::get('rekap-mahasiswa-univ', [API\LaporanController::class, 'rekapMahasiswaByUniv']);
        Route::get('rekap-mahasiswa-pendidikan', [API\LaporanController::class, 'rekapMahasiswaByPend']);
        Route::get('rekap-penugasan-mahasiswa-wilayah', [API\LaporanController::class, 'rekapPenugasanMahasiswaByWilayah']);
    });

    Route::prefix('puspaga')->group(function () {
        Route::put('{id}/switch-status', [API\PuspagaRwController::class, 'switchStatus']);
        Route::get('{id}/cetak-pdf', [API\PuspagaRwController::class, 'cetakPdf']);
        Route::get('{id}/download-sk', [API\PuspagaRwController::class, 'downloadSK']);
        Route::get('lists-rw', [API\PuspagaRwController::class, 'listRw']);
        Route::get('rangkuman', [API\PuspagaRwController::class, 'summary']);
        Route::post('import', [API\PuspagaRwController::class, 'import']);
        Route::get('download-format', [API\PuspagaRwController::class, 'downloadFormat']);
        Route::get('export', [API\PuspagaRwController::class, 'export']);
    });
    Route::apiResource('puspaga', API\PuspagaRwController::class)->except(['destroy']);

    Route::prefix('database')->group(function () {
        Route::get('konselor/export', [API\DKonselorController::class, 'export']);
        Route::post('konselor/import', [API\DKonselorController::class, 'import']);
        Route::get('konselor/download-format', [API\DKonselorController::class, 'downloadFormat']);
        Route::put('konselor/{id}/switch-status', [API\DKonselorController::class, 'switchStatus']);
        Route::get('konselor/{id}/cetak-pdf', [API\DKonselorController::class, 'cetakPdf']);
        Route::get('konselor/rangkuman', [API\DKonselorController::class, 'summary']);
        Route::apiResource('konselor', API\DKonselorController::class)->except(['destroy']);

        Route::get('satgas-ppa/export', [API\SatgasPpaController::class, 'export']);
        Route::post('satgas-ppa/import', [API\SatgasPpaController::class, 'import']);
        Route::get('satgas-ppa/download-format', [API\SatgasPpaController::class, 'downloadFormat']);
        Route::put('satgas-ppa/{id}/switch-status', [API\SatgasPpaController::class, 'switchStatus']);
        Route::get('satgas-ppa/{id}/cetak-pdf', [API\SatgasPpaController::class, 'cetakPdf']);
        Route::get('satgas-ppa/{id}/download-sk', [API\SatgasPpaController::class, 'downloadSK']);
        Route::get('satgas-ppa/rangkuman', [API\SatgasPpaController::class, 'summary']);
        Route::apiResource('satgas-ppa', API\SatgasPpaController::class)->except(['destroy']);

        Route::get('pkbm/export', [API\PkbmController::class, 'export']);
        Route::post('pkbm/import', [API\PkbmController::class, 'import']);
        Route::get('pkbm/download-format', [API\PkbmController::class, 'downloadFormat']);
        Route::put('pkbm/{id}/switch-status', [API\PkbmController::class, 'switchStatus']);
        Route::get('pkbm/{id}/cetak-pdf', [API\PkbmController::class, 'cetakPdf']);
        Route::get('pkbm/{id}/download-sk', [API\PkbmController::class, 'downloadSK']);
        Route::get('pkbm/rangkuman', [API\PkbmController::class, 'summary']);
        Route::apiResource('pkbm', API\PkbmController::class)->except(['destroy']);

        Route::get('psikolog-volunteer/export', [API\PsikologVolunteerController::class, 'export']);
        Route::post('psikolog-volunteer/import', [API\PsikologVolunteerController::class, 'import']);
        Route::get('psikolog-volunteer/download-format', [API\PsikologVolunteerController::class, 'downloadFormat']);
        Route::put('psikolog-volunteer/{id}/switch-status', [API\PsikologVolunteerController::class, 'switchStatus']);
        Route::get('psikolog-volunteer/{id}/cetak-pdf', [API\PsikologVolunteerController::class, 'cetakPdf']);
        Route::get('psikolog-volunteer/rangkuman', [API\PsikologVolunteerController::class, 'summary']);
        Route::get('psikolog-volunteer/lists', [API\PsikologVolunteerController::class, 'lists']);
        Route::get('psikolog-volunteer/hasschedulelists', [API\PsikologVolunteerController::class, 'hasScheduleLists']);
        Route::apiResource('psikolog-volunteer', API\PsikologVolunteerController::class)->except(['destroy']);
    });

    Route::prefix('m-instansi-pendidikan')->group(function () {
        Route::get('lists', [API\SelectListController::class, 'MInstansiPendidikan']);
        Route::put('{id}/switch-status', [API\MInstansiPendidikanController::class, 'switchStatus']);
        Route::get('export', [API\MInstansiPendidikanController::class, 'export']);
    });
    Route::apiResource('m-instansi-pendidikan', API\MInstansiPendidikanController::class);

    Route::prefix('m-jabatan-dalam-instansi')->group(function () {
        Route::get('lists', [API\SelectListController::class, 'MJabatanDalamInstansi']);
        Route::put('{id}/switch-status', [API\MJabatanDalamInstansiController::class, 'switchStatus']);
        Route::get('export', [API\MJabatanDalamInstansiController::class, 'export']);
    });
    Route::apiResource('m-jabatan-dalam-instansi', API\MJabatanDalamInstansiController::class);

    Route::prefix('m-kedudukan-dalam-tim')->group(function () {
        Route::get('lists', [API\SelectListController::class, 'MKedudukanDalamTim']);
        Route::put('{id}/switch-status', [API\MKedudukanDalamTimController::class, 'switchStatus']);
        Route::get('export', [API\MKedudukanDalamTimController::class, 'export']);
    });
    Route::get('d-balai-puspaga-rw/lists', [API\DBalaiPuspagaRWController::class, 'lists']);
    Route::apiResource('d-balai-puspaga-rw', API\DBalaiPuspagaRWController::class);
    Route::put('d-balai-puspaga-rw/{id}/switch-status', [API\MKedudukanDalamTimController::class, 'switchStatus']);
    Route::get('m-puspaga-balai-rw/export', [API\DBalaiPuspagaRWController::class, 'export']);

    Route::apiResource('m-kedudukan-dalam-tim', API\MKedudukanDalamTimController::class);

    Route::apiResource('m-kategori-mitra', API\MKategoriMitraController::class);

    Route::apiResource('kie', API\KieController::class);
    Route::put('kie/{id}/switch-status', [API\KieController::class, 'switchStatus']);
    Route::get('kie-types', [API\KieController::class, 'getKieTypes']);
    Route::get('kie-get/{type}', [API\KieController::class, 'getKieByTypes']);

    Route::apiResource('artikel', API\ArtikelController::class);
    Route::put('artikel/{id}/switch-status', [API\ArtikelController::class, 'switchStatus']);
    Route::get('artikelppa', [API\ArtikelController::class, 'getArtikels']);
    Route::get('lookup/mahasiswa', [API\ArtikelController::class, 'getMahasiswaByNIM']);

    Route::apiResource('standarisasi', API\StandarisasiController::class);
    Route::put('standarisasi/{id}/switch-status', [API\StandarisasiController::class, 'switchStatus']);

    Route::prefix('m-standarisasi-persyaratan')->group(function () {
        Route::put('{id}/switch-status', [API\MStandarisasiPersyaratanController::class, 'switchStatus']);
        Route::get('lists', [API\MStandarisasiPersyaratanController::class, 'lists']);
    });
    Route::apiResource('m-standarisasi-persyaratan', API\MStandarisasiPersyaratanController::class);

    Route::prefix('m-standarisasi-indikator')->group(function () {
        Route::put('{id}/switch-status', [API\MStandarisasiIndikatorController::class, 'switchStatus']);
        Route::get('lists', [API\MStandarisasiIndikatorController::class, 'lists']);
    });
    Route::apiResource('m-standarisasi-indikator', API\MStandarisasiIndikatorController::class);

    Route::prefix('m-standarisasi-pertanyaan')->group(function () {
        Route::put('{id}/switch-status', [API\MStandarisasiPertanyaanController::class, 'switchStatus']);
        Route::get('lists', [API\MStandarisasiPertanyaanController::class, 'lists']);
    });
    Route::apiResource('m-standarisasi-pertanyaan', API\MStandarisasiPertanyaanController::class);

    Route::apiResource('mitra', API\MitraController::class);
    Route::put('mitra/{id}/switch-status', [API\MitraController::class, 'switchStatus']);
    Route::get('mitra-export', [API\MitraController::class, 'export']);

    Route::apiResource('m-jadwal-konseling', API\MJadwalKonselingController::class);
    Route::put('m-jadwal-konseling/{id}/switch-status', [API\MJadwalKonselingController::class, 'switchStatus']);

    Route::apiResource('m-jadwal-konseling-detail', API\MJadwalKonselingDetailController::class);
    Route::put('m-jadwal-konseling-detail/{id}/switch-status', [API\MJadwalKonselingDetailController::class, 'switchStatus']);
    Route::get('m-jadwal-konseling-detail-export', [API\MJadwalKonselingDetailController::class, 'export']);

    Route::apiResource('m-kategori-konseling', API\MKategoriKonselingController::class);

    Route::prefix('m-kategori-laporan-monev')->group(function () {
        Route::put('{id}/switch-status', [API\MKategoriLaporanMonevController::class, 'switchStatus']);
        Route::get('lists', [API\MKategoriLaporanMonevController::class, 'lists']);
    });
    Route::apiResource('m-kategori-laporan-monev', API\MKategoriLaporanMonevController::class);

    Route::prefix('m-sub-kategori-laporan-monev')->group(function () {
        Route::put('{id}/switch-status', [API\MSubKategoriLaporanMonevController::class, 'switchStatus']);
        Route::get('lists', [API\MSubKategoriLaporanMonevController::class, 'lists']);
    });
    Route::apiResource('m-sub-kategori-laporan-monev', API\MSubKategoriLaporanMonevController::class);

    Route::prefix('m-kuesioner-laporan-monev')->group(function () {
        Route::put('{id}/switch-status', [API\MKuesionerLaporanMonevController::class, 'switchStatus']);
        Route::get('lists', [API\MKuesionerLaporanMonevController::class, 'lists']);
    });
    Route::apiResource('m-kuesioner-laporan-monev', API\MKuesionerLaporanMonevController::class);

    Route::apiResource('laporan-monev', API\LaporanMonevController::class);
    Route::put('laporan-monev/{id}/switch-status', [API\LaporanMonevController::class, 'switchStatus']);
    Route::middleware('role:' . config('env.role.subkord') . ',' . config('env.role.kabid'))->group(function () {
        Route::put('laporan-monev/{id}/verif', [API\LaporanMonevController::class, 'verif']);
    });
    Route::get('laporan-monev-export', [API\LaporanMonevController::class, 'export']);
    Route::get('laporan-monev-export/{id}', [API\LaporanMonevController::class, 'exportById']);
    Route::get('laporan-monev-list-kuesioner', [API\LaporanMonevController::class, 'listsKuesioner']);
    Route::get('laporan-monev/detail/{id}', [API\LaporanMonevController::class, 'detail']);

    Route::prefix('m-kategori-rumah-perubahan')->group(function () {
        Route::put('{id}/switch-status', [API\MRumahPerubahanKategoriController::class, 'switchStatus']);
        Route::get('lists', [API\MRumahPerubahanKategoriController::class, 'lists']);
        Route::get('listsDB', [API\MRumahPerubahanKategoriController::class, 'listsDB']);
        Route::get('getKategoris', [API\MRumahPerubahanKategoriController::class, 'getKategoris']);
        Route::get('getKategori/{id}', [API\MRumahPerubahanKategoriController::class, 'getKategori']);

    });
    Route::apiResource('m-kategori-rumah-perubahan', API\MRumahPerubahanKategoriController::class);

    Route::prefix('m-materi-rumah-perubahan')->group(function () {
        Route::put('{id}/switch-status', [API\MRumahPerubahanMateriController::class, 'switchStatus']);
        Route::get('lists', [API\MRumahPerubahanMateriController::class, 'lists']);
        Route::get('/getMateris/{id}', [API\MRumahPerubahanMateriController::class, 'getMateris']);
        Route::get('/getMateri/{id}', [API\MRumahPerubahanMateriController::class, 'getMateri']);
    });
    Route::apiResource('m-materi-rumah-perubahan', API\MRumahPerubahanMateriController::class);

    Route::prefix('m-soal-rumah-perubahan')->group(function () {
        Route::put('{id}/switch-status', [API\MRumahPerubahanSoalController::class, 'switchStatus']);
        Route::get('lists', [API\MRumahPerubahanSoalController::class, 'lists']);
        Route::get('/latihanSoal/{id}', [API\MRumahPerubahanSoalController::class, 'getSoals']);

    });
    Route::apiResource('m-soal-rumah-perubahan', API\MRumahPerubahanSoalController::class);

    Route::prefix('rumahperubahan-detailjawaban')->group(function () {
        Route::post('submit-answers', [API\RumahPerubahanJawabanDetailController::class, 'submitAnswers']);
        Route::get('hasil-latihan-soal/{id}', [API\RumahPerubahanJawabanDetailController::class, 'hasilLatihanSoal']);
        Route::get('history-latihan-soal/{id}', [API\RumahPerubahanJawabanDetailController::class, 'historyLatihanSoal']);
        Route::get('lanjut-belajar/{id}', [API\RumahPerubahanJawabanDetailController::class, 'navigateToLearning']);
    });
    Route::apiResource('rumahperubahan-detailjawaban', API\RumahPerubahanJawabanDetailController::class);

    Route::prefix('rumahperubahan-jawaban')->group(function () {
        // Route::get('database', [API\RumahPerubahanJawabanController::class, 'complete']);
        Route::post('store', [API\RumahPerubahanJawabanController::class, 'store']);
        Route::put('{id}/complete', [API\RumahPerubahanJawabanController::class, 'complete']);
        Route::post('create-new-attempt', [API\RumahPerubahanJawabanController::class, 'createNewAttempt']);
        Route::get('export', [API\RumahPerubahanJawabanController::class, 'export']);
  
    });
    Route::apiResource('rumahperubahan-jawaban', API\RumahPerubahanJawabanController::class);

    // Route::apiResource('rumahperubahan-jawaban', API\RumahPerubahanJawabanController::class)->middleware('auth:api');

    Route::prefix('m-jenis-mahasiswa')->group(function () {
        Route::put('{id}/switch-status', [API\MJenisMahasiswaController::class, 'switchStatus']);
        Route::get('lists', [API\MJenisMahasiswaController::class, 'lists']);
    });
    Route::apiResource('m-jenis-mahasiswa', API\MJenisMahasiswaController::class);

    Route::apiResource('d-mahasiswa', API\DMahasiswaController::class);
    Route::get('d-mahasiswa-export', [API\DMahasiswaController::class, 'export']);
    Route::get('d-mahasiswa-export-recap', [API\DMahasiswaController::class, 'recap']);
    Route::prefix('d-mahasiswa')->group(function () {
        Route::put('{id}/switch-status', [API\DMahasiswaController::class, 'switchStatus']);
        Route::put('{id}/assign', [API\DMahasiswaController::class, 'assignBalai']);
        Route::put('{id}/set-inactive', [API\DMahasiswaController::class, 'setInactive']);
        Route::put('{id}/switch-status-penugasan', [API\DMahasiswaController::class, 'assignSwitchStatus']);
    });

    // Route::apiResource('laporan-mahasiswa',API\LaporanKegiatanController::class);
    Route::get('mahasiswa-balai-check-replacement', [API\LaporanKegiatanController::class, 'checkPlacement']);
    Route::get('laporan-mahasiswa', [API\LaporanKegiatanController::class, 'index']);
    Route::get('laporan-mahasiswa/{id}', [API\LaporanKegiatanController::class, 'show']);
    Route::post('laporan-mahasiswa/store', [API\LaporanKegiatanController::class, 'store']);
    Route::post('laporan-mahasiswa/update', [API\LaporanKegiatanController::class, 'update']);
    Route::middleware('role:' . config('env.role.subkord') . ',' . config('env.role.konselor') . ',' . config('env.role.admin') . ',' . config('env.role.mahasiswa'))->group(function () {
        Route::get('laporan-mahasiswa-export', [API\LaporanKegiatanController::class, 'export']);
        Route::get('laporan-mahasiswa-export/{id}', [API\LaporanKegiatanController::class, 'exportById']);
    });

    Route::middleware('role:' . config('env.role.subkord') . ',' . config('env.role.konselor'))->group(function () {
        Route::put('laporan-mahasiswa/{id}/verif', [API\LaporanKegiatanController::class, 'verif']);
        Route::put('laporan-mahasiswa/verifAll', [API\LaporanKegiatanController::class, 'verifAll']);
    });

    Route::prefix('fasilitator')->group(function () {
        Route::get('lists', [API\PuspagaRwController::class, 'listPublic']);
        Route::get('laporan', [API\LaporanKegiatanController::class, 'index']);
        Route::get('laporan/{id}', [API\LaporanKegiatanController::class, 'show']);
        Route::post('laporan/store', [API\LaporanKegiatanController::class, 'store']);
        Route::post('laporan/update', [API\LaporanKegiatanController::class, 'update']);
        Route::get('laporan-export', [API\LaporanKegiatanController::class, 'export']);
        Route::get('laporan-export/{id}', [API\LaporanKegiatanController::class, 'exportById']);
        Route::get('data-fasilitator', [API\LaporanKegiatanController::class, 'checkPlacement']);
    });

    Route::prefix('enum')->group(function () {
        Route::get('day-enum', [API\EnumController::class, 'getDayEnum']);
        Route::get('kie-jenis-enum', [API\EnumController::class, 'getKieJenisEnum']);
        Route::get('lang-enum', [API\EnumController::class, 'getLangEnum']);
        Route::get('status-konseling-enum', [API\EnumController::class, 'getStatusKonselingEnum']);
        Route::get('client-type-enum', [API\EnumController::class, 'getClientTypeEnum']);
        Route::get('jenis-mahasiswa-status', [API\EnumController::class, 'getJenisMahasiswaStatus']);
        Route::get('laporan-kegiatan-file-source', [API\EnumController::class, 'getLaporanKegiatanFileSource']);
        Route::get('laporan-kegiatan-file-type', [API\EnumController::class, 'getLaporanKegiatanFileType']);
        Route::get('laporan-kegiatan-konseling-type', [API\EnumController::class, 'getLaporanKegiatanKonselingType']);
        Route::get('laporan-kegiatan-sosialisasi-type', [API\EnumController::class, 'getLaporanKegiatanSosialisasiType']);
        Route::get('laporan-kegiatan-status', [API\EnumController::class, 'getLaporanKegiatanStatus']);
        Route::get('laporan-monev-kuesioner-file-type', [API\EnumController::class, 'getLaporanMonevKuesionerInputTypeEnum']);
        Route::get('mahasiswa-file-type', [API\EnumController::class, 'getMahasiswaFileType']);
        Route::get('klien-konseling-file-type', [API\EnumController::class, 'getDKlienKonselingFileType']);
        Route::get('puspagarw-file-type', [API\EnumController::class, 'getPuspagaRwFileType']);
        Route::get('mahasiswa-status', [API\EnumController::class, 'getMahasiswaStatus']);
        Route::get('laporan-kegiatan-publikasi-kie-type', [API\EnumController::class, 'getLaporanKegiatanPublikasiKieTypeEnum']);
        Route::get('laporan-kegiatan-publikasi-konten-type', [API\EnumController::class, 'getLaporanKegiatanPublikasiKontenTypeEnum']);
        Route::get('laporan-kegiatan-sosialisasi-sasaran', [API\EnumController::class, 'getLaporanKegiatanSosialisasiSasaran']);
    });

    Route::get('konseling-hasil/{id}', [API\KonselingController::class, 'getHasilKonseling']);

    // Klien Routing
    Route::middleware('role:' . config('env.role.klien') . ',' . config('env.role.konselor'))->group(function () {
        Route::get('konseling-languages', [API\KonselingController::class, 'getLanguages']);
        Route::get('konseling-prepare-booking-day/{id_konsultan}', [API\KonselingController::class, 'prepareBookingDay']);
        Route::get('konseling-prepare-booking-shift/{id_konsultan}/{daynumber}', [API\KonselingController::class, 'prepareBookingShift']);
        Route::post('konseling-booking', [API\KonselingController::class, 'booking']);
        Route::put('konseling-review/{id}', [API\KonselingController::class, 'review']);
        Route::get('klien-konseling-history', [API\KonselingController::class, 'getHistoryByKlienID']);
    });

    // Konselor Routing
    Route::middleware('role:' . config('env.role.konselor') . "," . config('env.role.psikolog'))->group(function () {
        Route::get('konselor-konseling-history', [API\KonselingController::class, 'getHistoryByKonselorID']);
        Route::put('konselor-konseling-accept/{id}', [API\KonselingController::class, 'accept']);
        Route::put('konselor-konseling-reject/{id}', [API\KonselingController::class, 'reject']);
        Route::put('konselor-konseling-finish/{id}', [API\KonselingController::class, 'finish']);

        Route::get('informed-consent/{id}/cetak-pdf', [API\KonselingController::class, 'cetakPdf']);

        Route::post('konselor-pengaduan-integrate', [API\KonselingController::class, 'integratePengaduan']);
    });
    Route::get('konseling-get-review/{id}', [API\KonselingController::class, 'getReview'])->middleware('role:' . config('env.role.konselor') . "," . config('env.role.admin'));
    // Admin Routing
    Route::middleware('role:' . config('env.role.admin'))->group(function () {
        Route::get('admin-konseling-history', [API\KonselingController::class, 'getHistory']);
        Route::put('d-klien-konseling/{id}/switch-status', [API\DKlienKonselingController::class, 'switchStatus']);
        Route::get('konseling-export', [API\KonselingController::class, 'export']);

        Route::post('admin-pengaduan-integrate', [API\KonselingController::class, 'integratePengaduan']);
    });


});


Route::post('login', [API\MUserController::class, 'login'])->middleware(['throttle:5,1']);
Route::post('external-login', [API\MUserController::class, 'externalLogin']);
Route::get('show-files/{id}/{model}', [API\FileController::class, 'show'])->name('file.show');
// Route::get('phpmyinfo', function () {
//     phpinfo();
// })->name('phpmyinfo');

Route::get('getall-klien', [API\PenjangkauanController::class, 'getAllKlienExternalApi']);

// Public API Route
Route::prefix('public')->group(function () {
    Route::get('m-kategori-mitra', [API\MKategoriMitraController::class, 'indexPublic']);
    Route::get('m-kategori-konseling', [API\MKategoriKonselingController::class, 'indexPublic']);
    Route::get('m-jadwal-konseling', [API\MJadwalKonselingController::class, 'indexPublic']);
    Route::get('d-balai-puspaga-rw', [API\DBalaiPuspagaRWController::class, 'indexPublic']);
    Route::get('d-mahasiswa', [API\DMahasiswaController::class, 'indexPublic']);
    Route::get('kie', [API\KieController::class, 'indexPublic']);
    Route::get('recentkie', [API\KieController::class, 'recent']);
    Route::get('mitra/{slug}', [API\MitraController::class, 'indexPublic']);
    Route::post('klien-konseling-register', [API\DKlienKonselingController::class, 'register']);
    Route::post('buku-tamu', [API\BukuTamuController::class, 'store']);
    Route::post('upload-OCR', [API\KTPController::class, 'store']);
    Route::get('buku-tamu-OCR/{id}', [API\KTPController::class, 'show']);
    Route::post('mahasiswa-register', [API\DMahasiswaController::class, 'register']);
    Route::get('list-kabupaten', [API\MKabupatenController::class, 'lists']);
    Route::get('list-kecamatan', [API\MKecamatanController::class, 'lists']);
    Route::get('list-kelurahan', [API\MKelurahanController::class, 'lists']);
    Route::get('kie-jenis-enum', [API\EnumController::class, 'getKieJenisEnum']);
    Route::get('all-enum', [API\EnumController::class, 'getAllEnum']);
    Route::get('list-jenis-mahasiswa', [API\MJenisMahasiswaController::class, 'lists']);
    Route::get('list-pendidikan-terakhir', [API\MPendidikanTerakhirController::class, 'lists']);
    Route::get('list-instansi-pendidikan', [API\SelectListController::class, 'MInstansiPendidikan']);
    Route::get('list-jurusan', [API\MJurusanController::class, 'lists']);
    Route::get('test-route', [API\TestController::class, 'sendEmail']);
    Route::get('artikelpublic', [API\ArtikelController::class, 'indexPublic']);
    Route::get('artikel/{id}', [API\ArtikelController::class, 'show']);
    Route::get('recentartikel', [API\ArtikelController::class, 'recent']);

    Route::get('absensi-kelas-catin', [API\AbsensiKelasCatinController::class, 'listsPublic']);
    Route::get('absensi-kelas-catin/{id}', [API\AbsensiKelasCatinController::class, 'show']);
    Route::get('absensi-kegiatan', [API\AbsensiKegiatanController::class, 'listsPublic']);
    Route::get('absensi-kegiatan/{id}', [API\AbsensiKegiatanController::class, 'show']);

});

Route::prefix('master-public')->group(function () {
    Route::get('m-kebutuhan-layanan', [API\MKebutuhanLayananController::class, 'listsPublic']);
    Route::get('m-sumber-keluhan', [API\MSumberKeluhanController::class, 'listsPublic']);
    Route::get('m-sumber-keluhan/{id}', [API\MSumberKeluhanController::class, 'show']);
    Route::get('m-tipe-permasalahan', [API\MTipePermasalahanController::class, 'listsPublic']);
    Route::get('m-tipe-permasalahan/{id}', [API\MTipePermasalahanController::class, 'show']);
    Route::get('m-kategori-kasus', [API\MKategoriKasusController::class, 'listsPublic']);
    Route::get('m-kategori-kasus/{id}', [API\MKategoriKasusController::class, 'show']);
    Route::get('m-jenis-kasus', [API\MJenisKasusController::class, 'listsPublic']);
    Route::get('m-jenis-kasus/{id}', [API\MJenisKasusController::class, 'show']);
    Route::get('m-intervensi', [API\MIntervensiController::class, 'listsPublic']);
    Route::get('m-intervensi/{id}', [API\MIntervensiController::class, 'show']);
    Route::get('m-lokasi-kejadian', [API\MLokasiKejadianController::class, 'listsPublic']);
    Route::get('m-lokasi-kejadian/{id}', [API\MLokasiKejadianController::class, 'show']);
    Route::get('m-hubungan', [API\MHubunganController::class, 'listsPublic']);
    Route::get('m-hubungan/{id}', [API\MHubunganController::class, 'show']);
    Route::get('m-status-pernikahan', [API\MStatusPernikahanController::class, 'listsPublic']);
    Route::get('m-status-pernikahan/{id}', [API\MStatusPernikahanController::class, 'show']);
    Route::get('m-pekerjaan', [API\MPekerjaanController::class, 'listsPublic']);
    Route::get('m-pekerjaan/{id}', [API\MPekerjaanController::class, 'show']);
    Route::get('m-pendidikan-terakhir', [API\MPendidikanTerakhirController::class, 'listsPublic']);
    Route::get('m-pendidikan-terakhir/{id}', [API\MPendidikanTerakhirController::class, 'show']);
    Route::get('m-jurusan', [API\MJurusanController::class, 'listsPublic']);
    Route::get('m-jurusan/{id}', [API\MJurusanController::class, 'show']);
    Route::get('m-kabupaten', [API\MKabupatenController::class, 'listsPublic']);
    Route::get('m-kabupaten/{id}', [API\MKabupatenController::class, 'show']);
    Route::get('m-wilayah', [API\MWilayahController::class, 'listsPublic']);
    Route::get('m-wilayah/{id}', [API\MWilayahController::class, 'show']);
    Route::get('m-kecamatan', [API\MKecamatanController::class, 'listsPublic']);
    Route::get('m-kecamatan/{id}', [API\MKecamatanController::class, 'show']);
    Route::get('m-kelurahan', [API\MKelurahanController::class, 'listsPublic']);
    Route::get('m-kelurahan/{id}', [API\MKelurahanController::class, 'show']);
    Route::get('m-opd', [API\MOpdController::class, 'listsPublic']);
    Route::get('m-opd/{id}', [API\MOpdController::class, 'show']);
    Route::get('m-agama', [API\MAgamaController::class, 'listsPublic']);
    Route::get('m-agama/{id}', [API\MAgamaController::class, 'show']);
    Route::get('m-jabatan-dalam-instansi', [API\MJabatanDalamInstansiController::class, 'indexPublic']);
    Route::get('m-jabatan-dalam-instansi/{id}', [API\MJabatanDalamInstansiController::class, 'show']);
    Route::get('m-program-kegiatan', [API\MProgramKegiatanController::class, 'listsPublic']);
    Route::get('m-program-kegiatan/{id}', [API\MProgramKegiatanController::class, 'show']);
    Route::get('m-jenis-kegiatan', [API\MJenisKegiatanController::class, 'listsPublic']);
    Route::get('m-jenis-kegiatan/{id}', [API\MJenisKegiatanController::class, 'show']);
    Route::get('m-bentuk-kegiatan', [API\MBentukKegiatanController::class, 'listsPublic']);
    Route::get('m-bentuk-kegiatan/{id}', [API\MBentukKegiatanController::class, 'show']);
    Route::get('kegiatan-puspaga', [API\MKegiatanPuspagaController::class, 'listsPublic']);
    Route::get('kegiatan-puspaga/{id}', [API\MKegiatanPuspagaController::class, 'show']);
    Route::get('absensi-kelas-catin', [API\AbsensiKelasCatinController::class, 'listsPublic']);
    Route::get('absensi-kelas-catin/{id}', [API\AbsensiKelasCatinController::class, 'show']);
    Route::get('absensi-kegiatan', [API\AbsensiKegiatanController::class, 'listsPublic']);
    Route::get('absensi-kegiatan/{id}', [API\AbsensiKegiatanController::class, 'show']);
});


Route::apiResource('kegiatan-puspaga', API\MKegiatanPuspagaController::class);
Route::apiResource('absensi-kegiatan', API\AbsensiKegiatanController::class);
Route::apiResource('absensi-kelas-catin', API\AbsensiKelasCatinController::class);

