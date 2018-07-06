<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DeliveryGroup extends Model
{
    protected $fillable = [
        'name',
        'open_status',
        'capacity',
        'factor',
        //'take_charge',
        'is_time',
        'time_table',
    ];
}
