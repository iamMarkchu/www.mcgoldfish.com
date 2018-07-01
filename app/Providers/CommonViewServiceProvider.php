<?php

namespace App\Providers;

use App\Models\Tag;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Category;

class CommonViewServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('*', function($view){
            $categories = Category::orderBy('display_order', 'desc')->get();
            $tags = Tag::orderBy('display_order', 'desc')->limit(9)->get();
            $view->with('categories', $categories);
            $view->with('tags', $tags);
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
