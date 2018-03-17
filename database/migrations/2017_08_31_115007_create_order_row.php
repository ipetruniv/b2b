<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderRow extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_row', function (Blueprint $table) {
            $table->integer('order_id')->unsigned()->comment('ID замовлення');
            $table->integer('product_id')->unsigned()->comment('ID товара');
            $table->integer('count')->unsigned()->comment('Кількість');
            $table->double('price')->unsigned()->comment('Ціна позиції');
            $table->double('price_sum')->unsigned()->comment('Ціна всієї позиції');
            $table->text('comment')->nullable()->comment('Коментар до товару');
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_row');
    }
}
