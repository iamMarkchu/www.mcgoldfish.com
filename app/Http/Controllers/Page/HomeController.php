<?php

namespace App\Http\Controllers\Page;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    public function index(Request $request)
    {
        $data['articles'] = Article::where(['status' => 'active'])->with('category', 'user')->orderBy('updated_at', 'desc')->paginate(15);
        return view('page.home', $data);
    }
}
