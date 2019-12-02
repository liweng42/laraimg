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

// Route::get('/', function () {
//     return view('welcome');
// });
Auth::routes();

Route::get('/', 'HomeController@index');
Route::get('/home', 'HomeController@index');

Route::get('/test', 'TestController@index');
Route::post('/test', 'TestController@post');

Route::get('/upload', 'UploadController@index')->name('upload');
Route::post('/upload', 'UploadController@upload');


// Route::get('file','FileController@create');
// Route::post('file','FileController@store');

