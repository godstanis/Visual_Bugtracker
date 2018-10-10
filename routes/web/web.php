<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Base app and service routes are listed here.
|
*/

/*
 * Base routes:
 */

Route::get('/', 'HomeController@getHomePage')->name('home');

/*
 * Maintenance routes:
 */
Route::get('lang/{lang}', ['uses'=>'LanguageController@setLang'])->name('lang.set');
Route::post('/pusher-auth', 'PusherAuthController@authorizeBoardChannel')->middleware('auth');
