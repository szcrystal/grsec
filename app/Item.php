<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = [ //varchar:文字数
        'open_status',
                    
        'number',
        'title' ,
        'catchcopy',
        'cate_id',
        'subcate_id',
        
        'main_img',
        
        /*
        'spare_img_0',
        'spare_img_1',
        'spare_img_2',
        'spare_img_3',
        'spare_img_4',
        'spare_img_5',
        'spare_img_6',
        'spare_img_7',
        'spare_img_8',
        'spare_img_9',
        */
        
        'price',
        'cost_price',
        
        'consignor_id',
        'cod',
        'farm_direct',
        'dg_id',
        'deli_fee',
        'is_once',
        'stock',
        'stock_show',
        'point_back',
        
        'exp_first',
        'explain',
        'about_ship',
        'contents',
                
        //'what_is',
        //'warning',
        
        'open_date',
        'view_count',
        'sale_count',

    ];
    
    
}


