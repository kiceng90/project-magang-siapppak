<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterForeignIdJadwalKonselingDetailInKonselingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('konseling', function (Blueprint $table) {
            $table->dropForeign('konseling_id_jadwal_konseling_detail_foreign');
            $table->foreign('id_jadwal_konseling_detail')->references('id')->on('m_jadwal_konseling_detail')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('konseling', function (Blueprint $table) {
            $table->dropForeign('konseling_id_jadwal_konseling_detail_foreign');
            $table->foreign('id_jadwal_konseling_detail')->references('id')->on('m_jadwal_konseling')->onDelete('cascade');
        });
    }
}
