@extends('layouts.app')

@section('content')

<?php
use App\Item;
?>

<div id="main" class="mypage">

        <div class="panel panel-default">

            <div class="panel-body">
                {{-- @include('main.shared.main') --}}



<h3 class="mb-3 card-header">お気に入り一覧</h3>
@if(! count($items) > 0)
<p style="min-height: 300px;">まだお気に入りに登録された商品がありません。</p>

@else
<div class="table-responsive table-custom">
    <table class="table table-bordered bg-white"> {{-- table-striped  --}}
    
    @if(! Ctm::isAgent('sp'))
        <thead>
        <tr>
        	<th>登録日</th>
         	<th style="width: 40%;">商品名</th>
          	<th>カテゴリー</th>
           	<th>金額</th>
			<th></th>
        </tr>
        </thead>
        
        <tbody>
        @foreach($items as $item)
        <tr>
             <td>{{ Ctm::changeDate($item->created_at, 1) }}</td>
             <td class="clearfix">
             	<a href="{{ url('item/'.$item->id) }}">
              	<img src="{{ Storage::url($item->main_img) }}" width="85" height="85" class="img-fluid float-left mr-3">  
             	{{ $item->title }}<br>
              	[{{ $item->number }}]
               </a>      
            </td>
             <td><a href="{{ url('category/'. $item->cate_id) }}">{{ $cates->find($item->cate_id)->name }}</a></td>
             <td>¥{{ number_format(Ctm::getPriceWithTax($item->price)) }}</td>
             <td>
                <a href="{{ url('item/'.$item->id) }}" class="btn border-secondary bg-white text-small w-100 rounded-0">
                商品ページへ <i class="fas fa-angle-double-right"></i>
                </a>
                
                <?php 
                	$pots = Item::where('pot_parent_id', $item->id)->get();
                ?>
             
             	@if($pots->isEmpty())
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('shop/cart') }}">
                        {{ csrf_field() }}
                                                                               
                        <input type="hidden" name="item_count[]" value="1">
                        <input type="hidden" name="from_item" value="1">
                        <input type="hidden" name="item_id[]" value="{{ $item->id }}">
                        <input type="hidden" name="uri" value="{{ Request::path() }}"> 
                            
                    @if($item->saleDate)
                        <small class="d-block mb-2 mt-4">この商品は{{ Ctm::changeDate($item->saleDate, 1) }}<br>に購入しています</small>                   
                        <button class="btn btn-custom text-small w-100 text-center" type="submit" name="regist_off" value="1">もう一度購入</button>         
                    @else   
                        <button type="submit" class="btn btn-custom text-small text-center w-100 mt-3">カートに入れる</button>
                    @endif  
                    </form>
                @endif 
             </td>
        </tr>
        @endforeach
        
        </tbody>
 	
    @else
     
        <tbody>
        @foreach($items as $item)
        <tr>
        	<td class="clearfix">
             <p>登録日：{{ Ctm::changeDate($item->created_at, 1) }}</P>
             
             <div class="clearfix mb-2">
             	<a href="{{ url('item/'.$item->id) }}">
              	<img src="{{ Storage::url($item->main_img) }}" width="85" height="85" class="img-fluid float-left d-block mr-3">  
             	{{ $item->title }}<br>
              	[{{ $item->number }}]
               </a> 
               <p class="text-right">¥{{ number_format(Ctm::getPriceWithTax($item->price)) }}</p>
            </div>
            
            <p>カテゴリー：<a href="{{ url('category/'. $item->cate_id) }}">{{ $cates->find($item->cate_id)->link_name }}</a></p>
            
            
            
            <div class="w-50 float-right">
                <a href="{{ url('item/'.$item->id) }}" class="btn border-secondary bg-white text-small w-100 rounded-0">
                商品ページへ <i class="fas fa-angle-double-right"></i>
                </a>
                
                <?php 
                	$pots = Item::where('pot_parent_id', $item->id)->get();
                ?>
             
             	@if($pots->isEmpty())
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('shop/cart') }}">
                        {{ csrf_field() }}
                                                                               
                        <input type="hidden" name="item_count[]" value="1">
                        <input type="hidden" name="from_item" value="1">
                        <input type="hidden" name="item_id[]" value="{{ $item->id }}">
                        <input type="hidden" name="uri" value="{{ Request::path() }}"> 
                    
                    @if($item->saleDate)
                        <small class="d-block mb-2 mt-2">この商品は{{ Ctm::changeDate($item->saleDate, 1) }}<br>に購入しています</small>
                        <button class="btn btn-custom text-small text-center w-100" type="submit" name="regist_off" value="1">もう一度購入</button>      
                    @else   
                        <button type="submit" class="btn btn-custom text-small text-center w-100 mt-3">カートに入れる</button>
                    @endif 
                    </form> 
                @endif
             </div>
        </tr>
        @endforeach
        
        </tbody>
 		
        
        
	@endif
	</table>
</div>

<div>
	{{ $items->links() }}
</div>
@endif

<a href="{{ url('mypage') }}" class="btn border-secondary bg-white mt-5">
<i class="fas fa-angle-double-left"></i> マイページに戻る
</a>                  


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


