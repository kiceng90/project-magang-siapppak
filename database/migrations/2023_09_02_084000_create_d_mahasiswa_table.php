<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDMahasiswaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('d_mahasiswa', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_user')->nullable()->references('id')->on('m_user')->onDelete('cascade');
            $table->foreignId('id_kabupaten_lahir')->references('id')->on('m_kabupaten')->onDelete('cascade');
            $table->foreignId('id_pendidikan_terakhir')->references('id')->on('m_pendidikan_terakhir')->onDelete('cascade');
            $table->foreignId('id_jenis_mahasiswa')->references('id')->on('m_jenis_mahasiswa')->onDelete('cascade');
            $table->foreignId('id_jurusan')->references('id')->on('m_jurusan')->onDelete('cascade');
            $table->foreignId('id_instansi_pendidikan')->references('id')->on('m_instansi_pendidikan')->onDelete('cascade');
            $table->foreignId('id_kelurahan_domisili')->references('id')->on('m_kelurahan')->onDelete('cascade');
            $table->foreignId('id_kelurahan_kk')->references('id')->on('m_kelurahan')->onDelete('cascade');
            $table->string('name');
            $table->string('email');
            $table->string('nik');
            $table->string('nim');
            $table->date('birth_date');
            $table->string('phone');
            $table->integer('semester');
            $table->double('ipk');
            $table->text('domicile_address');
            $table->integer('domicile_rt');
            $table->integer('domicile_rw');
            $table->text('kk_address');
            $table->integer('kk_rt');
            $table->integer('kk_rw');
            $table->integer('status');
            $table->boolean('is_active')->default(true);
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
        Schema::dropIfExists('d_mahasiswa');
    }
}
