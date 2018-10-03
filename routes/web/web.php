<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
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

Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});
