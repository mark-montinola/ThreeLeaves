<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PoHeader extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('po_header', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('supplier_id');
            $table->dateTime('date');
            $table->char('status');
            $table->string('currency');
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
        Schema::dropIfExists('po_header');
    }
}
