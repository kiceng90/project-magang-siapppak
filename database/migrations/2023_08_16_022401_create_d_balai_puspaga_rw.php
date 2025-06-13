<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDBalaiPuspagaRw extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('d_balai_puspaga_rw', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('id_wilayah')->references('id')->on('m_wilayah')->onDelete('cascade');
            $table->foreignId('id_kelurahan')->references('id')->on('m_kelurahan')->onDelete('cascade');
            $table->foreignId('id_konselor')->references('id')->on('m_konselor')->onDelete('cascade');
            $table->integer('rw');
            $table->text('address');
            $table->string('rw_name');
            $table->string('rw_phone');
            $table->string('operational_day');
            $table->string('operational_start_time');
            $table->string('operational_end_time');
            $table->integer('inauguration_year');
            $table->boolean('is_active')->default(false);
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
        Schema::dropIfExists('d_balai_puspaga_rw');
    }
}
