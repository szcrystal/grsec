@extends('layouts.app')


@section('content')

<?php
    use App\Tag;
    use App\TagRelation;
    use App\Setting;
?>

<div id="main" class="archive">

@include('main.shared.bread')

    <div class="panel panel-default top-cont">

                {{-- @include('main.shared.main') --}}


				<div class="panel-heading">
                    <h2 class="h2 mb-3 card-header">
                    @if($type == 'category')
                    	{{ $cate->name }}
                    @elseif($type == 'subcategory')
                    	<small class="d-block pb-2">{{ $cate->name }}</small>{{ $subcate->name }}
                    @elseif($type == 'tag')
                    	{{ $tag->name }}
                    @elseif($type=='search')
                        @if(!count($items))
                        検索ワード：{{ $searchStr }}の記事がありません
                        @else
                        検索ワード：{{ $searchStr }}
                        @endif
                    @endif
                    </h2>
                </div>
                
                <div class="panel-body">
                	
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

				<div class="pagination-wrap">
                {{ $items->links() }}
                </div>
                	
                    <?php $itemArr = array_chunk($items->all(), 3); ?>
                    
                    @foreach($itemArr as $itemVal)
                    	<div class="clearfix">
            
                		@foreach($itemVal as $item)
                            <article class="main-atcl">
                            	<div class="img-box">
                                <a href="{{ url('/item/'.$item->id) }}">
                                    <img src="{{ Storage::url($item->main_img) }}" alt="{{ $item->title }}">
                                </a>
                                </div>
                                
                                <div class="meta">
                                    <h3><a href="{{ url('/item/'.$item->id) }}">{{ $item->title }}</a></h3>
                                    <p>{{ $item->catchcopy }}</p>
                                    
                                    <div class="tags">
                                        <?php
                                            $num = 5;
                                        ?>
                                        @include('main.shared.tag')
                                        
                                    </div>
                                    
                                    <div class="price">
                                    	<?php 
                                            $isSale = Setting::get()->first()->is_sale; 
                                        ?>
                                        @if($isSale)
                                            <strike>{{ number_format(Ctm::getPriceWithTax($item->price)) }}</strike>
                                            <i class="fas fa-arrow-right text-small"></i>
                                            ¥{{ number_format(Ctm::getSalePriceWithTax($item->price)) }}
                                        @else
                                    		¥{{ number_format(Ctm::getPriceWithTax($item->price)) }}
                                        @endif
                                    </div>
                                </div>
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


{{--
@section('rightbar')
	@include('main.shared.rightbar')
@endsection
--}}
