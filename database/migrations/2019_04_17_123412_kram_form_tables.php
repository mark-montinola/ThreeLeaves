<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class KramFormTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kram_form_tables', function (Blueprint $table) {
            $table->increments('id');
            $table->string('form_id', 10);
            $table->string('kdw', 5);
            $table->unique(['form_id', 'kdw']);
            $table->string('table', 50);
            $table->string('description', 50)->unique();
            $table->string('presentation_style', 20);
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
        Schema::dropIfExists('kram_form_tables');
    }
}
