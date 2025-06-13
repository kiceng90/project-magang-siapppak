<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIdPengaduanInKonselingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

     public function up()
     {
        Schema::table('konseling', function (Blueprint $table) {
            $table->foreignId('id_pengaduan')->nullable()->references('id')->on('pengaduan')->onDelete('cascade');
        });
     }
 
     /**
      * Reverse the migrations.
      *
      * @return void
      */
     public function down()
     {
        Schema::table('konseling', function (Blueprint $table) {
            $table->dropForeign('konseling_id_pengaduan_foreign');
            $table->dropColumn('id_pengaduan');
        });
     }
}
