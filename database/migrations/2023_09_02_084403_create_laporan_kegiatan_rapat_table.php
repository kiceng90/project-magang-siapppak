<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLaporanKegiatanRapatTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('laporan_kegiatan_rapat', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_mahasiswa_balai_puspaga_rw')->nullable()->references('id')->on('mahasiswa_balai_puspaga_rw')->onDelete('cascade');
            $table->foreignId('id_puspaga_rw')->nullable()->references('id')->on('puspaga_rw')->onDelete('cascade');
            $table->foreignId('id_kelurahan')->references('id')->on('m_kelurahan')->onDelete('cascade');
            $table->date('date');
            $table->string('name');
            $table->text('description');
            $table->integer('total_participant');
            $table->text('resume');
            $table->string('url_video')->nullable();
            $table->integer('status');
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
        Schema::dropIfExists('laporan_kegiatan_rapat');
    }
}
