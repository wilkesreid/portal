<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveTimesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::dropIfExists('times');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('times', function (Blueprint $table) {
            $table->increments('id');
            $table->text('user_id');
            $table->dateTime('time_started');
            $table->dateTime('time_ended');
            $table->timestamps();
        });
    }
}
