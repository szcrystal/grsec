<?php
use App\Setting;

$isSale = Setting::get()->first()->is_sale; 
?>

                            
@if(isset($obj->sale_price))
    <small class="text-white bg-enji py-1 px-2 mr-1">セール商品</small>
    <strike class="text-small">{{ number_format(Ctm::getPriceWithTax($obj->price)) }}</strike>
    <i class="fal fa-arrow-right text-small"></i>
    <span class="text-enji">{{ number_format(Ctm::getPriceWithTax($obj->sale_price)) }}
@else
    @if($isSale)
        <small class="text-white bg-enji py-1 px-2 mr-1">セール{{ Setting::get()->first()->sale_per }}%引</small>
        <strike class="text-small">{{ number_format(Ctm::getPriceWithTax($obj->price)) }}</strike>
        <i class="fas fa-arrow-right text-small"></i>
        <span class="text-enji">{{ number_format(Ctm::getSalePriceWithTax($obj->price)) }}
    @else
        <span>{{ number_format(Ctm::getPriceWithTax($obj->price)) }}
    @endif
@endif
</span>
<span class="text-small">円&nbsp;(税込)</span>


