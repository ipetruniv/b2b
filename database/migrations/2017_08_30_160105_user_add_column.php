<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UserAddColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('user_code_1c',255)->nullable()->comment('Унікальний код з 1С');
            $table->string('surname',191)->nullable()->comment('Прізвище');
            $table->string('company',255)->nullable()->comment('Компанія'); 
            $table->string('vat',255)->nullable()->comment('VAT');  
            $table->string('country',255)->nullable()->comment('Країна');
            $table->string('region',255)->nullable()->comment('Область');
            $table->string('city',255)->nullable()->comment('Місто');
            $table->string('street',255)->nullable()->comment('Вулиця');
            $table->string('build',255)->nullable()->comment('Будинок');
            $table->string('post_code',100)->nullable()->comment('Поштовий індекс');
            $table->tinyInteger('is_legal')->unsigned()->nullable()->comment('Легальний');
            $table->string('phone',255)->nullable()->comment('Телефон'); 
            $table->tinyInteger('user_is_synk')->default(0)->comment('Статус синхронізації 1-так\0-ні');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
}
