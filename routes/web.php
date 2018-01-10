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

Auth::routes();
Route::get('/checkLogin', function (){
   return Auth::check()? 1: 0;
});
Route::get('/home', 'HomeController@index')->name('home');

Route::group(['namespace' => 'Page', 'middleware' => ['tracking']], function(){
    Route::get('/', 'HomeController@index')->name('index');
    Route::get('article/{id}', 'ArticleController@index')->name('article');
    Route::get('category/{id}', 'CategoryController@index')->name('category');
    Route::get('/sitemap.xml', 'SitemapController@index')->name('sitemap-index');
    Route::get('/sitemap/articles.xml', 'SitemapController@articles')->name('sitemap-articles');
    Route::get('/sitemap/categories.xml', 'SitemapController@categories')->name('sitemap-categories');
});

Route::group(['namespace' => 'Api', 'middleware' => ['auth']], function () {
   Route::resource('comments', 'CommentController');
   Route::post('/comments/vote', 'CommentController@vote');
   Route::post('/articles/vote', 'ArticleController@vote');
   Route::get('/user/settings', 'UserController@settings')->name('user-settings');
});