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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/facebook', 'FacebookController@index')->name('facebook');
Route::get('/instagram', 'InstagramController@index')->name('instagram');
Route::get('/instagram/media', 'InstagramController@list_media')->name('instagram-media');