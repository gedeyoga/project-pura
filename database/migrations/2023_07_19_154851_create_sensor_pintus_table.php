<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSensorPintusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sensor_pintu', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pura_id');
            $table->string('gs_kode_sensor' , 100);
            $table->string('gs_nama');
            $table->enum('gs_sensor_pintu' , [1,0])->default(0);
            $table->enum('guard_state' , [1,0])->default(0);
            $table->string('token');
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
        Schema::dropIfExists('sensor_pintu');
    }
}
