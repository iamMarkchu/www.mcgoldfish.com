<?php

namespace App\Http\Controllers\Page;

use App\Http\Controllers\Controller;
use App\Repositories\ArticleRepository as Article;
use App\Tools\Markdown;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * @param  \Illuminate\Http\Request $request
     * @param  Article $article
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    public function index(Request $request,  Article $article)
    {
        $map = ['status' => 'active'];
        $articles = $article->fetchList($map, 15);

        $markdown = new Markdown();
        // 增加 简介
        foreach ($articles as $article)
        {
            $contentSplitByN = explode("\n", $article->content);
            $previewMarkdown = (count($contentSplitByN) > 4) ? implode("\n", array_slice($contentSplitByN, 0, 4)): '';
            $article->preview = $markdown->text($previewMarkdown);
        }
        return view('page.home', compact('articles'));
    }
}
