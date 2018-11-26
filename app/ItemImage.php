<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ItemImage extends Model
{
    protected $fillable = [ //varchar:文字数
                    
        'item_id',
        'img_path',
        'caption',
        'link',
        'type',
        'number',

    ];
}
