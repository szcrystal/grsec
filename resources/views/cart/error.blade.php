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
                <?php
                    //$pmName = $pmModel->find($pm)->name; 
                    $thankStr = "お買い上げ、ありがとうございます。<br>ご注文が完了致しました。";
                ?>
                
                @if(isset($erroeName))
                	{{ $erroeName }}<br>
                @endif
                
                ご注文を正しく進めることができませんでした。<br>
                
                @if(isset($data['order_number']))
                    ご注文番号：[ {{ $data['order_number'] }} ] <br>
                @endif
                
                
                
                <div class="text-center mt-5 pb-3">
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



