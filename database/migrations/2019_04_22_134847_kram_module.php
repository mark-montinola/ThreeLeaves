<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class KramModule extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kram_module', function (Blueprint $table) {
            $table->string('id', 5)->primary();
            $table->string('description', 50);
            $table->unique(['description']);
            $table->string('active')->default('Y');
            $table->string('icon', 30)->nullable();
            $table->string('remarks')->nullable();
            $table->integer('order')->default(0);
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
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
        Schema::dropIfExists('kram_module');
    }
}
