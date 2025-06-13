<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AlterKonselingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table("mitra", function (Blueprint $table) {
            $table->dropColumn('status');
            $table->enum('status', [1, 2, 3, 4, 5])->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table("mitra", function (Blueprint $table) {
            $table->dropColumn('status');
            $table->enum('status', [1, 2, 3, 4, 5, 6])->default(1);
        });
    }
}
