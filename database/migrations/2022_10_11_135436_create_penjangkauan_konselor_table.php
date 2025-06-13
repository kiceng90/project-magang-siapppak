<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePenjangkauanKonselorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('penjangkauan_konselor', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_penjangkauan')->references('id')->on('penjangkauan')->onDelete('cascade');
            $table->foreignId('id_konselor')->references('id')->on('m_konselor')->onDelete('cascade');
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
        Schema::dropIfExists('penjangkauan_konselor');
    }
}
