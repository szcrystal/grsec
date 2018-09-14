@extends('layouts.app')


@section('content')

<?php
use App\Category;	
use App\Tag;
use App\TagRelation;
use App\Setting;
?>

<div id="main" class="archive">

@include('main.shared.bread')

<div class="panel panel-default top-cont">

        {{-- @include('main.shared.main') --}}


        <div class="panel-heading">
            <h2 class="mb-3 card-header">{{ $title }}</h2>
        </div>
        
        <div class="panel-body">
            

            <div class="pagination-wrap">
            	{{ $items->links() }}
            </div>

            
            <div class="clearfix top-second">
    
                    @foreach($items as $item)
                    
                        <article class="main-atcl">
                            
                            <?php
                                if(strpos($item['top_img_path'], 'category') !== false) {
                                    $slugType = 'category';
                                }
                                elseif(strpos($item['top_img_path'], 'subcate') !== false) {
                                    $slugType = 'category/' . Category::find($recom->parent_id)->slug;
                                }
                                elseif(strpos($item['top_img_path'], 'tag') !== false) {
                                    $slugType = 'tag';
                                }
                            ?>
            
                    
                    <div class="img-box">
                        <a href="{{ url($slugType . '/'. $item['slug']) }}">
                        <img src="{{ Storage::url($item['top_img_path']) }}" alt="{{ $item['top_title'] }}">
                        </a>
                    </div>
                    
                    <div class="meta">
                        <h3><a href="{{ url($slugType . '/'. $item['slug']) }}">{{ $item['top_title'] }}</a></h3>
                        
                        <p>{!! nl2br($item['top_text']) !!}</p>
                        
                    </div>
                        
                        
                        {{-- @include('main.shared.favorite') --}}
                            
                    </article>
                @endforeach
                
            </div>

        
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
