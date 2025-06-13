<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBukuTamu extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('buku_tamu', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_pendaftaran')->unique()->nullable();
            $table->string('nik');
            $table->string('nama');
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->integer('usia');
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan']);
            $table->text('alamat_ktp');
            $table->string('rt_ktp');
            $table->string('rw_ktp');
            $table->string('kel_desa_ktp');
            $table->string('kecamatan_ktp');
            $table->string('kota_kabupaten_ktp');
            $table->string('provinsi');
            $table->string('agama');
            $table->string('status_perkawinan');
            $table->string('kewarganegaraan');
            $table->string('foto_ktp')->nullable();
            $table->boolean('disposisi')->default(false);
            $table->foreignId('ktp_id')->nullable()->constrained('k_t_p_s')->onDelete('cascade');
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
        Schema::dropIfExists('buku_tamu');
    }
}
