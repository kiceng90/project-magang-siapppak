<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMJadwalKonselingDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('m_jadwal_konseling_detail', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_jadwal_konseling')->references('id')->on('m_jadwal_konseling')->onDelete('cascade');
            $table->time('start_time');
            $table->time('end_time');
            $table->foreignId('id_kategori_konseling')->references('id')->on('m_kategori_konseling')->onDelete('cascade');
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
        Schema::dropIfExists('m_jadwal_konseling_detail');
    }
}
