<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDKlienKonselingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('d_klien_konseling', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_user')->references('id')->on('m_user')->onDelete('cascade');
            $table->string('name');
            $table->string('nik');
            $table->string('phone');
            $table->string('email');
            $table->foreignId('id_kabupaten')->references('id')->on('m_kabupaten')->onDelete('cascade');
            $table->boolean('is_active')->default(false);
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
        Schema::dropIfExists('d_klien_konseling');
    }
}
