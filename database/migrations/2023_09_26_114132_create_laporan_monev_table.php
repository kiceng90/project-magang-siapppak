<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLaporanMonevTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('laporan_monev', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_jabatan_dalam_instansi')->references('id')->on("m_jabatan_dalam_instansi")->onDelete('cascade');
            // $table->foreignId('id_mahasiswa_balai_puspaga_rw')->references('id')->on("mahasiswa_balai_puspaga_rw")->onDelete('cascade');
            $table->foreignId('id_d_balai_puspaga_rw')->references('id')->on("d_balai_puspaga_rw")->onDelete('cascade');
            $table->date('date');
            $table->integer('status');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('laporan_monev');
    }
}
