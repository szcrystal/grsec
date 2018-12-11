<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ItemImage extends Model
{
/*
    type:1->item spare
    type:2->item snap(content)
    type:3->category
    type:4->sub category
    type:5->tag
    type:6->top carousel
    type:7->fix 
    type:8->top setting news                           
*/

    protected $fillable = [ //varchar:文字数
                    
        'item_id',
        'img_path',
        'caption',
        'link',
        'type',
        'number',

    ];
}
