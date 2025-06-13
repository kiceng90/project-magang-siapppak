<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterDaftarKlienTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('daftar_klien', function (Blueprint $table) {
            $table->string('name')->nullable()->change();
            $table->string('initial_name')->nullable()->change();
            $table->string('phone_number')->nullable()->change();
            $table->text('residence_address')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('daftar_klien', function (Blueprint $table) {
            $table->string('name')->nullable(false)->change();
            $table->string('initial_name')->nullable(false)->change();
            $table->string('phone_number')->nullable(false)->change();
            $table->text('residence_address')->nullable(false)->change();
        });
    }
}
