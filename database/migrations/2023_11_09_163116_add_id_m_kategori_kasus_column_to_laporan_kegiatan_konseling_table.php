<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIdMKategoriKasusColumnToLaporanKegiatanKonselingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('laporan_kegiatan_konseling', function (Blueprint $table) {
            $table->foreignId('id_m_kategori_kasus')->nullable()->references('id')->on("m_kategori_kasus")->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('laporan_kegiatan_konseling', function (Blueprint $table) {
            $table->dropForeign('laporan_kegiatan_konseling_id_m_kategori_kasus_foreign');
            $table->dropColumn('id_m_kategori_kasus');
        });
    }
}
