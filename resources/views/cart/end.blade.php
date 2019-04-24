@extends('layouts.app')

@section('content')

<?php
use App\Item;

?>

    <div class="single top-cont">

            <div class="clearfix">
                <h2></h2>
            </div>


            <div class="panel-body">
@include('cart.guide')
                <div class="cont-wrap">
                	
                 <?php //print_r($data); ?>   

                    <div class="clearfix contents text-center">
                    	<?php
//                     	   	$pmName = $pmModel->find($pm)->name; 
//                        	$thankStr = "お買い上げ、ありがとうございます。<br>ご注文が完了致しました。";
                        ?>
                        
                        お買い上げ、ありがとうございます。<br>ご注文が完了致しました。<br>
                        
                        @if(isset($orderNumber))
                        	ご注文番号：[ {{ $orderNumber }} ] <br>
                        @endif
                      	
                        
                        @if(isset($xml) && $xml != '')
                        	{!! nl2br($xml) !!}
                        @endif
                     	
					{{--
                        
                        @if($pm ==1)
                        	@if($data['result'])
                         		{{ $thankStr }} <br>
                           		ご注文番号：[ {{ $data['order_number'] }} ] <br>     
                         		{{ $pmName }}による手続きが完了致しました。
                         	@else   
                        		{{ $pmName }}による手続きが正常に終了出来ませんでした。
                         	@endif   
                        
                        @elseif($pm == 2)
                            {{ $thankStr }} <br> 
                            {{ $pmName }}
                        
                        @elseif($pm == 3)
                            @if($data['state'])
                            	{{ $thankStr }} <br>
                             	ご注文番号：[ {{ $data['order_number'] }} ] <br>   
                             	{{ $pmName }}（{{ $paymentCode }}）による手続きが正常に完了致しました。   
                            @else
                            	{{ $pmName }}（{{ $paymentCode }}）による手続きが正常に終了出来ませんでした。
                            @endif                            
                        
                        @elseif($pm == 4)
                            {{ $thankStr }} <br> 
                            ご注文番号：[ {{ $data['order_number'] }} ] <br>
                            {{ $data['payment_code'] }}<br>
                            {{ $pmName }} {{ $pmName }}（{{ $paymentCode }}）
                        
                        @elseif($pm == 5)
                            {{ $thankStr }} <br> 
                            ご注文番号：[ {{ $data['order_number'] }} ] <br>
                            <br>
                            {{ $pmName }} 
                        
                        @elseif($pm == 6)
                            {{ $thankStr }} <br> 
                            ご注文番号：[ {{ $data['order_number'] }} ] <br>
                            {{ $pmName }}<br>
                            下記の振込先まで
                            
                        
                        @else
                      		{{ $pmName }}によりお買い物が完了致しました。
                        @endif
                    
                    --}}
                        
                        
                        <div class="text-center mt-5 pb-3">
                        	<a href="{{ url('/') }}">HOMEへ <i class="fal fa-angle-double-right"></i></a>   
                        </div>    
                        
                        {{--
                        @foreach($data as $val)
                    		<p>{{ $val }}</p>
                     	@endforeach 
                      --}}     
                    </div>

                </div>


            </div><!-- panelbody -->

    </div>

@if(isset($saleRel) && count($saleObjs) > 0)
<script>
window.dataLayer = window.dataLayer || []
dataLayer.push({
'transactionId': "{{ $saleRel->order_number }}",
'transactionAffiliation': 'Acme Clothing',
'transactionTotal': {{ $saleRel->all_price }},
'transactionTax': '',
'transactionShipping': '',
'transactionProducts': [
@foreach($saleObjs as $saleObj)
<?php
	$item = Item::find($saleObj->item_id);
?>

{
'sku': "{{ $saleObj->item_id }}",
'name': "{{ $item->title }}",
'category': '',
'price': {{ $saleObj->total_price }},
'quantity': {{ $saleObj->item_count }},
},
@endforeach

]
});
</script>

@endif
    
    
@endsection
