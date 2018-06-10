<?php
use Illuminate\Http\Request;
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

Route::get('login/github', 'Auth\LoginController@redirectToProvider')->name('github');
Route::get('login/github/callback', 'Auth\LoginController@handleProviderCallback');
Route::get('/checkLogin', function (){
   return Auth::check()? 1: 0;
});
Route::get('/home', 'HomeController@index')->name('home');

Route::group(['namespace' => 'Page', 'middleware' => ['tracking']], function(){
    Route::get('/', 'HomeController@index')->name('index');
    Route::get('article/{id}', 'ArticleController@index')->name('article')->where(['id' => '[0-9]+']);
    Route::get('article/{url_name}.html', 'ArticleController@show')->name('article-v2')->where(['url_name' => '[A-Za-z0-9|\-]+']);
    Route::get('category/{id}', 'CategoryController@index')->name('category')->where(['id' => '[0-9]+']);
    Route::get('category/{url_name}.html', 'CategoryController@show')->name('category-v2')->where(['url_name' => '[A-Za-z0-9|\-]+']);
    Route::get('/sitemap.xml', 'SitemapController@index')->name('sitemap-index');
    Route::get('/sitemap/articles.xml', 'SitemapController@articles')->name('sitemap-articles');
    Route::get('/sitemap/categories.xml', 'SitemapController@categories')->name('sitemap-categories');
    Route::get('/link', function(Request $request) {
       return redirect($request->input('target'));
    })->name('link');

    Route::post('/qrcode/', 'QrcodeController@show')->name('qrcode');
});

Route::group(['namespace' => 'Api', 'middleware' => ['auth']], function () {
   Route::resource('comments', 'CommentController');
   Route::post('/comments/vote', 'CommentController@vote');
   Route::post('/articles/vote', 'ArticleController@vote');
   Route::get('/user/settings', 'UserController@settings')->name('user-settings');
});

Route::group(['prefix' => 'admin', 'namespace' => 'Api', 'middleware' => ['auth', 'admin']], function() {
    Route::get('/', function() {
        return view('admin');
    });

    Route::post('/upload', function(Request $request) {
        $name = 'file';
        return upload($request->file($name), $name);
    });

    Route::resources([
        'users' => 'UserController',
        'categories' => 'CategoryController',
        'tags' => 'TagController',
        'articles' => 'ArticleController',
    ]);
    Route::put('/articles/{article}/change', 'ArticleController@change');
    Route::get('/categories-tree', 'CategoryController@tree');
});

Route::get('test', function () {
   $str = "测试123123测";
   echo generate_url($str);
});