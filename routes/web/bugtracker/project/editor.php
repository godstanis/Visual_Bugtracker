<?php

/*
|--------------------------------------------------------------------------
| Bugtracker\Project\Editor Routes
|--------------------------------------------------------------------------
|
| Editor related routes are listed here.
|
*/

Route::group(['prefix'=>'{project}/editor', 'middleware'=>'auth', 'namespace'=>'Bugtracker'], function(){
    Route::group(['prefix'=>'{board}'], function() {

        Route::post('delete-path', 'PathController@deletePath')
            ->name('board.delete_path');
        Route::post('create-path', 'PathController@savePath')
            ->name('board.create_path');
        Route::get('/', 'EditorController@getBoardEditor')->name('project.editor.board');
        Route::get('paths', 'BoardsController@paths')->name('board.paths');

        Route::resource('comment_points', 'CommentPointController');
    });
});
