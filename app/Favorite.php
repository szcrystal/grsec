<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    protected $fillable = [ //varchar:文字数
        'user_id',
        'item_id',
        'sale_id',
        'number' ,

    ];
}
