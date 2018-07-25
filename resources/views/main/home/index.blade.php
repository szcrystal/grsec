@extends('layouts.app')

@section('content')


	{{-- @include('main.shared.carousel') --}}

<div id="main" class="top home">

    <div class="panel panel-default">

        <div class="panel-body">
            {{-- @include('main.shared.main') --}}

<?php
    use App\User;
    use App\Category;
    use App\Setting;
//    use App\TagRelation;

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
        
        <?php $items = array_chunk($items, 4); ?>
        
    	@foreach($items as $itemVal)
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
                            <?php $num = 3; ?>
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
      
      	<?php $slug = Category::where('name', $key)->first()->slug; ?>
      	<a href="{{ url('category/'.$slug) }}" class="btn btn-block mx-auto btn-custom bg-white border-secondary text-dark rounded-0">VIEW MORE <i class="fa fa-caret-right" aria-hidden="true"></i></a>
           
     </div>   
    @endforeach

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


