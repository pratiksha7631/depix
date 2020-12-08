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
    return redirect('login');

});

Auth::routes();

Route::get('index', 'HomeController@index')->name('index');
Route::post('home', 'ArticleController@save_article')->name('save_article');
Route::get('get-article', 'ArticleController@get_article')->name('get_article');
Route::get('delete-article/{id?}', 'ArticleController@delete_article')->name('delete_article');
Route::get('edit-article/{id?}', 'ArticleController@edit_article')->name('edit_article');
Route::post('edit-article-save', 'ArticleController@edit_article_save')->name('edit_article_save');
Route::get('category', 'CategoryController@category')->name('category');
Route::post('save-all-category', 'CategoryController@save_all_category')->name('save_all_category');
