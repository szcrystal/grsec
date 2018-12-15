<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [ //varchar:文字数
                    
        'admin_name',
        'admin_email' ,
        'mail_footer',
        
        'is_product',
        'tax_per',
        
        'is_sale',
        'sale_per',
        'is_point',
        'point_per',
        
        'kare_ensure',
        'bank_info',
        'cot_per',
        
        'contents',
        
        'snap_news',
        'snap_top',
        
        'snap_primary',
        'snap_secondary',
        
        'snap_block_a',
        'snap_block_b',
        'snap_block_c',
        
        'snap_category',
        'snap_fix',
        
        'meta_title',
        'meta_description',
        'meta_keyword',
        
        'fix_need',
        'fix_other',
        
        'analytics_code',

    ];
}
