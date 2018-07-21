<?php
/**
 * Created by PhpStorm.
 * User: chukui
 * Date: 7/21/2018
 * Time: 8:51 AM
 */

namespace App\Repositories;

use App\Models\Article;
use App\Models\Vote;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class ArticleRepository
{

    /**
     * @var Article
     */
    private $article;

    public function __construct(Article $article)
    {

        $this->article = $article;
    }

    /**
     * @return mixed
     */
    public function getQueryable()
    {
        return $this->article->queryable;
    }

    public function getFillable()
    {
        return $this->article->getFillable();
    }

    /**
     * @param $map
     * @param int $pageSize
     * @return mixed
     */
    public function fetchList($map, $pageSize=30)
    {
        $query = $this->setQuery($map);
        return $this->article->where($query)->with(['user', 'tags'])->orderBy('id', 'desc')->paginate($pageSize);
    }

    /**
     * @param $map
     * @return array
     */
    protected function setQuery($map)
    {
        $query = [];
        foreach ($map as $k => $v)
        {
            if ($k == 'title')
            {
                $query[] = ['title', 'like', '%'.$v.'%'];
                continue;
            }
            $query[] = [$k, $v];
        }
        return $query;
    }

    /**
     * @param $data
     *
     * @return Article
     */
    public function create($data)
    {
        $tagIds = [];
        if (isset($data['tag_ids']))
        {
            $tagIds = $data['tag_ids'];
            unset($data['tag_ids']);
        }

        // 保存内容
        foreach ($data as $k => $v)
        {
            $this->article->$k = $v;
        }

        $this->article->save();
        if (!empty($tagIds))
            $this->article->tags()->sync($tagIds);

        return $this->article;
    }

    public function update($data, $id)
    {
        $tagIds = [];
        if (isset($data['tag_ids']))
        {
            $tagIds = $data['tag_ids'];
            unset($data['tag_ids']);
        }

        // 查找内容
        $model = $this->article->find($id);

        if (!$model)
            return false;

        // 保存内容
        foreach ($data as $k => $v)
        {
            $model->$k = $v;
        }

        if ($model->save())
        {
            $model->tags()->sync($tagIds);
            return $model;
        } else {
            return false;
        }
    }

    /**
     * @param $id
     * @return Collection
     */
    public function find($id)
    {
        return $this->article->with(['tags'])->find($id);
    }

    /**
     * 修改文章状态
     * @param $status
     * @param $id
     * @return bool
     */
    public function changeStatus($status, $id)
    {
        // 记录修改日志
        $model = $this->article->find($id);
        if (!$model)
            return false;
        $model->status = $status;
        $model->save();

        return $model;
    }

    /**
     * 是否已投票
     * @param $articleId
     * @param $userId
     * @return bool
     */
    public function isVoted($articleId, $userId)
    {
        return $this->article->whereHas('votes', function ($query) use ($articleId, $userId) {
            $query->where(['article_id' => $articleId, 'user_id' => $userId]);
        })->first();
    }

    /**
     * 给文章投票
     * @param $articleId
     * @param $userId
     *
     * @return Article | boolean
     */
    public function vote($articleId, $userId)
    {
        $article = $this->article->find($articleId);
        if (!$articleId)
            return false;

        // 事务
        DB::transaction(function () use ($article, $userId) {
            $article->increment('vote_count');
            $article->votes()->save(
                new Vote(['user_id' => $userId])
            );
            return $article;
        });
        return false;
    }

    /**
     * @param $articleId
     * @param $userId
     *
     * @return Article | boolean
     */
    public function deleteVote($articleId, $userId)
    {
        $article = $this->article->find($articleId);
        if (!$articleId)
            return false;

        // 事务
        DB::transaction(function () use ($article, $userId) {
            $article->decrement('vote_count');
            Vote::where(['article_id' => $article->id, 'user_id' => $userId])->delete();
            return $article;
        });
        return false;
    }
}