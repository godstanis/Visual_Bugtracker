<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommentPointsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comment_points', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('board_id');
            $table->integer('user_id');
            $table->integer('issue_id')->unique()->nullable();
            $table->string('text')->nullable();
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
        Schema::dropIfExists('comment_points');
    }
}
