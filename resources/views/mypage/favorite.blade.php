@extends('layouts.app')

@section('content')

<?php
use App\Item;
use App\Category;
use App\CategorySecond;
?>

<div id="main" class="mp-favorite">

    <div class="panel panel-default">

        <div class="panel-body">

<h3 class="mb-3 card-header">お気に入り一覧</h3>
@if(! count($items) > 0)
<p class="min-height-45">まだお気に入りに登録された商品がありません。</p>

@else

@if(! Auth::check())
<p class="mb-5 ml-1 text-small">
お気に入りに関する操作が3ヶ月以上ない場合は自動で削除されます。<br>
また、ログインすると下記の登録された商品は表示されません。<br>
永続してご利用になりたい場合は、<a href="{{ url('login') }}"><b>ログイン<i class="fal fa-angle-double-right"></i></b></a> してご利用下さい。
</p>
@endif

<div class="table-responsive table-cart min-height-45">
    <table class="table"> {{-- table-striped  --}}
        
        <tbody>
            @foreach($items as $item)
            
                <tr>
                    <th>
                        @include('main.shared.smallThumbnail')
                    </th>
                    
                    <?php 
                        $cate = Category::find($item->cate_id);
                        
                        if($cate->id == 1) {
                            $subcate = CategorySecond::find($item->subcate_id);
                            $cateSlug = $cate->slug . '/' .$subcate->slug;
                            $cateName = $subcate->name;
                        }
                        else {
                            $cateSlug = $cate->slug;
                            $cateName = $cate->name;
                        }
                        
                        $pots = Item::where(['is_potset'=>1, 'pot_parent_id'=>$item->id])->orderBy('price', 'asc')->get();
                    ?>
                    
                    <td class="clearfix">                	

                        <div class="float-left col-md-9">
                            <p class="m-0"><i class="fas fa-heart text-enji"></i> {{ Ctm::changeDate($item->fav_created_at, 1) }}</p>
                            <a href="{{ url('item/'.$item->id) }}">{{ $item->title }}</a><br>
                            
                            <span class="mr-2">[{{ $item->number }}]</span>
                            
                            <span>
                                @if($pots->isNotEmpty())
                                    ¥{{ Ctm::getItemPrice($pots->first()) }}~
                                @else
                                    ¥{{ Ctm::getItemPrice($item) }}
                                @endif
                            </span>
                            <br>
                            <span class="text-small">カテゴリー：</span><a href="{{ url('category/'. $cateSlug) }}" class="d-inline-block py-1">{{ $cateName }}</a>
                         </div>
                            
                        <div class="fav-btn-wrap float-right col-md-3 p-0">
                            <a href="{{ url('item/'.$item->id) }}" class="btn border-secondary bg-white text-small w-100 rounded-0 mb-2">
                                商品ページへ <i class="fal fa-angle-double-right"></i>
                            </a>

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
                                        <button type="submit" class="btn btn-custom text-small text-center w-100">カートに入れる</button>
                                    @endif  
                                </form>
                            @else
                                <p class="text-extra-small m-0">＊商品ページよりご希望のポットセット数を選択してカートに入れて下さい。</p>
                            @endif
                       </div>

                     </td>
                     
                     <td class="text-right">
                     	<form class="form-horizontal" role="form" method="POST" action="{{ url('favorite-del') }}">
                        	{{ csrf_field() }}
                    		<button class="btn btn-cart-del mb-4" type="submit" name="fav_del_id" value="{{ $item->fav_id }}"><i class="fal fa-times"></i></button>
                        </form>      
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

@if(Auth::check())
<a href="{{ url('mypage') }}" class="btn border-secondary bg-white mt-5">
<i class="fal fa-angle-double-left"></i> マイページに戻る
</a>
@endif     


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


