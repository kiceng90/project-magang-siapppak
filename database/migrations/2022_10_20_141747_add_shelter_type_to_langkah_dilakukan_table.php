<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddShelterTypeToLangkahDilakukanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('langkah_dilakukan', function (Blueprint $table) {
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
        Schema::table('langkah_dilakukan', function (Blueprint $table) {
            $table->dropColumn('shelter_type');
        });
    }
}
