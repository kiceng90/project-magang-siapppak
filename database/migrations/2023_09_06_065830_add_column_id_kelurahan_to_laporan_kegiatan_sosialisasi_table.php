<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnIdKelurahanToLaporanKegiatanSosialisasiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('laporan_kegiatan_sosialisasi', 'id_kelurahan')) {
            Schema::table('laporan_kegiatan_sosialisasi', function (Blueprint $table) {
                $table->foreignId('id_kelurahan')->nullable()->references('id')->on('m_kelurahan')->onDelete('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('laporan_kegiatan_sosialisasi', function (Blueprint $table) {
            // $table->dropForeign('laporan_kegiatan_sosialisasi_id_kelurahan_foreign');
            // $table->dropColumn('id_kelurahan');
        });
    }
}
