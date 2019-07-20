@extends('layouts.app')

@section('content')

<div id="main" class="cart-index">


<div class="top-cont clearfix">

@include('cart.shared.guide', ['active'=>1])

@if(! count($itemData))
	<div class="col-md-8 mx-auto text-center">
	<p class="">カートに商品が入っていません</p>
	<a href="{{ url('/') }}">HOMEへ戻る <i class="fal fa-angle-double-right"></i></a>
	</div>
@else

<?php
//	print_r($errors->get('no_delivery.*'));
//    echo $errors->has('no_delivery.*');
    //exit;
?>

@if ($errors->has('no_delivery.*'))
    <div class="alert alert-danger">
        <i class="far fa-exclamation-triangle"></i> 配送不可の商品があります。
        <ul class="mt-2">
            @foreach ($errors->get('no_delivery.*') as $error)
                <li>{{ $error[0] }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form id="with1" class="form-horizontal" role="form" method="POST" action="{{ url('shop/cart') }}">
      {{ csrf_field() }}
                        
<div class="table-responsive table-cart clearfix">
	<table class="table">
    
    	<tbody>
        	<?php $disabled = ''; ?>

     		
     		@foreach($itemData as $key => $item)    
                <tr class="clearfix {{ $errors->has('no_delivery.'. $key) ? 'tr-danger-border' : '' }}">
                    <th>
                        @include('main.shared.smallThumbnail')
                    </th>
                    
                    <td class="clearfix">
                        
                        <?php 
                            $obj = $item;
                            $urlId = $item->is_potset ? $item->pot_parent_id : $item->id; 
                        ?>
                        
  
                        <div>
                            <a href="{{ url('item/'. $urlId) }}">{!! Ctm::getItemTitle($item, 1) !!}</a>
                            <br>
                            <span class="mr-3">[ {{ $item->number }} ]</span>¥{{ Ctm::getItemPrice($item) }}（税込）
                        </div>
                        
                        <div class="clearfix mt-2">
                        	<div class="">
                            	
                            	<fieldset class="form-group p-0 m-0">
                                	<input type="hidden" name="last_item_id[]" value="{{ $item->id }}">
                                    
                                	<span class="text-small"><b>数量</b>：</span>
                                    
                                    
                                    @if(! $item->stock)
                                        <span class="text-small text-danger"><i class="fas fa-exclamation-triangle"></i> <b>売切れ商品です。カートから削除して進んで下さい。</b></span>
                                        <input type="hidden" name="last_item_count[]" value="0">
                                    
                                        <?php $disabled = ' disabled'; ?>
                                    
                                    @else
                                       <label class="select-wrap select-cart-count p-0"> 
                                        <select class="form-control {{ $errors->has('last_item_count') ? ' is-invalid' : '' }}" name="last_item_count[]">
                                                
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
                                                        if(old('last_item_count.'. $key) == $i)
                                                            $selected = ' selected';
                                                    }
                                                    else {
                                                        if($i == $item->count) {
                                                            $selected = ' selected';
                                                        }
                                                    }
                                                ?>
                                                
                                                <option value="{{ $i }}"{{ $selected }}>{{ $i }}</option>
                                            @endfor
                                        </select>
                                        </label>
                                                                                
                                        @if ($errors->has('last_item_count'))
                                            <div class="help-block text-danger">
                                                <span class="fa fa-exclamation form-control-feedback"></span>
                                                <span>{{ $errors->first('last_item_count.'. $key) }}</span>
                                            </div>
                                        @endif
                                    
                                    @endif
                                    
                                </fieldset>
                            </div>
                            
                            <div class="mt-1">
                            	<span class="text-small"><b>小計<span class="text-small">（税込）</b>：</span></span>¥{{ number_format( $item->total_price ) }}
                            </div>
                            
                            
                        </div>
                    </td>
                          
                    <td class="text-right">
                    	<button class="btn btn-cart-del mb-4" type="submit" name="del_item_key" value="{{ $key }}"><i class="fal fa-times"></i></button>       
                    </td>

                </tr> 
        	 @endforeach
          	            
         </tbody>
         
         </table>
    </div>
         
         
         
	<div class="table-responsive table-foot">
	<table class="table">
         <tbody class="clearfix">
         	<tr>
          		<th class="text-right text-big">
                	小計   
                </th>
                
            	<td class="text-big">
                	<b>¥{{ number_format($allPrice) }}</b>
                </td>
             	
                {{--
                <td class="col-md-3">	
                    <input type="hidden" name="calc" value="1" form="re">
                    <button class="btn btn-line px-2 w-100" type="submit" name="re_calc" value="1"{{ $disabled }}><i class="fal fa-redo"></i> 再計算</button>
                </td>
                --}}
          	</tr>
            
            @if(isset($deliFee))
                <tr>
                    <th class="text-right text-big">
                    	送料
                    </th>
                    
                    <td class="text-big">
                    	<b>¥{{ number_format($deliFee) }}</b>
                    </td>
                    
                </tr>
                
                <tr>
                    <th class="text-right text-big">
                    	合計 <small>(小計+送料)</small>
                    </th>
                    
                    <td class="text-big text-danger">
                    	<b>¥{{ number_format($allPrice + $deliFee) }}</b>
                    </td>
                    
                </tr>
            @else
            	<tr>
                	<td colspan="2" class="text-right pt-0">
                        <span class="text-enji text-small"><i class="fas fa-exclamation-triangle"></i> <b>送料は含まれておりません</b></span>
                    </td>
                </tr>
            @endif
           
           
            <tr>
            	<th class="pt-3 text-right text-big"><span class="d-inline-block pt-1">配送先都道府県</span></th>
                <td class="pt-3">                
                    <div class="select-wrap w-100 p-0 m-0">
                        {{-- <label class="control-label mb-0 text-small d-inline col-md-6"><b>配送先都道府県</b></label> --}}
                    
                        <select id="pref" class="form-control d-inline{{ $errors->has('pref_id') ? ' is-invalid' : '' }}" name="pref_id">
                            <option selected value="0">選択</option>
                            <?php
    //                            use App\Prefecture;
    //                            $prefs = Prefecture::all();  
                            ?>
                            @foreach($prefs as $pref)
                                <?php
                                    $selected = '';
                                    if(Ctm::isOld()) {
                                        if(old('pref_id') == $pref->id)
                                            $selected = ' selected';
                                    }
                                    else {
                                        if(isset($prefId) && $prefId == $pref->id) {
                                        //if(Session::has('all.data.user')  && session('all.data.user.prefecture') == $pref->name) {
                                            $selected = ' selected';
                                        }
                                    }
                                ?>
                                <option value="{{ $pref->id }}"{{ $selected }}>{{ $pref->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    @if ($errors->has('pref_id'))
                        <div class="help-block text-danger">
                            <span class="fa fa-exclamation form-control-feedback"></span>
                            <span>{{ $errors->first('pref_id') }}</span>
                        </div>
                    @endif
                    
                </td>   
            </tr>
            
            <tr>
            	<th class="clearfix">
                	@if(! isset($deliFee))
                        <div class="cart-note">
                            <span class="text-enji"><i class="fas fa-exclamation-triangle"></i> 数量変更は「数量」を、送料確認は「配送先都道府県」を選択して「再計算」を押して下さい。</span>
                        </div>
                        
                    @endif
                </th>
                
                <td>
                	<button class="btn px-2 w-100 bg-enji" type="submit" name="re_calc" value="1"{{ $disabled }}><i class="fal fa-redo"></i> 再計算</button>
                	{{--
                    <button class="btn px-2 w-100 bg-enji" type="submit" name="delifee_calc" value="1"{{ $disabled }}><b>送料計算</b></button>
                    --}}
                </td>
            </tr>
           
         </tbody>        
	</table>
    
    
    
</div>

<div class="clearfix mt-3 cart-btn-wrap">
	
	<div class="clearfix">
        <input type="hidden" name="from_cart" value="1">

		@if($disabled)
            <div class="text-right mb-1">
            	<span class="text-small text-danger"><i class="fas fa-exclamation-triangle"></i> <b>売切れ商品をカートから削除して下さい。</b></span>
            </div>
        @endif

        @if(Auth::check())
            <button class="btn btn-block btn-custom btn-pink mb-4 py-2 px-5" type="submit" name="regist_off" value="1" formaction="{{ url('shop/form') }}"{{ $disabled }}>購入手続きへ <i class="fal fa-angle-double-right"></i></button>
        @else
            <div class="table-responsive">
                <table class="table">
                    <tr>
                        <th rowspan="2" class="border-0">会員登録がまだの方 <i class="far fa-arrow-alt-right"></i></th>
                        <td class="border-0">
                        	<button class="btn btn-block btn-pink mb-0 py-2 px-5" type="submit" name="regist_on" value="1" formaction="{{ url('shop/form') }}"{{ $disabled }}>会員登録をして購入手続きへ <i class="fal fa-angle-double-right"></i></button>
                        </td>
                   </tr>
                   <tr class="border-0">
                        <td class="border-0">
                        	<button class="btn btn-block btn-white mb-4 py-2 px-5" type="submit" name="regist_off" value="1" formaction="{{ url('shop/form') }}"{{ $disabled }}>会員登録せずに購入手続きへ <i class="fal fa-angle-double-right"></i></button>
                        </td>               
                    </tr>
                    <tr>
                        <th class="border-0">会員登録がお済みの方 <i class="far fa-arrow-alt-right"></i></th>      
                        <td class="border-0">	
                        <a href="{{ url('login?to_cart=1') }}" class="btn btn-block btn-custom mb-2 py-2 px-5">ログインする</a>
                        {{--
                        <button class="btn btn-block btn-custom mb-3 py-2" type="submit" name="to_cart" value="shop/cart" formaction="{{ url('login') }}">ログインする</button>
                        --}}
                        </td>               
                    </tr>	      
                </table>
            </div>
        @endif
        
	</div>
    
    
    
    <div class="">
		<input type="hidden" name="uri" value="{{ $uri }}">
		<a href="{{ url($uri)}}" class="btn border border-secondary bg-white my-2"><i class="fal fa-angle-double-left"></i> 元に戻って買い物を続ける</a>
	</div>
    
</div>
</form>  
@endif


{{--
<div class="col-lg-10">
        <form class="form-horizontal" role="form" method="POST" action="{{ url('cart/payment') }}">

            {{ csrf_field() }}            

		
    		<input type="hidden" name="item_id" value="{{ $data['item_id'] }}">
            <input type="hidden" name="price" value="{{ $data['price'] }}">
            <input type="hidden" name="tax" value="{{ $data['tax'] }}">      
            <input type="hidden" name="count" value="1">
        

            <fieldset class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                <label>お名前</label>
                <input class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ Ctm::isOld() ? old('name') : (isset($item) ? $item->name : '') }}">

                @if ($errors->has('name'))
                    <div class="text-danger">
                        <span class="fa fa-exclamation form-control-feedback"></span>
                        <span>{{ $errors->first('name') }}</span>
                    </div>
                @endif
            </fieldset>
	</form>
</div>
--}}          
 


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


