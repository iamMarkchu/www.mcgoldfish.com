<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    public function category()
    {
        return $this->hasOne('App\Models\Category');
    }

    public function tags()
    {
        return $this->hasMany('App\Models\Tag');
    }
}
