<?php

namespace App\Http\Controllers\Page;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Comment;
use Parsedown;

class ArticleController extends Controller
{
    public function index($id)
    {
        $article = Article::find($id);
        $pd = new Parsedown();
        $article->htmlContent = $pd->text($article->content);
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
        $comments = Comment::where(['status' => 'active', 'article_id' => $article->id])->with('owner')->orderBy('id', 'desc')->get();
        $comments = $comments->groupBy('parent_id');
        $data['article'] = $article;
        $data['headers'] = $headers;
        $data['comments'] = $comments;
        // dd($data);die;
        return view('page.article', $data);
    }
}