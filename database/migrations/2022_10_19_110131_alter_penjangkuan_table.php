<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterPenjangkuanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('penjangkauan', function (Blueprint $table) {
            $table->boolean('klien_draft_status')->nullable()->default(null)->change();
            $table->boolean('keluarga_klien_draft_status')->nullable()->default(null)->change();
            $table->boolean('pelaku_draft_status')->nullable()->default(null)->change();
            $table->boolean('situasi_keluarga_draft_status')->nullable()->default(null)->change();
            $table->boolean('kronologi_kejadian_draft_status')->nullable()->default(null)->change();
            $table->boolean('harapan_klien_draft_status')->nullable()->default(null)->change();
            $table->boolean('kondisi_klien_draft_status')->nullable()->default(null)->change();
            $table->boolean('analisis_dp3kappkb_draft_status')->nullable()->default(null)->change();
            $table->boolean('rencana_intervensi_draft_status')->nullable()->default(null)->change();
            $table->boolean('langkah_dilakukan_draft_status')->nullable()->default(null)->change();
            $table->boolean('dokumen_pendukung_draft_status')->nullable()->default(null)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('penjangkauan', function (Blueprint $table) {
            $table->boolean('klien_draft_status')->nullable(false)->default(true)->change();
            $table->boolean('keluarga_klien_draft_status')->nullable(false)->default(true)->change();
            $table->boolean('pelaku_draft_status')->nullable(false)->default(true)->change();
            $table->boolean('situasi_keluarga_draft_status')->nullable(false)->default(true)->change();
            $table->boolean('kronologi_kejadian_draft_status')->nullable(false)->default(true)->change();
            $table->boolean('harapan_klien_draft_status')->nullable(false)->default(true)->change();
            $table->boolean('kondisi_klien_draft_status')->nullable(false)->default(true)->change();
            $table->boolean('analisis_dp3kappkb_draft_status')->nullable(false)->default(true)->change();
            $table->boolean('rencana_intervensi_draft_status')->nullable(false)->default(true)->change();
            $table->boolean('langkah_dilakukan_draft_status')->nullable(false)->default(true)->change();
            $table->boolean('dokumen_pendukung_draft_status')->nullable(false)->default(true)->change();
        });
    }
}
