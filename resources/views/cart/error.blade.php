@extends('layouts.app')

@section('content')


<div id="main" class="top-cont">

        <div class="panel panel-default">

            <div class="panel-body">


<div class="clearfix">

@include('cart.guide')


@if (count($errors) > 0)
    <div class="alert alert-danger">
        <i class="far fa-exclamation-triangle"></i> 確認して下さい。
        
        <ul class="mt-2">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif



	<div class="cont-wrap">
                	
         <?php //print_r($data); ?>   

            <div class="clearfix contents text-center">
                
                <span class="text-danger"><i class="fal fa-exclamation-triangle"></i> ご注文が完了していません。</span>
                
                <p class="mt-2">
	                ご注文を正常に進めることができませんでした。<br>
    	            クレジットカード入力情報を再度ご確認の上<br>
                    少し時間を置いてやり直すか<br>別のお支払い方法を選択下さい。<br><br>
                    @if(isset($erroeName))
                        <span class="text-small text-secondary">{{ $erroeName }}</span>
                    @endif
                </p>
                
                
                <div class="text-center mt-5 pb-3">
                    <a href="{{ url('shop/cart') }}">カートに戻る <i class="fal fa-angle-double-right"></i></a><br><br>
                    <a href="{{ url('/') }}">HOMEへ <i class="fal fa-angle-double-right"></i></a>   
                </div>    
   
            </div>

    </div>

	{{--
	<a href="{{ url('shop/form') }}" class="btn border border-secondary bg-white my-3"><i class="fal fa-angle-double-left"></i> お客様情報の入力に戻る</a>
    --}}
</div>





</div>
</div>
</div>

@endsection



