<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePkbmTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pkbm', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('nik')->nullable();
            $table->string('sk_number')->nullable();
            $table->date('sk_date')->nullable();

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
        Schema::dropIfExists('pkbm');
    }
}
