<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLaporanMonevJawabanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('laporan_monev_jawaban', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_laporan_monev')->references('id')->on("laporan_monev")->onDelete('cascade');
            $table->foreignId('id_kuesioner_laporan_monev')->references('id')->on("m_kuesioner_laporan_monev")->onDelete('cascade');
            $table->text('answer');
            $table->boolean('is_active')->default(true);
            $table->boolean('is_file')->default(false);
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
        Schema::dropIfExists('laporan_monev_jawaban');
    }
}
