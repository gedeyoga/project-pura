<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pura', function (Blueprint $table) {
            $table->id();
            $table->string('pura_nama');
            $table->text('pura_alamat');
            $table->double('pura_lat');
            $table->double('pura_lng');
            $table->unsignedInteger('jp_id');
            $table->unsignedInteger('kel_id')->nullable();
            $table->string('pura_ip', 100);
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
        Schema::dropIfExists('pura');
    }
}
