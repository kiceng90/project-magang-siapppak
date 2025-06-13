<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddShelterTypeToAnalisisDp3kappkb extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('analisis_dp3kappkb', function (Blueprint $table) {
            $table->integer('shelter_type')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('analisis_dp3kappkb', function (Blueprint $table) {
            $table->dropColumn('shelter_type');
        });
    }
}
