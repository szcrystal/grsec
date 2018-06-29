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
        'is_time',
        'time_table',
    ];
}
