<?php

/*
|--------------------------------------------------------------------------
| Bugtracker\Project\Editor Routes
|--------------------------------------------------------------------------
|
| Editor related routes are listed here.
|
*/

Route::group(['prefix'=>'{project}/editor', 'middleware'=>['auth', 'can:view,project'], 'namespace'=>'Bugtracker'], function(){
    Route::group(['prefix'=>'{board}'], function() {

        Route::post('delete-path', 'PathController@destroy')
            ->name('board.delete_path');
        Route::post('create-path', 'PathController@create')
            ->name('board.create_path');
        Route::get('/', 'EditorController@getBoardEditor')->name('project.editor.board');
        Route::get('paths', 'PathController@all')->name('board.paths');

        Route::resource('comment_points', 'CommentPointController');
    });
});
