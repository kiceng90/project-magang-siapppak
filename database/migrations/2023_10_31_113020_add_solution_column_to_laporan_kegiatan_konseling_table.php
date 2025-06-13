<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSolutionColumnToLaporanKegiatanKonselingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('laporan_kegiatan_konseling', function (Blueprint $table) {
            $table->string('solution')->default("-");
        });
    }
    
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('laporan_kegiatan_konseling', function (Blueprint $table) {
            $table->dropColumn('solution');
        });
    }
}
