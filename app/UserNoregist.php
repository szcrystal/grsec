<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserNoregist extends Model
{
    protected $fillable = [
        'name', 
        'email', 
       // 'password', 
        //'confirm_token',
        
        'hurigana',
        'gender',

        'birth_year',
        'birth_month',
        'birth_day',
        
        'post_num',
        'prefecture',
        'address_1',
        'address_2',
        'address_3',
        
        'tel_num',
        
        'magazine',
        'user_register',
        
        'point',
        
        'destination',
        
        'active',
    ];
}
