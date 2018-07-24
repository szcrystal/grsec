<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PayMethod extends Model
{
    protected $fillable = [

        'name',
        'sec_name', 

    ];
}
