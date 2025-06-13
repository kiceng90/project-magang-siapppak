<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnIdPsikologVolunteerToMJadwalKonselingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('m_jadwal_konseling', function (Blueprint $table) {
            $table->foreignId('id_konselor')->nullable()->change();
            $table->foreignId('id_psikolog_volunteer')->nullable()->references('id')->on('psikolog_volunteer')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('m_jadwal_konseling', function (Blueprint $table) {
            $table->foreignId('id_konselor')->nullable(false)->change();
            $table->dropConstrainedForeignId('id_psikolog_volunteer');
        });
    }
}
