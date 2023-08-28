<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeachingMaterialTitlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teaching_material_titles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name_en')->length(255);
            $table->string('name_ja')->length(255);
            $table->integer('order');
            $table->string('thumbnail')->length(255);
            $table->softDeletes('deleted_at');
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
        Schema::dropIfExists('teaching_material_titles');
    }
}
