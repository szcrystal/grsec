@extends('layouts.app')

@section('content')


	{{-- @include('main.shared.carousel') --}}

<div id="main" class="top">

        <div class="panel panel-default">

            <div class="panel-body">

				<div class="main-list clearfix">

<h3 class="mb-3 card-header">
@if($isMypage == 2)
退会手続きの完了
<?php
	$errorStr = '';
?>
@else
会員情報の登録完了
<?php
	$errorStr = 'カード情報をご確認の上、少し時間を空けて再度お試し下さい。';
?>
@endif
</h3>

@if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
@endif

<div class="top-cont">

<div class="mt-3 ml-1">
<p>{!! $status !!}</p>


@if(isset($editCardErrors))
	<p class="text-danger">
    	<i class="fal fa-exclamation-triangle"></i> 
        登録クレジットカードの更新を正常に進めることが出来ませんでした。
        
        @if(strpos($editCardErrors, '42G830000') !== false) 
        	<?php $errorStr = '正しい有効期限であることなど' . $errorStr; ?>
        @endif
        
        <small>{!! $editCardErrors !!}</small>
    </p>
@endif

@if(isset($delCardErrors))
	<p class="text-danger">
    	<i class="fal fa-exclamation-triangle"></i> 登録クレジットカードの削除を正常に進めることが出来ませんでした。
        <small>{!! $delCardErrors !!}</small>
    </p>
@endif

@if(isset($delMemberErrors))
	<p class="text-danger">
    	<i class="fal fa-exclamation-triangle"></i> クレジットカード登録情報の削除を正常に進めることが出来ませんでした。
        <small>{!! $delMemberErrors !!}</small>
    </p>
@endif

@if(isset($editCardErrors) || isset($delCardErrors) || isset($delMemberErrors))
    @if($isMypage != 2)
    	{{ $errorStr }}<br><br>
    @else
        <?php
            $mailLink = '<a href="mailto:info@green-rocket.jp">info@green-rocket.jp</a> までご連絡をお願い致します。';
        ?>
        {!! $mailLink !!}<br><br>
    @endif
@endif



@if(! $isMypage)
<p class="m-0 p-0">現在ログイン中です。<br>
購入履歴や各種情報など、<a href="{{ url('mypage') }}">マイページ</a>より確認できます。</p>
<a href="{{ url('mypage') }}" class="btn border-secondary bg-white mt-5">
<i class="fal fa-angle-double-left"></i> マイページへ
</a>
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


