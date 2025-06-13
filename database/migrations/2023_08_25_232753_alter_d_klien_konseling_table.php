<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterDKlienKonselingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('d_klien_konseling', function (Blueprint $table) {
            $table->foreignId('id_kelurahan')->nullable()->references('id')->on('m_kelurahan')->onDelete('cascade');
            $table->text('address')->nullable();
            $table->integer('rw')->nullable();
            $table->integer('rt')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('d_klien_konseling', function (Blueprint $table) {
            $table->dropForeign('d_klien_konseling_id_kelurahan_foreign');
            $table->dropColumn('id_kelurahan');
            $table->dropColumn('address');
            $table->dropColumn('rw');
            $table->dropColumn('rt');
        });
    }
}
