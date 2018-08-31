@extends('layouts.app')

@section('content')

<?php
use App\Setting;
use App\Favorite;
?>


<div id="main" class="top home">

    <div class="panel panel-default">

        <div class="panel-body top-cont">
            {{-- @include('main.shared.main') --}}


@foreach($firstItems as $key => $firstItem)
	
    @if(strpos($key, '新着情報') !== false)
    	<?php $type = 1; ?>
    @elseif(strpos($key, 'ランキング') !== false)
        <?php 
        	$type = 2; 
        	$rankNum = 1;
        ?>
    @elseif(strpos($key, 'チェック') !== false)
        <?php 
        	$type = 3;
        ?>
    @endif

@if(isset($firstItem) && count($firstItem) > 0)

	<div class="wrap-atcl top-first">
    	<div class="head-atcl">
    		<h2>{{ $key }}</h2>
        </div>
    
    	<div class="clearfix">
        	<?php $items = array_chunk($firstItem, 4); ?>
	
            @foreach($items as $itemVal)

                <div class="clearfix">
                    @foreach($itemVal as $item)
                        <?php $cate = $cates->find($item->cate_id); ?>
                    
                        <article class="main-atcl">
                            @if($type == 1)
                                <span class="top-new">NEW！</span>
                            @elseif($type == 2)
                                <span class="top-rank"><i class="fas fa-crown"></i><em>{{ $rankNum }}</em></span>
                            @endif
                            
                            <div class="img-box">
                                <a href="{{ url('/item/'.$item->id) }}">
                                <img src="{{ Storage::url($item->main_img) }}" alt="{{ $item->title }}">
                                </a>
                            </div>
                            
                            <div class="meta">
                            	
                                <h3><a href="{{ url('/item/'.$item->id) }}">{{ $item->title }}</a></h3>
                                <p><a href="{{ url('category/'.$cate->slug) }}">
                                	@if(isset($cate->link_name))
                                    {{ $cate->link_name }}
                                    @else
                                    {{ $cate->name }}
                                    @endif
                                </a></p>
                                
                                <div class="tags">
                                    <?php $num = 2; ?>
                                    @include('main.shared.tag')
                                </div>
                                
                                
                                <div class="price">
                                    <?php 
                                        $isSale = Setting::get()->first()->is_sale; 
                                    ?>
                                    @if($isSale || isset($item->sale_price))
                                    	<strike>{{ number_format(Ctm::getPriceWithTax($item->price)) }}</strike>
                                        <i class="fas fa-arrow-right text-small"></i>
                                    @endif
                                    
                                    @if(isset($item->sale_price))
                                    	<span>{{ number_format(Ctm::getPriceWithTax($item->sale_price)) }}</span>
                                    @else
                                        @if($isSale)
                                            <span>{{ number_format(Ctm::getSalePriceWithTax($item->price)) }}</span>
                                        @else
                                            <span>{{ number_format(Ctm::getPriceWithTax($item->price)) }}</span>
                                        @endif
                                    @endif
                                    円(税込)
                                </div>
                                
                                
                                @if(Auth::check())
                                	<div class="favorite">

                                        <?php
                                            if(Favorite::where(['user_id'=>Auth::id(), 'item_id'=>$item->id])->first()) {
                                                $on = ' d-none';
                                                $off = ' d-inline'; 
                                                $str = 'お気に入りの商品です';              
                                            }
                                            else {
                                                $on = ' d-inline';
                                                $off = ' d-none';
                                                $str = 'お気に入りに登録';
                                            }               
                                        ?>

                                        <span class="fav fav-on{{ $on }}" data-id="{{ $item->id }}"><i class="far fa-heart"></i></span>
                                        <span class="fav fav-off{{ $off }}" data-id="{{ $item->id }}"><i class="fas fa-heart"></i></span>
                                        <small class="fav-str"><span class="loader"><i class="fas fa-square"></i></span>{{-- $str --}}</small>    
                                	</div>
                                @else
                                    {{-- <span class="fav-temp"><a href="{{ url('login') }}"><i class="far fa-heart"></i></a></span> --}}
                                @endif 
                                
                            </div>

                        </article>
                        
                        @if($type == 2)
                            <?php $rankNum++; ?>
                        @endif
                    @endforeach
                </div>
          
                <?php $slug = $cate->slug; ?>
                <a href="{{ url('category/'.$slug) }}" class="btn btn-block mx-auto btn-custom bg-white border-secondary text-dark rounded-0">もっと見る</a>

            @endforeach

        </div>
    </div>
    
@endif
@endforeach

@if(isset($allRecoms) && count($allRecoms) > 0)
<div class="wrap-atcl top-second">
	<div class="head-atcl">
        <h2>おすすめ情報</h2>
    </div>
    
	<div class="clearfix">
    	@foreach($allRecoms as $recom)
        	
            <?php
            	if(strpos($recom->top_img_path, 'category') !== false) {
            		$slugType = 'category';
                }
                elseif(strpos($recom->top_img_path, 'subcate') !== false) {
                	$slugType = 'category/' . $cates->find($recom->parent_id)->slug;
                }
                elseif(strpos($recom->top_img_path, 'tag') !== false) {
                	$slugType = 'tag';
                }
            ?>
        
            <article class="main-atcl clearfix">     
                <div class="img-box">
                    <a href="{{ url($slugType . '/'. $recom->slug) }}">
                    <img src="{{ Storage::url($recom->top_img_path) }}" alt="{{ $recom->top_title }}">
                    </a>
                </div>
                
                <div class="meta">
                    <h3><a href="{{ url($slugType . '/'. $recom->slug) }}">{{ $recom->top_title }}</a></h3>
                    
                    <p>{!! nl2br($recom->top_text) !!}</p>
                    
                </div>
                
            </article>
        @endforeach
    </div>
    
</div>
@endif
 


	</div><!-- top cont --> 

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


