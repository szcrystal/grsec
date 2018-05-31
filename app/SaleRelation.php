<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SaleRelation extends Model
{
	protected $fillable = [
    	'order_number',
        
        'regist',
        'user_id',
        'is_user',
        'receiver_id',

        'pay_method',
        'deli_fee',
        'cod_fee',
        'use_point',
        'all_price',
        
        'destination',
        
        'deli_done',
        'pay_done',
        
        'pay_trans_code',
        'pay_user_id',
        'pay_order_number',
        'pay_payment_code', //ネットバンク、GMO後払いのみ  
        'pay_result', //クレカのみ
        'pay_state',
        
    ];
}