@extends('layouts.app')

<?php
use App\User;
use App\Category;
use App\DeliveryGroupRelation;
use App\Prefecture;
use App\Setting;
use App\TopSetting;
?>


@section('belt')
<div class="tophead-wrap">
    <div class="clearfix">
        {!! nl2br(TopSetting::get()->first()->contents) !!}
    </div>
    
    @if(isset($isTop) && $isTop)
        @include('main.shared.carousel')
    @endif
</div>
@endsection



@section('content')

    <div id="main" class="single">
    	
        @include('main.shared.bread')
		
        <div class="head-frame clearfix">
            
            <div class="single-left">
                @if($item -> main_img)
                <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel" data-interval="7500">
                      
                      
                      <div class="carousel-inner">
                        <div class="carousel-item active">
                          <img class="d-block w-100" src="{{ Storage::url($item->main_img) }}" alt="First slide">
                        </div>
                        
                        @foreach($imgsPri as $img)
                            @if($img->img_path !== null )
                            <div class="carousel-item">
                              <img class="d-block w-100" src="{{ Storage::url($img->img_path)}}" alt="Sub slide">
                            </div>
                            @endif
                        @endforeach
                        
                      </div>
                      
                      <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"><i class="fa fa-angle-left"></i></span>
                        <span class="sr-only">Previous</span>
                      </a>
                      <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"><i class="fa fa-angle-right"></i></span>
                        <span class="sr-only">Next</span>
                      </a>
                      
                      
                      <ol class="carousel-indicators clearfix">
                        <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active">
                        	<img class="img-fluid" src="{{ Storage::url($item->main_img) }}" alt="slide">
                        </li>
                        
                        <?php 
                        	$count = count($imgsPri);
                            $n = 1;
                        ?>
                        
                        	
                            @foreach($imgsPri as $img)
                                @if($img->img_path !== null )
                                	<li data-target="#carouselExampleIndicators" data-slide-to="{{$n}}">
                                        <img class="img-fluid" src="{{ Storage::url($img->img_path)}}" alt="slide">
                                    </li>
                                    
                                    <?php $n++; ?>
                                @endif
                            @endforeach
                      </ol>
                </div>
                    
                @else
                    <span class="no-img">No Image</span>
                @endif
                
                   
                      
                         
                
                <div class="panel-body mt-3 pt-1">

                    @if(count($isOnceItems) > 0)
                        <div class="mt-5 pt-2 mb-3 floar">
                            <h4 class="text-small">同梱包が可能な他の商品</h4>
                            <ul class="clearfix">
                                @foreach($isOnceItems as $isOnceItem)
                                	<?php
                                        $category = Category::find($isOnceItem->cate_id);
                                    ?>
                                    
                                    <li>
                                        <a href="{{ url('item/'. $isOnceItem->id) }}"> 
                                            <div class="img-box">         
                                                <img src="{{ Storage::url($isOnceItem->main_img) }}" class="img-fluid">
                                            </div>
                                            
                                            <p class="mb-1">{{ Ctm::shortStr($isOnceItem->title, 25) }}</p>
                                            
                                            {{--
                                            <p>
                                                <a href="{{ url('category/'. $category->slug) }}">
                                                    @if(isset($category->link_name))
                                                        {{ $category->link_name }}
                                                    @else
                                                        {{ $category->name }}
                                                    @endif
                                                </a>
                                            </p>
                                            --}}

                                            <div class="price text-right">
                                                <?php 
                                                    $isSale = Setting::get()->first()->is_sale; 
                                                ?>
                                                
                                                @if(isset($isOnceItem->sale_price))
                                                    <span>{{ number_format(Ctm::getPriceWithTax($isOnceItem->sale_price)) }}</span>
                                                @else
                                                    @if($isSale)
                                                        <span>{{ number_format(Ctm::getSalePriceWithTax($isOnceItem->price)) }}</span>
                                                    @else
                                                        <span>{{ number_format(Ctm::getPriceWithTax($isOnceItem->price)) }}</span>
                                                    @endif
                                                @endif
                                                円(税込)
                                            </div>
      
                                        </a>
                                    </li>
                                @endforeach
                            </ul> 
                        </div>
                    @endif
                

                    @if(count($recommends) > 0)
                        <div class="mt-5 floar">
                            <h4>あなたにおすすめの商品</h4>
                            
                                <ul class="clearfix">
                                    @foreach($recommends as $recommend)
                                        <li>
                                            <a href="{{ url('item/'. $recommend->id) }}"> 
                                                <div class="img-box">         
                                                    <img src="{{ Storage::url($recommend->main_img) }}" class="img-fluid">
                                                </div>
                                                <p>{{ Ctm::shortStr($recommend->title, 25) }}</p>
                                                
                                                <div class="price text-right">
                                                    <?php 
                                                        $isSale = Setting::get()->first()->is_sale; 
                                                    ?>
                                                    
                                                    @if(isset($isOnceItem->sale_price))
                                                        <span>{{ number_format(Ctm::getPriceWithTax($isOnceItem->sale_price)) }}</span>
                                                    @else
                                                        @if($isSale)
                                                            <span>{{ number_format(Ctm::getSalePriceWithTax($isOnceItem->price)) }}</span>
                                                        @else
                                                            <span>{{ number_format(Ctm::getPriceWithTax($isOnceItem->price)) }}</span>
                                                        @endif
                                                    @endif
                                                    円(税込)
                                                </div>
                                            </a>
                                        </li>         
                                    @endforeach      
                                </ul>   
                        </div>
                    @endif

            </div>
                
                
            </div>
                
            <div class="single-right">
            		<span>{{ $item->title_addition }}</span>
                	<h2 class="single-title">{{ $item -> title }}<br><span>商品番号 {{ $item->number }}</span></h2>

                 	<p class="text-big">{{ $item->catchcopy }}</p>   
                 	
                  	<?php
                        $per = env('TAX_PER');
                        $per = $per/100;
                        
                        $tax = floor($item->price * $per);
                        $price = $item->price + $tax;
                   ?>
                   
                   {{--
                    <div class="mb-3" >
                    	<span class="text-small">カテゴリー：</span>
                        @if(isset($cate))
                        	<a href="{{ url('category/'.$cate->slug) }}">{{ $cate->link_name }}</a>
                        @endif
                        @if(isset($subCate))
                        	&nbsp;<i class="fas fa-angle-right"></i>&nbsp;<a href="{{ url('category/'.$cate->slug. '/'.$subCate->slug) }}">{{ $subCate->name }}</a>
                        @endif
                    </div>
                    --}}
                    
                 	<div class="price-meta"> 
                    	<?php 
                        	$isSale = Setting::get()->first()->is_sale; 
                        ?>
                        
                        @if(isset($item->sale_price))
                        	<small class="text-white bg-gray py-1 px-2 mr-1">セール商品</small>
                        	<strike class="text-small">{{ number_format(Ctm::getPriceWithTax($item->price)) }}</strike>
                            <i class="fas fa-arrow-right text-small"></i>
                        	{{ number_format(Ctm::getPriceWithTax($item->sale_price)) }}
                        @else
                            @if($isSale)
                            	<small class="text-white bg-gray py-1 px-2 mr-1">セール{{ Setting::get()->first()->sale_per }}%引</small>
                                <strike class="text-small">{{ number_format(Ctm::getPriceWithTax($item->price)) }}</strike>
                                <i class="fas fa-arrow-right text-small"></i>
                                {{ number_format(Ctm::getSalePriceWithTax($item->price)) }}
                            @else
                                {{ number_format(Ctm::getPriceWithTax($item->price)) }}
                            @endif
                        @endif
                        円&nbsp;<span class="text-small">(税込)</span>
                    </div>
                    
                    <div class="my-3 text-small">
                    	<p>{!! nl2br($item->exp_first) !!}</p>
                    </div>
                    

                    <div class="favorite my-4" data-type='single'>
                        @if(Auth::check())
                            <?php
                                if($isFav) {
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
                            <small class="fav-str"><span class="loader"><i class="fas fa-square"></i></span>{{ $str }}</small>    
                            
                        @else
                            <span class="fav-temp"><i class="far fa-heart"></i></span>
                            <small class="fav-str"><a href="{{ url('login') }}"><b>ログイン</b></a>するとお気に入りに登録できます</small>   
                        @endif 	   
                    </div>
                    
                    
                    
                  
                  	<div class="form-wrap">
                  	@if($item->stock > 0)
                    	
                           <form method="post" action="{{ url('shop/cart') }}">
                            {{ csrf_field() }}
                            
                            <fieldset class="mb-4 form-group clearfix text-right">
                                <label>数量
                                @if($item->stock_show)
                                    <span><b>（在庫数：{{ $item->stock }}）</b></span>
                                @endif
                                </label>
                                
                                <select class="form-control col-md-6 d-inline{{ $errors->has('item_count') ? ' is-invalid' : '' }}" name="item_count">
                                    <option disabled selected>選択して下さい</option>
                                    	<?php
                                        	$max = 100;
                                        	if($item->stock < 100) {
                                            	$max = $item->stock;
                                            }
                                        ?>
                                        @for($i=1; $i <= $max; $i++)
                                            <?php
                                                $selected = '';
                                                if(Ctm::isOld()) {
                                                    if(old('item_count') == $i)
                                                        $selected = ' selected';
                                                }
                                                else {
                                                    if($i == 1) {
                                                        $selected = ' selected';
                                                    }
                                                }
                                            ?>
                                            <option value="{{ $i }}"{{ $selected }}>{{ $i }}</option>
                                        @endfor
                                </select>
                                <span class="text-warning"></span>
                                
                                @if ($errors->has('item_count'))
                                    <div class="help-block text-danger">
                                        <span class="fa fa-exclamation form-control-feedback"></span>
                                        <span>{{ $errors->first('item_count') }}</span>
                                    </div>
                                @endif
                                
                            </fieldset>
                            
                            <input type="hidden" name="from_item" value="1">
                            <input type="hidden" name="item_id" value="{{ $item->id }}">
                            <input type="hidden" name="uri" value="{{ Request::path() }}">     
                            {{--
                            <input type="hidden" name="item_price" value="{{ $item->price }}">
                            <input type="hidden" name="tax" value="{{ $tax }}"> 
                            --}}     
                            
                            <button type="submit" class="btn btn-custom text-center col-md-12">カートに入れる</button>
                            
                            @if(Ctm::isAgent('sp'))
                            	<button id="spCartBtn" type="submit" class="btn btn-custom text-center col-md-6">この商品をカートに入れる</button>
                            @endif
                       </form>
                       
                       <span class="text-danger text-big">{{ $item->deli_plan_text }}</span>
                	
                    @else
                    	<span class="text-danger text-big">在庫がありません</span>
                        @if($item->stock_type)
                        <p>
                        	@if($item->stock_type == 1)
                        		次回{{ $item->stock_reset_month }}月頃入荷予定
                            @else
                            	次回入荷未定
                            @endif
                        </p>
                        @endif
                 	@endif  
                  	</div> 
                    
                    
                    
                    <div class="tags mt-4 mb-1">
                        <?php $num = 0; ?>
                        @include('main.shared.tag')
                    </div>
                    
                    
                    <div class="cont-wrap mt-5 mb-5 pb-2">
                
                       <ul class="nav nav-tabs">
                            <li class="nav-item">
                              <a href="#tab1" class="nav-link active" data-toggle="tab">商品説明</a>
                            </li>
                            <li class="nav-item">
                              <a href="#tab2" class="nav-link" data-toggle="tab">配送について</a>
                            </li>
                            <li class="nav-item">
                              <a href="#tab3" class="nav-link" data-toggle="tab">商品情報</a>
                            </li>
                        </ul> 
                        
                        <div class="tab-content mt-2">
                          
                          <div id="tab1" class="tab-pane active contents clearfix">
                            {!! nl2br($item->explain) !!}
                          </div>
                          
                          <div id="tab2" class="tab-pane contents">
                            <div class="clearfix">
                                {!! nl2br($item->about_ship) !!}
                            </div>
                            
                            @if($item->is_delifee_table)
                                <div class="btn btn-custom mt-4 slideDeli">
                                    送料表を見る <i class="fas fa-angle-down"></i>
                                </div>
                                <?php
                                    $dgRels = DeliveryGroupRelation::where('dg_id', $item->dg_id)->get();
                                ?>
                                
                                
                                <div class="table-responsive table-custom text-small mt-2">
                                    <table class="table table-bordered bg-white">
                                    	<thead class="bg-light">
                                        	<tr>
                                            	<td class="text-center" colspan="2">地域</td>
                                                <td class="text-center">送料</td>
                                            </tr>
                                        </thead>
                                        
                                        <tbody>
                                            @foreach($dgRels as $dgRel)
                                                <tr>
                                                	<?php
                                                    	$format = '<td class="bg-light" rowspan="%d">'. Prefecture::find($dgRel->pref_id)->rural . '</td>';
                                                    ?>
                                                        
                                                    @if($dgRel->pref_id == 1)
                                                        <?php printf($format, 1); ?>
                                                    
                                                    @elseif($dgRel->pref_id == 2)
                                                        <?php printf($format, 7); ?>
                                                    
                                                    @elseif($dgRel->pref_id == 9)
                                                        <?php printf($format, 6); ?>
                                                    
                                                    @elseif($dgRel->pref_id == 15)
                                                        <?php printf($format, 9); ?>
                                                    
                                                    @elseif($dgRel->pref_id == 24)
                                                        <?php printf($format, 7); ?>
                                                    
                                                    @elseif($dgRel->pref_id == 31)
                                                        <?php printf($format, 5); ?>
                                                    
                                                    @elseif($dgRel->pref_id == 36)
                                                        <?php printf($format, 4); ?>
                                                    
                                                    @elseif($dgRel->pref_id == 40)
                                                        <?php printf($format, 7); ?>
                                                    
                                                    @elseif($dgRel->pref_id == 47)
                                                        <?php printf($format, 1); ?>
                                                    @endif
 
                                                    
                                                    <td>{{ Prefecture::find($dgRel->pref_id)->name }}</td>
                                                    <td class="bg-light">
                                                        @if($dgRel->fee == 99999 || $dgRel->fee === null)
                                                            配送不可
                                                        @else
                                                            {{ number_format($dgRel->fee) }} 円
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endif
                          </div>
                          
                          <div id="tab3" class="tab-pane contents clearfix">
                            {!! nl2br($item->contents) !!}
                          </div>
                          
                        </div>
                        
                    </div>
                    
            	
                </div>
                
        </div><!-- head-frame -->
        
        
        
        <div class="aaa panel-body mt-3 pt-1">
            @if(isset($cacheItems))
                <div class="mt-4 floar">
                    
                    <h4>最近見た商品</h4>
                    <ul class="clearfix">
                        @foreach($cacheItems as $cacheItem)
                            <li>
                                <a href="{{ url('item/'. $cacheItem->id) }}"> 
                                    <div class="img-box">        
                                        <img src="{{ Storage::url($cacheItem->main_img) }}" class="img-fluid">
                                    </div>
                                    <p>{{ Ctm::shortStr($cacheItem->title, 20) }}</p>
                                </a>
                            </li>         
                        @endforeach      
                    </ul>	     
                </div>
            @endif
        </div>


            
		
    </div>
@endsection
