<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnFileNameToTeachingMaterialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('teaching_materials', function (Blueprint $table) {
            $table->string('file_name')->after('lesson_name')->length(255)->nullable();
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
            $table->dropColumn('file_name');
        });
    }
}
