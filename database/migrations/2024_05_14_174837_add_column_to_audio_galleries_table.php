<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToAudioGalleriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('audio_galleries', function (Blueprint $table) {
            $table->string('image')->nullable()->after('file');
            $table->string('duration')->nullable()->after('image');
            $table->string('language')->nullable()->after('duration');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('audio_galleries', function (Blueprint $table) {
            //
        });
    }
}
