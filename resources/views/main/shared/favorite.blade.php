<?php
use App\Setting;
use App\Category;
use App\CategorySecond;
use App\Favorite;
?>

<div class="img-box">
    <a href="{{ url('/item/'.$item->id) }}">
    	<img src="{{ Storage::url($item->main_img) }}" alt="{{ $item->title }}">
    </a>
</div>

<div class="meta">
    <?php
    	$category = Category::find($item->cate_id);
    ?>
    <h3><a href="{{ url('/item/'.$item->id) }}">{{ Ctm::shortStr($item->title, 25) }}</a></h3>
    <p>
    	@if(isset($type) && $type == 'category')
        	@if(isset($item->subcate_id))
                <?php $cateSec = CategorySecond::find($item->subcate_id); ?>
                <a href="{{ url('category/'. $category->slug. '/' .$cateSec->name) }}">
                    {{ $cateSec->name }}
                </a>
            @else
            	{{ $item->catchcopy }}
            @endif
        @else
            <a href="{{ url('category/'. $category->slug) }}">
                @if(isset($category->link_name))
                    {{ $category->link_name }}
                @else
                    {{ $category->name }}
                @endif
            </a>
        @endif
    </p>


    <div class="tags">
        <?php $num = 2; ?>
        @include('main.shared.tag')
    </div>


    <div class="price">
        <?php 
            $isSale = Setting::get()->first()->is_sale; 
        ?>
        @if($isSale || isset($item->sale_price))
            <strike>{{ number_format(Ctm::getPriceWithTax($item->price)) }}</strike>
            <i class="fas fa-arrow-right text-small"></i>
        @endif
        
        @if(isset($item->sale_price))
            <span>{{ number_format(Ctm::getPriceWithTax($item->sale_price)) }}</span>
        @else
            @if($isSale)
                <span>{{ number_format(Ctm::getSalePriceWithTax($item->price)) }}</span>
            @else
                <span>{{ number_format(Ctm::getPriceWithTax($item->price)) }}</span>
            @endif
        @endif
        円(税込)
    </div>


    @if(Auth::check())
        <div class="favorite">
            <?php
                if(Favorite::where(['user_id'=>Auth::id(), 'item_id'=>$item->id])->first()) {
                    $on = ' d-none';
                    $off = ' d-inline'; 
                    $str = 'お気に入りの商品です';              
                }
                else {
                    $on = ' d-inline';
                    $off = ' d-none';
                    $str = 'お気に入りに登録';
                }               
            ?>

            <span class="fav fav-on{{ $on }}" data-id="{{ $item->id }}"><i class="far fa-heart"></i></span>
            <span class="fav fav-off{{ $off }}" data-id="{{ $item->id }}"><i class="fas fa-heart"></i></span>
            <small class="fav-str"><span class="loader"><i class="fas fa-square"></i></span>{{-- $str --}}</small>    
        </div>
    @else
        {{-- <span class="fav-temp"><a href="{{ url('login') }}"><i class="far fa-heart"></i></a></span> --}}
    @endif
    
</div>


