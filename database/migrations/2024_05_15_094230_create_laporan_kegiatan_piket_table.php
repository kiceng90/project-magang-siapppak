<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLaporanKegiatanPiketTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('laporan_kegiatan_piket', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_kelurahan')->references('id')->on('m_kelurahan')->onDelete('cascade');
            $table->string('rw');
            $table->time('opening_time');
            $table->time('closing_time');
            $table->text('description');
            $table->softDeletes();
            $table->timestamps();
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
        Schema::dropIfExists('laporan_kegiatan_piket');
    }
}
