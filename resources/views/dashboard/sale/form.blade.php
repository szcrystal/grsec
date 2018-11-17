@extends('layouts.appDashBoard')

@section('content')
<?php
use App\Setting;

?>
	
	<div class="text-left">
        <h1 class="Title">
        @if(isset($edit))
        売上個別情報（注文商品個別）
        @else
        売上個別情報（注文商品個別）
        @endif
        </h1>
        <p class="Description"></p>
    </div>

    <div class="row">
      <div class="col-sm-12 col-md-6 col-lg-6 col-xl-5 mb-5">
        <div class="bs-component clearfix">
        <div class="pull-left">
            <a href="{{ url('/dashboard/sales') }}" class="btn bg-white border border-1 border-round border-secondary text-primary"><i class="fa fa-angle-double-left" aria-hidden="true"></i>一覧へ戻る</a>
            <br>
            <a href="{{ url('/dashboard/sales/order/' . $sale->order_number) }}" class="btn bg-white border border-1 border-round border-secondary text-primary mt-2"><i class="fa fa-angle-double-left" aria-hidden="true"></i>ご注文情報へ</a>
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

			<div class="form-group col-md-5 mx-auto my-5">
                <button type="submit" class="btn btn-primary btn-block w-btn w-100 text-white" name="only_up" value="1"> 更新する</button>
            </div>
            
             <div class="form-group mb-0">
                <div class="clearfix">
                	<p class="w-50 float-left">
                    	@if($sale->is_cancel)
                        	<span class="text-danger text-big">この商品はキャンセルです。</span>
                        @else
                            @if($sale->deli_done)
                            <span class="text-success text-big">この商品は{{ date('Y/m/d H:i', time($sale->deli_start_date)) }}に発送済みです。</span>
                            @else
                            <span class="text-danger text-big">この商品は未配送です。</span>
                            @endif
                        @endif                  
                    </p>
                </div>
            </div>


            	<div class="table-responsive">
                    <table class="table table-bordered">
                        <colgroup>
                            <col style="background: #f5dfd5; width: 20%;" class="cth">
                            <col style="background: #fefefe;" class="ctd">
                        </colgroup>
                        
                        <tbody>
                        	<tr>
                                <th>売上ID</th>
                                <td>{{ $sale->id }}</td>
                            </tr>
                        	<tr>
                                <th>購入日</th>
                                <td><span class="text-big">{{ Ctm::changeDate($sale->created_at, 0) }}</span></td>
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
                                     <a href="mailto:{{ $users->email }}">{{ $users->email }}</a><br>
                                     
                                     〒{{ Ctm::getPostNum($users->post_num) }}<br>
                                     {{ $users->prefecture }}
                                     {{ $users->address_1 }}
                                     {{ $users->address_2 }}
                                     {{ $users->address_3 }}<br>
                                     TEL：{{ $users->tel_num }}
                                     
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
                                <td><a href="{{ url('dashboard/sales/order/'. $sale->order_number) }}">{{ $sale->order_number }}</a></td>
                            </tr>
                            <tr>
                                <th>[ID]商品名</th>
                                <td class="clearfix">
                                	
                                	<div class="float-left mr-2 mb-1">
                                        <?php //$item = $items->find($sameSale->item_id); ?>
                                        @include('main.shared.smallThumbnail')
                                    </div>  
                                	<div>
                                 		商品番号: {{ $item->number }}<br>   
                                 		<a href="{{ url('dashboard/items/'. $item->id) }}">   
                                 	   	[{{ $item->id }}] {{ Ctm::getItemTitle($item) }}
                                     	</a>
                                      	<br>
                                       	      
                                      	¥<b>{{ number_format($sale->single_price) }}</b> （税込）  
                                    </div>
	
									<input type="hidden" name="sale_ids[]" value="{{ $sale->id }}">
                                </td>
                  
                            </tr>
                            <tr>
                                <th>数量</th>
                                <td>{{ $sale->item_count }}</td>
                            </tr>
                            

                            <tr>
                                <th>商品合計金額</th>
                                <td>
                                	<?php 
                                    	$per = Setting::find(1)->tax_per;
                                    	$per = ($per/100) + 1;
                                    ?>
                                	<b>¥{{ number_format($sale->total_price / $per) }}</b>（税抜）<br>
                                	<b>¥{{ number_format($sale->total_price) }}</b>（税込）
                                </td>
                            </tr>
                            
                            <tr>
                                <th>決済方法</th>
                                <td>{{ $pms->find($sale->pay_method)->name }}</td>
                            </tr>
                            
                            <tr>
                                <th>送料区分</th>
                                <td>
                                @if($item->deli_fee)
                                	<span class="text-warning">送料無料商品</span>
                                @else
                                	{{ $itemDg->name }}<br>
                                @endif
                                {{-- ¥{{ number_format($sale->deli_fee) }} --}}
                                
                                {{--
                                <fieldset class="mt-2 mb-4 form-group">
                                    <input class="form-control col-md-6 d-inline{{ $errors->has('deli_fee') ? ' is-invalid' : '' }}" name="deli_fee" value="{{ Ctm::isOld() ? old('deli_fee') : (isset($sale->deli_fee) ? $sale->deli_fee : '') }}">
                                    
                                    @if ($errors->has('deli_fee'))
                                        <div class="text-danger">
                                            <span class="fa fa-exclamation form-control-feedback"></span>
                                            <span>{{ $errors->first('deli_fee') }}</span>
                                        </div>
                                    @endif
                                </fieldset>
                                --}}
                                
                                </td>
                            </tr>
                            
                            <tr>
                                <th>ご希望配送日時</th>
                                <td>
                                	@if(isset($sale->plan_date))
                                        <p class="mb-2">{{ $sale->plan_date }}</p>
                                    @endif
                                    
                                    @if(isset($sale->deli_time))
                                        {{ $sale->deli_time }}
                                    @endif
                                </td>
                            </tr>
                             
                            <tr>
                            	<th>出荷予定日<br><span class="text-small text-secondary">（ユーザー反映）</span></th>
                                <td>
                                	<div class="">
                                        <fieldset class="mb-4 form-group">
                                        	
                                            @if(isset($sale->deli_start_date) && $sale->deli_start_date)
                                        	<p>{{ Ctm::getDateWithYoubi($sale->deli_start_date) }}</p>
                                            @endif
                                            
                                            <select class="form-control col-md-6{{ $errors->has('deli_start_date') ? ' is-invalid' : '' }}" name="deli_start_date">
                                                <option selected value="0">選択して下さい</option>
                                                    <?php 
                                                        $days = array();
                                                        //$week = ['日', '月', '火', '水', '木', '金', '土'];
                                                    
                                                        for($plusDay = 0; $plusDay < 64; $plusDay++) {
                                                            $now = date('Y-m-d H:i:s', time());
                                                            $first = strtotime($now." +". $plusDay . " day");
                                                            //$days[$first] = date('Y/m/d', $first) . '（' . $week[date('w', $first)] . '）';
                                                            $days[$first] = Ctm::getDateWithYoubi(date('Y-m-d H:i:s', $first));
                                                        }
                                                    ?>
                                                

                                                    @foreach($days as $key => $day)
                                                        <?php
                                                            $selected = '';
                                                            $key = date('Y-m-d', $key);
                                                            
                                                            if(Ctm::isOld()) {
                                                                if(old('deli_start_date') == $key)
                                                                    $selected = ' selected';
                                                            }
                                                            else {
                                                                if(isset($sale) && $sale->deli_start_date == $key) {
                                                                    $selected = ' selected';
                                                                }
                                                            }
                                                        ?>
                                                        <option value="{{ $key }}"{{ $selected }}>{{ $day }}</option>
                                                    @endforeach
                                            </select>
                                            
                                            @if ($errors->has('deli_start_date'))
                                                <span class="help-block">
                                                    <strong class="text-danger">{{ $errors->first('deli_start_date') }}</strong>
                                                </span>
                                            @endif
                                        </fieldset>
                                    </div>
                                </td>
                            </tr>
                            
                            <tr>
                            	<th>お届け予定日<br><span class="text-small text-secondary">（ユーザー反映）</span></th>
                                <td>
                                	<div class="">
                                        <fieldset class="mb-4 form-group">
                                        	@if(isset($sale->deli_schedule_date) && $sale->deli_schedule_date)
                                        	<p>{{ Ctm::getDateWithYoubi($sale->deli_schedule_date) }}</p>
                                            @endif
                                            
                                            <select class="form-control col-md-6{{ $errors->has('deli_schedule_date') ? ' is-invalid' : '' }}" name="deli_schedule_date">
                                                <option selected value="0">選択して下さい</option>
                                                    <?php 
//                                                        $days = array();
//                                                        //$week = ['日', '月', '火', '水', '木', '金', '土'];
//                                                    
//                                                        for($plusDay = 0; $plusDay < 64; $plusDay++) {
//                                                            $now = date('Y-m-d H:i:s', time());
//                                                            $first = strtotime($now." +". $plusDay . " day");
//                                                            //$days[$first] = date('Y/m/d', $first) . '（' . $week[date('w', $first)] . '）';
//                                                            $days[$first] = Ctm::getDateWithYoubi(date('Y-m-d H:i:s', $first));
//                                                        }
                                                    ?>
                                                

                                                    @foreach($days as $key => $day)
                                                        <?php
                                                            $selected = '';
                                                            $key = date('Y-m-d', $key);
                                                            
                                                            if(Ctm::isOld()) {
                                                                if(old('deli_schedule_date') == $key)
                                                                    $selected = ' selected';
                                                            }
                                                            else {
                                                                if(isset($sale) && $sale->deli_schedule_date == $key) {
                                                                    $selected = ' selected';
                                                                }
                                                            }
                                                        ?>
                                                        <option value="{{ $key }}"{{ $selected }}>{{ $day }}</option>
                                                    @endforeach
                                            </select>
                                            
                                            <?php
//                                                $current = new DateTime('now');
//                                                $from = new DateTime($sale->deli_schedule_date);
//                                                $diff = $current->diff($from); //マイナスの時はinvert:1
//                                                echo $diff->days . '/' . $diff->invert . '/';
//                                                
//                                                print_r($diff);
                                            ?>

                                            
                                            @if ($errors->has('deli_schedule_date'))
                                                <span class="help-block">
                                                    <strong class="text-danger">{{ $errors->first('deli_schedule_date') }}</strong>
                                                </span>
                                            @endif
                                        </fieldset>
                                    </div>
                                </td>
                            </tr>
                            
                            <tr>
                            	<th>配送会社<br><span class="text-small text-secondary">（ユーザー反映）</span></th>
                                <td>
                                	<select class="form-control col-md-6{{ $errors->has('deli_company_id') ? ' is-invalid' : '' }}" name="deli_company_id">
                                            <option selected value="0">選択して下さい</option>
                                                
                                                @foreach($dcs as $dc)
                                                    <?php
                                                        $selected = '';
                                                        if(Ctm::isOld()) {
                                                            if(old('deli_company_id') == $dc->id)
                                                                $selected = ' selected';
                                                        }
                                                        else {
                                                            if(isset($sale) && $sale->deli_company_id == $dc->id) {
                                                                $selected = ' selected';
                                                            }
                                                        }
                                                    ?>
                                                    <option value="{{ $dc->id }}"{{ $selected }}>{{ $dc->name }}</option>
                                                @endforeach
                                        </select>
                                        
                                        @if ($errors->has('deli_company_id'))
                                            <span class="help-block">
                                                <strong class="text-danger">{{ $errors->first('deli_company_id') }}</strong>
                                            </span>
                                        @endif
                                    </fieldset>
                                </td>
                            </tr>
                            
                            <tr>
                            	<th>伝票番号<br><span class="text-small text-secondary">（ユーザー反映）</span></th>
                                <td>
                                <fieldset class="mb-4 form-group">
                                	
                                    <input class="form-control col-md-6 d-inline{{ $errors->has('deli_slip_num') ? ' is-invalid' : '' }}" name="deli_slip_num" value="{{ Ctm::isOld() ? old('deli_slip_num') : (isset($sale->deli_slip_num) ? $sale->deli_slip_num : '') }}">
                                    
                                    @if ($errors->has('deli_slip_num'))
                                        <div class="text-danger">
                                            <span class="fa fa-exclamation form-control-feedback"></span>
                                            <span>{{ $errors->first('deli_slip_num') }}</span>
                                        </div>
                                    @endif
                                </fieldset>
                                
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
                                    $sumCostPrice = $costPrice * $sale->item_count;
                                ?>
                                <fieldset class="mb-4 form-group">
                                    <input class="form-control col-md-5 d-inline{{ $errors->has('cost_price') ? ' is-invalid' : '' }}" name="cost_price" value="{{ Ctm::isOld() ? old('cost_price') : (isset($costPrice) ? $costPrice : '') }}">
                                    
                                    <span class="">x {{ $sale->item_count }} = {{ number_format($sumCostPrice) }}
                                    
									<input type="hidden" name="this_count" value="{{ $sale->item_count }}">
                                    
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
                                <th>送料差損</th>
                                <td>
                                <fieldset class="mb-4 form-group">
                                    <input class="form-control col-md-5{{ $errors->has('charge_loss') ? ' is-invalid' : '' }}" name="charge_loss" value="{{ Ctm::isOld() ? old('charge_loss') : (isset($sale) ? $sale->charge_loss : '') }}">
                                    

                                    @if ($errors->has('charge_loss'))
                                        <div class="text-danger">
                                            <span class="fa fa-exclamation form-control-feedback"></span>
                                            <span>{{ $errors->first('charge_loss') }}</span>
                                        </div>
                                    @endif
                                </fieldset>
                                </td>
                            </tr>
                            
                            
                  
                  			<?php 
                                $all = 0;
                     			$num = 2; 
                        	?>                 
                  
                  			@foreach($sameSales as $sameSale)
                            <tr>
                                <th>同時購入商品.{{ $num }}</th>
                                <td class="clearfix">
                                	
                                    
                                	<a href="{{ url('dashboard/sales/'.$sameSale->id) }}" class="float-right btn border border-secondary text-dark bg-white"><i class="fa fa-arrow-right"></i> 売上個別情報</a>
                                    
                                    <div class="clearfix">
                                    <div class="float-left mr-2 mb-1">
                                        <?php $item = $items->find($sameSale->item_id); ?>
                                        @include('main.shared.smallThumbnail')
                                    </div>
                                    
                                    
                                	<a href="{{ url('dashboard/items/'. $sameSale->item_id) }}">
                                 	   
                                    	[{{ $sameSale->item_id }}]
                                    	{{ Ctm::getItemTitle($items->find($sameSale->item_id)) }}<br>
                                    </a>
                                    商品番号: {{ $items->find($sameSale->item_id)->number }}<br>
                                    </div>
                                    
                                    <div class="clearfix">
                                    	数量：{{ $sameSale->item_count }}<br>
                                        
                                        ご希望配送時間：
                                        @if(isset($sameSale->plan_date))
                                            {{ $sameSale->plan_date }}
                                        @endif
                                        &nbsp;&nbsp;
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
                                        
                                        {{--
                                        商品合計：¥{{ number_format($sameSale->total_price) }}<br>
                                        送料：¥{{ number_format($sameSale->deli_fee) }}<br>
                                        @if($sameSale->pay_method == 5)
                                            代引手数料：¥{{ number_format($sameSale->cod_fee) }}<br>
                                        @endif
                                        --}}
                                        
                                        <?php $allTotal = $sameSale->total_price + $sameSale->deli_fee +  $sameSale->cod_fee; ?>
                                        <b>商品合計（B）：<span class="text-success">¥{{ number_format($sameSale->total_price) }}</span></b>
                                    </div>
                                    
                                    <?php 
                                    	$all += $allTotal;
                                     	$num++;   
                                    ?>
                                    
                                </td>
                            </tr>
                            @endforeach
                            
                            <tr>
                                <th>購入総合計（A+B）</th>
                                <td><span style="font-size:1.2em;">¥{{ number_format($total + $all) }}</span></td>
                            </tr>

							
                            <tr>
                            	<th></th>
                                <td>
                                	<fieldset class="form-group checkbox">
                                        <label class="{{ $errors->has('is_cancel') ? 'is-invalid' : '' }}">
                                            <?php
                                                $checked = '';
                                                if(Ctm::isOld()) {
                                                    if(old('is_cancel'))
                                                        $checked = ' checked';
                                                }
                                                else {
                                                    if(isset($sale) && $sale->is_cancel) {
                                                        $checked = ' checked';
                                                    }
                                                }
                                            ?>
                                            <input type="checkbox" name="is_cancel" value="1"{{ $checked }}> キャンセルする
                                        </label>
                                        
                                        @if ($errors->has('is_cancel'))
                                            <br><span class="help-block text-danger text-small">
                                                {{ $errors->first('is_cancel') }}
                                            </span>
                                        @endif
                                        
                                    </fieldset>
                                </td>
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
                
                

				<input type="hidden" name="saleId" value="{{ $sale->id }}">
                
                <div class="form-group col-md-5 mx-auto my-5">
                    <button type="submit" class="btn btn-primary btn-block w-btn w-100 text-white" name="only_up" value="1"> 更新する</button>
                </div>
				
                {{--
                <div class="clearfix my-5">
                	<div class="form-group float-left w-25">
                        <button type="submit" class="btn btn-primary btn-block w-btn w-100 text-white" name="only_up" value="1"> 更新のみする</button>
                    </div>
                
                    <div class="form-group float-right col-md-4">
                        <button type="submit" class="btn btn-danger btn-block mx-auto w-btn w-100 text-white" name="with_mail" value="1"><i class="fa fa-envelope"></i> 更新して発送済みメールを送る</button>
                    </div>
                </div>
                --}}
        </form>
        
        <a href="{{ url('/dashboard/sales/order/' . $sale->order_number) }}" class="btn bg-white border border-1 border-round border-secondary text-primary mt-2"><i class="fa fa-angle-double-left" aria-hidden="true"></i>ご注文情報へ</a>
        
    </div>

@endsection
