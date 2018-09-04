<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TopSetting extends Model
{
    protected $fillable = [ //varchar:文字数
        
        'contents',
        
        'meta_title',
        'meta_description',
        'meta_keyword',

    ];
}
