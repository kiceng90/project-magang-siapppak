<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMKegiatanPuspagaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('m_kegiatan_puspaga', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_program_kegiatan')->constrained('m_program_kegiatan')->onDelete('cascade');
            $table->foreignId('id_jenis_kegiatan')->constrained('m_jenis_kegiatan')->onDelete('cascade');
            $table->foreignId('id_bentuk_kegiatan')->constrained('m_bentuk_kegiatan')->onDelete('cascade');
            $table->date('tanggal_kegiatan');
            $table->time('jam_kegiatan');
            $table->enum('jenis_kelas', ['online', 'offline']);
            $table->string('link_kelas')->nullable(); // Hanya diisi jika online
            $table->string('judul_kegiatan');
            $table->text('sasaran_kegiatan');
            $table->string('tempat_kegiatan')->nullable(); // Hanya diisi jika offline
            $table->string('narasumber');
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
        Schema::dropIfExists('m_kegiatan_puspaga');
    }
}
