<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class LengthenPasswordAndUsernameFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('credentials',function($table){
	       $table->string('username',500)->change();
	       $table->string('password',500)->change(); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('credentials',function($table){
	       $table->string('username',255)->change();
	       $table->string('password',255)->change(); 
        });
    }
}
