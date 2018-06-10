<?php

namespace App\Models;

class Article extends BaseModel
{
    protected $fillable = [
        'category_id', 'title', 'content', 'image', 'display_order', 'status', 'source'
    ];

    protected $queryable = [
        'title', 'status', 'source', 'user_id'
    ];

    public function getQueryable()
    {
        return $this->queryable;
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function category()
    {
        return $this->belongsTo('App\Models\Category');
    }

    public function tags()
    {
        return $this->belongsToMany('App\Models\Tag');
    }

    public function comments()
    {
        return $this->hasMany('App\Models\Comment');
    }

    public function votes()
    {
        return $this->hasMany('App\Models\Vote');
    }

    public function fetchList($map, $pageSize=30)
    {
        $query = $this->setQuery($map);
        return $this->where($query)->with(['user', 'category', 'tags'])->orderBy('id', 'desc')->paginate($pageSize);
    }

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
}
