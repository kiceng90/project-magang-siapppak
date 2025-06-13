<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsExcludedExportToMKuesionerLaporanMonevTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('m_kuesioner_laporan_monev', function (Blueprint $table) {
            $table->boolean('is_excluded_export')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('m_kuesioner_laporan_monev', function (Blueprint $table) {
            $table->dropColumn('is_excluded_export');
        });
    }
}
