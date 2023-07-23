<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGedongSimpensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gedong_simpen', function (Blueprint $table) {
            $table->id();
            $table->string('gs_nama');
            $table->enum('gs_sensor_pintu' , [1,0])->default(0);
            // $table->unsignedBigInteger('pura_id');
            $table->bigInteger('pura_id');
            $table->string('gs_kode_sensor' , 100);
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
        Schema::dropIfExists('gedong_simpen');
    }
}
