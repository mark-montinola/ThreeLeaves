<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class KramFormFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kram_form_fields', function (Blueprint $table) {
            $table->increments('id');
            $table->string('form_id', 10);
            $table->string('kdw', 5);
            $table->string('column_name', 50);
            $table->unique(['form_id', 'kdw', 'column_name']);
            $table->string('icon', 30)->nullable();
            $table->longText('field_properties')->nullable();
            $table->longText('field_properties_fm')->nullable();
            $table->integer('order')->default(0);
            $table->string('created_by', 20)->nullable();
            $table->string('updated_by', 20)->nullable();
            $table->timestamps();
            $table->integer('version')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kram_form_fields');
    }
}
