<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMahasiswaBalaiPuspagaRwTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mahasiswa_balai_puspaga_rw', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_mahasiswa')->references('id')->on('d_mahasiswa')->onDelete('cascade');
            $table->foreignId('id_balai_puspaga_rw')->references('id')->on('d_balai_puspaga_rw')->onDelete('cascade');
            $table->foreignId('id_konselor')->references('id')->on('m_konselor')->onDelete('cascade');
            $table->boolean('is_active')->default(true);
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
        Schema::dropIfExists('mahasiswa_balai_puspaga_rw');
    }
}
