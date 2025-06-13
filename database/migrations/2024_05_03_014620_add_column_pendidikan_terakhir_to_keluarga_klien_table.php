<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnPendidikanTerakhirToKeluargaKlienTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('keluarga_klien', function (Blueprint $table) {
            $table->unsignedBigInteger('id_pendidikan_terakhir');
            $table->foreign("id_pendidikan_terakhir")->references("id")->on('m_pendidikan_terakhir')->onDelete("cascade");
            $table->foreignId('id_jurusan')->nullable()->references('id')->on('m_jurusan')->onDelete('cascade');
            $table->integer('highest_class')->nullable();
            $table->integer('graduation_year')->nullable();
            $table->string('school_name')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('keluarga_klien', function (Blueprint $table) {
            $table->dropColumn('id_pendidikan_terakhir');
            $table->dropColumn('id_jurusan');
            $table->dropColumn('highest_class');
            $table->dropColumn('graduation_year');
            $table->dropColumn('school_name');
        });
    }
}
