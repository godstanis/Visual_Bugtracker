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
            $table->unsignedInteger('board_id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('issue_id')->nullable();
            $table->string('text')->nullable();
            $table->integer('position_x');
            $table->integer('position_y');
            $table->timestamps();
        });
        Schema::table('comment_points', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('board_id')->references('id')->on('boards')->onDelete('cascade');
            $table->foreign('issue_id')->references('id')->on('issues')->onDelete('cascade');
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
