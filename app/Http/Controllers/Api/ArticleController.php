<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreArticleRequest;
use App\Http\Requests\UpdateArticleRequest;
use App\Models\Article;
use App\Models\Vote;
use Illuminate\Support\Facades\Auth;

class ArticleController extends Controller
{
    protected $article;

    public function __construct(Article $article)
    {
        $this->article = $article;
    }
    /**
     * Display a listing of the resource.
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Models\Article $article
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $map = $this->filterQuery($request);
        $result = $this->article->fetchList($map, $request->input('pageSize', 30));
        return response()->api($result);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreArticleRequest  $request
     * @param  \App\Models\Article $article
     * @return \Illuminate\Http\Response
     */
    public function store(StoreArticleRequest $request, Article $article)
    {
        $article = $this->fillFromRequest($request, $article);
        $article->save();
        // 保存 tag信息
        $article->tags()->sync($request->tag_ids);
        return response()->api($article);
    }

    /**
     * Display the specified resource.
     *
     * @param  integer $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = $this->article->with(['tags'])->find($id);
        return response()->api($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateArticleRequest $request
     * @param  integer $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateArticleRequest $request, $id)
    {
        $data = $this->handleRequest($request);
        $tagIds = $data['tag_ids'];
        unset($data['tag_ids']);

        if ($model = $this->article->updateItem($data, $id))
            $model->tags()->sync($tagIds);
        return response()->api($this->article);
    }

    /**
     * fill data from request
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Article $article
     *
     * @return \App\Models\Article $article
     */
    public function fillFromRequest(Request $request, Article $article)
    {
        $article->category_id = ($request->filled('category_id')) ? $request->category_id: 0;
        $article->user_id = Auth::id();
        $article->url_name = ($article->title !== $request->title) ? generate_url($request->title): $article->url_name;
        $article->title = $request->title;
        $article->content = $request->input('content');  // content属性被保留
        $article->image = ($request->filled('image')) ? $request->image: '';
        $article->display_order = $request->display_order;
        $article->status = isset($article->status)? $article->status: 'republish';
        $article->source = $request->source;
        $article->click_count = 0;
        $article->vote_count = 0;
        return $article;
    }

    protected function handleRequest(Request $request)
    {
        $data = $request->only(
            array_merge(
                    $this->article->getFillable(),
                    [ 'tag_ids' ]
                )
        );
        $data['url_name'] = generate_url($request->title);
        $data['content'] = $data['content'] ?? '';
        $data['image'] = $data['image'] ?? '';
        return $data;
    }

    protected function filterQuery(Request $request)
    {
        $data = $request->only(
            $this->article->getQueryable()
        );

        return filter_empty($data);
    }

    /**
     * change status
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Article $article
     */
    public function change(Request $request, Article $article)
    {
        $article->status = $request->status;
        $article->save();
        return response()->api($article);
    }

    public function vote(Request $request)
    {
        $id = $request->id;
        $article = Article::find($id);
        $action = $request->action;
        $comment = Vote::where(['article_id' => $id, 'user_id' => Auth::id()])->first();
        if($action == 'add')
        {
            if(empty($comment))
            {
                $comment = new Vote();
                $comment->article_id = $id;
                $comment->user_id = Auth::id();
                $comment->save();
                $article->increment('vote_count');
            }

        }else {
            if(!empty($comment))
            {
                $comment->forceDelete();
                $article->decrement('vote_count');
            }

        }
        return response()->api('1');
    }
}
