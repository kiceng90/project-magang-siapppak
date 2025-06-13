<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnNamaPenulisToArtikelTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('artikel', function (Blueprint $table) {
            $table->string('nim')->nullable();
            $table->string('nama_mahasiswa')->nullable();
            $table->string('kecamatan_puspaga')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('artikel', function (Blueprint $table) {
            $table->dropColumn('nim');
            $table->dropColumn('nama_mahasiswa');
            $table->dropColumn('kecamatan_puspaga');
        });
    }
}
