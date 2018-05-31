@extends('layouts.app')

@section('content')

<?php
// use App\User;

?>

    <div class="single top-cont">

            <div class="clearfix">
                <h2></h2>
            </div>


            <div class="col-md-12 panel-body">
@include('cart.guide')
                <div class="cont-wrap">
                	
                 <?php //print_r($data); ?>   

                    <div class="clearfix contents">
                    	<?php
                     	   	$pmName = $pmModel->find($pm)->name; 
                        	$thankStr = "お買い上げ、ありがとうございます。";
                        ?>
                     	

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
                        
                        
                        <div class="text-center">
                        	<a href="{{ url('/') }}">HOMEへ</a>   
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
@endsection
