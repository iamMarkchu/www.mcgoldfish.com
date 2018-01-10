<?php

namespace App\Http\Controllers\Page;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Article;

class SitemapController extends Controller
{
    public function index()
    {
        $article = Article::where('status', 'active')->orderBy('updated_at', 'desc')->first();
        $category = Category::orderBy('updated_at', 'desc')->first();
        return response()->view('sitemap.index', [
            'article' => $article,
            'category' => $category,
        ])->header('Content-Type', 'text/xml');
    }

    public function articles()
    {
        $articles = Article::where('status', 'active')->get();
        return response()->view('sitemap.articles', [
            'articles' => $articles,
        ])->header('Content-Type', 'text/xml');
    }

    public function categories()
    {
        $categories = Category::all();
        return response()->view('sitemap.categories', [
            'categories' => $categories,
        ])->header('Content-Type', 'text/xml');
    }
}
