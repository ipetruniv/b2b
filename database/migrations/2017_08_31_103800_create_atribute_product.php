<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAtributeProduct extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('atribute_product', function (Blueprint $table) {
            $table->integer('attr_prod_id')->unsigned()->comment('ID Продукта');
            $table->integer('attr_id')->unsigned()->comment('ID Атрибута');
            $table->string('value',255)->comment('Значення атрибута');   
            $table->foreign('attr_prod_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('attr_id')->references('id')->on('atributes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('atribute_product');
    }
}
