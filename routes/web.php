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

Route::get('/', function () {
    return view('main-page');
})->name('main-page');

Route::get('/news', function () {
    return view('news');
})->name('news');

Route::get('/day-article', function () {
    return view('article');
})->name('article');

