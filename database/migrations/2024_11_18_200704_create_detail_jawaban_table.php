<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailJawabanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_jawaban', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_jawaban')->references('id')->on('jawaban')->onDelete('cascade');
            $table->foreignId('id_soal')->references('id')->on('soal')->onDelete('cascade');
            $table->foreignId('id_pilihan_jawaban')->references('id')->on('pilihan_jawaban')->onDelete('cascade');
            $table->integer('skor')->default(0);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();
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
        Schema::dropIfExists('detail_jawaban');
    }
}
