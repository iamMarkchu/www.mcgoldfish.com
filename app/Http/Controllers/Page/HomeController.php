<?php

namespace App\Http\Controllers\Page;

use App\Http\Controllers\Controller;
use App\Models\Article;

class HomeController extends Controller
{
    /**
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    public function index()
    {
        $data['articles'] = Article::where(['status' => 'active'])->with('category', 'user')->limit(20)->get();
        return view('page.home', $data);
    }
}
