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

        <div class="panel-heading">
            <h2 class="mb-3 card-header">
            @if($type == 'category')
                {{ $cate->name }}
            @elseif($type == 'subcategory')
                <small class="d-block pb-2">{{ $cate->name }}</small>{{ $subcate->name }}
            @elseif($type == 'tag')
                タグ：{{ $tag->name }}
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
        	
            @if(! Ctm::isEnv('product'))
            	@include('main.shared.upper')
            @endif
            
            {{--
            @if($type == 'category' && isset($cate->contents))
                <div class="my-4">
                    {!! $cate->contents !!}
                </div>
            @elseif($type == 'subcategory' && isset($subcate->contents))
                <div class="my-4">
                    {!! $subcate->contents !!}
                </div>
            @elseif($type == 'tag' && isset($tag->contents))
                <div class="my-4">{!! $tag->contents !!}</div>
            
            @endif
            --}}

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


