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
	
    <?php 
        if(strpos($key, '新着情報') !== false)
            $lineType = 1;
        elseif(strpos($key, 'ランキング') !== false) {
            $lineType = 2; 
            $rankNum = 1;
        }
        elseif(strpos($key, 'チェック') !== false)
            $lineType = 3;
    ?>

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
                    
                        <article class="main-atcl">
                            @if($lineType == 1)
                                <span class="top-new">NEW！</span>
                            @elseif($lineType == 2)
                                <span class="top-rank"><i class="fas fa-crown"></i><em>{{ $rankNum }}</em></span>
                            @endif
                                                            
                                
                            @include('main.shared.favorite')
     
                        </article>
                        
                        @if($lineType == 2)
                            <?php $rankNum++; ?>
                        @endif
                    @endforeach
                </div>
          
                <?php 
                	if($lineType == 1)
                	    $slug = 'new-items';
                    elseif($lineType == 2)
                	    $slug = 'ranking';
                    elseif($lineType == 3)
                	    $slug = 'recent-items';
                ?>
                
                <a href="{{ url($slug) }}" class="btn btn-block mx-auto btn-custom bg-white border-secondary text-dark rounded-0">もっと見る</a>

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
        	<article class="main-atcl clearfix"> 
            
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
    
    <a href="{{ url('recommend-info') }}" class="btn btn-block mx-auto btn-custom bg-white border-secondary text-dark rounded-0">もっと見る</a>
    
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


