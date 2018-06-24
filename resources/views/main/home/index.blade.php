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




<div class="top-cont">

    @foreach($itemCates as $key => $items)
    <div class="wrap-atcl">
    	<div class="clearfix head-atcl">
    		<h2>{{ $key }}</h2>
      		
        </div>
    
    	<div class="clearfix">
    	@foreach($items as $item)
            <article class="main-atcl">
                <a href="{{ url('/item/'.$item->id) }}">
                    <img src="{{ Storage::url($item->main_img) }}" alt="{{ $item->title }}">
                </a>
                
                <div class="meta">
                    <h3><a href="{{ url('/item/'.$item->id) }}">{{ $item->title }}</a></h3>
                    <p>{{ $item->catchcopy }}</p>
                    <div class="text-right text-big">¥{{ number_format(Ctm::getPriceWithTax($item->price)) }}</div>
                </div>
            </article>
    	@endforeach
     	</div> 
      
      	<?php $slug = Category::where('name', $key)->first()->slug; ?>
      	<a href="{{ url('category/'.$slug) }}" class="btn btn-block w-25 mx-auto btn-custom bg-white border-secondary text-dark rounded-0">VIEW MORE <i class="fa fa-caret-right" aria-hidden="true"></i></a>
           
     </div>   
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


