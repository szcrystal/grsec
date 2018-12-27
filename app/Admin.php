<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Foundation\Auth\User as Authenticatable;


class Admin extends Authenticatable
{
     protected $fillable = [
        'name',
        'email',
        'password',
        'permission',
    ];
    
    protected $hidden = [
        'password', 'remember_token',
    ];
}
