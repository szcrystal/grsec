@extends('layouts.app')


@section('content')

<div id="main" class="top">

    <div class="panel panel-default">

        <div class="panel-body">
                {{-- @include('main.shared.main') --}}

            <div class="main-list clearfix">
            <div class="top-cont feature clear">

            <div class="panel panel-default">
				<div class="panel-heading">
                    <h2 class="h2">
                    @if(!count($items))
                    検索ワード：{{ $searchStr }}の記事がありません
                    @else
                    検索ワード：{{ $searchStr }}
                    @endif
                    </h2>
                </div>
                
                
                @foreach($items as $item)
                    <article class="float-left">

                            <a href="{{ url('/item/'.$item->id) }}">
                                <img src="{{ Storage::url($item->main_img) }}" alt="{{ $item->title }}">
                            </a>
                            
                            <div class="meta">
                                <h3><a href="{{ url('/item/'.$item->id) }}">{{ $item->title }}</a></h3>
                                <p></p>
                            </div>

                            <span><i class="fa fa-caret-right" aria-hidden="true"></i></span>
                        
                    </article>
                @endforeach
                
                
                
                
            </div>
            
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
--}}

{{--
@section('rightbar')
	@include('main.shared.rightbar')
@endsection
--}}
