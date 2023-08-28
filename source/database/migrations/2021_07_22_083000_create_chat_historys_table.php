<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChatHistorysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chat_historys', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('room_id')->length(255);
            $table->string('name')->length(255);
            $table->datetime('start_time')->nullable();
            $table->datetime('end_time')->nullable();
            $table->string('message')->length(255)->nullable();
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
        Schema::dropIfExists('chat_historys');
    }
}
