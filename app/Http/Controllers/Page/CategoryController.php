<?php

namespace App\Http\Controllers\Page;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Article;

class CategoryController extends Controller
{
    public function index($id)
    {
        $category = Category::find($id);
        if(empty($category))
            abort(404);
        else
            return redirect(route('category-v2', ['url_name' => $category->url_name]), 301);
    }

    public function show($url_name)
    {
        $category = Category::where(['url_name' => $url_name])->first();
        if(empty($category))
            abort(404);
        $articles = Article::where(['status' => 'active', 'category_id' => $category->id])->with('category', 'user')->orderBy('updated_at', 'desc')->paginate(15);

        $data['category'] = $category;
        $data['articles'] = $articles;
        return view('page.category', $data);
    }
}
