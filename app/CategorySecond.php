<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CategorySecond extends Model
{
    protected $fillable = [
        'parent_id',
        'name',
        'slug',
        
        'is_top',
    	'top_img_path',
    	'top_title',
        'top_text',
        
        'meta_title',
        'meta_description',
        'meta_keyword',
            
        'contents',
        
        'view_count',
    ];
}
