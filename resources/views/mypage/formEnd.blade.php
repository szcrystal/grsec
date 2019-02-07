@extends('layouts.app')

@section('content')


	{{-- @include('main.shared.carousel') --}}

<div id="main" class="top">

        <div class="panel panel-default">

            <div class="panel-body">
                {{-- @include('main.shared.main') --}}

				<div class="main-list clearfix">
<h3 class="mb-3 card-header">
@if($isMypage == 2)
退会手続きの完了
@else
会員情報の登録完了
@endif
</h3>

@if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
@endif

<div class=" top-cont">

<div class="mt-3">
<p>{{ $status }}</p>

@if(isset($delCardErrors))
	<p class="text-danger">
    	<i class="fal fa-exclamation-triangle"></i> クレジットカードの登録削除を正常に進めることが出来ませんでした。
        <small>{!! $delCardErrors !!}</small>
    </p>
@endif

@if(! $isMypage)
現在ログイン中です。<br>
購入履歴や各種情報など、<a href="{{ url('mypage') }}">マイページ</a>より確認できます。

@endif
</div>

@if($isMypage == 2)
<a href="{{ url('/') }}" class="btn border-secondary bg-white mt-3">
<i class="fal fa-angle-double-left"></i> HOME
</a>

@elseif($isMypage == 1)
<a href="{{ url('mypage') }}" class="btn border-secondary bg-white mt-5">
<i class="fal fa-angle-double-left"></i> マイページへ
</a>
@endif
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


