<?php 
/* Here is mail view */
?>

<?php //$info = DB::table('siteinfos')['first(); ?>


{{ $user['name'] }} 様
@if($isUser)
<br><br>
※このメールは配信専用メールのため、ご返信いただけません。
<br><br>
{!! nl2br( $templ->header ) !!}
@else
<br>よりご注文がありました。<br>
ご注文内容は下記となります。
@endif
<br>
<br>
@if(isset($saleRel->information) && $saleRel->information != '')
【グリーンロケットからのお知らせ】<br>
{!! nl2br($saleRel->information) !!}<br><br>
@endif

<hr>
【ご注文番号】：{{ $saleRel->order_number }}<br>
【ご注文日】：{{ Ctm::changeDate($saleRel->created_at, 1) }}<br>
@if(isset($saleRelCancel))
	【キャンセル日】：{{ Ctm::changeDate($saleRelCancel->created_at, 1) }}<br>
@endif
【ご注文者】：{{ $user->name }} 様<br>
【お届け先】： 
<div style="margin: 0 0 1.5em 1.0em;">
{{ $receiver->name }} 様<br>
〒{{ Ctm::getPostNum($receiver->post_num) }}<br>
{{ $receiver->prefecture }}{{ $receiver->address_1 }}{{ $receiver->address_2 }}<br>
{{ $receiver->address_3 }}
</div>


【ご注文商品】： <br>
<?php $num = 1; ?>
@foreach($sales as $sale)
<div style="margin: 0 0 1.5em 1.0em;">
<div>{{ $num }}.</div>

@if($sale->is_keep)
    <b>[お取り置き商品]</b><br>
@endif

商品番号: {{ $itemModel->find($sale->item_id)->number }}<br>
商品名: {{ Ctm::getItemTitle($itemModel->find($sale->item_id)) }}<br>
数量: {{ $sale->item_count}}<br>
金額：¥{{ number_format($sale->total_price) }}（税込）<br>

@if($templ->type_code == 'thanks')
	@if(isset($sale->deli_start_date) && $sale->deli_start_date)
        <b>出荷予定日：{{ Ctm::getDateWithYoubi($sale->deli_start_date) }}</b>
        <br>
    @endif
@elseif($templ->type_code == 'deliDoneNo' || $templ->type_code == 'deliDone')
	<?php $d = date('Y-m-d', time()); ?>
    <b>出荷日：{{ Ctm::getDateWithYoubi($d) }}</b><br>
@endif

@if($templ->type_code == 'thanks' || $templ->type_code == 'deliDoneNo' || $templ->type_code == 'deliDone')
    @if(isset($sale->deli_schedule_date) && $sale->deli_schedule_date)
    	<b>お届け予定日：{{ Ctm::getDateWithYoubi($sale->deli_schedule_date) }}</b><br>
    @endif
    
    @if(isset($sale->deli_company_id) && $sale->deli_company_id)
        <?php $dc = $dcModel->find($sale->deli_company_id); ?>
        <br>
        配送会社：
        @if($dc->id == 1)
        	後ほど店舗よりご連絡致します
        @else
        	{{ $dc->name }}
        @endif
        <br>
    @endif
@endif

@if($templ->type_code == 'deliDone')
    @if(isset($sale->deli_slip_num) && $sale->deli_slip_num != '')
    	伝票番号：{{ $sale->deli_slip_num }}<br>
    @endif
    @if(isset($dc->url) && $dc->url != '')
    	お荷物の追跡はこちらから<br>
    	{{ $dc->url }}
    @endif
@endif

</div>

<?php $num++; ?>
@endforeach


<?php
//if($allCancel) {
//	$relModel = $saleRelCancel;
//}
//else {
//	$relModel = $saleRel;
//}
?>

@if(! isset($allCancel))
    @if(isset($saleRel->user_comment) && $saleRel->user_comment != '')
    【コメント】：
    <div style="margin: 0 0 1.0em 1.0em;">
    {!! nl2br($saleRel->user_comment) !!}
    </div>
    @endif

    【ご注文金額】：
    <div style="margin: 0 0 1.0em 1.0em;">
    商品金額合計：￥{{ number_format($saleRel->all_price) }} <br>
    送料：￥{{ number_format($saleRel->deli_fee) }}<br>
    
    @if($saleRel->pay_method == 2)
    	コンビニ決済手数料：￥{{ number_format($saleRel->cod_fee) }}<br>
    @elseif($saleRel->pay_method == 4)
    	後払い手数料：￥{{ number_format($saleRel->cod_fee) }}<br>
    @elseif($saleRel->pay_method == 5)
    	代引手数料：￥{{ number_format($saleRel->cod_fee) }}<br>
    @endif
    
    @if($saleRel->is_user)
    	ポイント利用：{{ $saleRel->use_point }}ポイント<br>
    @endif

    <?php
    	if(isset($saleRel->total_price)) {
        	$allTotal = $saleRel->total_price;
        }
        else {
        	$allTotal = $saleRel->all_price + $saleRel->deli_fee + $saleRel->cod_fee - $saleRel->use_point;
        }
    ?>

    <b style="display:block; font-size:1.1em; margin-top:0.5em;">ご注文金額合計：￥{{ number_format($allTotal) }} （税込）</b>
    </div>

    【お支払方法】：{{ $pmModel->find($saleRel->pay_method)->name }}
    @if($saleRel->pay_method == 3)
    	（{{ $pmChildModel->find($saleRel->pay_method_child)->name }}）
    @elseif($templ->type_code == 'thanks' && $saleRel->pay_method == 6)
        <div style="margin: 0 0 0.2em 0.8em;">
        	{!! nl2br($setting['bank_info']) !!}
        </div>
    @endif
    
    @if($templ->type_code == 'payDone')
    	<br><br>【ご入金確認日】：{{ Ctm::changeDate($saleRel->pay_date, 1) }} <br>
    @endif

@endif

<br>
<hr>
<br>

@if($isUser)
	@if(isset($saleRel->information_foot) && $saleRel->information_foot != '')
    	{!! nl2br($saleRel->information_foot) !!}<br><br><br>
    @endif
	
    {!! nl2br( $templ->footer ) !!}
@endif

<br><br><br><br>
{!! nl2br($setting->mail_footer) !!}


