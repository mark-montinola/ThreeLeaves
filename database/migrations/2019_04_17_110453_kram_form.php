<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class KramForm extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kram_form', function (Blueprint $table) {
            $table->string('id', 10)->primary();
            $table->string('description', 50)->unique();
            $table->string('module', 5);
            $table->string('category', 5);
            $table->string('presentation_style', 20);
            $table->char('active', 1)->default('Y');
            $table->integer('order')->default(0);
            $table->char('has_parent', 1)->default('N');
            $table->string('parent_form_id', 10)->nullable();
            $table->char('has_child', 1)->default('N');
            $table->string('child_form_id', 10)->nullable();
            $table->string('icon', 30)->nullable();
            $table->string('remarks')->nullable();
            $table->string('route_vue')->nullable();
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
        Schema::dropIfExists('kram_form');
    }
}
