<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIdKecamatanKelurahanToMUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('m_user', function (Blueprint $table) {
            $table->foreignId('id_kelurahan')->nullable()->references('id')->on('m_kelurahan')->cascadeOnUpdate()->nullOnDelete();
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
        Schema::table('m_user', function (Blueprint $table) {
            $table->dropColumn('id_kelurahan');
            $table->dropColumn('id_kecamatan');
        });
    }
}
