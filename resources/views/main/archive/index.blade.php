@extends('layouts.app')

<?php
use App\TopSetting;
?>

@section('belt')
<div class="tophead-wrap">
    <div class="clearfix">
        {!! nl2br(TopSetting::get()->first()->contents) !!}
    </div>
    
    @if(isset($isTop) && $isTop)
        @include('main.shared.carousel')
    @endif
</div>
@endsection


@section('bread')
@include('main.shared.bread')
@endsection


@section('content')

<?php
    use App\Tag;
    use App\TagRelation;
    use App\Setting;
?>

<div id="main" class="archive">

<div class="panel panel-default top-cont">
	
    <?php $orgObj = null; ?>
    
    <div class="panel-heading">
        <h2 class="mb-3 card-header">
        @if($type == 'category')
            {{ $cate->name }}
            <?php $orgObj = $cate; ?>
            
        @elseif($type == 'subcategory')
            <small class="d-block pb-2">{{ $cate->name }}</small>{{ $subcate->name }}
            <?php $orgObj = $subcate; ?>
            
        @elseif($type == 'tag')
            タグ：{{ $tag->name }}
            <?php $orgObj = $tag; ?>
            
        @elseif($type=='search')
            @if(!count($items))
            検索ワード：{{ $searchStr }}の商品がありません
            @else
            検索ワード：{{ $searchStr }}
            @endif
        @elseif($type == 'unique')
            {{ $title }}
        @endif
        </h2>
    </div>
        
    <div class="panel-body">
        
        @if($type == 'category' || $type == 'subcategory' || $type == 'tag')
            @if(Request::query('page') < 2)
                @include('main.shared.upper')
            
                @if(isset($orgObj->upper_title) || isset($orgObj->upper_text))
                    <div class="mb-4">
                        @if(isset($orgObj->upper_title) && $orgObj->upper_title != '')
                            <h3 class="upper-title">{{ $orgObj->upper_title }}</h3>
                        @endif
                        
                        @if(isset($orgObj->upper_text) && $orgObj->upper_text != '')
                            <p class="upper-text px-1 m-0">{!! nl2br($orgObj->upper_text) !!}</p>
                        @endif
                    
                    </div>
                @endif
            @endif
        @endif
        
        
        <div class="pagination-wrap">
            {{ $items->links() }}
        </div>
        
        <?php 
            $n = Ctm::isAgent('sp') ? 3 : 4;
            $itemArr = array_chunk($items->all(), $n); 
        ?>
        
        @foreach($itemArr as $itemVal)
            <div class="clearfix">

            @foreach($itemVal as $item)
                <article class="main-atcl">
                        
                    <?php $strNum = Ctm::isAgent('sp') ? 16 : 25; ?>
                    @include('main.shared.atcl')
                        
                </article>
            @endforeach
            
            </div>
        @endforeach
    
    </div>
        
    <div class="pagination-wrap">
        {{ $items->links() }}
    </div>
            
</div>
</div>

@endsection


@section('leftbar')
    @include('main.shared.leftbar')
@endsection


