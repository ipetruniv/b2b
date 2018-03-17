<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('order_user')->unsigned()->comment('ID користувача');
            $table->double('order_sum')->comment('Сума замовлення');
            $table->tinyInteger('order_synk_1c')->default(0)->unsigned()->comment('0-ні 1-так');
            $table->foreign('order_user')->references('id')->on('users')->onDelete('cascade');
            $table->tinyInteger('order_status')->default(1)->unsigned()->comment('1-відкритий'
                                                                               . '2-очікування'
                                                                               . '3-в роботі'
                                                                               . '4-готовий до віднрузки'
                                                                               . '5-відгружений');
            $table->date('desirable_delivery')->nullable()->comment('Дата бажаної доставки');
            $table->tinyInteger('payment_method')->default(1)->unsigned()->comment('1-paypal 2-stripe 3-Visa');
            $table->tinyInteger('person')->default(1)->unsigned()->comment('1-Фізична 2-Юридична');
            $table->text('order_comment')->nullable()->comment('Коментар до замовлення');
            $table->string('order_company',255)->nullable()->comment('Компанія'); 
            $table->string('order_country',255)->nullable()->comment('Країна');
            $table->string('order_region',255)->nullable()->comment('Область');
            $table->string('order_city',255)->nullable()->comment('Місто');
            $table->string('order_street',255)->nullable()->comment('Вулиця');
            $table->string('order_build',255)->nullable()->comment('Будинок');
            $table->string('order_post_code',100)->nullable()->comment('Поштовий індекс');
            $table->string('order_email',255)->nullable()->comment('email');

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
        Schema::dropIfExists('orders');
    }
}
