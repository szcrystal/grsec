<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ItemUpper extends Model
{
    protected $fillable = [ 
        'parent_id',
    	'type_code',
        'open_status',

    ];
}
