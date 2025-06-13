<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterPelakuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pelaku', function (Blueprint $table) {
            $table->string('name')->nullable()->change();
            $table->string('initials_name')->nullable()->change();
            $table->integer('gender')->nullable()->change();
            $table->integer('citizenship')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pelaku', function (Blueprint $table) {
            $table->string('name')->nullable(false)->change();
            $table->string('initials_name')->nullable(false)->change();
            $table->integer('gender')->nullable(false)->change();
            $table->integer('citizenship')->nullable(false)->change();
        });
    }
}
