<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CategorySecond extends Model
{
    protected $fillable = [
        'parent_id',
        'name',
        'slug',
        
        'main_img',
        
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
        
        'updated_at',
    ];
}
