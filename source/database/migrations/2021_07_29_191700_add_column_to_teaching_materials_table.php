<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToTeachingMaterialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('teaching_materials', function (Blueprint $table) {
            $table->renameColumn('name', 'name_en');
            $table->tinyInteger('users')->after('materials_id');
            $table->tinyInteger('category')->after('users');
            $table->string('sub_category')->length(255)->nullable()->after('category');
            $table->tinyInteger('target_age')->after('sub_category');
            $table->string('lesson_name')->length(255)->after('target_age');
            $table->tinyInteger('level')->after('lesson_name');
            $table->string('name_ja')->length(255)->after('name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('teaching_materials', function (Blueprint $table) {
            $table->renameColumn('name_en', 'name');
            $table->dropColumn('users');
            $table->dropColumn('category');
            $table->dropColumn('sub_category');
            $table->dropColumn('target_age');
            $table->dropColumn('lesson_name');
            $table->dropColumn('level');
            $table->dropColumn('name_ja');
        });
    }
}
