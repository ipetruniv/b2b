<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGroupSettings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('group_settings', function (Blueprint $table) {
            $table->integer('group_id')->unsigned()->comment('ID групи');
            $table->tinyInteger('type_currency')->default(1)->comment('Тип валюти 1-$/2-€');
            $table->tinyInteger('type_payment')->default(1)->comment('');
            $table->string('price_1',6)->nullable()->comment('Перша ціна');
            $table->string('price_2',6)->nullable()->comment('Друга ціна');
            $table->string('price_3',6)->nullable()->comment('Третя ціна');
            $table->foreign('group_id')->references('id')->on('groups')->onDelete('cascade');     
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
        Schema::dropIfExists('group_settings');
    }
}
