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

Route::post('launch', 'LaunchController@index');
Route::get('clicker', 'ClickerController@index');
Route::get('clicker/new', 'ClickerController@newClickerItem');
Route::post('clicker', 'ClickerController@create');
Route::get('clicker/{clickerItemId}', 'ClickerController@show');
Route::post('clicker/{id}/answer', 'ClickerController@answer');
Route::post('clicker/{clickerItemId}/start', 'ClickerController@start');
Route::post('clicker/{clickerItemId}/stop', 'ClickerController@stop');

