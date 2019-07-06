<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FavoriteCookie extends Model
{
    protected $fillable = [
        'key',
        'item_id',
        'type',
        'value',
        'expiration',
    ];
}
