@extends('layouts.app')

@section('content')


<div id="main" class="confirm">

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



<div class="mt-5">
<form id="with1" class="form-horizontal" role="form" method="POST" action="{{ $actionUrl }}">
    {{ csrf_field() }}
    
    
    @if($data['pay_method'] == 5)
    	<input type="hidden" name="trans_code" value="888888">
    @elseif($data['pay_method'] == 6)
    	<input type="hidden" name="trans_code" value="999999">
    @endif   
    
    
    @foreach($settles as $key => $settle)
    	<input type="hidden" name="{{ $key }}" value="{{ $settle }}">
    @endforeach
    
  
  
	<div class="">
    	<?php
        	$disabled = '';
            if(count($errors) > 0) {
            	$disabled = ' disabled';
            }
        ?>
  		<button class="btn btn-block btn-enji col-md-4 mb-4 mx-auto py-2" type="submit" name="regist_off" value="1"{{ $disabled }}>注文する</button>
	</div>                
</form>

<a href="{{ url('shop/form') }}" class="btn border border-secondary bg-white my-3"><i class="fal fa-angle-double-left"></i> お客様情報の入力に戻る</a>
</div>





</div>
</div>
</div>

@endsection


{{--
@section('leftbar')
    @include('main.shared.leftbar')
@endsection


@section('rightbar')
	@include('main.shared.rightbar')
@endsection
--}}


