<?php

namespace App\Http\Controllers\Page;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Tools\Markdown;

class ArticleController extends Controller
{
    public function index($id)
    {
        $article = Article::with('tags')->where('status', 'active')->find($id);
        if(empty($article))
            abort(404);
        else
            return redirect(route('article-v2', ['url_name' => $article->url_name]), 301);
    }

    public function show($url_name)
    {
        $article = Article::with('tags')->where(['status' => 'active', 'url_name' => $url_name])->first();
        if(empty($article))
            abort(404);
        $md = new Markdown();
        $article->htmlContent = $md->text($article->content);
        $regex = '/<h(2|3)>(.*?)<\/h(2|3)>/';
        preg_match_all($regex, $article->htmlContent, $match);
        $headers = [];
        if(!empty($match[1]))
        {
            $currentIndex = 'header_1';
            foreach ($match[1] as $k => $v) {
                if($v == 2)
                {
                    if($k !== 0){
                        $currentIndex = 'header_'. ($k + 1);
                    }
                    $headers[$currentIndex]['title'] = $match[2][$k];
                }else{
                    $subCurrentIndex = 'header_'. ($k + 1);
                    $headers[$currentIndex]['h3'][$subCurrentIndex]= $match[2][$k];
                }
            }
        }
        $article->htmlContent = preg_replace_callback('/\<h(2|3)>(.*?)<\/h(2|3)>/', function($match) {
            global $headerIndex;
            return '<h'. $match[1] . ' id="header_'.(++$headerIndex) .'">'.$match[2]. '</h'.$match[1].'>';
        }, $article->htmlContent);

        // 评论
        $commentQuery = Comment::where(['status' => 'active', 'article_id' => $article->id]);
        if(Auth::check())
        {
            $commentQuery->orWhere(function($query) use($article){
                $query->where(['user_id' => Auth::id(), 'article_id' => $article->id, 'status' => 'pending']);
            });
        }
        $comments = $commentQuery->with('owner')->orderBy('id', 'desc')->get();
        $comments = $comments->groupBy('parent_id');
        $data['article'] = $article;
        $data['headers'] = $headers;
        $data['comments'] = $comments;
        $data['seo']['title'] = $article->title. ' McGoldfish.com';
        // dd($data);die;
        return view('page.article', $data);
    }
}
