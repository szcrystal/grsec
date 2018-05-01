@extends('layouts.app')

@section('content')


	{{-- @include('main.shared.carousel') --}}

<div id="main" class="top">

        <div class="panel panel-default">

            <div class="panel-body">
                {{-- @include('main.shared.main') --}}

				<div class="main-list clearfix">
<?php
    use App\User;
    use App\Category;
    use App\Tag;

    $path = Request::path();
    $path = explode('/', $path);
    

    
?>


<div class="top-cont feature clear">

<h2></h2>
    @foreach($items as $item)
    <article style="background-image:url()" class="float-left">

            <a href="{{ url('/item/'.$item->id) }}">
				<img src="{{ Storage::url($item->main_img) }}" alt="{{ $item->title }}">
            </a>
            
            <div class="meta">
            	<h3><a href="">{{ $item->title }}</a></h3>
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

@endsection


{{--
@section('leftbar')
    @include('main.shared.leftbar')
@endsection


@section('rightbar')
	@include('main.shared.rightbar')
@endsection
--}}


