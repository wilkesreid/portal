<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveUserInlineSettings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users',function($table){
	       $table->dropColumn('role');
	       $table->dropColumn('theme_id');
	       $table->dropColumn('clocked_in');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users',function($table) {
	       $table->string('role');
	       $table->integer('theme'); 
	       $table->boolean('clocked_in');
        });
    }
}
