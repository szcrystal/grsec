<?php 
/* Here is mail view */
?>

<?php //$info = DB::table('siteinfos')['first(); ?>


{{ $user['name'] }} 様
@if($isUser)
<br /><br />
{!! nl2br( $header ) !!}

@else
よりご注文がありました。<br>
ご注文内容は下記となります。
@endif


<br /><br />
<hr>
【ご注文番号】：{{ $saleRel->order_number }}<br>
【ご注文日】：{{ date('Y/m/d', time()) }}<br>
【ご注文者】：{{ $user->name }} 様<br>
【お届け先】： 
<div style="margin: 0 0 1.5em 1.0em;">
〒{{ Ctm::getPostNum($receiver->post_num) }}<br>
{{ $receiver->prefecture }}{{ $receiver->address_1 }}{{ $receiver->address_2 }}<br>
{{ $receiver->address_3 }}<br>
{{ $receiver->name }} 様<br>
</div>

【ご注文商品】： <br>
<?php $num = 1; 
?>
@foreach($sales as $sale)
<div style="margin: 0 0 1.5em 1.0em;">
<div>{{ $num }}.</div>
商品番号: {{ $itemModel->find($sale->item_id)->number }}<br>
商品名: {{ $itemModel->find($sale->item_id)->title }}<br>
個数: {{ $sale->item_count}}<br>
金額：¥{{ number_format($sale->total_price) }}（税込）
</div>

<?php $num++; ?>
@endforeach

【お買上金額】：
<div style="margin: 0 0 1.5em 1.0em;">
商品金額合計：￥{{ number_format($saleRel->all_price) }} <br>
送料：￥{{ number_format($saleRel->deli_fee) }} <br>
@if($saleRel->pay_method == 5)
代引手数料：￥{{ number_format($saleRel->cod_fee) }} <br>
@endif
@if(Auth::check())
ポイント利用：{{ $saleRel->use_point }}ポイント <br>
@endif
<?php
$allTotal = $saleRel->all_price + $saleRel->deli_fee + $saleRel->cod_fee - $saleRel->use_point;
?>
<b style="font-size:1.1em; padding-top:0.5em;">ご注文金額合計：￥{{ number_format($allTotal) }} （税込）</b><br>
</div>
【お支払方法】：{{ $pmModel->find($saleRel->pay_method)->name }} <br>
@if($saleRel->pay_method == 6)
<div style="margin: 0 0 1.5em 0.8em;">
５日以内に下記口座までお振り込み下さい。<br>
{!! nl2br($setting['bank_info']) !!}
</div>
@endif
<hr>
<br><br>

@if($isUser)
{!! nl2br( $footer ) !!}
@endif

<br><br><br><br>
{!! nl2br($setting->mail_footer) !!}


