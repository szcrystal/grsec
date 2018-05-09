<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MailTemplate extends Model
{
    protected $fillable = [
        'type_code',
        'type_name',
        'title',
        'header',
        'footer',
    ];
}
