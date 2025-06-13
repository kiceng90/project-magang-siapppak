<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProgresKategoriTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('progres_kategori', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_progres_subkategori')->nullable()->references('id')->on('progres_subkategori')->onDelete('cascade'); // Relasi ke jawaban
            $table->foreignId('id_user')->nullable()->references('id')->on('m_user')->onDelete('cascade'); // User terkait
            $table->foreignId('id_kategori')->nullable()->references('id')->on('kategori')->onDelete('cascade'); // Materi terkait
            $table->boolean('is_completed')->default(false);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();
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
        Schema::dropIfExists('progres_kategori');
    }
}
