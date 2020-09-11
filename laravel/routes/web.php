<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/board/{symbol}', 'KabuController@board')
    ->where('symbol', '[0-9]+');

Route::get('/regist', 'KabuController@registSymbols');
Route::get('/unregist', 'KabuController@unregistAll');

Route::get('/order', 'KabuController@order');
Route::get('/websocket', 'KabuController@websocket');