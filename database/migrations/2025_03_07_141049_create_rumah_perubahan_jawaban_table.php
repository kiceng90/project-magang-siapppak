<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRumahPerubahanJawabanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rumah_perubahan_jawaban', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_user')->references('id')->on('m_user')->onDelete('cascade');
            $table->foreignId('id_materi')->references('id')->on('m_rumah_perubahan_materi')->onDelete('cascade');
            $table->double('skor')->nullable();
            $table->boolean('is_done')->default(false);
            $table->boolean('is_selesai')->default(false);
            $table->string('nama')->nullable();
            $table->string('nik')->nullable();
            $table->foreignId('id_kabupaten')->nullable()->references('id')->on('m_kabupaten')->onDelete('cascade');
            $table->foreignId('id_kecamatan')->nullable()->references('id')->on('m_kecamatan')->onDelete('cascade');
            $table->foreignId('id_kelurahan')->nullable()->references('id')->on('m_kelurahan')->onDelete('cascade');
            $table->text('alamat')->nullable();
            $table->string('no_telepon')->nullable();
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
        Schema::dropIfExists('m_rumah_perubahan_jawaban');
    }
}
