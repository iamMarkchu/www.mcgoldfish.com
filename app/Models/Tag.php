<?php

namespace App\Models;

class Tag extends BaseModel
{
    protected $fillable = [
        'tag_name', 'display_order',
    ];

    public function articles()
    {
        return $this->belongsToMany('App\Models\Article');
    }
}
