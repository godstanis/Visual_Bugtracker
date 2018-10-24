<?php

/*
|--------------------------------------------------------------------------
| Bugtracker\Project\Settings Routes
|--------------------------------------------------------------------------
|
| Settings related routes are listed here.
|
*/

Route::group(['prefix'=>'{project}/settings', 'middleware'=>['auth', 'can:view,project'], 'namespace'=>'Bugtracker'], function(){

    Route::get('', 'ProjectsController@getSettingsPage')
        ->name('project.settings');
    Route::post('', 'ProjectsController@postUpdateProject')
        ->name('project.settings')->middleware('can:delete,project');

});
