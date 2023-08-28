<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyColumnThumbnailAndAddColumnThumbnailEnToTeachingMaterialTitlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('teaching_material_titles', function (Blueprint $table) {
            $table->renameColumn('thumbnail', 'thumbnail_ja');
            $table->string('thumbnail_en')->after('order')->length(255);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('teaching_material_titles', function (Blueprint $table) {
            $table->renameColumn('thumbnail_ja', 'thumbnail');
            $table->dropColumn('thumbnail_en');

        });
    }
}
