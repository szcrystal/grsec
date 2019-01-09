<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SendMailFlag extends Model
{
    protected $fillable = [
        'sale_id',
        'templ_id',
        'templ_code',
        'is_mail',
        'type',
		'information',
        'information_foot',
    ];
}
