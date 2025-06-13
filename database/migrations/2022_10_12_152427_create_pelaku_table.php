<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePelakuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pelaku', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_penjangkauan')->references('id')->on('penjangkauan')->onDelete('cascade');
            $table->string('name');
            $table->string('initials_name');
            $table->integer('gender');
            $table->integer('citizenship');
            $table->foreignId('id_hubungan')->nullable()->constrained("m_hubungan")->cascadeOnUpdate()->nullOnDelete();
            $table->foreignId('id_kabupaten_lahir')->nullable()->constrained("m_kabupaten")->cascadeOnUpdate()->nullOnDelete();
            $table->date('birth_date')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('nik_number')->nullable();
            $table->string('kk_number')->nullable();
            $table->string('residence_address')->nullable();
            $table->foreignId('id_kelurahan_tinggal')->nullable()->constrained("m_kelurahan")->cascadeOnUpdate()->nullOnDelete();
            $table->string('kk_address')->nullable();
            $table->foreignId('id_kelurahan_kk')->nullable()->constrained("m_kelurahan")->cascadeOnUpdate()->nullOnDelete();
            $table->foreignId('id_agama')->nullable()->constrained("m_agama")->cascadeOnUpdate()->nullOnDelete();
            $table->foreignId('id_pekerjaan')->nullable()->constrained("m_pekerjaan")->cascadeOnUpdate()->nullOnDelete();
            $table->foreignId('id_status_pernikahan')->nullable()->constrained("m_status_pernikahan")->cascadeOnUpdate()->nullOnDelete();
            $table->foreignId('id_pendidikan_terakhir')->nullable()->constrained("m_pendidikan_terakhir")->cascadeOnUpdate()->nullOnDelete();
            $table->integer('highest_class')->nullable();
            $table->foreignId('id_jurusan')->nullable()->constrained("m_jurusan")->cascadeOnUpdate()->nullOnDelete();
            $table->integer('graduation_year')->nullable();
            $table->string('school_name')->nullable();
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
        Schema::dropIfExists('pelaku');
    }
}
