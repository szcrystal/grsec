<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ItemStockChange extends Model
{
    protected $fillable = [ //varchar:文字数
        'item_id',          
        'is_auto',

    ];
    
}


