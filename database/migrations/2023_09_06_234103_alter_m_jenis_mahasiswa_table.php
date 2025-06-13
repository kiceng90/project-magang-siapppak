<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterMJenisMahasiswaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        if (Schema::hasColumn('m_jenis_mahasiswa', 'status')) {
            Schema::table('m_jenis_mahasiswa', function (Blueprint $table) {
                $table->dropColumn('status');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (!Schema::hasColumn('m_jenis_mahasiswa', 'status')) {
            Schema::table('m_jenis_mahasiswa', function (Blueprint $table) {
                $table->integer('status')->default(0);
            });
        }
    }
}
