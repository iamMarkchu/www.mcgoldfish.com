<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreArticleRequest;
use App\Http\Requests\UpdateArticleRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use App\Repositories\ArticleRepository;

class ArticleController extends Controller
{

    /**
     * @var ArticleRepository
     */
    private $article;

    /**
     * ArticleController constructor.
     * @param ArticleRepository $article
     */
    public function __construct(ArticleRepository $article)
    {

        $this->article = $article;
    }

    /**
     * Display a listing of the resource.
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $map = $this->filterQuery($request);
        $result = $this->article->fetchList($map, $request->input('pageSize', 30));
        return Response::api($result);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreArticleRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreArticleRequest $request)
    {
        $data = $this->handleRequest($request);
        $this->article->create($data);
        return response()->api('创建成功');
    }

    /**
     * Display the specified resource.
     *
     * @param  integer $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = $this->article->find($id);
        return Response::api($data);
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
        $this->article->update($data, $id);
        return Response::api('修改成功!');
    }

    /**
     * 处理request参数
     * @param Request $request
     * @return array
     */
    protected function handleRequest(Request $request)
    {
        $data = $request->only(
            array_merge(
                $this->article->getFillable(),
                ['tag_ids']
            )
        );
        $data['url_name'] = generate_url($request->input('title'));
        $data['user_id'] = Auth::id();
        return $data;
    }

    /**
     * 获取查询参数
     * @param Request $request
     * @return array
     */
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
     * @param integer $id
     * @return string
     */
    public function change(Request $request, $id)
    {
        if (!$request->filled('status'))
            return Response::api('请提供要修改的状态');

        $isChanged = $this->article->changeStatus($request->input('status'), $id);
        if ($isChanged)
            return Response::api('修改成功！');
        else
            return Response::api('修改失败！', 500);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function vote(Request $request)
    {
        $articleId = $request->input('id', 0);
        $article = $this->article->find($articleId);
        if (! $article)
            return Response::api('文章不存在!', 500);
        $action = $request->input('action');

        // 是否投过票
        $isVoted = $this->article->isVoted($articleId, Auth::id());
        if ($action == 'add') {
            if ($isVoted)
            {
                return Response::api('已经投过票了', 500);
            } else {
                $this->article->vote($articleId, Auth::id());
                return Response::api('投票成功!');
            }
        } else {
            if ($isVoted) {
                $this->article->deleteVote($articleId, Auth::id());
                return Response::api('投票已撤销!');
            } else {
                return Response::api('还没有投过票!', 500);
            }
        }
    }
}
