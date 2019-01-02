<?php
use App\Setting;
use App\Item;
use App\Category;
use App\CategorySecond;
use App\Favorite;
use App\Icon;
?>

<?php
	$isCate = (isset($type) && $type == 'category') ? 1 : 0;
	
    $category = Category::find($item->cate_id);
    $link = url('/item/'. $item->id);
    ///$linkName = isset($category->link_name) ? $category->link_name : $category->name;
    
    
    if($isCate && isset($item->subcate_id)) {
        $subCate = CategorySecond::find($item->subcate_id);
        $cateLink = url('category/'. $category->slug . '/' . $subCate->slug);
        $cateName = isset($subCate->link_name) ? $subCate->link_name : $subCate->name;
    }
    else {
    	$cateLink = url('category/'. $category->slug);
    	$cateName = isset($category->link_name) ? $category->link_name : $category->name;
    }

    $isSp = Ctm::isAgent('sp');
    $isSale = Setting::get()->first()->is_sale;
    
    $isStock = 0;
    $imgClass = '';
        
    $pots = Item::where(['is_potset'=>1, 'pot_parent_id'=>$item->id])->get();
    
    if($pots->isNotEmpty()) {
        foreach($pots as $pot) {
            if($pot->stock) {
                $isStock = 1;
                break;
            }
        }
    }
    else {
    	if($item->stock) {
        	$isStock = 1;
        }
    }
   
?>

@if($isSale || isset($item->sale_price))
<span class="sale-belt">SALE</span>
@endif


<div class="img-box">
	@if(! $isStock)
    	<?php $imgClass = 'stock-zero'; ?>
    	<span>SOLD OUT</span>
    @endif
    
    <a href="{{ $link }}">
    	<img src="{{ Storage::url($item->main_img) }}" alt="{{ $item->title }}" class="{{ $imgClass }}">
    </a>
</div>

<div class="meta">
    <h3><a href="{{ $link }}">
        {{ Ctm::shortStr($item->title, $strNum) }}
    </a></h3>
    
    <p>
        <a href="{{ $cateLink }}">{{ $cateName }}</a>
    </p>
    
    @if(isset($item->icon_id) && $item->icon_id != '')
        <div class="icons">
            <?php $obj = $item; ?>
            @include('main.shared.icon')
        </div>
    @endif


    <div class="tags">
        <?php $num = 2; ?>
        @include('main.shared.tag')
    </div>
            
        
    <div class="price">
        <?php
            $pots = Item::where(['is_potset'=>1, 'pot_parent_id'=>$item->id])->orderBy('price', 'asc')->get();
            $isPotParent = $pots->isNotEmpty();
            
            if($isPotParent) {
                $thisItem = $pots->first();
            }
            else {
                $thisItem = $item;
            }
        ?>
        
        @if($isSale || isset($thisItem->sale_price))
            @if(! $isSp)
                <strike>{{ number_format(Ctm::getPriceWithTax($thisItem->price)) }}</strike>
                <i class="fal fa-arrow-right text-small"></i>
            @endif
        @endif
        
        @if(isset($thisItem->sale_price))
            <span class="show-price text-enji">{{ number_format(Ctm::getPriceWithTax($thisItem->sale_price)) }}
        @else
            @if($isSale)
                <span class="show-price text-enji">{{ number_format(Ctm::getSalePriceWithTax($thisItem->price)) }}
            @else
                <span class="show-price">{{ number_format(Ctm::getPriceWithTax($thisItem->price)) }}
            @endif
        @endif
        </span>
        <span class="show-yen">円(税込)
        @if($isPotParent)
        〜
        @endif
        </span>
        
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

                <span class="fav fav-on{{ $on }}" data-id="{{ $item->id }}"><i class="fal fa-heart"></i></span>
                <span class="fav fav-off{{ $off }}" data-id="{{ $item->id }}"><i class="fas fa-heart"></i></span>
                <span class="loader"><i class="fas fa-square"></i></span>
                <small class="fav-str">{{-- $str --}}</small>    
            </div>
        @else
            {{-- <span class="fav-temp"><a href="{{ url('login') }}"><i class="far fa-heart"></i></a></span> --}}
        @endif
    
    
</div>


