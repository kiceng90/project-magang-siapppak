<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLaporanKegiatanKonselingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('laporan_kegiatan_konseling', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_mahasiswa_balai_puspaga_rw')->nullable()->references('id')->on('mahasiswa_balai_puspaga_rw')->onDelete('cascade');
            $table->foreignId('id_puspaga_rw')->nullable()->references('id')->on('puspaga_rw')->onDelete('cascade');
            $table->foreignId('id_kelurahan')->references('id')->on('m_kelurahan')->onDelete('cascade');
            $table->date('date');
            $table->string('name');
            $table->string('nik');
            $table->text('phone');
            $table->boolean('is_surabaya_citizen')->default(true);
            $table->text('address');
            $table->integer('type');
            $table->text('description');
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
        Schema::dropIfExists('laporan_kegiatan_konseling');
    }
}
