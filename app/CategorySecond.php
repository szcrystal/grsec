<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CategorySecond extends Model
{
    protected $fillable = [
        'parent_id',
        'name',
        'slug',
        
        'meta_title',
        'meta_description',
        'meta_keyword',
            
        'contents',
        
        'view_count',
    ];
}
