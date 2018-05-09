<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DeliveryGroupRelation extends Model
{
    protected $fillable = [
        'dg_id',
        'pref_id',
        'fee',
    ];
}
