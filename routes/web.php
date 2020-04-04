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
use App\Category;

Route::get('/', function () {
    return view('main-page', [ 'menu' => Category::getCaterorys()]);
})->name('main-page');

// Страница авторизации )))
// Не подключаю бд, так как ещё не прошли.
Auth::routes();

// Наверное будет middelware отвечать за админа?
Route::group(['prefix' => 'admin', 'before' => 'auth'], function() {

    // Страница добавлени или редактирования новости
    Route::get('article/edit/{id?}', 'AdminArticelController@edit')
        ->where('id','[0-9]+')
        ->name('admin.article.edit');

    // Метод сохранения новости
    Route::post('article/save/', 'AdminArticelController@save')
        ->name('admin.article.save');
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


