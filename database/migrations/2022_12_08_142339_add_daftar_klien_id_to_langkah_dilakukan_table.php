<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDaftarKlienIdToLangkahDilakukanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('langkah_dilakukan', function (Blueprint $table) {
            $table->foreignId('id_daftar_klien')->nullable()->references('id')->on('daftar_klien')->onDelete('cascade');
            $table->unsignedBigInteger('id_penjangkauan')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('langkah_dilakukan', function (Blueprint $table) {
            $table->dropColumn('id_daftar_klien');
            $table->unsignedBigInteger('id_penjangkauan')->nullable(false)->change();
        });
    }
}
