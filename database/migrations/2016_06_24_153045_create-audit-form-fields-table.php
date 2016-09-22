<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAuditFormFieldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('audit_form_fields', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('audit_form_id');
            $table->string('name');
            $table->string('tag');
            $table->longText('value');
            $table->smallInteger('column_size');
            $table->json('attributes');
            $table->json('options');
            $table->softDeletes();
            $table->timestamps();
            
            //$table->foreign('audit_form_id')->references('id')->on('audit_forms')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('audit_form_fields');
    }
}
