<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterOldLaporanKegiatanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('laporan_kegiatan_rapat', function (Blueprint $table) {
            $table->dropForeign('laporan_kegiatan_rapat_id_mahasiswa_balai_puspaga_rw_foreign');
            $table->dropColumn('id_mahasiswa_balai_puspaga_rw');

            $table->dropForeign('laporan_kegiatan_rapat_id_puspaga_rw_foreign');
            $table->dropColumn('id_puspaga_rw');

            $table->dropColumn('date');
            $table->dropColumn('status');

            $table->foreignId('id_laporan_kegiatan')->nullable()->references('id')->on('laporan_kegiatan')->onDelete('cascade');
        });

        
        Schema::table('laporan_kegiatan_sosialisasi', function (Blueprint $table) {
            $table->dropForeign('laporan_kegiatan_sosialisasi_id_mahasiswa_balai_puspaga_rw_foreign');
            $table->dropColumn('id_mahasiswa_balai_puspaga_rw');

            $table->dropForeign('laporan_kegiatan_sosialisasi_id_puspaga_rw_foreign');
            $table->dropColumn('id_puspaga_rw');

            $table->dropColumn('date');
            $table->dropColumn('status');

            $table->foreignId('id_laporan_kegiatan')->nullable()->references('id')->on('laporan_kegiatan')->onDelete('cascade');
        });
        Schema::table('laporan_kegiatan_konseling', function (Blueprint $table) {
            $table->dropForeign('laporan_kegiatan_konseling_id_mahasiswa_balai_puspaga_rw_foreign');
            $table->dropColumn('id_mahasiswa_balai_puspaga_rw');

            $table->dropForeign('laporan_kegiatan_konseling_id_puspaga_rw_foreign');
            $table->dropColumn('id_puspaga_rw');

            $table->dropColumn('date');
            $table->dropColumn('status');
            
            $table->foreignId('id_laporan_kegiatan')->nullable()->references('id')->on('laporan_kegiatan')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        
        Schema::table('laporan_kegiatan_rapat', function (Blueprint $table) {
            $table->foreignId('id_mahasiswa_balai_puspaga_rw')->nullable()->references('id')->on('mahasiswa_balai_puspaga_rw')->onDelete('cascade');
            $table->foreignId('id_puspaga_rw')->nullable()->references('id')->on('puspaga_rw')->onDelete('cascade');
            $table->date('date')->nullable();
            $table->integer('status')->nullable();

            $table->dropForeign('laporan_kegiatan_rapat_id_laporan_kegiatan_foreign');
            $table->dropColumn('id_laporan_kegiatan');
        });
        Schema::table('laporan_kegiatan_sosialisasi', function (Blueprint $table) {
            $table->foreignId('id_mahasiswa_balai_puspaga_rw')->nullable()->references('id')->on('mahasiswa_balai_puspaga_rw')->onDelete('cascade');
            $table->foreignId('id_puspaga_rw')->nullable()->references('id')->on('puspaga_rw')->onDelete('cascade');
            $table->date('date')->nullable();
            $table->integer('status')->nullable();

            $table->dropForeign('laporan_kegiatan_sosialisasi_id_laporan_kegiatan_foreign');
            $table->dropColumn('id_laporan_kegiatan');
        });
        Schema::table('laporan_kegiatan_konseling', function (Blueprint $table) {
            $table->foreignId('id_mahasiswa_balai_puspaga_rw')->nullable()->references('id')->on('mahasiswa_balai_puspaga_rw')->onDelete('cascade');
            $table->foreignId('id_puspaga_rw')->nullable()->references('id')->on('puspaga_rw')->onDelete('cascade');
            $table->date('date')->nullable();
            $table->integer('status')->nullable();

            $table->dropForeign('laporan_kegiatan_konseling_id_laporan_kegiatan_foreign');
            $table->dropColumn('id_laporan_kegiatan');
        });
        
    }
}
