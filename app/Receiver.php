<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Receiver extends Model
{
    protected $fillable = [

        'user_id', 
        'regist',
        'salerel_id',
        
        'order_number',
        
        'name',
        'hurigana',
        'tel_num',

        'post_num',
        'prefecture',
        'address_1',
        'address_2',
        'address_3',
        
        

    ];
}
