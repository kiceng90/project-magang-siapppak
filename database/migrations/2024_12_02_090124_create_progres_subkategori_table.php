<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProgresSubkategoriTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('progres_subkategori', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_user')->references('id')->on('m_user')->onDelete('cascade');
            $table->foreignId('id_sub_kategori')->references('id')->on('sub_kategori')->onDelete('cascade');
            $table->boolean('is_completed')->default(false); 
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
        Schema::dropIfExists('progres_subkategori');
    }
}
