<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CategorySecond extends Model
{
    protected $fillable = [
        'parent_id',
        'name',
        'slug',

    ];
}
