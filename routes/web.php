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

Auth::routes();

Route::get('/home', 'HomeController@home')->name('home');
Route::get('/stroop1', 'HomeController@stroop1')->name('stroop1');
Route::get('/stroop2', 'HomeController@stroop2')->name('stroop2');
Route::get('/stroop3', 'HomeController@stroop3')->name('stroop3');
Route::get('/stroop4', 'HomeController@stroop4')->name('stroop4');
Route::get('/tmtA', 'HomeController@tmtA')->name('tmtA');
Route::get('/tmtB', 'HomeController@tmtB')->name('tmtB');
Route::get('/go_nogo_one', 'HomeController@go_nogo_one')->name('go_nogo_one');
Route::get('/go_nogo_two', 'HomeController@go_nogo_two')->name('go_nogo_two');
