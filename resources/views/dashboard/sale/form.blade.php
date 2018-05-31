@extends('layouts.appDashBoard')

@section('content')
	
	<div class="text-left">
        <h1 class="Title">
        @if(isset($edit))
        売上情報
        @else
        売上情報
        @endif
        </h1>
        <p class="Description"></p>
    </div>

    <div class="row">
      <div class="col-sm-12 col-md-6 col-lg-6 col-xl-5 mb-5">
        <div class="bs-component clearfix">
        <div class="pull-left">
            <a href="{{ url('/dashboard/sales') }}" class="btn bg-white border border-1 border-round border-secondary text-primary"><i class="fa fa-angle-double-left" aria-hidden="true"></i>一覧へ戻る</a>
        </div>
        </div>
    </div>
  </div>

    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <strong>Error!!</strong> 追加できません<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
        
	@if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif
        
    <div class="col-lg-12 mb-5">
        <form class="form-horizontal" role="form" method="POST" action="/dashboard/sales/{{$id}}">

            {{ csrf_field() }}

            {{ method_field('PUT') }}
            
             <div class="form-group mb-3">
                <div class="clearfix">
                	<p class="w-50 float-left">
                 		@if($sale->deli_done)
                   		<span class="text-success text-big">この商品は発送済みです。</span>
                     	@else
                      	<span class="text-danger text-big">この商品は未配送です。</span>
                       	@endif                  
                    </p>
                    <button type="submit" class="btn btn-info btn-block float-right mx-auto w-btn w-25 text-white"><i class="fa fa-envelope"></i> 配送済みメールを送る</button>
                </div>
            </div>


            	<div class="table-responsive">
                    <table class="table table-bordered">
                        <colgroup>
                            <col style="background: #dfdcdb; width: 25%;" class="cth">
                            <col style="background: #fefefe;" class="ctd">
                        </colgroup>
                        
                        <tbody>
                        	<tr>
                                <th>売上ID</th>
                                <td>{{ $sale->id }}</td>
                            </tr>
                        	<tr>
                                <th>購入日</th>
                                <td>{{ Ctm::changeDate($sale->created_at, 0) }}</td>
                            </tr>
                            <tr>
                                <th>購入者</th>
                                <td>
                                    @if($saleRel->is_user)
                                        <span class="text-dark">会員</span>: 
                                        <a href="{{ url('dashboard/users/'. $saleRel->user_id) }}">
                                        （{{ $users->find($saleRel->user_id)->id }}）
                                        {{ $users->find($saleRel->user_id)->name }}さん
                                        </a>
                                    @else
                                         <span class="text-danger">非会員</span>: 
                                         <a href="{{ url('dashboard/users/'. $saleRel->user_id.'?no_r=1') }}">
                                         {{ $userNs->find($saleRel->user_id)->name }}さん
                                         </a>
                                     @endif
                                </td>
                            </tr>
                            <tr>
                                <th>配送先</th>
                                <td>
                                〒{{ Ctm::getPostNum($receiver->post_num) }}<br>
                                {{ $receiver->prefecture }}{{ $receiver->address_1 }}{{ $receiver->address_2 }}&nbsp;
                                {{ $receiver->address_3 }}<br>
                                {{ $receiver->name }} 様<br>
                                TEL: {{ $receiver->tel_num }}
                                
                                </td>
                            </tr>
                            <tr>
                            	<th>配送状況</th>
                             	<td>   
                            	@if($sale->deli_done)
                                   <span class="text-success">発送済み</span>
                                 @else
                                  <span class="text-danger">未配送</span>
                                @endif
                                </td>  
                            </tr>
                            
                            <tr>
                                <th>注文番号</th>
                                <td>{{ $sale->order_number }}</td>
                            </tr>
                            <tr>
                                <th>(ID)商品名</th>
                                <td class="clearfix">
                                	
                                	<a href="{{ url('dashboard/items/'. $item->id) }}">
                                	<img src="{{ Storage::url($item->main_img) }}" width="80" height="60" class="img-fluid float-left mr-3">
                                 	</a>   
                                	<div>
                                 		商品番号: {{ $item->number }}<br>   
                                 		<a href="{{ url('dashboard/items/'. $item->id) }}">   
                                 	   	（{{ $item->id }}）{{ $item->title }}
                                     	</a>
                                      	<br>   
                                      	¥{{ number_format(Ctm::getPriceWithTax($item->price)) }} （税込）  
                                    </div>
	
									<input type="hidden" name="send_mail[]" value="$sale->id">
                                </td>
                  
                            </tr>
                            <tr>
                                <th>個数</th>
                                <td>{{ $sale->item_count }}</td>
                            </tr>
                            <tr>
                                <th>決済方法</th>
                                <td>{{ $pms->find($sale->pay_method)->name }}</td>
                            </tr>
                            <tr>
                                <th>商品合計金額（税込）</th>
                                <td>¥{{ number_format($sale->total_price) }}</td>
                            </tr>
                            <tr>
                                <th>送料区分／送料</th>
                                <td>
                                @if($item->deli_fee)
                                	<span class="text-warning">送料無料商品</span>
                                @else
                                	{{ $itemDg->name }}<br>
                                @endif
                                ¥{{ number_format($sale->deli_fee) }}
                                </td>
                            </tr>
                            @if($sale->pay_method == 5)
                            <tr>
                                <th>代引手数料</th>
                                <td>¥{{ number_format($sale->cod_fee) }}</td>
                            </tr>
                            @endif
                            <tr>
                                <th>総合計（A）</th>
                                <?php $total = $sale->total_price + $sale->deli_fee + $sale->cod_fee; ?>
                                <td><span style="font-size: 1.3em;" class="text-success"><b>¥{{ number_format($total) }}</b></span></td>
                            </tr>
                            
                  			<tr>
                                <th>粗利額</th>
                                <td>
                                <?php $arari = ($item->price - $item->cost_price) * $sale->item_count; ?>
                                ¥{{ number_format($arari) }}
                                </td>
                            </tr>
                            <tr>
                                <th>粗利率</th>
                                <td>{{ round($arari / $total * 100, 1) }}%</td>
                            </tr>
                  
                  			<?php 
                                $all = 0;
                     			$num = 1; 
                        	?>                 
                  
                  			@foreach($sameSales as $sameSale)
                            <tr>
                                <th>同時購入商品.{{ $num }}</th>
                                <td class="clearfix">
                                	@if(! $sale->deli_done)
                                	<fieldset class="form-group checkbox">
                                            <label>
                                                <?php
                                                    $checked = '';
                                                    if(Ctm::isOld()) {
                                                        if(old('open_status'))
                                                            $checked = ' checked';
                                                    }
                                                    else {
                                                        if(isset($item) && ! $item->open_status) {
                                                            $checked = ' checked';
                                                        }
                                                    }
                                                ?>
                                                <input type="checkbox" name="send_mail[]" value="$sameSale->id"{{ $checked }}> 同時にメールする
                                            </label>
                                    </fieldset>
                                    @endif
                                    
                                	<a href="{{ url('dashboard/sales/'.$sameSale->id) }}" class="float-right btn border border-secondary text-dark bg-white"><i class="fa fa-arrow-right"></i> 売上情報</a>
                                    
                                    商品番号: {{ $items->find($sameSale->item_id)->number }}<br>
                                	<a href="{{ url('dashboard/items/'. $sameSale->item_id) }}">
                                 	   
                                    （{{ $sameSale->item_id }}）
                                    {{ $items->find($sameSale->item_id)->title }}<br>
                                    </a>
                                    配送状況：
                                    @if($sale->deli_done)
                                       <span class="text-success">発送済み</span>
                                     @else
                                      <span class="text-danger">未配送</span>
                                    @endif
                                    <br>
                                    個数：{{ $sameSale->item_count }}<br>
                                    商品合計：¥{{ number_format($sameSale->total_price) }}<br>
                                    送料：¥{{ number_format($sameSale->deli_fee) }}<br>
                                    @if($sameSale->pay_method == 5)
                                    	代引手数料：¥{{ number_format($sameSale->cod_fee) }}<br>
                                    @endif
                                    <?php $allTotal = $sameSale->total_price + $sameSale->deli_fee +  $sameSale->cod_fee; ?>
                                    <b>総合計（B）：<span class="text-success">¥{{ number_format($allTotal) }}</span></b>
                                    
                                    <?php 
                                    	$all += $allTotal;
                                     	$num++;   
                                    ?>
                                    
                                </td>
                            </tr>
                            @endforeach
                            
                            <tr>
                                <th>購入総合計（A+B）</th>
                                <td><span style="font-size: 1.2em;">¥{{ number_format($total + $all) }}</span></td>
                            </tr>
                            
                            
                            
                 
                            
                            {{--
                            <tr>
                                <th>対応状況</th>
                                <td>
                                    <div class="form-group{{ $errors->has('status') ? ' has-error' : '' }}">
                                        <div class="col-md-10">
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" name="status" value="1"{{isset($contact) && $contact->status ? ' checked' : '' }}> 対応済みにする
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            --}}

                            <tr>

                            </tr>
                            

                        </tbody>
                    </table>
                </div>

				
                <div class="form-group mb-5">
                    <div class="clearfix">
                        <button type="submit" class="btn btn-info btn-block mx-auto w-btn w-25 text-white"><i class="fa fa-envelope"></i> 配送済みメールを送る</button>
                    </div>
                </div>
                

        </form>
    </div>

@endsection
