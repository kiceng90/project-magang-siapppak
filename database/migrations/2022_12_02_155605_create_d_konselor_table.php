<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDKonselorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('d_konselor', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_m_konselor')->nullable()->constrained("m_konselor")->cascadeOnUpdate()->cascadeOnDelete();
            $table->string('nik')->nullable()->unique();
            $table->date('tmt_tugas')->nullable();
            $table->foreignId('id_kelurahan_domisili')->nullable()->constrained("m_kelurahan")->cascadeOnUpdate()->nullOnDelete();
            $table->string('alamat_domisili')->nullable();
            $table->string('rt_domisili')->nullable();
            $table->string('rw_domisili')->nullable();
            $table->foreignId('id_kelurahan_ktp')->nullable()->constrained("m_kelurahan")->cascadeOnUpdate()->nullOnDelete();
            $table->string('alamat_ktp')->nullable();
            $table->string('rt_ktp')->nullable();
            $table->string('rw_ktp')->nullable();
            $table->foreignId('id_kabupaten_lahir')->nullable()->constrained("m_kabupaten")->cascadeOnUpdate()->nullOnDelete();
            $table->date('tanggal_lahir')->nullable();
            $table->foreignId('id_pendidikan_terakhir')->nullable()->constrained("m_pendidikan_terakhir")->cascadeOnUpdate()->nullOnDelete();
            $table->foreignId('id_jurusan')->nullable()->constrained("m_jurusan")->cascadeOnUpdate()->nullOnDelete();
            $table->foreignId('id_instansi_pendidikan')->nullable()->constrained("m_instansi_pendidikan")->cascadeOnUpdate()->nullOnDelete();
            $table->enum('status', ['konselor', 'psikolog'])->nullable();
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
        Schema::dropIfExists('d_konselor');
    }
}
