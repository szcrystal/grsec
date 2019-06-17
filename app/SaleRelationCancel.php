<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SaleRelationCancel extends Model
{
	protected $fillable = [
        'order_number',
        'salerel_id',
        'pay_method',
        'deli_fee',
        'cod_fee',
        'use_point',
        'add_point',
        'all_price',
        'total_price',
        'pay_done',
        'pay_date',
    ];

}
