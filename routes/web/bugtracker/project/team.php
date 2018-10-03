<?php

/*
|--------------------------------------------------------------------------
| Bugtracker\Project\Team Routes
|--------------------------------------------------------------------------
|
| Team related routes are listed here.
|
*/

Route::group(['prefix'=>'bugtracker/projects/{project}/team', 'middleware'=>'auth', 'namespace'=>'Bugtracker'], function(){

    Route::get('', 'TeamController@getAllTeamMembers')
        ->name('project.team');
    Route::post('add-member', 'TeamController@postAddMember')
        ->name('project.team.add')->middleware('can:delete,project');
    Route::post('delete-member/{user}', 'TeamController@postRemoveMember')
        ->name('project.team.remove')->middleware('can:delete,project');
    // TODO: GET->POST
    Route::get('search-member', 'TeamController@searchUser')
        ->name('project.team.search')->middleware('can:delete,project');

});
