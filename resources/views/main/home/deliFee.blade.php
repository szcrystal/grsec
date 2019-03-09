@extends('layouts.app')

<?php
use App\User;
use App\Category;
use App\DeliveryGroupRelation;
use App\Prefecture;
use App\Setting;
use App\TopSetting;
?>


@if(! Ctm::isAgent('sp'))
@section('belt')
<div class="tophead-wrap">
    <div class="clearfix">
        {!! nl2br(TopSetting::get()->first()->contents) !!}
    </div>
</div>
@endsection
@endif


@section('content')

<div id="main" class="fix-page deli-fee">

    <div class="panel panel-default">
        <h2 class="mb-3 card-header">{{ $dg->table_name }}</h2>
        
        @if(isset($dg->table_comment) && $dg->table_comment != '')
        	<p class="mt-0 mb-3 p-0">{!! nl2br($dg->table_comment) !!}</p>
        @endif

        <div class="panel-body">

            <div class="top-cont clearfix">
 
				@include('main.shared.deliFeeTable')
            
            </div>

		</div>

    </div>


</div>

@endsection


@section('leftbar')
    @include('main.shared.leftbar')
@endsection


