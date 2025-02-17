<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateFavoriteSignedArtistsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('favorite_signed_artists', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('signed_artist_id')->nullable();
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
        Schema::drop('favorite_signed_artists');
    }
}
