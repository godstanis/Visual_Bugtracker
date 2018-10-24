<?php

/*
|--------------------------------------------------------------------------
| Bugtracker\Project\Board Routes
|--------------------------------------------------------------------------
|
| Board related routes are listed here.
|
*/

Route::group(['prefix'=>'{project}/boards', 'middleware'=>['auth', 'can:view,project'], 'namespace'=>'Bugtracker'], function(){

    Route::get('', 'BoardsController@index')
        ->name('project.boards');

    Route::post('create', 'BoardsController@create')
        ->name('project.create_board');
    Route::get('{board}/delete', 'BoardsController@delete')
        ->name('project.delete_board')->middleware('can:delete,board');

});
