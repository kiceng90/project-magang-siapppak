<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAbsensiKelasCatinTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('absensi_kelas_catin', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->char('nik', 16)->unique(); // NIK KTP 16 digit
            $table->text('alamat');
            $table->string('kecamatan_ktp');
            $table->string('kelurahan_ktp');
            $table->date('tanggal_lahir');
            $table->string('nomor_hp');
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan']);
            $table->string('pendidikan_terakhir');
            $table->enum('jenis_kelas', ['Online', 'Offline']);
            $table->string('alamat_email')->nullable();
            $table->string('unggah_ktp')->nullable(); // Base64 atau path file
            $table->string('unggah_foto')->nullable(); // Base64 atau path file
            $table->text('rating_kegiatan')->nullable();
            $table->text('kritik_saran')->nullable();
            $table->string('tanda_tangan')->nullable(); // Base64 tanda tangan
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
        Schema::dropIfExists('absensi_kelas_catin');
    }
}
