<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterRencanaIntervensiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rencana_intervensi', function (Blueprint $table) {
            $table->longText('description')->nullable()->change();
            $table->bigInteger('id_opd')->unsigned()->nullable()->change();
            $table->bigInteger('id_intervensi')->unsigned()->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rencana_intervensi', function (Blueprint $table) {
            $table->longText('description')->nullable(false)->change();
            $table->bigInteger('id_opd')->unsigned()->nullable(false)->change();
            $table->bigInteger('id_intervensi')->unsigned()->nullable(false)->change();
        });
    }
}
