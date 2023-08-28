<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveColumnFromThumbnailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('thumbnails', function (Blueprint $table) {
            $table->dropColumn('target_age');
            $table->dropColumn('level');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('thumbnails', function (Blueprint $table) {           
            $table->tinyInteger('target_age');
            $table->tinyInteger('level');
        });
    }
}
