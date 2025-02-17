<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMusicEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('music_events', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('event_title')->nullable();
            $table->string('description')->nullable();
            $table->string('image')->nullable();
            $table->string('location')->nullable();
            $table->string('artist_id')->nullable();
            $table->string('event_date')->nullable();
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
        Schema::drop('music_events');
    }
}
