<?php

/*
|--------------------------------------------------------------------------
| Bugtracker\Project Routes
|--------------------------------------------------------------------------
|
| Base project related routes are stored here.
|
*/

Route::group(['middleware'=>'auth', 'namespace'=>'Bugtracker'], function(){

    Route::group(['prefix'=>'projects'], function(){

        Route::get('', 'ProjectsController@getAvailableProjects')
            ->name('bugtracker.projects');
        Route::post('create-project', 'ProjectsController@postCreateProject')
            ->name('bugtracker.create_project');

    });

    Route::group(['prefix'=>'project/{project}', 'middleware'=>'can:view,project'], function(){

        Route::get('', 'ProjectsController@getProjectById')
            ->name('bugtracker.project');

        Route::post('delete-project', 'ProjectsController@postDeleteProject')
            ->name('bugtracker.delete_project')->middleware('can:delete,project');


        Route::get('activity', 'ActivityController@getProjectActivities')
            ->name('project.activity');

    });

});