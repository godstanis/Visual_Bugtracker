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
            $table->string('title');
            $table->longText('description');

            $table->unsignedInteger('project_id');
            $table->unsignedInteger('type_id');
            $table->unsignedInteger('priority_id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('closed_by_user_id')->nullable();

            $table->boolean('closed')->default(false);
            $table->boolean('deleted')->default(false);
            $table->timestamps();
        });
        Schema::table('issues', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('closed_by_user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('type_id')->references('id')->on('issue_type')->onDelete('cascade');
            $table->foreign('priority_id')->references('id')->on('issue_priority')->onDelete('cascade');
            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
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
