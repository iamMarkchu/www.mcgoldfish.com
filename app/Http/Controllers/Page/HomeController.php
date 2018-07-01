<?php

namespace App\Http\Controllers\Page;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Tools\Baidu\Translate;

class HomeController extends Controller
{
    /**
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    public function index(Request $request)
    {
        $data['articles'] = Article::where(['status' => 'active'])->with('tags', 'user')->orderBy('created_at', 'desc')->paginate(15);
        return view('page.home', $data);
    }
}
