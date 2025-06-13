<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateMKebutuhanLayanan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('m_kebutuhan_layanan', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->boolean('is_active')->default(true);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        // Insert data default dengan ID tetap
        DB::table('m_kebutuhan_layanan')->insert([
            ['id' => 1, 'name' => 'Informasi', 'is_active' => true],
            ['id' => 2, 'name' => 'Kelas Calon Pengantin', 'is_active' => true],
            ['id' => 3, 'name' => 'Rujukan', 'is_active' => true],
            ['id' => 4, 'name' => 'Konsultasi ', 'is_active' => true],
            ['id' => 5, 'name' => 'Telekonsultasi', 'is_active' => true],
            ['id' => 6, 'name' => 'Konseling', 'is_active' => true],
            ['id' => 7, 'name' => 'Konseling Lanjutan', 'is_active' => true],
            ['id' => 8, 'name' => 'Kunjungan', 'is_active' => true],
            ['id' => 9, 'name' => 'Bimbingan Masyarakat', 'is_active' => true],
            ['id' => 10, 'name' => 'Bermain', 'is_active' => true],
            ['id' => 11, 'name' => 'Laktasi', 'is_active' => true],
            ['id' => 12, 'name' => 'Penjangkauan', 'is_active' => true],
            ['id' => 13, 'name' => 'Rapat', 'is_active' => true],
            ['id' => 14, 'name' => 'Pinjam Tempat', 'is_active' => true],
            ['id' => 15, 'name' => 'Maintenance', 'is_active' => true],  
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('m_kebutuhan_layanan');
    }
}
