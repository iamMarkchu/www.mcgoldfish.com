<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['namespace' => 'Api', 'middleware' => ['auth:api'],], function(){
    Route::resources([
        'articles' => 'ArticleController',
        'tags' => 'TagController',
        'categories' => 'CategoryController',
    ]);
    Route::put('/articles/{article}/change', 'ArticleController@change');
    Route::post('upload', function(Request $request){
        $path = $request->file('uploadFile')->store('public/image');
        return Storage::url($path);
    });
    Route::delete('upload', function(Request $request){
        echo $request->uploadFile;
    });
});