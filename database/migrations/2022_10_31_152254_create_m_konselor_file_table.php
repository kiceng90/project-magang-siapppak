<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMKonselorFileTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('m_konselor_file', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_m_konselor')->references('id')->on('m_konselor')->onDelete('cascade');
            $table->string('name');
            $table->string('path');
            $table->string('ext');
            $table->float('size');
            $table->boolean('is_image')->default(false);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();
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
        Schema::dropIfExists('m_konselor_file');
    }
}
