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
            $table->char('nik', 16)->unique(); // NIK 16 digit
            $table->string('alamat_email')->nullable();
            $table->text('alamat');
            $table->string('kecamatan_ktp');
            $table->string('kelurahan_ktp');
            $table->date('tanggal_lahir');
            $table->string('nomor_hp');
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan']);
            $table->string('pendidikan_terakhir');
            $table->enum('jenis_kelas', ['Online', 'Offline']);
            $table->string('instansi');
            $table->string('alamat_domisili');
            $table->string('kecamatan_domisili');
            $table->string('kelurahan_domisili');
            $table->text('unggah_ktp')->nullable(); // Base64
            $table->text('unggah_foto')->nullable(); // Base64 selfie
            $table->text('tanda_tangan')->nullable(); // Base64 signature
            $table->integer('rating_kegiatan')->nullable(); // Rating 1-5
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
