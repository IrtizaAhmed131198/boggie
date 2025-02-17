<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateFavoriteDjsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('favorite_djs', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('dj_id')->nullable();
            $table->string('description')->nullable();
            $table->string('image')->nullable();
            $table->string('is_approved')->nullable();
            $table->string('auth_id')->nullable();
            });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('favorite_djs');
    }
}
