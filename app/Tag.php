<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = [ //varchar:文字数
        'name',
        'slug',
        
        'meta_title',
        'meta_description',
        'meta_keyword',
            
        'contents',
        
        'view_count',
    ];
}
