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

Route::get('/', 'HomeController@index')->name('index');

Route::get('/ankieta', 'PollController@poll_view')->name('poll_view');
Route::post('/poll_send', 'PollController@poll_send')->name('poll_send');

Route::prefix('test')->name('test.')->middleware('tester')->group(function () {
    Route::post('save','TestResultController@save')->name('save');
    Route::get('next','TestResultController@next')->name('next');
    Route::get('finish','TestResultController@finish')->name('finish');
});

Auth::routes();

Route::prefix('auth')->name('auth.')->middleware('auth')->group(function () {
    Route::get('home', 'AdminController@home')->name('home');
    Route::prefix('tests')->name('tests.')->group(function() {
        Route::get('objects','AdminController@objects')->name('objects');
        Route::get('object/result/{id}','AdminController@objectResult')->name('object.result');
    });
});
