<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSensorCctvTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sensor_cctv', function (Blueprint $table) {
            $table->id();
            $table->string('gs_kode_sensor');
            $table->text('cctv_photo');
            $table->enum('cctv_status' , [1,0]);
            $table->unsignedBigInteger('pura_id');
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
        Schema::dropIfExists('sensor_cctv');
    }
}
