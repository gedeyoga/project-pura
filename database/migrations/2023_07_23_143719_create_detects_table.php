<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('pura')) {
            Schema::create('detect', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('pura');
                $table->date('tanggal');
                $table->time('waktu');
                $table->text('path_image');
            });
        }
       
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detect');
    }
}
