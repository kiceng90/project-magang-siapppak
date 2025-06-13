<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterLaporanMonevTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        if (Schema::hasColumn('laporan_monev', 'id_mahasiswa_balai_puspaga_rw')) {
            Schema::table('laporan_monev', function (Blueprint $table) {
                $table->dropForeign('laporan_monev_id_mahasiswa_balai_puspaga_rw_foreign');
                $table->dropColumn('id_mahasiswa_balai_puspaga_rw');
                
                $table->foreignId('id_d_balai_puspaga_rw')->references('id')->on("d_balai_puspaga_rw")->onDelete('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    }
}
