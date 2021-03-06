<?php

namespace App\Models;

class Article extends BaseModel
{
    // 定义允许插入，更新的字段
    protected $fillable = [
        'category_id', 'title', 'content', 'image', 'display_order', 'status', 'source'
    ];

    // 定义允许搜索的字段
    public $queryable = [
        'title', 'status', 'source', 'user_id'
    ];

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
}
