@extends('layouts.app')

@section('content')


	{{-- @include('main.shared.carousel') --}}

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
                <a href="{{ url('item/'.$item->id) }}" class="btn border-secondary bg-white text-small">
                商品ページへ <i class="fas fa-angle-double-right"></i>
                </a> 
             
             	@if($item->saled)
              		<small class="d-block mb-2 mt-4">この商品は{{ Ctm::changeDate($item->saleDate, 1) }}<br>に購入しています</small>
                	<form class="form-horizontal" role="form" method="POST" action="{{ url('shop/cart') }}">
                        {{ csrf_field() }}
                                                                               
                        <input type="hidden" name="item_count" value="1">
                        <input type="hidden" name="from_item" value="1">
                        <input type="hidden" name="item_id" value="{{ $item->id }}">
                        <input type="hidden" name="uri" value="{{ Request::path() }}"> 
                                          
                       <button class="btn btn-custom text-small px-4" type="submit" name="regist_off" value="1"><i class="fas fa-shopping-basket"></i> もう一度購入</button>                 
                    </form>      
              	@else   
             		<button type="submit" class="btn btn-custom text-small">カートに入れる</button>
              	@endif   
             </td>
        </tr>
        @endforeach
        
        </tbody>
        
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


