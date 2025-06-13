<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRencanaIntervensiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::create('rencana_intervensi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_penjangkauan')->references('id')->on('penjangkauan')->onDelete('cascade');
            $table->foreignId('id_kebutuhan')->nullable()->references('id')->on('m_kebutuhan')->onDelete('cascade');
            $table->foreignId('id_opd')->references('id')->on('m_opd')->onDelete('cascade');
            $table->foreignId('id_intervensi')->references('id')->on('m_intervensi')->onDelete('cascade');
            $table->longText('description');
            $table->boolean('realisasi_draft_status')->default(true);
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
        Schema::dropIfExists('rencana_intervensi');
    }
}
