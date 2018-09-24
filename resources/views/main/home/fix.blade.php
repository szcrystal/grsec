@extends('layouts.app')

<?php
use App\TopSetting;
?>

@section('belt')
<div class="tophead-wrap">
    <div class="clearfix">
        {!! nl2br(TopSetting::get()->first()->contents) !!}
    </div>
</div>
@endsection


@section('bread')
@include('main.shared.bread')
@endsection


@section('content')

<div id="main" class="fix-page col-md-12 {{ $fix->slug }}">

    <div class="panel panel-default">
        <h2 class="h2 mb-3 card-header">{{ $fix->title }}</h2>

        <div class="panel-body">

            <div class="top-cont clearfix">
            
                {!! $fix->contents !!}
            
            </div>

		</div>

    </div>


</div>

@endsection


@section('leftbar')
    @include('main.shared.leftbar')
@endsection






