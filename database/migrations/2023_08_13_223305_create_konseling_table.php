<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKonselingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('konseling', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_klien_konseling')->references('id')->on('d_klien_konseling')->onDelete('cascade');
            $table->foreignId('id_jadwal_konseling_detail')->references('id')->on('m_jadwal_konseling')->onDelete('cascade');
            $table->date('date');
            $table->enum('language',[1,2]);
            $table->text('description');
            $table->text('result')->nullable();
            $table->integer('rating')->nullable();
            $table->text('review')->nullable();
            $table->enum('status',[1,2,3,4,5,6]);
            $table->text('note_reject')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('konseling');
    }
}
