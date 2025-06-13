<?php

use App\Helpers\DayEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMJadwalKonselingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('m_jadwal_konseling', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_konselor')->references('id')->on('m_konselor')->onDelete('cascade');
            $table->enum('day',[1,2,3,4,5,6,7]);
            $table->boolean('is_active')->default(false);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('m_jadwal_konseling');
    }
}
