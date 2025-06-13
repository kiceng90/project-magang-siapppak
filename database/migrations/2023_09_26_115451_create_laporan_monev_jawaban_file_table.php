<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLaporanMonevJawabanFileTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('laporan_monev_jawaban_file', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_laporan_monev_jawaban')->references('id')->on('laporan_monev_jawaban')->onDelete('cascade');
            $table->string('name');
            $table->string('path');
            $table->string('ext');
            $table->float('size');
            $table->boolean('is_image')->default(false);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();
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
        Schema::dropIfExists('laporan_monev_jawaban_file');
    }
}
