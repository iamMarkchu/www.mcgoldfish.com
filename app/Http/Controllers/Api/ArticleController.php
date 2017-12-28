<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreArticleRequest;
use App\Http\Requests\UpdateArticleRequest;
use App\Models\Article;
use Illuminate\Support\Facades\Auth;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Models\Article $article
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Article $article)
    {
        return $article->with('category', 'tags', 'user')->paginate($request->limit);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
        $article->tags()->sync($request->tags);
        return response()->api($article);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Article $article
     * @return \Illuminate\Http\Response
     */
    public function show(Article $article)
    {
        $data = $article->toArray();
        $tags = $article->tags;
        foreach ($tags as $tag)
        {
            $data['tags'][] = $tag->id;
        }
        return response()->api($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateArticleRequest $request
     * @param  \App\Models\Article $article
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateArticleRequest $request, Article $article)
    {
        $article = $this->fillFromRequest($request, $article);
        $article->save();
        // 保存 tag信息
        $article->tags()->sync($request->tags);
        return response()->api($article);
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
        $article->title = $request->title;
        $article->content = $request->input('content');  // content属性被保留
        $article->image = $request->image;
        $article->display_order = $request->display_order;
        $article->status = 'republish';
        $article->source = $request->source;
        $article->click_count = 0;
        $article->vote_count = 0;
        return $article;
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
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
}
