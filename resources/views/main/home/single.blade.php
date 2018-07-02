@extends('layouts.app')

@section('content')

<?php
use App\User;

?>

    <div id="main" class="single">
		
        <div class="head-frame clearfix">
            
            <div class="float-left col-md-7 pr-3">
                @if($item -> main_img)
                <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel" data-interval="7500">
                      <ol class="carousel-indicators">
                        <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                        
                        <?php 
                        	$count = count($imgsPri);
                        ?>
                        @for($n=1; $n<=$count; $n++)
                        	<li data-target="#carouselExampleIndicators" data-slide-to="{{$n}}"></li>
                        @endfor
                      </ol>
                      
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
                </div>
                    
                @else
                    <span class="no-img">No Image</span>
                @endif   
            </div>
                
            <div class="float-right col-md-5">
                	<h2>{{ $item -> title }}</h2>
                 	<p class="text-big">{{ $item->catchcopy }}</p>   
                 	
                  	<?php
                   	$per = env('TAX_PER');
                    $per = $per/100;
                    
                    $tax = floor($item->price * $per);
                    $price = $item->price + $tax;
                   	
                   ?>      
                    
                 	<div class="price-meta">
                  	   価格: {{ number_format(Ctm::getPriceWithTax($item->price)) }}円　(税込)
                    </div>
                    
                    @if(env('APP_ENV') != 'trial') 
                    <div class="favorite my-2">
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
                    @endif
                    
                    <div class="mt-3">
                    	<p>{!! nl2br($item->exp_first) !!}</p>
                    </div>
                  
                  	<div>
                  	@if($item->stock > 0)
                    	
                           <form method="post" action="{{ url('shop/cart') }}">
                            {{ csrf_field() }}
                            
                            <fieldset class="mb-4 form-group">
                                <label>数量</label>
                                @if($item->stock_show)
                                    <span><b>（在庫数：{{ $item->stock }}）</b></span>
                                @endif
                                
                                <select class="form-control col-md-6{{ $errors->has('item_count') ? ' is-invalid' : '' }}" name="item_count">
                                    <option disabled selected>選択して下さい</option>
                                        @for($i=1; $i <= $item->stock; $i++)
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
                            <button type="submit" class="btn btn-custom px-5">カートに入れる</button>
                       </form>  
                	
                    @else
                    	<span class="text-warning text-big">在庫がありません</span>
                 	@endif  
                  	</div> 
                    
                       
                    <div class="mt-5">
                    	@foreach($tags as $tag)
                        	<span class="rank-tag">
                            <i class="fa fa-tag" aria-hidden="true"></i>
                            <a href="{{ url('tag/' . $tag->slug) }}">{{ $tag->name }}</a>
                            </span>
                        @endforeach
                    
                    </div>
            	
                </div>
                
        </div><!-- head-frame -->


            <div class="col-md-12 panel-body mt-5 pt-1">

                <div class="cont-wrap">
                	

                    <div class="clear contents mt-4">
                    	<h4>説明</h4>
						{!! nl2br($item->explain) !!}
                    </div>
                    
                    <div class="clear contents mt-4">
                    	<h4>配送について</h4>
                        {!! nl2br($item->about_ship) !!}
                    </div>
                    
                    <div class="clear contents mt-4">
                        <h4>商品情報</h4>
                        {!! nl2br($item->detail) !!}
                        
                        <div class="clearfix">
                        @foreach($imgsSec as $sec)
                        	@if(isset($sec->img_path))
                        	<img src="{{ Storage::url($sec->img_path) }}" class="img-fluid col-md-3 mr-2 my-4">
                         	@endif   
                        @endforeach
                        </div>
                    </div>

                    <div class="map-wrap">

                    </div>

                    <div class="table-responsive py-3 mt-4">
                    	<table class="table table-bordered table-striped">
                            <colgroup>
                                <col class="cth">
                                <col class="ctd">
                            </colgroup>
                            
                            <tbody>

                                
							{{--
                                <tr>
                                    <th>カテゴリー</th>
                                    <td>
                                    @if($cateObj)
                                    	<span class="rank-tag">
                                    		{{ $cateObj->find($item->cate_id)->name }}
                                        </span>
                                    @endif
                                    </td>
                                </tr>
                                
                                <tr>
                                    <th>タグ</th>
                                    <td>
                                        @foreach($tags as $tag)
                                            <span class="rank-tag">
                                            <i class="fa fa-tag" aria-hidden="true"></i>
                                            <a href="{{ url('tag/' . $tag->slug) }}">{{ $tag->name }}</a>
                                            </span>
                                        @endforeach

                                    </td>
                                </tr>

                              --}} 

                            </tbody>
                		</table>
                    </div>



					
					@if(count($recommends) > 0)
                    <div class="mt-4 floar">
                    	<h4>あなたにおすすめの商品</h4>
                        
                        	<ul class="clearfix">
                                @foreach($recommends as $recommend)
                                    <li class="">
                                        <a href="{{ url('item/'. $recommend->id) }}"> 
                                        	<div class="img-box">         
                                        		<img src="{{ Storage::url($recommend->main_img) }}" class="img-fluid">
                                            </div>
                                        	<p>{{ $recommend->title }}</p>
                                        </a>
                                    </li>         
                                @endforeach      
                            </ul>   
                    </div>
                    @endif
                    
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
                                    	<p>{{ $cacheItem->title }}</p>
                                    </a>
                          		</li>         
                       		@endforeach      
                     	</ul>	     
                    </div>
                    @endif
                    
                    
					


                	</div>


				</div><!-- panelbody -->

    </div>
@endsection
