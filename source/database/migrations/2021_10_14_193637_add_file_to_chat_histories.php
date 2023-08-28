<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFileToChatHistories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('chat_historys', function (Blueprint $table) {
            $table->string('type')->length(100)->nullable();
            $table->string('file_link')->length(255)->nullable();
            $table->string('file_name')->length(255)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('chat_historys', function (Blueprint $table) {
            $table->dropColumn('type');
            $table->dropColumn('file_link');
            $table->dropColumn('file_name');
        });
    }
}