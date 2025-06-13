<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMKuesionerLaporanMonevTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('m_kuesioner_laporan_monev', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_sub_kategori_laporan_monev')->references('id')->on('m_sub_kategori_laporan_monev')->onDelete('cascade');
            $table->string('key')->unique();
            $table->string('question');
            $table->integer('input_type'); // Input Type, text, select, date, number, etc.
            $table->json('input_options')->nullable();
            $table->text('validation_rules');
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
        Schema::dropIfExists('m_kuesioner_laporan_monev');
    }
}
