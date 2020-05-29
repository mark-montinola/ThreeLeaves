<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PoDetail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('po_detail', function (Blueprint $table) {
            $table->integer('id');
            $table->integer('no');
            $table->primary(['id', 'no']);
            $table->integer('item_id');
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
        Schema::dropIfExists('po_detail');
    }
}
