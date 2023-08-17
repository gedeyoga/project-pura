<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropColumnSensorPintuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sensor_pintu', function (Blueprint $table) {
            $table->dropColumn(['guard_state', 'token']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sensor_pintu', function (Blueprint $table) {
            $table->enum('guard_state', [1, 0])->default(0);
            $table->string('token')->nullable();
        });
    }
}
