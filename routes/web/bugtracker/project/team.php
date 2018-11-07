<?php

/*
|--------------------------------------------------------------------------
| Bugtracker\Project\Team Routes
|--------------------------------------------------------------------------
|
| Team related routes are listed here.
|
*/

Route::group(['prefix'=>'{project}/team', 'middleware'=>['auth', 'can:view,project'], 'namespace'=>'Bugtracker'], function() {

    Route::get('', 'TeamController@index')
        ->name('project.team');
    Route::post('attach', 'TeamController@add')
        ->name('project.team.add')->middleware('can:update,project');
    Route::post('detach/{user}', 'TeamController@remove')
        ->name('project.team.remove')->middleware('can:update,project');
    Route::get('search-member', 'TeamController@search')
        ->name('project.team.search')->middleware('can:update,project');

    Route::post('allow', 'TeamController@addAbility')->name('project.team.allow')->middleware('can:delete,project');
    Route::post('disallow', 'TeamController@removeAbility')->name('project.team.disallow')->middleware('can:delete,project');

});
