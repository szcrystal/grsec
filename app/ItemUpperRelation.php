<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ItemUpperRelation extends Model
{
    protected $fillable = [ 
        'upper_id',
        'block',
        'img_path',
        'url',
        'title',
        'detail',
        'sort_num',
		'is_section',
        //'is_mid_section',
    ];
}
