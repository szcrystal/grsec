<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Consignor extends Model
{
    protected $fillable = [
        
        'name',
        'tel_num',
        'address',
    
    ];
}
