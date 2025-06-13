<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterKeluargaKlienTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('keluarga_klien', function (Blueprint $table) {
            $table->string('name')->nullable()->change();
            $table->bigInteger('id_hubungan')->unsigned()->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('keluarga_klien', function (Blueprint $table) {
            $table->string('name')->nullable(false)->change();
            $table->bigInteger('id_hubungan')->unsigned()->nullable(false)->change();
        });
    }
}
