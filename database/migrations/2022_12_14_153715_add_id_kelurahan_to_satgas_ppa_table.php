<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIdKelurahanToSatgasPpaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('satgas_ppa', function (Blueprint $table) {
            $table->foreignId('id_kelurahan')->nullable()->references('id')->on('m_kelurahan')->cascadeOnUpdate()->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('satgas_ppa', function (Blueprint $table) {
            $table->dropColumn('id_kelurahan');
        });
    }
}
