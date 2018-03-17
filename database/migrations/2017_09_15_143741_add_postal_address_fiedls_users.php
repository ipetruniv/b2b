<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPostalAddressFiedlsUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('post_country', 50)->nullable();
            $table->string('post_region', 50)->nullable();
            $table->string('post_city', 50)->nullable();
            $table->string('post_street', 50)->nullable();
            $table->string('post_post_code', 50)->nullable();
            $table->string('login', 50)->nullable();
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
