<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnIdJasaPelayananToSatgasPpaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('satgas_ppa', function (Blueprint $table) {
            $table->string('penerima_jasa_pelayanan')->nullable();
            $table->foreignId('id_jasa_pelayanan')->nullable()->references('id')->on('m_jasa_pelayanan')->cascadeOnUpdate()->nullOnDelete();
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
            $table->dropColumn('penerima_jasa_pelayanan');
            $table->dropColumn('id_jasa_pelayanan');
        });
    }
}
