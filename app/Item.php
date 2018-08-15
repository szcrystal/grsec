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
        'is_ensure',
        
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
        'sale_price',
        
        'consignor_id',
        'cod',
        'farm_direct',
        
        'dg_id',
        'is_delifee',
        'is_once',
        'factor',
        
        'stock',
        'stock_show',
        'stock_type',
        'stock_reset_month',
        'stock_reset_count',
            
        'point_back',
        
        'exp_first',
        'explain',
        
        'about_ship',
        'is_delifee_table',
        
        'contents',
                
        'meta_title',
        'meta_description',
        'meta_keyword',
        
        //'open_date',
        'view_count',
        'sale_count',

    ];
    
    
}


