<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMRumahPerubahanPilihanJawabanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('m_rumah_perubahan_pilihan_jawaban', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_soal')->references('id')->on('m_rumah_perubahan_soal')->onDelete('cascade');
            $table->char('abjad', 1);
            $table->text('pilihan');
            $table->boolean('is_active')->default(true);
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
        Schema::dropIfExists('m_rumah_perubahan_pilihan_jawaban');
    }
}
