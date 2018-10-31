<?php 
/* Here is mail view */
?>

<?php //$info = DB::table('siteinfos')['first(); ?>


{{ $user['name'] }} 様
<br>
<p>※このメールは配信専用メールのため、ご返信いただけません。</p>

@if($isUser)
{!! nl2br( $templ->header ) !!}
@else
よりご注文がありました。<br>
ご注文内容は下記となります。
@endif
<br>
<br>
@if($templ->type_code == 'thanks' && isset($saleRel->information))
【グリーンロケットからのお知らせ】<br>
{!! nl2br($saleRel->information) !!}<br><br>
@endif
<hr>
【ご注文番号】：{{ $saleRel->order_number }}<br>
【ご注文日】：{{ Ctm::changeDate($saleRel->created_at, 1) }}<br>
【ご注文者】：{{ $user->name }} 様<br>
【お届け先】： 
<div style="margin: 0 0 1.5em 1.0em;">
{{ $receiver->name }} 様<br>
〒{{ Ctm::getPostNum($receiver->post_num) }}<br>
{{ $receiver->prefecture }}{{ $receiver->address_1 }}{{ $receiver->address_2 }}<br>
{{ $receiver->address_3 }}
</div>

{{--
@if($templ->type_code == 'deliDoneNo' || $templ->type_code == 'deliDone' )
【発送日】： {{ date('Y/m/d', time()) }}<br>
@endif

@if(isset($thisSale->plan_date))
【お届け予定日】： {{ $thisSale->plan_date }}<br>
@endif
--}}

【ご注文商品】： <br>

<?php $num = 1; ?>
@foreach($sales as $sale)
<div style="margin: 0 0 1.5em 1.0em;">
<div>{{ $num }}.</div>
商品番号: {{ $itemModel->find($sale->item_id)->number }}<br>
商品名: {{ Ctm::getItemTitle($itemModel->find($sale->item_id)) }}<br>
数量: {{ $sale->item_count}}<br>
金額：¥{{ number_format($sale->total_price) }}（税込）<br>
@if($templ->type_code == 'thanks')
<b>出荷予定日：{{ Ctm::getDateWithYoubi($sale->deli_start_date) }}</b><br>
@elseif($templ->type_code == 'deliDoneNo' || $templ->type_code == 'deliDone')
<b>出荷日：{{ Ctm::getDateWithYoubi($sale->deli_sended_date) }}</b><br>
@endif

@if($templ->type_code == 'thanks' || $templ->type_code == 'deliDoneNo' || $templ->type_code == 'deliDone')
<b>お届け予定日：{{ Ctm::getDateWithYoubi($sale->deli_schedule_date) }}</b><br>
@endif

@if($templ->type_code == 'deliDone')
    <?php $dc = $dcModel->find($sale->deli_company_id); ?>
    <br>
    配送会社：{{ $dc->name }}<br>
    @if(isset($sale->deli_slip_num) && $sale->deli_slip_num != '')
    伝票番号：{{ $sale->deli_slip_num }}<br>
    @endif
    @if(isset($dc->url))
    お荷物の追跡はこちらから<br>
    {{ $dc->url }}
    @endif
@endif

</div>

<?php $num++; ?>
@endforeach

【ご注文金額】：
<div style="margin: 0 0 1.0em 1.0em;">
商品金額合計：￥{{ number_format($saleRel->all_price) }} <br>
送料：￥{{ number_format($saleRel->deli_fee) }}<br>
@if($saleRel->pay_method == 2)
コンビニ決済手数料：￥{{ number_format($saleRel->cod_fee) }}<br>
@elseif($saleRel->pay_method == 4)
GMO後払い手数料：￥{{ number_format($saleRel->cod_fee) }}<br>
@elseif($saleRel->pay_method == 5)
代引手数料：￥{{ number_format($saleRel->cod_fee) }}<br>
@endif
@if($saleRel->is_user)
ポイント利用：{{ $saleRel->use_point }}ポイント<br>
@endif
<?php
$allTotal = $saleRel->all_price + $saleRel->deli_fee + $saleRel->cod_fee - $saleRel->use_point;
?>
<b style="display:block; font-size:1.1em; margin-top:0.5em;">ご注文金額合計：￥{{ number_format($allTotal) }} （税込）</b>
</div>
【お支払方法】：{{ $pmModel->find($saleRel->pay_method)->name }}

<br><br>
<hr>
<br>
@if($isUser)
{!! nl2br( $templ->footer ) !!}
@endif

<br><br><br><br>
{!! nl2br($setting->mail_footer) !!}


