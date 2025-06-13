<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKlienHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('klien_history', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_daftar_klien')->nullable()->references('id')->on('daftar_klien')->onDelete('cascade');
            $table->text('residence_address')->nullable();
            $table->foreignId('id_kabupaten_tinggal')->nullable()->references('id')->on('m_kabupaten')->onDelete('cascade');
            $table->foreignId('id_kelurahan_tinggal')->nullable()->references('id')->on('m_kelurahan')->onDelete('cascade');
            $table->string('kk_number')->nullable();
            $table->text('kk_address')->nullable();
            $table->foreignId('id_kelurahan_kk')->nullable()->references('id')->on('m_kelurahan')->onDelete('cascade');
            $table->foreignId('id_kabupaten_lahir')->nullable()->references('id')->on('m_kabupaten')->onDelete('cascade');
            $table->date('birth_date')->nullable();
            $table->integer('age_category')->nullable();
            $table->integer('physical_category')->nullable();
            $table->integer('bpjs_category')->nullable();
            $table->integer('gender')->nullable();
            $table->foreignId('id_agama')->nullable()->references('id')->on('m_agama')->onDelete('cascade');
            $table->foreignId('id_pekerjaan')->nullable()->references('id')->on('m_pekerjaan')->onDelete('cascade');
            $table->float('monthly_income')->nullable();
            $table->foreignId('id_status_pernikahan')->nullable()->references('id')->on('m_status_pernikahan')->onDelete('cascade');
            $table->foreignId('id_pendidikan_terakhir')->nullable()->references('id')->on('m_pendidikan_terakhir')->onDelete('cascade');
            $table->foreignId('id_jurusan')->nullable()->references('id')->on('m_jurusan')->onDelete('cascade');
            $table->integer('highest_class')->nullable();
            $table->integer('graduation_year')->nullable();

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
        Schema::dropIfExists('klien_history');
    }
}
