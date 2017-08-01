<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableBoardMessages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('board_messages', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('board_id');
            $table->string('text')->default(null);
            $table->integer('issue_id')->default(null);
            $table->integer('position_x');
            $table->integer('position_y');
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
        Schema::dropIfExists('board_messages');
    }
}
