<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLaporanKegiatanPublikasiKIETable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('laporan_kegiatan_publikasi_k_i_e', function (Blueprint $table) {
            $table->id();
            $table->string('jenis_kegiatan');
            $table->string('deskripsi_kegiatan');
            $table->string('jenis_konten');
            $table->string('tema_konten');
            $table->string('judul_konten');
            $table->string('deskripsi_konten');
            $table->string('link_konten')->nullable();
            $table->timestamps();
            $table->softDeletes();
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
        Schema::dropIfExists('laporan_kegiatan_publikasi_k_i_e');
    }
}
