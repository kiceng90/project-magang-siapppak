<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterPuspagaRwTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('puspaga_rw', function (Blueprint $table) {
            $table->dropColumn([
                'id_kelurahan', 'instansi_position', 'sk_position',
            ]);
            $table->foreignId('id_jabatan_dalam_instansi')->nullable()->constrained("m_jabatan_dalam_instansi")->cascadeOnUpdate()->nullOnDelete();
            $table->foreignId('id_kedudukan_dalam_tim')->nullable()->constrained("m_kedudukan_dalam_tim")->cascadeOnUpdate()->nullOnDelete();
            $table->foreignId('id_kelurahan_domisili')->nullable()->constrained("m_kelurahan")->cascadeOnUpdate()->nullOnDelete();
            $table->string('alamat_domisili')->nullable();
            $table->string('rt_domisili')->nullable();
            $table->string('rw_domisili')->nullable();
            $table->foreignId('id_kelurahan_ktp')->nullable()->constrained("m_kelurahan")->cascadeOnUpdate()->nullOnDelete();
            $table->string('alamat_ktp')->nullable();
            $table->string('rt_ktp')->nullable();
            $table->string('rw_ktp')->nullable();
            $table->string('no_hp')->nullable();
            $table->string('email')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('puspaga_rw', function (Blueprint $table) {
            $table->string('instansi_position')->nullable();
            $table->string('sk_position')->nullable();
            $table->foreignId('id_kelurahan')->nullable()->constrained("m_kelurahan")->cascadeOnUpdate()->nullOnDelete();
            $table->dropColumn([
                'id_jabatan_dalam_instansi', 'id_kedudukan_dalam_tim', 'id_kelurahan_domisili',
                'alamat_domisili', 'rt_domisili', 'rw_domisili', 'id_kelurahan_ktp', 'alamat_ktp',
                'rt_ktp', 'rw_ktp', 'no_hp', 'email',
            ]);
        });
    }
}
