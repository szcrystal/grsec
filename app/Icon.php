<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Icon extends Model
{
    protected $fillable = [ //varchar:文字数
        'title',
        'name',
        'img_path',
    ];
}
