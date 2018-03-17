<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserAddressTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_address', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('user_code_1c',255)->comment('Унікальний код юзера');
            $table->string('address', 255)->nulablle()->comment('Аддрес з 1С');
            $table->string('phone', 30)->nulablle()->comment('Номер телефону');
            $table->string('email', 255)->nulablle()->comment('Email');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_address');
    }
}
