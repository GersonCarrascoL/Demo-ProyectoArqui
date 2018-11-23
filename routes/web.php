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

Route::get('/', 'TripController@index');

Route::post('/api/v1/trip','TripController@postTrip');

Route::post('/api/v1/trip/send',array('as' => 'send_data', 'uses' => 'TripController@sendData'));