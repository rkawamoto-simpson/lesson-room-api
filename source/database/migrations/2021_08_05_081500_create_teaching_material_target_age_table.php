<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeachingMaterialTargetAgeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teaching_material_target_ages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('teaching_material_id');
            $table->foreign('teaching_material_id')
            ->references('id')->on('teaching_materials')
            ->onDelete('cascade');
            $table->tinyInteger('target_age');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('teaching_material_target_ages');
    }
}
