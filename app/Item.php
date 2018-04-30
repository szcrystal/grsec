<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = [ //varchar:文字数
        'open_status',
        'main_img',

        'cate_id',
        'title',
        'price',
        'delivery_fee',
        'what_is',
        'detail',
        'warning',
    
        'open_date',
        //'view_count',

    ];
    
    
}


