<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIdKecamatanToPkbmTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pkbm', function (Blueprint $table) {
            $table->foreignId('id_kecamatan')->nullable()->references('id')->on('m_kecamatan')->cascadeOnUpdate()->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pkbm', function (Blueprint $table) {
            $table->dropColumn('id_kecamatan');
        });
    }
}
