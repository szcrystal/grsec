@extends('layouts.app')

@section('content')


	{{-- @include('main.shared.carousel') --}}

<div id="main" class="mypage">

    <div class="panel panel-default">

            <div class="panel-body">
                {{-- @include('main.shared.main') --}}

				<div class="main-list clearfix">
<?php
//    $path = Request::path();
//    $path = explode('/', $path);
?>


<div class="mx-auto clearfix">

<h2 class="mb-3 card-header">マイページ</h2>
	<div class="text-right text-big mr-3">
		<b class="text-big">{{ $user->name }}</b> 様<br>
  		現在の保持ポイント：<b class="text-big">{{ $user->point }}</b> pt      
	</div>

	
    <ul class="mt-5 col-md-9 mx-auto list-unstyled">
    	<li class="mb-5">
     	   <a href="{{ url('mypage/history') }}" class="d-inline-block text-big"><i class="fal fa-shopping-cart"></i> 購入履歴</a>
           <p>今までに購入した商品や枯れ保証の残り期間を確認できます。</p>
        </li>
        
        <li class="mb-5">
        	<a href="{{ url('mypage/favorite') }}" class="d-inline-block text-big"><i class="fal fa-heart"></i> お気に入り</a>
            <p>お気に入りに追加した商品を確認できます。</p>
        </li>
    	
        <li class="mb-5">
     	   <a href="{{ url('mypage/register') }}" class="d-inline-block text-big"><i class="fal fa-edit"></i> 会員情報の変更/メルマガ登録・解除</a>
           <p>会員情報の変更、メルマガの登録・解除はこちらから</p>
        </li>
     	
        <li class="mb-5">
      	   <a href="{{ url('password/reset') }}" class="d-inline-block text-big"><i class="fal fa-key"></i> パスワードの変更</a>
        </li>

        <li class="mb-5">
            <a href="{{ url('/logout') }}" class="d-inline-block text-big"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="fal fa-sign-out-alt"></i> ログアウト</a>

                    <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form>
        </li>
        
        <li class="mb-5">
        	<a href="{{ url('mypage/optout') }}" class="d-inline-block text-big"><i class="fal fa-user-times"></i> 退会する</a>
            <p>退会後はログイン不可となり、各種情報などの確認ができなくなります。</p>
        </li>
        
    </ul>

</div>






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


