@extends('layouts.app')

<?php
use App\User;
use App\Category;
use App\DeliveryGroupRelation;
use App\Prefecture;
use App\Setting;
use App\TopSetting;
?>


@if(! Ctm::isAgent('sp'))
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
@endif



@section('content')

    <div id="main" class="single">
    	
        @if(! Ctm::isAgent('sp'))
        	@include('main.shared.bread')
        @endif
        
        
        @include('main.shared.upper')
        
        @if(isset($item->upper_title) || isset($item->upper_text))
            <div class="upper-introduce-wrap mb-4">
                @if(isset($item->upper_title) && $item->upper_title != '')
                    <h3 class="upper-title">{{ $item->upper_title }}</h3>
                @endif
                
                @if(isset($item->upper_text) && $item->upper_text != '')
                    <p class="upper-text px-1 m-0">{!! nl2br($item->upper_text) !!}</p>
                @endif
            
            </div>
        @endif
        
		
        <div class="head-frame clearfix">
            
            <div class="single-left">
            
            	<?php //================================================================= 
                	$itemId = $item->id;
                ?>
                
                @if($item -> main_img)
                    <div id="carouselExampleIndicators" class="carousel slide" data-ride="false" data-interval="false">

                          <div class="carousel-inner">
                            <div class="carousel-item active">
                            	
                                <?php $mainCaption = ''; ?>
                            	
                                @if(isset($item->main_caption))
                                	<?php $mainCaption = $item->main_caption; ?>
                                    <div class="carousel-caption d-block">
                                        {{ $mainCaption }}
                                    </div>
                                @endif
                                
                                @if(! Ctm::isAgent('sp'))
                                <a href="{{ Storage::url($item->main_img) }}" data-lightbox="{{ $item->number }}" data-title="{{ $mainCaption }}">
                                @endif
                               
                                    <img class="d-block w-100" src="{{ Storage::url($item->main_img) }}" alt="First slide">
                                
                                @if(! Ctm::isAgent('sp'))
                                </a>
                                @endif
                            </div>
                            
                            @foreach($imgsPri as $itemImg)
                            	
                                <?php $caption = ''; ?>
                                
                                @if($itemImg->img_path !== null )
                                    <div class="carousel-item">
                                        @if(isset($itemImg->caption))
                                        	<?php $caption = $itemImg->caption; ?>
                                            <div class="carousel-caption d-block">
                                                {{ $caption }}
                                            </div>
                                        @endif
                                        
                                        @if(! Ctm::isAgent('sp'))
                                        <a href="{{ Storage::url($itemImg->img_path)}}" data-lightbox="{{ $item->number }}" data-title="{{ $caption }}">
                                        @endif
                                        
                                            <img class="d-block w-100" src="{{ Storage::url($itemImg->img_path)}}" alt="Sub slide">
                                        
                                        @if(! Ctm::isAgent('sp'))
                                        </a>
                                        @endif
                                    </div>
                                @endif
                            @endforeach
                            
                          
                          
                          <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"><i class="fal fa-angle-left"></i></span>
                            <span class="sr-only">Previous</span>
                          </a>
                          <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"><i class="fal fa-angle-right"></i></span>
                            <span class="sr-only">Next</span>
                          </a>
                          
                          </div>
                          
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
            
            	<?php //END ================================================================= ?>    

			</div><!-- left -->
            
            @if(Ctm::isAgent('sp'))
				@include('main.shared.bread')
			@endif
			
            <div class="single-right">
            	
                <?php //================================================================= ?>
            		<span>{{ $item->title_addition }}</span>
                	<h2 class="single-title">{{ $item -> title }}<br><span>商品番号 {{ $item->number }}</span></h2>
                 	<p class="text-big">{{ $item->catchcopy }}</p>
                    
                    <?php $isPotSet = count($potSets) > 0; ?>
                    
                    @if(! $isPotSet)
                        @if(isset($item->icon_id) && $item->icon_id != '')
                            <div class="icons">
                                @include('main.shared.icon', ['obj'=>$item])
                            </div>
                        @endif
                    @endif
                 	
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
                    
                    
                    <form method="post" action="{{ url('shop/cart') }}">
                        {{ csrf_field() }}
                    

                    @if($isPotSet)
                    	
                        <?php 
                            //Object $itemを最初に追加する時
                            //$potSets->prepend($item);
                        ?>
						
                        <div class="potset-wrap form-wrap">
                        	 
                            @foreach($potSets as $potSet)
                                <div class="potset clearfix">
                                    @if(isset($potSet->main_img))
                                    <div class="img-box">
                                        <img src="{{ Storage::url($potSet->main_img) }}" class="img-fluid">
                                    </div>
                                    @endif
                                    
                                    <div class="potset-text">
                                        <h3>
                                            {{ $potSet->title }}
                                            @if(Ctm::isEnv('local'))
                                            	<small>[{{ $potSet->id }}]</small>
                                            @endif
                                        </h3>
                                        
                                        <div class="price-meta">
                                            <?php $obj = $potSet; ?>
                                            @include('main.shared.priceMeta')
                                        </div>
                                        
                                        @if(isset($potSet->icon_id) && $potSet->icon_id != '')
                                            <div class="icons">
                                                <?php //$obj = $potSet; ?>
                                                @include('main.shared.icon')
                                            </div>
                                        @endif
                                        
                                        <div class="clearfix">
                                            
                                            @if($potSet->stock > 0)
                                                @if($potSet->stock_show)
                                                    <span>在庫：{{ $potSet->stock }}</span>
                                                @endif
                                                
                                                <div class="potSetSelect-wrap float-right">
                                                    <fieldset class="clearfix text-right">
                                                    <label>数量</label>
                                                    
                                                    <label class="select-wrap potSetSelect">
                                                    <select class="form-control d-inline{{ $errors->has('item_count') ? ' is-invalid' : '' }}" name="item_count[]">
                                                        <option value="0" selected>選択</option>
                                                            <?php
                                                                $max = 100;
                                                                if($potSet->stock < 100) {
                                                                    $max = $potSet->stock;
                                                                }
                                                            ?>
                                                            @for($ii=1; $ii <= $max; $ii++)
                                                                <?php
                                                                    $selected = '';
                                                                    if(Ctm::isOld()) {
                                                                        if(old('item_count') == $ii)
                                                                            $selected = ' selected';
                                                                    }
        //                                                            else {
        //                                                                if($i == 1) {
        //                                                                    $selected = ' selected';
        //                                                                }
        //                                                            }
                                                                ?>
                                                                <option value="{{ $ii }}"{{ $selected }}>{{ $ii }}</option>
                                                            @endfor
                                                    </select>
                                                    </label>
                                                    <span class="text-warning"></span>
                                                    
                                                    @if ($errors->has('item_count'))
                                                        <div class="help-block text-danger">
                                                            <span class="fa fa-exclamation form-control-feedback"></span>
                                                            <span>{{ $errors->first('item_count') }}</span>
                                                        </div>
                                                    @endif
                                                    
                                                    <input type="hidden" name="item_id[]" value="{{ $potSet->id }}">
                                                    
                                                    </fieldset>
                                                </div>
                                            @else
                                                <span class="text-danger text-small">在庫がありません</span>
                                                @if($potSet->stock_type)
                                                    <p class="d-inline text-small ml-1">
                                                        @if($potSet->stock_type == 1)
                                                            次回{{ $potSet->stock_reset_month }}月頃入荷予定
                                                        @else
                                                            次回入荷未定
                                                        @endif
                                                    </p>
                                                @endif
                                            @endif
                                                
                                        </div>
                                    
                                    </div>
                                </div>
                            @endforeach
  
                    	</div>   	
                    
                    @else
                        <div class="price-meta">
                            @include('main.shared.priceMeta', ['obj'=>$item])
                        </div>
                    @endif
                    
                    <div class="my-3 text-small">
                    	<p>{!! nl2br($item->exp_first) !!}</p>
                    </div>
                    

                    @if(! Auth::check())
                        <div class="pl-1">
                            {{-- <span class="fav-temp"><i class="far fa-heart"></i></span> --}}
                            <small class="p-0 m-0"><a href="{{ url('login') }}"><b>ログイン<i class="fal fa-angle-double-right"></i></b></a> すると永続してお気に入りに登録できます</small>
                        </div>
                    @endif
                    
                    <div class="favorite mt-1 mb-4" data-type='single'>
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
                    </div>
                    

                  	<div class="form-wrap">
                  		@if($item->stock > 0)
 
 							@if(! $isPotSet)
                                <fieldset class="mb-3 form-group clearfix text-right">
                                    <label>数量
                                    @if($item->stock_show)
                                        <span>（在庫：{{ $item->stock }}）</span>
                                    @endif
                                    </label>
                                    
                                    <label class="select-wrap w-50">
                                    <select class="form-control {{ $errors->has('item_count') ? ' is-invalid' : '' }}" name="item_count[]">
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
                                    </label>
                                    <span class="text-warning"></span>
                                    
                                    @if ($errors->has('item_count'))
                                        <div class="help-block text-danger">
                                            <span class="fa fa-exclamation form-control-feedback"></span>
                                            <span>{{ $errors->first('item_count') }}</span>
                                        </div>
                                    @endif
                                    
                                    <input type="hidden" name="item_id[]" value="{{ $item->id }}">
                                </fieldset>
                            @endif

                	
                        @else
                        	<div class="no-stock">
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
                            </div>
                        @endif  
                  	 
                    
                    
                    	@if($item->stock > 0 || $isPotSet)
                            <input type="hidden" name="from_item" value="1">
                            <input type="hidden" name="uri" value="{{ Request::path() }}">     
                            
                            <?php
                            	$disabled = '';
                            	if($isPotSet) {
                                	$disabled = ' disabled';
                                }
                            ?>
                            
                            <button type="submit" class="btn btn-custom btn-pink text-center col-md-12"{{ $disabled }}><i class="fal fa-cart-arrow-down"></i> カートに入れる</button>
                            <p class=""><b>{{ $item->deli_plan_text }}</b></p>
                            
                            @if(Ctm::isAgent('sp'))
                                <button id="spCartBtn" type="submit" class="btn btn-custom btn-pink text-center col-md-6"{{ $disabled }}><i class="fal fa-cart-arrow-down"></i> この商品をカートに入れる</button>
                            @endif
                        @endif
                   </form>
                   
                   </div><!-- form-wrap -->
                    
                    
                    
                    <div class="tags mt-4 mb-1">
                        <?php $num = 0; ?>
                        @include('main.shared.tag')
                    </div>
                    
                    <?php
                    	$isCaution = isset($item->caution) && $item->caution != '';
                        $dgId = $item->dg_id;
                    ?>
                    
                    @if(Ctm::isAgent('sp'))
                    	<div id="accordion" class="mt-4">
                          <div class="card">
                            <div class="card-header" id="headingOne">
                                <a class="btn clearfix" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                  <i class="fal fa-info-circle"></i> 商品詳細
                                  <i class="fal fa-angle-down float-right"></i>
                                </a>
                            </div>

                            <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
                              <div class="card-body clearfix">
                                {!! nl2br($item->explain) !!}
                              </div>
                            </div>
                          </div>
                          
                          <div class="card">
                            <div class="card-header" id="headingTwo">
                                <a class="btn clearfix collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                  <i class="fal fa-truck"></i> 配送について
                                  <i class="fal fa-angle-down float-right"></i>
                                </a>
                            </div>
                            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                              <div class="card-body clearfix">
                                {!! nl2br($item->about_ship) !!}
                                
                                @if($item->is_delifee_table)
                                    <div class="btn btn-custom mt-2 slideDeli">
                                        送料表を見る <i class="fal fa-angle-down"></i>
                                    </div>
                                	
                                    @include('main.shared.deliFeeTable')
                                @endif
                              </div>
                            </div>
                          </div>
                          
                          <div class="card">
                            <div class="card-header" id="headingThree">
                                <a class="btn clearfix collapsed" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                  <i class="fal fa-tree-alt"></i> 育て方
                                  <i class="fal fa-angle-down float-right"></i>
                                </a>
                            </div>
                            
                            <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
                              <div class="card-body clearfix">
                                {!! nl2br($item->contents) !!}
                              </div>
                            </div>
                          </div>

                        @if($isCaution)
                        	<div class="card">
                                <div class="card-header" id="headingFour">
                                    <a class="btn clearfix" data-toggle="collapse" data-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                      <i class="fal fa-exclamation-triangle"></i> ご注意下さい
                                      <i class="fal fa-angle-down float-right"></i>
                                    </a>
                                </div>
                                
                                <div id="collapseFour" class="collapse show" aria-labelledby="headingFour" data-parent="#accordion">
                                  <div class="card-body clearfix">
                                    {!! nl2br($item->caution) !!}
                                  </div>
                                </div>
                              </div>
                            </div>	
                        @endif
                        
                        </div><!-- accordion -->
                    
                    @else
                        <div class="cont-wrap mt-5 mb-5 pb-2">
                           <ul class="nav nav-tabs">
                                <li class="nav-item">
                                  <a href="#tab1" class="nav-link active" data-toggle="tab"><i class="fal fa-info-circle"></i> 詳細</a>
                                </li>
                                <li class="nav-item">
                                  <a href="#tab2" class="nav-link" data-toggle="tab"><i class="fal fa-truck"></i> 配送</a>
                                </li>
                                <li class="nav-item">
                                  <a href="#tab3" class="nav-link" data-toggle="tab"><i class="fal fa-tree-alt"></i> 育て方</a>
                                </li>
                                @if(isset($item->caution))
                                    <li class="nav-item">
                                      <a href="#tab4" class="nav-link" data-toggle="tab"><i class="fal fa-exclamation-triangle"></i> ご注意</a>
                                    </li>
                                @endif
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
                                        <div class="btn btn-custom mt-2 slideDeli">
                                            送料表を見る <i class="fal fa-angle-down"></i>
                                        </div>
                                        
                                        @include('main.shared.deliFeeTable')
                                    @endif
                                    
                                  </div>
                                  
                                  <div id="tab3" class="tab-pane contents clearfix">
                                    {!! nl2br($item->contents) !!}
                                  </div>
                                  
                                  @if($isCaution)
                                      <div id="tab4" class="tab-pane contents clearfix">
                                        {!! nl2br($item->caution) !!}
                                      </div>
                                  @endif
                            </div> 
                        </div>
                    
                    @endif
                    
            	
                </div><!-- right -->


			<?php //================================================================= ?> 
                <div class="single-recom">

					@foreach($recomArr as $key => $recoms)
                        @if(count($recoms) > 0)
                            <div class="mt-3 floar">
                                <h4 class="text-small">{{ $key }}</h4>
                                
                                <?php 
                                    //レコメンドアイテムはItemControllerでchunkされている
                                ?>
                                
                                @foreach($recoms as $recom)
                                <div>
                                    <ul class="clearfix">
                                        @foreach($recom as $item)
                                            <li class="main-atcl">
                                                @include('main.shared.atcl', ['strNum'=>Ctm::isAgent('sp') ? 16 : 23])
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                                @endforeach
                                
                                @if(strpos($key, '同梱包可能') !== false)
                                	<a href="{{ url('item/packing?orgId=' . $itemId) }}" class="btn btn-block btn-custom bg-white border-secondary rounded-0 mt-0 mb-5 text-center">同梱包可能な商品を全て見る <i class="fal fa-angle-double-right"></i></a>
                                @endif
                            </div>
                        @endif
                    @endforeach   

            	</div><!-- single-recom -->
            <?php //================================================================= ?>
                

        </div><!-- head-frame -->
        

        <div class="recent-check mt-3 pt-1">
            @if(count($cacheItems) > 0)
                <div class="mt-4 floar">
                    <h4>最近チェックしたアイテム</h4>
                    <?php 
                    	//キャッシュアイテムはItemControllerでchunkされている
                    ?>
                    
                    @foreach($cacheItems as $cacheItem)
                    <div>
                        <ul class="clearfix">
                            @foreach($cacheItem as $item)                            
                                <li class="main-atcl">
                                    @include('main.shared.atcl', ['strNum'=>Ctm::isAgent('sp') ? 12 : 16])
                                </li>    
                            @endforeach      
                        </ul>
                    </div>
                    @endforeach
                </div>
            @endif
        </div>


            
		
    </div><!-- id -->
@endsection
