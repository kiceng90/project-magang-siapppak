<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePengaduanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pengaduan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_sumber_keluhan')->nullable()->references('id')->on('m_sumber_keluhan')->onDelete('cascade');
            $table->string('registration_number');
            $table->dateTime('complaint_date');
            $table->string('complainant_name');
            $table->string('complainant_nik');
            $table->string('complainant_phone_number');
            $table->boolean('complainant_is_surabaya_resident')->default(true);
            $table->foreignId('complainant_id_kabupaten')->nullable()->references('id')->on('m_kabupaten')->onDelete('cascade');
            $table->text('complainant_residence_address');
            $table->integer('client_type');
            $table->foreignId('id_klien')->nullable()->references('id')->on('daftar_klien')->onDelete('cascade');
            $table->text('problem_description');
            $table->foreignId('id_status')->nullable()->references('id')->on('status')->onDelete('cascade');
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
        Schema::dropIfExists('pengaduan');
    }
}
