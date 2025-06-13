<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMSubKategoriLaporanMonevTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('m_sub_kategori_laporan_monev', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_kategori_laporan_monev')->references('id')->on('m_kategori_laporan_monev')->onDelete('cascade');
            $table->string('name');
            $table->integer('order'); // display order
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('m_sub_kategori_laporan_monev');
    }
}
