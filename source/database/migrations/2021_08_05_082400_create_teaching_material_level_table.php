<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeachingMaterialLevelTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teaching_material_levels', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('teaching_material_id');
            $table->foreign('teaching_material_id')
            ->references('id')->on('teaching_materials')
            ->onDelete('cascade');
            $table->tinyInteger('level');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('teaching_material_levels');
    }
}
