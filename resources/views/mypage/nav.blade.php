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


<div class="top-cont feature clear">

<h2>マイページ</h2>
    <ul>
    	<li>会員情報の変更</li>
     	<li>パスワードの変更</li>
      	<li>購入履歴</li>
       	<li>お気に入り</li>
        <li>メルマガ登録・解除</li>            
    
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


