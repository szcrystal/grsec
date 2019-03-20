<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [ //varchar:文字数
        'name',
        'link_name',
        'slug',
        
        'is_top',
    	'top_img_path',
    	'top_title',
        'top_text',
        
        'meta_title',
        'meta_description',
        'meta_keyword',
        
        'upper_title',
        'upper_text',
            
        'contents',
        
        'view_count',
        'sort_num',
    ];
}
