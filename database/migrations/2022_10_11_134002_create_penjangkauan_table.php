<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePenjangkauanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     public function up()
    {
        Schema::create('penjangkauan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_pengaduan')->references('id')->on('pengaduan')->onDelete('cascade');
            $table->dateTime('date')->nullable();
            $table->text('location')->nullable();
            $table->text('address')->nullable();
            $table->integer('case_type')->nullable();
            $table->foreignId('id_jenis_kasus')->nullable()->references('id')->on('m_jenis_kasus')->onDelete('cascade');
            $table->foreignId('id_lokasi_kejadian')->nullable()->references('id')->on('m_lokasi_kejadian')->onDelete('cascade');
            $table->longText('case_description')->nullable();
            $table->dateTime('case_date')->nullable();
            $table->boolean('draft_status')->default(true);
            $table->boolean('klien_draft_status')->default(true);
            $table->boolean('keluarga_klien_draft_status')->default(true);
            $table->boolean('pelaku_draft_status')->default(true);
            $table->boolean('situasi_keluarga_draft_status')->default(true);
            $table->boolean('kronologi_kejadian_draft_status')->default(true);
            $table->boolean('harapan_klien_draft_status')->default(true);
            $table->boolean('kondisi_klien_draft_status')->default(true);
            $table->boolean('analisis_dp3kappkb_draft_status')->default(true);
            $table->boolean('rencana_intervensi_draft_status')->default(true);
            $table->boolean('langkah_dilakukan_draft_status')->default(true);
            $table->boolean('dokumen_pendukung_draft_status')->default(true);

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
        Schema::dropIfExists('penjangkauan');
    }
}
