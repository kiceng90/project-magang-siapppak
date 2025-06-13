<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLaporanKegiatanSosialisasiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('laporan_kegiatan_sosialisasi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_mahasiswa_balai_puspaga_rw')->nullable()->references('id')->on('mahasiswa_balai_puspaga_rw')->onDelete('cascade');
            $table->foreignId('id_puspaga_rw')->nullable()->references('id')->on('puspaga_rw')->onDelete('cascade');
            $table->foreignId('id_kelurahan')->references('id')->on('m_kelurahan')->onDelete('cascade');
            $table->date('date');
            $table->integer('total_participant');
            $table->string('name');
            $table->string('organization');
            $table->text('description');
            $table->string('url_video')->nullable();
            $table->integer('status');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('laporan_kegiatan_sosialisasi');
    }
}
