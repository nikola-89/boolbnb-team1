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

// Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::name('upr.')->prefix('upr')->namespace('Upr')->middleware('auth')->group(function () {
    Route::get('/dashboard', 'HomeController@index')->name('dashboard');
    Route::resource('apartments', 'ApartmentController');

    Route::resource('images', 'ImageController');
    Route::post('delete', 'ImageController@deleteImage');
});
