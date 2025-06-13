<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLangkahDilakukanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('langkah_dilakukan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_penjangkauan')->references('id')->on('penjangkauan')->onDelete('cascade');
            $table->integer('service_type');
            $table->date('service_date');
            $table->foreignId('id_pelayanan')->nullable()->constrained("m_pelayanan")->cascadeOnUpdate()->nullOnDelete();
            $table->text('description')->nullable();
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
        Schema::dropIfExists('langkah_dilakukan');
    }
}
