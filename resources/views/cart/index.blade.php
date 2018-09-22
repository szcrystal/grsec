@extends('layouts.app')

@section('content')

<div id="main" class="top">

        <div class="panel panel-default">

            <div class="panel-body">
                {{-- @include('main.shared.main') --}}

				<div class="main-list clearfix">


<div class="top-cont feature clear">

@include('cart.guide')

@if(! count($itemData))
	<div class="col-md-8 mx-auto text-center">
	<p class="">カートに商品が入っていません</p>
	<a href="{{ url('/') }}">TOPへ戻る</a>
	</div>
@else

<form id="with1" class="form-horizontal" role="form" method="POST" action="{{ url('shop/cart') }}">
      {{ csrf_field() }}
                        
<div class="table-responsive table-cart">
	<table class="table table-bordered bg-white">
		<thead>
  			<tr>
                <th>商品名</th>
                <th>数量</th>
                <th>金額（税込）</th>
                <th></th>
            </tr>
  		</thead>  
    
    	<tbody>
     		
     		@foreach($itemData as $key => $item)    
     		<tr>
                <td class="clearfix">
                	<img src="{{ Storage::url($item->main_img) }}" alt="{{ $item->title }}" class="img-fluid" width=80 height=80>
                
                	<a href="{{ url('item/'.$item->id) }}">
                        {{ Ctm::getItemTitle($item) }}
                        <br>
                        [ {{ $item->number }} ]
                 	</a>   
                	<span class="d-block mt-2">¥{{ number_format(Ctm::getPriceWithTax($item->price)) }}（税込）</span>
                </td>
                	
                <td>
                    <fieldset class="mb-4 form-group">
                        {{-- <label>数量</label> --}}
                        
                        <input type="hidden" name="last_item_id[]" value="{{ $item->id }}">
                        {{--
                        <input type="hidden" name="last_item_total_price[]" value="{{ $item->total_price }}">
                        --}}
                        
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
                                            if(old('item_count') == $i)
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
                                <span>{{ $errors->first('last_item_count') }}</span>
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
                		<button class="btn bg-white border-secondary btn-normal" type="submit" name="del_item_key" value="{{ $key }}"><i class="fas fa-times"></i> 削除</button>

                </td>        

       		</tr> 
        	 @endforeach
          	            
         </tbody> 
         
         <tfoot>
         	<tr>
          		<td colspan="2" class="text-right"><strong>小計</strong></td>
            	<td class="text-danger text-big">¥{{ number_format($allPrice) }}</td>
             	<td>	
                    <input type="hidden" name="calc" value="1" form="re">
                    <button class="btn border border-secondary bg-white px-2" type="submit" name="re_calc" value="1"><i class="fas fa-redo"></i> 再計算</button>
                    {{-- <input type="submit" name="re_calc" value="再計算"> --}}
                </td>
          	</tr>  
           <tr>
           		<td colspan="5" class="text-right"><small>数量変更後の小計を確認する場合は再計算を押して下さい</small></td>
           </tr>    
         </tfoot>        
	</table>
</div>

<div class="clearfix mt-3">
	
	<div class="float-right">
			<input type="hidden" name="from_cart" value="1">
   
   			@if(Auth::check())
      			<button class="btn btn-block btn-custom mb-4 py-2 px-5" type="submit" name="regist_off" value="1" formaction="{{ url('shop/form') }}"><i class="fas fa-shopping-basket"></i> 購入手続きへ</button>
      		@else
        	<div class="table-responsibe">
         		<table class="table">
           			<tr>
              			<th rowspan="2" class="border-0">会員登録がまだの方</th>
                 		<td class="border-0"><button class="btn btn-block btn-custom mb-1 py-2" type="submit" name="regist_on" value="1" formaction="{{ url('shop/form') }}">会員登録をして購入手続きへ</button></td>
                   </tr>
                   <tr class="border-0">
                   		<td class="border-0"><button class="btn btn-block btn-custom mb-4 py-2" type="submit" name="regist_off" value="1" formaction="{{ url('shop/form') }}">会員登録せずに購入手続きへ</button></td>               
              		</tr>
                	<tr class="pt-2">
                        <th class="border-0">会員登録がお済みの方</th>      
                        <td class="border-0">	
                        <a href="{{ url('login?to_cart=1') }}" class="btn btn-block btn-custom mb-4 py-2">ログインする</a>
                        {{--
                        <button class="btn btn-block btn-custom mb-3 py-2" type="submit" name="to_cart" value="shop/cart" formaction="{{ url('login') }}">ログインする</button>
                        --}}
                        </td>               
                    </tr>	      
            	</table>
            </div>
            
			@endif
	</div>
    
    <div class="float-left">
		<input type="hidden" name="uri" value="{{ $uri }}">
        
		<a href="{{ url($uri)}}" class="btn border border-secondary bg-white"><i class="fas fa-angle-double-left"></i> 元に戻って買い物を続ける</a>
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


