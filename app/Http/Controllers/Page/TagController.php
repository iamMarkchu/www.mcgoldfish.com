<?php

namespace App\Http\Controllers\Page;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Tag;
use App\Models\Article;

class TagController extends Controller
{
    public function index(Request $request, $id)
    {
        $tag = Tag::find($id);
        $data['articles'] = $tag->articles()->where('status', 'active')->orderBy('created_at', 'desc')->paginate(15);
        $data['tag'] = $tag;
        return view('page.tag', $data);
    }
}
