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

// Страницу приветствия.
Route::get('/', function () {
    return view('main-page');
})->name('main-page');

// Страница авторизации )))
Auth::routes();

// Страница добавлени новости
//
Route::group(['prefix' => 'personal', 'before' => 'auth'], function() {

});

Route::group(['prefix' => 'news'], function() {

    // Страница категорий новостей.
    Route::get('categories', 'NewsController@categories')
        ->name('categories');

    // Страницу вывода новостей по конкретной категории.
    // В данном случае поддержка беконечной вложенности каталога:
    // /news/path/category/subcategory/sub_sub/.../sub_sub_sub/
    Route::get('/path/{category_path}', 'NewsController@category')
        ->where('category_path','^[a-zA-Z0-9-_\/]+$')
        ->name('category');

    // Страница конкретной новости\
    // /news/the_best_news_of_ever/
    Route::get('{alias}', 'NewsController@news')
        ->where('category_path','^[a-zA-Z0-9-_\/]+$')
        ->name('news');
});


