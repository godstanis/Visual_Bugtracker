<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIssuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('issues', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('project_id');
            $table->string('title');
            $table->longText('description');
            $table->integer('type_id');
            $table->integer('priority_id');
            $table->integer('created_by_user_id');
            $table->integer('closed_by_user_id')->default(null);
            $table->integer('assigned_to_user_id');
            $table->integer('path_id')->default(null);
            $table->boolean('closed')->default(false);
            $table->timestamps();
            $table->boolean('deleted')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('issues');
    }
}
