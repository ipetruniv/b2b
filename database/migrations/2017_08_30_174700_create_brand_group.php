<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBrandGroup extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('brand_group', function (Blueprint $table) {
            $table->integer('group_id')->unsigned()->comment('ID Групи');
            $table->integer('brand_id')->unsigned()->comment('ID Бренду');
            $table->foreign('group_id')->references('id')->on('groups')->onDelete('cascade'); 
            $table->foreign('brand_id')->references('id')->on('brands')->onDelete('cascade');
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
        Schema::dropIfExists('brand_group');
    }
}
