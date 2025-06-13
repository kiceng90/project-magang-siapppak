<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIdKonselorToLaporanMonevTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('laporan_monev', function (Blueprint $table) {
            $table->foreignId('id_konselor')->references('id')->on("m_konselor")->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('laporan_monev', function (Blueprint $table) {
            $table->dropForeign('laporan_monev_id_konselor_foreign');
            $table->dropColumn('id_konselor');
        });
    }
}
