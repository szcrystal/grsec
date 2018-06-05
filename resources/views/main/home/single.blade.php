@extends('layouts.app')

@section('content')

<?php
use App\User;

?>

    <div class="single">

            <div class="head-frame clearfix">
                
                <div class="float-left col-md-7">
                    @if($item -> main_img)
                        <img src="{{ Storage::url($item->main_img) }}" alt="{{ $item->title }}" class="img-fluid">
                     @else
                        <span class="no-img">No Image</span>
                     @endif   
                </div>
                
                <div class="float-right col-md-5">
                	<h2>{{ $item -> title }}</h2>
                 	<p>{{ $item->catchcopy }}</p>   
                 	
                  	<?php
                   	$per = env('TAX_PER');
                    $per = $per/100;
                    
                    $tax = floor($item->price * $per);
                    $price = $item->price + $tax;
                   	
                   ?>      
                    
                 	<div class="price-meta">
                  	   価格 {{ number_format($price) }}円　(内税:{{ number_format($tax) }}円)
                    </div>	
                    
                    <div class="">
                    	<p>{{ $item->explain }}</p>
                    </div>
                  
                  	<div>
                  	@if($item->stock > 0)
                  	
                   		   @if(env('APP_ENV') == 'trial')   
                            <form method="post" action="{{ url('cart/form') }}">
                                {{ csrf_field() }}
                                       
                                <input type="hidden" name="item_id" value="{{ $item->id }}">      
                                <input type="hidden" name="price" value="{{ $item->price }}">
                                <input type="hidden" name="tax" value="{{ $tax }}">      
                                <input type="hidden" name="count" value="1">           
                                <button type="submit" class="btn btn-warning">カートに入れる</button>
                           </form>  
                        @else
                               <form method="post" action="{{ url('shop/cart') }}">
                                {{ csrf_field() }}
                                
                                <fieldset class="mb-4 form-group">
                                    <label>数量</label>
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
                                <button type="submit" class="btn btn-warning">カートに入れる</button>
                           </form>  
                       @endif                            
                	
                    @else
                    	<span class="text-warning text-big">在庫がありません</span>
                 	@endif  
                  	</div>    
            	</div>
                
            </div>


            <div class="col-md-12 panel-body">

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

                    
                    <div class="mt-4">
                    
                    	{!! $item->what_is !!}
                    </div>
                    
                    <div class="mt-4">
                    	{!! nl2br($item->warning) !!}
                    </div>
					


                	</div>


				</div><!-- panelbody -->

    </div>
@endsection
