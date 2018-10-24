<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePathsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paths', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('board_id');
            $table->unsignedInteger('user_id');
            //path attributes
            $table->string('stroke_color')->default('green');
            $table->integer('stroke_width')->default(4);
            $table->string('path_slug');
            $table->longText('path_data');

            $table->boolean('deleted')->default(false);
            $table->timestamps();
        });
        Schema::table('paths', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('board_id')->references('id')->on('boards')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('paths');
    }
}
