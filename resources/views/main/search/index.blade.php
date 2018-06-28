@extends('layouts.app')


@section('content')

<div id="main" class="archive">

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


                    @foreach($items as $item)
                        <article class="float-left">
                            <a href="{{ url('/item/'.$item->id) }}">
                                <img src="{{ Storage::url($item->main_img) }}" alt="{{ $item->title }}">
                            </a>
                            
                            <div class="meta">
                                <h3><a href="{{ url('/item/'.$item->id) }}">{{ $item->title }}</a></h3>
                                <p></p>
                                <div class="text-right text-big">¥{{ number_format(Ctm::getPriceWithTax($item->price)) }}</div>
                            </div>
                        </article>
                    @endforeach
                
                </div>
            
        {{ $items->links() }}
            
</div>
</div>

@endsection

{{--
@section('leftbar')
    @include('main.shared.leftbar')
@endsection
--}}

{{--
@section('rightbar')
	@include('main.shared.rightbar')
@endsection
--}}
