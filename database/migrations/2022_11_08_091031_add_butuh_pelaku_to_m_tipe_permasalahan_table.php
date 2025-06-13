<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddButuhPelakuToMTipePermasalahanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('m_tipe_permasalahan', function (Blueprint $table) {
            $table->boolean('butuh_pelaku')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('m_tipe_permasalahan', function (Blueprint $table) {
            $table->dropColumn('butuh_pelaku');
        });
    }
}
