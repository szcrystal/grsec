<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $fillable = [
        'name',
        'email',
        'ask_category',
        'tel_num',
        'request_day',
        'request_time',
        'comment',
        'is_ask_type',
        'status',
        'accept',
    ];
}
