<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddHotListToAudioGalleriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('audio_galleries', function (Blueprint $table) {
            $table->tinyInteger('hot_list')->default(0)->after('free_style_name');
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
            $table->dropColumn('hot_list');
        });
    }
}
