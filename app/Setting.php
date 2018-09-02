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
        'kare_ensure',
        'bank_info',
        'cot_per',
        
        'contents',
        'snap_top',
        'snap_primary',
        'snap_secondary',
        'snap_category',
        
        'meta_title',
        'meta_description',
        'meta_keyword',
        
        'fix_need',
        'fix_other',

    ];
}
