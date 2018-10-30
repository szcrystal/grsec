<?php 
/* Here is mail view */
?>

<?php //$info = DB::table('siteinfos')['first(); ?>


{{ $name }} 様

<br>
<p>※このメールは配信専用メールのため、ご返信いただけません。</p>
<br>
{!! nl2br( $header ) !!}
<br><br>
@if($isEnsure)
<hr>
【ご注文番号】：{{ $sales[0]->order_number }}<br>
【ご注文日】：{{ Ctm::changeDate($saleRel->created_at, 1) }}<br>
【ご注文商品】： <br>

<?php $num = 1; ?>
@foreach($sales as $sale)
<div style="margin: 0 0 1em 1.0em;">
<div>{{ $num }}.</div>
商品番号: {{ $itemModel->find($sale->item_id)->number }}<br>
商品名: {{ Ctm::getItemTitle($itemModel->find($sale->item_id)) }}<br>
数量: {{ $sale->item_count}}<br>
発送日：{{ Ctm::changeDate($sale->deli_start_date, 1) }}
</div>
<?php $num++; ?>
@endforeach
<hr>
<br>
@endif
{!! nl2br( $footer ) !!}

<br><br><br><br>
{!! nl2br($setting->mail_footer) !!}


