<?php
use App\Setting;

$isSale = Setting::get()->first()->is_sale; 
?>

                            
@if(isset($obj->sale_price))
    <small class="text-white bg-gray py-1 px-2 mr-1">セール商品</small>
    <strike class="text-small">{{ number_format(Ctm::getPriceWithTax($obj->price)) }}</strike>
    <i class="fas fa-arrow-right text-small"></i>
    {{ number_format(Ctm::getPriceWithTax($obj->sale_price)) }}
@else
    @if($isSale)
        <small class="text-white bg-gray py-1 px-2 mr-1">セール{{ Setting::get()->first()->sale_per }}%引</small>
        <strike class="text-small">{{ number_format(Ctm::getPriceWithTax($obj->price)) }}</strike>
        <i class="fas fa-arrow-right text-small"></i>
        {{ number_format(Ctm::getSalePriceWithTax($obj->price)) }}
    @else
        {{ number_format(Ctm::getPriceWithTax($obj->price)) }}
    @endif
@endif
円&nbsp;<span class="text-small">(税込)</span>

