<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIdentifikasiKebutuhansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('identifikasi_kebutuhans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('buku_tamu_id')->constrained('buku_tamu')->onDelete('cascade');
            $table->boolean('dpa')->default(false);
            $table->string('narasi')->nullable();
            $table->text('hasil_assesment')->nullable();
            $table->boolean('disposisi_pimpinan')->default(true);
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
        Schema::dropIfExists('identifikasi_kebutuhans');
    }
}
