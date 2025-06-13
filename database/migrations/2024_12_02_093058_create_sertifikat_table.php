<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSertifikatTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sertifikat', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_user')->references('id')->on('m_user')->onDelete('cascade');
            $table->foreignId('id_subkategori')->references('id')->on('sub_kategori')->onDelete('cascade'); 
            $table->foreignId('id_progres_subkategori')->references('id')->on('progres_subkategori')->onDelete('cascade'); 
            $table->string('file_sertifikat'); 
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
        Schema::dropIfExists('sertifikat');
    }
}
