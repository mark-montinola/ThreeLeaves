<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Item extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item', function (Blueprint $table) {
            $table->increments('id');
            $table->string('description', 50);
            $table->string('category', 10)->nullable();
            $table->string('uom', 5)->nullable();
            $table->string('barcode', 50)->nullable();
            $table->char('priority', 1)->default('N');
            $table->decimal('min_inv_qty', 13, 5)->default(0);
            $table->decimal('max_inv_qty', 13, 5)->default(0);
            $table->char('active', 1)->default('Y');
            $table->char('inventoriable', 1)->default('N');
            $table->char('kit', 1)->default('N');
            $table->string('photo')->nullable();
            $table->string('remarks')->nullable();;
            $table->string('created_by')->nullable();;
            $table->string('updated_by')->nullable();;
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
        Schema::dropIfExists('item');
    }
}
