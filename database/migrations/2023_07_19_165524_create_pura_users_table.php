<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePuraUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pura_users', function (Blueprint $table) {
            $table->integer('user_id')->unsigned();
            // $table->integer('pura_id')->unsigned();
            $table->integer('pura_id');
            $table->nullableTimestamps();
            $table->primary(['user_id', 'pura_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pura_users');
    }
}
