@extends('layouts.app')

@section('content')


	{{-- @include('main.shared.carousel') --}}

<div id="main" class="top">

    <div class="panel panel-default">

            <div class="panel-body">
                {{-- @include('main.shared.main') --}}

				<div class="main-list clearfix">
<?php
//    $path = Request::path();
//    $path = explode('/', $path);
?>


<div class="col-md-11 mx-auto clearfix">

<h2>マイページ</h2>
	<div class="text-right">
		{{ $user->name }} 様<br>
  		現在のポイント：{{ $user->point }} pt      
	</div>
    <ul class="mt-5">
    	<li class="float-left col-md-6 mb-3"><a href="{{ url('mypage/history') }}">購入履歴</a></li>
    	<li class="float-left col-md-6 mb-3"><a href="{{ url('mypage/register') }}">会員情報の変更</a></li>
     	<li class="float-left col-md-6 mb-3">パスワードの変更</li>
      	
       	<li class="float-left col-md-6 mb-3"><a href="{{ url('mypage/favorite') }}">お気に入り</a></li>
        <li class="float-left col-md-6 mb-3">メルマガ登録・解除</li>
        <li class="float-left col-md-6 mb-3">退会する</li>
        <li class="float-left col-md-6 mb-3">
        	<a href="{{ url('/logout') }}" class=""
                                onclick="event.preventDefault();
                                         document.getElementById('logout-form').submit();">ログアウト</a>

                    <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form>
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


