<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PayMethodChild extends Model
{
    protected $fillable = [
        'parent_id',
        'name',
        'sec_name',

    ];
}
