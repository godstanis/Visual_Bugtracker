<?php

/*
|--------------------------------------------------------------------------
| Bugtracker\Project\Team Routes
|--------------------------------------------------------------------------
|
| Team related routes are listed here.
|
*/

Route::group(['prefix'=>'{project}/team', 'middleware'=>['auth', 'can:view,project'], 'namespace'=>'Bugtracker'], function(){

    Route::get('', 'TeamController@getAllTeamMembers')
        ->name('project.team');
    Route::post('attach', 'TeamController@postAddMember')
        ->name('project.team.add')->middleware('can:delete,project');
    Route::get('deattach/{user}', 'TeamController@getRemoveMember')
        ->name('project.team.remove')->middleware('can:delete,project');
    Route::get('search-member', 'TeamController@searchUser')
        ->name('project.team.search')->middleware('can:delete,project');

});
