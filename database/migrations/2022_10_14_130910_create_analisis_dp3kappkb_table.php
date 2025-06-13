<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnalisisDp3kappkbTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('analisis_dp3kappkb', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_penjangkauan')->references('id')->on('penjangkauan')->onDelete('cascade');
            $table->foreignId('id_pelayanan')->nullable()->constrained("m_pelayanan")->cascadeOnUpdate()->nullOnDelete();
            $table->text('description');
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
        Schema::dropIfExists('analisis_dp3kappkb');
    }
}
