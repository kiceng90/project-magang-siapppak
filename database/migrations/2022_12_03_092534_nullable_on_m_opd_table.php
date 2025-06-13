<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class NullableOnMOpdTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('m_opd', function (Blueprint $table) {
            $table->string('pic_name')->nullable()->change();
            $table->string('pic_number')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('m_opd', function (Blueprint $table) {
            $table->string('pic_name')->nullable(false)->change();
            $table->string('pic_number')->nullable(false)->change();
        });
    }
}
