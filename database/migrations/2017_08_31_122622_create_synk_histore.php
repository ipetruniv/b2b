<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSynkHistore extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('synk_histore', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->tinyInteger('status')->unsigned()->default(0)->comment('0-неуспішно 1-успішно');
            $table->string('table_value')->nullable()->comment('назва таблиці');
            $table->text('error_info')->nullable()->comment('Текст помилки');
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
        Schema::dropIfExists('synk_histore');
    }
}
