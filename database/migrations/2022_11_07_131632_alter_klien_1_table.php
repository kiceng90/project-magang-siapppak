<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterKlien1Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('klien', function (Blueprint $table) {
            $table->string('name')->nullable()->change();
            $table->string('initial_name')->nullable()->change();
            $table->string('phone_number')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('klien', function (Blueprint $table) {
            $table->string('name')->nullable(false)->change();
            $table->string('initial_name')->nullable(false)->change();
            $table->string('phone_number')->nullable(false)->change();
        });
    }
}
