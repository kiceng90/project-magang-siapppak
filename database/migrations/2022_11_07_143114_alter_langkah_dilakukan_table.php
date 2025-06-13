<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterLangkahDilakukanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('langkah_dilakukan', function (Blueprint $table) {
            $table->integer('service_type')->nullable()->change();
            $table->date('service_date')->nullable()->change();
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
            $table->integer('service_type')->nullable(false)->change();
            $table->date('service_date')->nullable(false)->change();
        });
    }
}
