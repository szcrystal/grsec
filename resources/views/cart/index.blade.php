@extends('layouts.app')

@section('content')

<div id="main" class="cart-index">

        <div class="panel panel-default">

            <div class="panel-body">

<div class="top-cont clearfix">

@include('cart.guide')

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
                        
<div class="table-responsive table-cart">
	<table class="table table-bordered bg-white">
		<thead>
  			<tr>
                <th>商品名</th>
                <th>数量</th>
                <th>金額<small>（税込）</small></th>
                <th></th>
            </tr>
  		</thead>  
    
    	<tbody>
     		
     		@foreach($itemData as $key => $item)    
     		<tr class="{{ $errors->has('no_delivery.'. $key) ? 'tr-danger-border' : '' }}">
                <td class="clearfix">
                	
                    <?php $obj = $item; ?>
                    @include('main.shared.smallThumbnail')
                	
                    <?php
                        $urlId = $item->is_potset ? $item->pot_parent_id : $item->id; 
                    ?>
                    
                	<a href="{{ url('item/'. $urlId) }}">
                        {!! Ctm::getItemTitle($item, 1) !!}
                        <br>
                        [ {{ $item->number }} ]
                 	</a>   
                	<span class="d-block mt-1">¥{{ Ctm::getItemPrice($item) }}（税込）</span>
                </td>
                	
                <td>
                    <fieldset class="mb-4 form-group">
                        {{-- <label>数量</label> --}}
                        
                        <input type="hidden" name="last_item_id[]" value="{{ $item->id }}">
                        
                        <select class="form-control col-md-11{{ $errors->has('last_item_count') ? ' is-invalid' : '' }}" name="last_item_count[]">
                            	
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
                        <span class="text-warning"></span>
                        
                        @if ($errors->has('last_item_count'))
                            <div class="help-block text-danger">
                                <span class="fa fa-exclamation form-control-feedback"></span>
                                <span>{{ $errors->first('last_item_count.'. $key) }}</span>
                            </div>
                        @endif
                        
                    </fieldset>
                </td>
                
                <td>¥{{ number_format( $item->total_price ) }}</td>
                
                <td>
   						{{--
                 		<input type="hidden" name="item_id" value="{{ $item->id }}">
                   		<input type="hidden" name="delete_item" value="1">  
                     	--}}             
                		<button class="btn bg-white border-secondary btn-normal w-100" type="submit" name="del_item_key" value="{{ $key }}"><i class="fal fa-times"></i> 削除</button>

                </td>        

       		</tr> 
        	 @endforeach
          	            
         </tbody> 
         
         <tfoot>
         	<tr>
          		<td colspan="2" class="text-right text-big">
                	<b>小計</b>
                </td>
            	<td class="text-big"><b>¥{{ number_format($allPrice) }}</b></td>
             	<td>	
                    <input type="hidden" name="calc" value="1" form="re">
                    <button class="btn border border-secondary bg-white px-2 w-100" type="submit" name="re_calc" value="1"><i class="fal fa-redo"></i> 再計算</button>
                    {{-- <input type="submit" name="re_calc" value="再計算"> --}}
                </td>
          	</tr>
            
            @if(isset($deliFee))
                <tr>
                    <td colspan="2" class="text-right text-big"><b>送料</b></td>
                    <td class="text-big"><b>¥{{ number_format($deliFee) }}</b></td>
                    <td></td>
                </tr>
                
                <tr>
                    <td colspan="2" class="text-right text-big"><b>合計 <small>（小計+送料）</small></b></td>
                    <td class="text-big text-danger"><b>¥{{ number_format($allPrice + $deliFee) }}</b></td>
                    <td></td>
                </tr>
            @endif
           
           
            <tr>
                <td colspan="3" class="clearfix">
                                    
                    <div class="float-right col-md-2 p-0 m-0">
                        {{-- <label class="control-label mb-0 text-small d-inline col-md-6"><b>配送先都道府県</b></label> --}}
                    
                        <select id="pref" class="form-control rounded-0 d-inline{{ $errors->has('pref_id') ? ' is-invalid' : '' }}" name="pref_id">
                            <option selected value="0">配送先都道府県</option>
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
                    
                        @if ($errors->has('pref_id'))
                            <div class="help-block text-danger">
                                <span class="fa fa-exclamation form-control-feedback"></span>
                                <span>{{ $errors->first('pref_id') }}</span>
                            </div>
                        @endif
                    </div>
                </td>
                <td>
                    <button class="btn px-2 w-100 bg-enji" type="submit" name="delifee_calc" value="1"><b>送料計算</b></button>
                </td>
            </tr>
            
            <tr>
           		<td colspan="5" class="text-right">
           			<span class="text-enji"><i class="fas fa-exclamation-triangle"></i> 上記の「小計」に送料は含まれておりません。送料を確認する場合は「配送先都道府県」を選択して「送料計算」を押して下さい。</span>
                </td>
           </tr>
           
         </tfoot>        
	</table>
</div>

<div class="clearfix mt-3 cart-btn-wrap">
	
	<div class="">
        <input type="hidden" name="from_cart" value="1">

        @if(Auth::check())
            <button class="btn btn-block btn-custom mb-4 py-2 px-5" type="submit" name="regist_off" value="1" formaction="{{ url('shop/form') }}">購入手続きへ</button>
        @else
            <div class="table-responsive">
                <table class="table">
                    <tr>
                        <th rowspan="2" class="border-0">会員登録がまだの方</th>
                        <td class="border-0"><button class="btn btn-block btn-custom mb-1 py-2 px-5" type="submit" name="regist_on" value="1" formaction="{{ url('shop/form') }}">会員登録をして購入手続きへ</button></td>
                   </tr>
                   <tr class="border-0">
                        <td class="border-0"><button class="btn btn-block btn-custom mb-4 py-2 px-5" type="submit" name="regist_off" value="1" formaction="{{ url('shop/form') }}">会員登録せずに購入手続きへ</button></td>               
                    </tr>
                    <tr>
                        <th class="border-0">会員登録がお済みの方</th>      
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


