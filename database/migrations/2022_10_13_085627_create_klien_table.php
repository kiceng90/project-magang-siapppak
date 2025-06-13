<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKlienTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('klien', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_penjangkauan')->references('id')->on('penjangkauan')->onDelete('cascade');
            $table->foreignId('id_klien_history')->nullable()->references('id')->on('klien_history')->onDelete('cascade');
            $table->string('name');
            $table->string('initial_name');
            $table->boolean('is_has_nik')->default(true);
            $table->string('identity_number')->nullable();
            $table->string('nik_number')->nullable();
            $table->string('phone_number');
            $table->boolean('is_surabaya_resident')->default(true);
            $table->foreignId('id_kabupaten_tinggal')->nullable()->references('id')->on('m_kabupaten')->onDelete('cascade');
            $table->foreignId('id_kelurahan_tinggal')->nullable()->references('id')->on('m_kelurahan')->onDelete('cascade');
            $table->text('residence_address');

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
        Schema::dropIfExists('klien');
    }
}
