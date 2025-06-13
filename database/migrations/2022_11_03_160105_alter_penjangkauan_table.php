<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterPenjangkauanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('penjangkauan', function (Blueprint $table) {
            $table->boolean('pendampingan')->nullable();
            $table->string('nama_wali')->nullable();
            $table->string('nomor_telepon_wali')->nullable();
            $table->string('saksi1')->nullable();
            $table->string('saksi2')->nullable();
            $table->text('hasil_pendampingan')->nullable();
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
            $table->dropColumn([
                'pendampingan', 'nama_wali', 'nomor_telepon_wali',
                'saksi1', 'saksi2', 'hasil_pendampingan'
            ]);
        });
    }
}
