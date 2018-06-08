<?php

namespace App\Models;

class Tag extends BaseModel
{
    protected $fillable = [
        'tag_name', 'display_order',
    ];
}
