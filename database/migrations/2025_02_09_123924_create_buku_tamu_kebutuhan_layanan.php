<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBukuTamuKebutuhanLayanan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('buku_tamu_kebutuhan_layanan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('buku_tamu_id')->constrained('buku_tamu')->onDelete('cascade');
            $table->foreignId('m_kebutuhan_layanan_id')->constrained('m_kebutuhan_layanan')->onDelete('cascade');
            $table->boolean('is_filled')->default(false);
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
        Schema::dropIfExists('buku_tamu_kebutuhan_layanan');
    }
}
