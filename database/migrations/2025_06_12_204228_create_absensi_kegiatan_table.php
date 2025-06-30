<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAbsensiKegiatanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('absensi_kegiatan', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->char('nik', 16)->unique(); 
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan']);
            $table->enum('status', ['Anak (<18)', 'Dewasa (>18)']);
            $table->text('alamat_ktp');
            $table->string('kecamatan_ktp');
            $table->string('kelurahan_ktp');
            $table->string('alamat_domisili');
            $table->string('kecamatan_domisili');
            $table->string('kelurahan_domisili');
            $table->date('tanggal_lahir');
            $table->string('nomor_hp');
            $table->string('pendidikan_terakhir');
            $table->enum('metode', ['Online', 'Offline']);
            $table->string('anda_adalah')->nullable();
            $table->string('instansi')->nullable();
            $table->string('alamat_instansi')->nullable();
            $table->string('kecamatan_instansi')->nullable();
            $table->string('kelurahan_instansi')->nullable();
            $table->text('unggah_ktp')->nullable(); 
            $table->text('unggah_foto')->nullable(); 
            $table->text('tanda_tangan')->nullable(); 
            $table->tinyInteger('rating_kegiatan')->nullable();
            $table->text('kritik_saran')->nullable();
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
        Schema::dropIfExists('absensi_kegiatan');
    }
}
