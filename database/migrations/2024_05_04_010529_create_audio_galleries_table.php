<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAudioGalleriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('audio_galleries', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('category')->nullable();
            $table->string('audio_title')->nullable();
            $table->string('description')->nullable();
            $table->string('file')->nullable();
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
        Schema::drop('audio_galleries');
    }
}
