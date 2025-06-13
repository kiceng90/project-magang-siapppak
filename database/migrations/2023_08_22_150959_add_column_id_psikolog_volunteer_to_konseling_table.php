<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnIdPsikologVolunteerToKonselingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('konseling', function (Blueprint $table) {
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
        Schema::table('konseling', function (Blueprint $table) {
            $table->dropConstrainedForeignId('id_psikolog_volunteer');
        });
    }
}
