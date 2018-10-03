<?php

/*
|--------------------------------------------------------------------------
| Bugtracker\Project\Board Routes
|--------------------------------------------------------------------------
|
| Board related routes are listed here.
|
*/

Route::group(['prefix'=>'bugtracker/projects/{project}/boards', 'middleware'=>'auth', 'namespace'=>'Bugtracker'], function(){

    Route::get('', 'BoardsController@getProjectBoards')
        ->name('project.boards');
    Route::post('create-board', 'BoardsController@postCreateBoard')
        ->name('project.create_board');
    Route::post('{board}/delete-board', 'BoardsController@postDeleteBoard')
        ->name('project.delete_board')->middleware('can:delete,board');

});
