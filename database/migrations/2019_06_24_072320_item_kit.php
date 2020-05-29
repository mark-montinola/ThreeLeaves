<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ItemKit extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item_kit', function (Blueprint $table) {
            $table->integer('id');
            $table->integer('item_kit_id');
            $table->primary(['id', 'item_kit_id']);
            $table->string('uom', 5);
            $table->decimal('quantity', 13, 5)->default(0);
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
        Schema::dropIfExists('item_kit');
    }
}
