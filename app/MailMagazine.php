<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MailMagazine extends Model
{
    protected $fillable = [
        //'code',
        'title',
        'contents',
        'is_send',
        'send_date',
    ];
}
