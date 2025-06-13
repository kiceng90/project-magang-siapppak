<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDKlienKonselingFileTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('d_klien_konseling_file', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_klien_konseling')->references('id')->on('d_klien_konseling')->onDelete('cascade');
            $table->string('name');
            $table->string('path');
            $table->string('ext');
            $table->float('size');
            $table->boolean('is_image')->default(false);
            $table->integer('type');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();
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
        Schema::dropIfExists('d_klien_konseling_file');
    }
}
