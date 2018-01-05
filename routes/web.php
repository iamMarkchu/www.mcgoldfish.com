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

Route::group(['namespace' => 'Page'], function(){
    Route::get('/', 'HomeController@index');
    Route::get('article/{id}', 'ArticleController@index')->name('article');
});

Route::group(['namespace' => 'Api', 'middleware' => ['auth']], function () {
   Route::resource('comments', 'CommentController');
   Route::post('/comments/vote', 'CommentController@vote');
});