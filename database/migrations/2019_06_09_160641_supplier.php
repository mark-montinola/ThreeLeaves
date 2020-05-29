<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Supplier extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('supplier', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->unique(['name']);
            $table->string('address');
            $table->string('phone_number')->comment('["inputType":"text"]');
            $table->string('fax_number');
            $table->string('email')->comment('["inputType":"email"]');
            $table->string('website')->comment('["inputType":"url"]');
            $table->string('tin_number');
            $table->string('currency_id');
            $table->string('active');
            $table->string('credit_term');
            $table->string('tax_code');
            $table->string('tax_inclusive');
            $table->string('ship_via_id');
            $table->string('acct_id');
            $table->string('acct_id_bulk');
            $table->string('acct_id_ir');
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
        Schema::dropIfExists('supplier');
    }
}
