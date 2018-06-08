<?php

namespace App\Models;

class Category extends BaseModel
{
    protected $fillable = [
        'category_name', 'parent_id', 'display_order'
    ];
    public function articles()
    {
        return $this->hasMany('App\Models\Article');
    }
}
