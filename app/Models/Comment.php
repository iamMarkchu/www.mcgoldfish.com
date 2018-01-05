<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    public function owner() {
        return $this->belongsTo('App\Models\User', 'user_id');
    }
}
