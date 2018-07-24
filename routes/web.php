<?php
use Illuminate\Http\Request;
use App\Models\Image;
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
    Route::get('tag/{id}', 'TagController@index')->name('tag')->where(['id' => '[0-9]+']);
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

Route::group(['prefix' => 'admin', 'namespace' => 'Api', 'middleware' => ['auth', 'role:Admin|Writer']], function() {
    Route::get('/', function() {
        return view('admin');
    });

    Route::post('/upload', function(Request $request) {
        $name = 'file';
        return upload($request->file($name), $name);
    });

    // 七牛
    Route::post('/upload/qiniu', 'UploadController@qiniu');

//    Route::put('articles/{id}', function () {
//
//    });
    // 不需要再次验证权限
    Route::resources([
        'categories' => 'CategoryController',
        'tags' => 'TagController',
        'articles' => 'ArticleController',
        'images' => 'ImageController',
    ]);

    // Admin才能
    Route::middleware(['role:Admin'])->group(function() {
        Route::resources([
            'users' => 'UserController',
            'permissions' => 'PermissionController',
            'roles' => 'RoleController',
        ]);
    });

    Route::put('/articles/{id}/change', 'ArticleController@change');
    Route::get('/categories-tree', 'CategoryController@tree');
});