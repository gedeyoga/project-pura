<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFotoPurasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('foto_pura', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pura_id');
            $table->text('fp_url');
            $table->text('fp_keterangan')->nullable();
            $table->timestamps();

            $table->foreign('pura_id')->references('id')->on('pura')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('foto_pura');
    }
}
