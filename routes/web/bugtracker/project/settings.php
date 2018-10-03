<?php

/*
|--------------------------------------------------------------------------
| Bugtracker\Project\Settings Routes
|--------------------------------------------------------------------------
|
| Settings related routes are listed here.
|
*/

Route::group(['prefix'=>'bugtracker/projects/{project}/settings', 'middleware'=>'auth', 'namespace'=>'Bugtracker'], function(){

    Route::get('', 'ProjectsController@getSettingsPage')
        ->name('project.settings');
    Route::post('', 'ProjectsController@postUpdateProject')
        ->name('project.settings')->middleware('can:delete,project');

});
