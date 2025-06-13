<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormTelekonsultasisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('form_telekonsultasis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('buku_tamu_kebutuhan_layanan_id')->constrained('buku_tamu_kebutuhan_layanan')->onDelete('cascade');
            $table->string('nomor_telepon');
            $table->dateTime('jadwal_konsultasi');
            $table->text('keluhan');
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
        Schema::dropIfExists('form_telekonsultasis');
    }
}
