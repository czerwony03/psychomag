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

Route::prefix('poll')->name('poll_')->middleware('pc.only')->group(function () {
    Route::get('depression', 'PollDepressionController@poll_view')->name('view');
    Route::post('depression/send', 'PollDepressionController@poll_send')->name('send');

    Route::middleware('tester')->group(function () {
        Route::get('pum', 'PollPumController@poll_view')->name('pum_view');
        Route::post('pum/send', 'PollPumController@poll_send')->name('pum_send');
        Route::get('personal_data', 'PollPersonalDataController@poll_view')->name('personal_data_view');
        Route::post('personal_data/send', 'PollPersonalDataController@poll_send')->name('personal_data_send');
    });
});

Route::prefix('test')->name('test.')->middleware('tester')->group(function () {
    Route::post('save', 'TestResultController@save')->name('save');
    Route::get('next', 'TestResultController@next')->name('next');
    Route::get('finish', 'TestResultController@finish')->name('finish');
});

Auth::routes(['register' => false]);

Route::prefix('auth')->name('auth.')->middleware('auth')->group(function () {
    Route::get('home', 'AdminController@home')->name('home');
    Route::prefix('tests')->name('tests.')->group(function () {
        Route::get('objects', 'AdminController@objects')->name('objects');
        Route::get('object/result/{id}', 'AdminController@objectResult')->name('object.result');
    });
});
