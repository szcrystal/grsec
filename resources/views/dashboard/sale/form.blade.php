@extends('layouts.appDashBoard')

@section('content')
<?php
//use App\Item;

?>
	
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
            <strong>Error!!</strong><br><br>
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
        <form class="form-horizontal" role="form" method="POST" action="/dashboard/sales">

            {{ csrf_field() }}

            
             <div class="form-group mb-3">
                <div class="clearfix">
                	<p class="w-50 float-left">
                 		@if($sale->deli_done)
                   		<span class="text-success text-big">この商品は{{ date('Y/m/d H:i', time($sale->deli_start_date)) }}に発送済みです。</span>
                     	@else
                      	<span class="text-danger text-big">この商品は未配送です。</span>
                       	@endif                  
                    </p>
                    {{--
                    <button type="submit" class="btn btn-info btn-block float-right mx-auto w-btn w-25 text-white"><i class="fa fa-envelope"></i> 配送済みメールを送る</button>
                    --}}
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
                                        <?php
                                        	$users = $users->find($saleRel->user_id);
                                        ?>
                                    @else
                                         <span class="text-danger">非会員</span>: 
                                         <a href="{{ url('dashboard/users/'. $saleRel->user_id.'?no_r=1') }}">
                                         <?php
                                            $users = $userNs->find($saleRel->user_id);
                                        ?>   
                                     @endif
                                     （{{ $users->id }}）{{ $users->name }}<br>
                                     <a href="mailto:{{ $users->email }}">{{ $users->email }}</a>
                                     
                                     <input type="hidden" name="user_email" value="{{ $users->email }}">
                                     <input type="hidden" name="user_name" value="{{ $users->name }}">
                                    </a>
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
                                   <span class="text-success">発送済み（{{ date('Y/m/d H:i', time($sale->deli_start_date)) }}）</span>
                                 @else
                                  <span class="text-danger">未発送</span>
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
                                       	[{{ $cates->find($item->cate_id)->name }}]
                                       	<br>      
                                      	¥<b>{{ number_format(Ctm::getPriceWithTax($item->price)) }}</b> （税込）  
                                    </div>
	
									<input type="hidden" name="sale_ids[]" value="{{ $sale->id }}">
                                </td>
                  
                            </tr>
                            <tr>
                                <th>個数</th>
                                <td>{{ $sale->item_count }}</td>
                            </tr>
                            
                            <tr>
                                <th>ご希望配送時間</th>
                                <td>
                                	@if(isset($sale->deli_date))
                                        {{ $sale->deli_date }}
                                    @endif
                                    
                                    @if(isset($sale->deli_time))
                                        {{ $sale->deli_time }}
                                    @endif
                                </td>
                            </tr>
                            
                            <tr>
                                <th>決済方法</th>
                                <td>{{ $pms->find($sale->pay_method)->name }}</td>
                            </tr>
                            <tr>
                                <th>商品合計金額（税込）</th>
                                <td><b>¥{{ number_format($sale->total_price) }}</b></td>
                            </tr>
                            <tr>
                                <th>送料区分/送料/送料差損</th>
                                <td>
                                @if($item->deli_fee)
                                	<span class="text-warning">送料無料商品</span>
                                @else
                                	{{ $itemDg->name }}<br>
                                @endif
                                ¥{{ number_format($sale->deli_fee) }}<br>
                                
                                @if(isset($itemDg->take_charge))
                                ¥{{ number_format($itemDg->take_charge) }}
                                @else
                                0
                                @endif
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
                                <th>仕入れ値</th>
                                <td>
                                <?php 
                                	$costPrice = $items->find($sale->item_id)->cost_price;
                                    $costPrice = $costPrice * $sale->item_count;
                                ?>
                                <fieldset class="mb-4 form-group">
                                    <input class="form-control col-md-5{{ $errors->has('cost_price') ? ' is-invalid' : '' }}" name="cost_price" value="{{ Ctm::isOld() ? old('cost_price') : (isset($sale->cost_price) ? $sale->cost_price : $costPrice) }}">
                                    

                                    @if ($errors->has('cost_price'))
                                        <div class="text-danger">
                                            <span class="fa fa-exclamation form-control-feedback"></span>
                                            <span>{{ $errors->first('cost_price') }}</span>
                                        </div>
                                    @endif
                                </fieldset>
                                </td>
                            </tr>
                            
                  			<tr>
                                <th>粗利額</th>
                                <td>
                                <?php 
                                	$arari = ($item->price - $item->cost_price - $itemDg->take_charge) * $sale->item_count;
                                	
                                ?>
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
                                                <input type="checkbox" name="sale_ids[]" value="{{ $sameSale->id }}"{{ $checked }}> 同時にメールする
                                            </label>
                                    </fieldset>
                                    @endif
                                    
                                	<a href="{{ url('dashboard/sales/'.$sameSale->id) }}" class="float-right btn border border-secondary text-dark bg-white"><i class="fa fa-arrow-right"></i> 売上情報</a>
                                    
                                    商品番号: {{ $items->find($sameSale->item_id)->number }}<br>
                                	<a href="{{ url('dashboard/items/'. $sameSale->item_id) }}">
                                 	   
                                    （{{ $sameSale->item_id }}）
                                    {{ $items->find($sameSale->item_id)->title }}<br>
                                    </a>
                                    
                                    ご希望配送時間：
                                    @if(isset($sameSale->deli_date))
                                        {{ $sameSale->deli_date }}
                                    @endif
                                    
                                    @if(isset($sameSale->deli_time))
                                        {{ $sameSale->deli_time }}
                                    @endif
                                    <br>
                                    配送状況：
                                    @if($sameSale->deli_done)
                                       <span class="text-success">発送済み（{{ date('Y/m/d H:i', time($sameSale->deli_start_date)) }}）</span>
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

                            

                        </tbody>
                    </table>
                </div>
                
                <div>
                	<fieldset class="mb-4 form-group">
                        <label for="stock" class="control-label">お届け予定日</label>
                        <input class="form-control col-md-6{{ $errors->has('plan_date') ? ' is-invalid' : '' }}" name="plan_date" value="{{ Ctm::isOld() ? old('plan_date') : (isset($sale) ? $sale->plan_date : '') }}">
                        

                        @if ($errors->has('plan_date'))
                            <div class="text-danger">
                                <span class="fa fa-exclamation form-control-feedback"></span>
                                <span>{{ $errors->first('plan_date') }}</span>
                            </div>
                        @endif
                    </fieldset>
                        
                	<fieldset class="mb-2 form-group{{ $errors->has('information') ? ' is-invalid' : '' }}">
                        <label for="detail" class="control-label">ご連絡事項</label>

                            <textarea id="information" class="form-control" name="information" rows="8">{{ Ctm::isOld() ? old('information') : (isset($sale) ? $sale->information : '') }}</textarea>

                            @if ($errors->has('information'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('information') }}</strong>
                                </span>
                            @endif
                    </fieldset>
                    
                    <fieldset class="mb-2 form-group{{ $errors->has('craim') ? ' is-invalid' : '' }}">
                        <label for="detail" class="control-label">クレーム</label>

                            <textarea id="detail" class="form-control" name="craim" rows="8">{{ Ctm::isOld() ? old('craim') : (isset($sale) ? $sale->craim : '') }}</textarea>

                            @if ($errors->has('craim'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('craim') }}</strong>
                                </span>
                            @endif
                    </fieldset>
                
                </div>

				<input type="hidden" name="saleId" value="{{ $sale->id }}">
				
                <div class="clearfix my-5">
                	<div class="form-group float-left w-25">
                        <button type="submit" class="btn btn-primary btn-block w-btn w-100 text-white" name="only_up" value="1"> 更新のみする</button>
                    </div>
                
                    <div class="form-group float-right col-md-4">
                        <button type="submit" class="btn btn-danger btn-block mx-auto w-btn w-100 text-white" name="with_mail" value="1"><i class="fa fa-envelope"></i> 更新して発送済みメールを送る</button>
                    </div>
                </div>
        </form>
        
    </div>

@endsection
