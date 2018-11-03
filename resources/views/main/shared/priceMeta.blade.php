<?php
use App\Setting;
use App\User;
use App\Prefecture;
use App\DeliveryGroupRelation;

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

<br><span class="text-middle">
@if($obj->is_delifee)
	送料無料</span>
@else
    @if(Auth::check())
    <?php
        $u = User::find(Auth::id());
        $pref = Prefecture::where('name', $u->prefecture)->first();
        $dgr = DeliveryGroupRelation::where(['dg_id'=>$obj->dg_id, 'pref_id'=>$pref->id])->first();
    ?>
    
    	{{ $pref->name }}への最低送料 {{ number_format($dgr->fee) }}円
    @else
    	<i class="fal fa-plus"></i> 送料
    @endif
@endif
</span>

<span class="d-block text-blue text-middle">
    @if($item->is_once)
    同梱包可能
    @else
    同梱包不可
    @endif
</span>


