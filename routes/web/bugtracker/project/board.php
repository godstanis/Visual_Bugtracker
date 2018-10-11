<?php

/*
|--------------------------------------------------------------------------
| Bugtracker\Project\Board Routes
|--------------------------------------------------------------------------
|
| Board related routes are listed here.
|
*/

Route::group(['prefix'=>'{project}/boards', 'middleware'=>'auth', 'namespace'=>'Bugtracker'], function(){

    Route::get('', 'BoardsController@index')
        ->name('project.boards');

    Route::post('create-board', 'BoardsController@create')
        ->name('project.create_board');
    Route::get('{board}/delete-board', 'BoardsController@delete')
        ->name('project.delete_board')->middleware('can:delete,board');

});
