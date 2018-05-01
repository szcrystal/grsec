<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fix extends Model
{
    protected $fillable = [
        'title',
        'sub_title',
        'slug',
        'contents',
        'open_status',
    ];
}
