<?php

/*
|--------------------------------------------------------------------------
| Bugtracker\Project\Editor Routes
|--------------------------------------------------------------------------
|
| Editor related routes are listed here.
|
*/

Route::group(['prefix'=>'bugtracker/projects/{project}/editor', 'middleware'=>'auth', 'namespace'=>'Bugtracker'], function(){


    Route::post('{board}/delete-path', 'PathController@deletePath')
        ->name('board.delete_path');
    Route::post('{board}/create-path', 'PathController@savePath')
        ->name('board.create_path');

    Route::get('{board?}', 'EditorController@getEditor')->name('project.editor');


});
