<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterMKategoriMitraTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table("m_kategori_mitra",function (Blueprint $table){
            $table->unique("slug");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table("m_kategori_mitra",function (Blueprint $table){
            $table->dropUnique("m_kategori_mitra_slug_unique");
        });
    }
}
