<?php

/*
|--------------------------------------------------------------------------
| User Routes
|--------------------------------------------------------------------------
|
| User related routes are stored here.
|
*/

Auth::routes();

Route::get('account-activation/{token}', 'Auth\ActivationController@activate')->name('account.activation');

Route::group(['prefix'=>'user', 'middleware'=>'auth'], function(){

    Route::get('{user}/settings', 'User\UserController@getUserSettings')->name('user.settings');

    Route::post('', 'User\UserController@postUserProfileImage')->name('user.update');

    Route::get('{user}', 'User\UserController@getUserPage')->name('user');

    Route::get('', function(){
        abort(404);
    });

});
