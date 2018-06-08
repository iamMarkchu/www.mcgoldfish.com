<?php

namespace App\Models;

class Article extends BaseModel
{
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
        return $this->where($map)->with(['user', 'category', 'tags'])->paginate($pageSize);
    }
}
