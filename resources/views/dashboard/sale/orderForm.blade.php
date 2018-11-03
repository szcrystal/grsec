@extends('layouts.appDashBoard')

@section('content')
<?php
use App\Item;
use App\Setting;
use App\PayMethod;
use App\DeliveryCompany;
use App\SendMailFlag;
?>
	
	<div class="text-left">
        <h1 class="Title">
        @if(isset($edit))
        ご注文情報
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
        <form class="form-horizontal" role="form" method="POST" action="/dashboard/sales/order">

            {{ csrf_field() }}

                <div class="clearfix">
                	<p class="w-50 float-left mb-0 pb-0">
                 		
                    @if($saleRel->pay_method == 2 || $saleRel->pay_method == 6)
                    	<?php $payName = PayMethod::find($saleRel->pay_method)->name; ?>
                        
                        @if($saleRel->pay_done)
                   		<span class="text-success text-big">このご注文は、{{ $payName }}：入金済みです。</span>
                     	@else
                      	<span class="text-danger text-big">このご注文は、{{ $payName }}：未入金です。</span>
                       	@endif  
                     @endif                 
                    </p>
                </div>


            	<div class="table-responsive">
                    <table class="table table-bordered">
                        <colgroup>
                            <col style="background: #dfdcdb; width: 20%;" class="cth">
                            <col style="background: #fefefe;" class="ctd">
                        </colgroup>
                        
                        <tbody>
                        	<tr>
                                <th>注文番号</th>
                                <td>
                                	{{ $saleRel->order_number }}
                                	<input type="hidden" name="order_id" value="{{ $saleRel->id }}">
                                </td>
                            </tr>
                        	<tr>
                                <th>購入日</th>
                                <td><span class="text-big"><b>{{ Ctm::changeDate($saleRel->created_at, 0) }}</b></span></td>
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
                                <th>決済方法</th>
                                <td>
                                	<span class="text-big"><b>{{ $pms->find($saleRel->pay_method)->name }}</b></span>
                                	@if($saleRel->pay_method == 6)
                                        @if($saleRel->pay_done)
                                        <span class="text-success">(入金済み)</span>
                                        @else
                                        <span class="text-danger">(未入金)</span>
                                        @endif  
                                     @endif 
                                
                                </td>
                            </tr>

                  
                  			<?php 
                                $all = 0;
                     			$num = 1; 
                        	?>                 
                  
                  			@foreach($sales as $sale)
                            <tr>
                                <th>購入商品.{{ $num }}</th>
                                <td class="clearfix">
                                	<a href="{{ url('dashboard/sales/'.$sale->id) }}" class="float-right btn border border-secondary text-dark bg-white"><i class="fa fa-arrow-right"></i> 売上個別情報</a>
                                	
                                    <fieldset class="form-group checkbox mt-3">
                                        <label class="{{ $errors->has('sale_ids') ? 'is-invalid' : '' }}">
                                            <?php
                                                $checked = '';
                                                if(Ctm::isOld()) {
                                                    if(old('sale_ids') && in_array($sale->id, old('sale_ids')))
                                                        $checked = ' checked';
                                                }
//                                                else {
//                                                    if(isset($item) && ! $item->open_status) {
//                                                        $checked = ' checked';
//                                                    }
//                                                }
                                            ?>
                                            <input type="checkbox" name="sale_ids[]" value="{{ $sale->id }}"{{ $checked }}> メールをする
                                        </label>
                                        
                                        @if ($errors->has('sale_ids'))
                                            <br><span class="help-block text-danger text-small">
                                                {{ $errors->first('sale_ids') }}
                                            </span>
                                        @endif
                                        
                                    </fieldset>
                                	
                                    <table class="table-tyumon w-100 table-striped">
                                    	<tbody>
                                        	<tr>
                                            	<th>商品<br><span class="text-small">売上ID:{{ $sale->id }}</span></th>
                                            	<td>
                                                	<div class="float-left mr-2">
                                                	<?php $item = $items->find($sale->item_id); ?>
                                                	@include('main.shared.smallThumbnail')
                                                    </div>
                                                    
                                                	<a href="{{ url('dashboard/items/'. $sale->item_id) }}">
                                                        [{{ $sale->item_id }}] 
                                                        {{ Ctm::getItemTitle($items->find($sale->item_id)) }}<br>
                                                    </a>
                                                    <span class="text-small">商品番号: {{ $items->find($sale->item_id)->number }}</span><br>
                                                    <span class="text-small">¥{{ number_format($sale->single_price) }}</span>
                                                </td>
                                            </tr>
                                            
                                            <tr>
                                            	<th>数量</th>
                                                <td>{{ $sale->item_count }}</td>
                                            </tr>
                                            
                                            <tr>
                                            	<th>合計金額</th>
                                                <td>¥{{ number_format($sale->total_price) }}</td>
                                            </tr>
                                            
                                            <tr>
                                            	<th>ご希望配送日時</th>
                                                <td>
                                                	@if(isset($sale->plan_date))
                                                        {{ $sale->plan_date }}&nbsp;
                                                    @endif
                                                    
                                                    @if(isset($sale->plan_time))
                                                        {{ $sale->plan_time }}
                                                    @endif
                                                </td>
                                            </tr>
                                            
                                            <tr>
                                            	<th>出荷予定日</th>
                                                <td>
                                                	@if(isset($sale->deli_start_date) && $sale->deli_start_date)
                                                        {{ Ctm::getDateWithYoubi($sale->deli_start_date) }}&nbsp;
                                                    @endif
                                                    
                                                    <input type="hidden" name="deli_start_date[{{ $sale->id }}]" value="{{ $sale->deli_start_date }}">
                                                </td>
                                            </tr>
                                            
                                            <tr>
                                            	<th>お届け予定日</th>
                                                <td>
                                                	@if(isset($sale->deli_schedule_date) && $sale->deli_schedule_date)
                                                        {{ Ctm::getDateWithYoubi($sale->deli_schedule_date) }}&nbsp;
                                                    @endif 
                                                    
                                                    <input type="hidden" name="deli_schedule_date[{{ $sale->id }}]" value="{{ $sale->deli_schedule_date }}">   
                                                </td>
                                            </tr>
                                            
                                            
                                            
                                            <tr>
                                            	<th>配送会社/伝票番号</th>
                                                <td>
                                                @if(isset($sale->deli_company_id) && $sale->deli_company_id)
                                                	{{ DeliveryCompany::find($sale->deli_company_id)->name }} / 
                                                    @if($sale->deli_slip_num)
                                                    	{{ $sale->deli_slip_num }}
                                                    @else
                                                    	<span class="text-danger">未確認</span>
                                                    @endif
                                                @endif
                                                </td>
                                                
                                                <input type="hidden" name="deli_company_id[{{ $sale->id }}]" value="{{ $sale->deli_company_id }}">
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
                                            	<th>サンクスメール</th>
                                                <td>
                                                	@if(SendMailFlag::where(['sale_id'=>$sale->id, 'templ_id'=>$templs['thanks'] ])->get()->isNotEmpty())
                                                    <span class="text-success">済</span>
                                                    @else
                                                    <span class="text-danger">未</span>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                            	<th>在庫確認中メール</th>
                                                <td>
                                                	@if(SendMailFlag::where(['sale_id'=>$sale->id, 'templ_id'=>$templs['stockNow'] ])->get()->isNotEmpty())
                                                    <span class="text-success">済</span>
                                                    @else
                                                    <span class="text-danger">未</span>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                            	<th>植え付け方法メール</th>
                                                <td>
                                                	@if(SendMailFlag::where(['sale_id'=>$sale->id, 'templ_id'=>$templs['howToUe'] ])->get()->isNotEmpty())
                                                    <span class="text-success">済</span>
                                                    @else
                                                    <span class="text-danger">未</span>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                            	<th>出荷完了（伝票未）メール</th>
                                                <td>
                                                	@if(SendMailFlag::where(['sale_id'=>$sale->id, 'templ_id'=>$templs['deliDoneNo'] ])->get()->isNotEmpty())
                                                    <span class="text-success">済</span>
                                                    @else
                                                    <span class="text-danger">未</span>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                            	<th>出荷完了メール</th>
                                                <td>
                                                	@if(SendMailFlag::where(['sale_id'=>$sale->id, 'templ_id'=>$templs['deliDone'] ])->get()->isNotEmpty())
                                                    <span class="text-success">済</span>
                                                    @else
                                                    <span class="text-danger">未</span>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                            	<th>キャンセル状況／<br>キャンセルメール</th>
                                                <td>
                                                	@if($sale->is_cancel)
                                                    <span class="text-danger">キャンセル済</span><br>
                                                    @else
                                                    --<br>
                                                    <input type="hidden" name="is_cancel[{{ $sale->id }}]" value="{{ $sale->is_cancel }}">
                                                    @endif
                                                    
                                                	@if(SendMailFlag::where(['sale_id'=>$sale->id, 'templ_id'=>$templs['cancel'] ])->get()->isNotEmpty())
                                                    <span class="text-success">済</span>
                                                    @else
                                                    <span class="text-danger">未</span>
                                                    @endif
                                                </td>
                                            </tr>
                                            
                                            
                                        </tbody>
                                    </table>
                                	
                                    
                                    <?php 
                                    	$all += $sale->total_price;
                                     	$num++;   
                                    ?>
                                    
                                </td>
                            </tr>
                            @endforeach
                            
                            <tr>
                                <th>商品総合計（A）</th>
                                <td><span style="font-size: 1.2em;">¥{{ number_format($saleRel->all_price) }}</span></td>
                            </tr>
                            
                            <tr>
                                <th>送料（B）</th>
                                <td>
                                	<span style="font-size: 1.2em;">¥{{ number_format($saleRel->deli_fee) }}</span>
                                </td>
                            </tr>
                            
                            <tr>
                                <th>手数料（C）</th>
                                <td>
                                	¥{{ number_format($saleRel->cod_fee) }}
                                	@if($saleRel->pay_method == 2)
                                    （コンビニ決済）
                                    @elseif($saleRel->pay_method == 4)
                                    （GMO後払い）
                                    @endif
                                	
                                </td>
                            </tr>
                            
                            <tr>
                                <th>ポイント利用（D）</th>
                                <td>
	                                {{ $saleRel->use_point }}
                                </td>
                            </tr>
                            
                            <tr>
                                <th>購入総合計<br>（A+B+C-D）</th>
                                <?php 
                                	//$total = $sale->total_price + $sale->deli_fee + $sale->cod_fee;
                                	$total = $saleRel->all_price + $saleRel->deli_fee + $saleRel->cod_fee - $saleRel->use_point;
                                ?>
                                <td>
                                	<span style="font-size: 1.3em;" class="text-success"><b>¥{{ number_format($total) }}</b></span><br>
                                
                                    @if($saleRel->pay_method == 6)
                                        @if($saleRel->pay_done)
                                            <span class="text-success">入金済み</span>
                                        @else
                                            <span class="text-danger">未入金</span>
                                        @endif
                                    @endif
                                </td>
                            </tr>
                            
                            <tr>
                                <th>粗利額</th>
                                <td>
                                <?php
                                    $taxPer = Setting::get()->first()->tax_per;
                                    $taxPer = $taxPer/100 + 1; //$taxPer ->1.08

                                    $tax = $saleRel->all_price - ($saleRel->all_price / $taxPer); //$taxPer ->1.08

                                    $arari = $total - $tax - $sales->sum('cost_price') - $sales->sum('charge_loss');
                                ?>
                                                                
                                ¥{{ number_format($arari) }}
                                </td>
                            </tr>
                            <tr>
                                <th>粗利率</th>
                                <td>{{ round($arari / $total * 100, 1) }}%</td>
                            </tr>
                            
                            
                            @if($saleRel->pay_method == 2 || $saleRel->pay_method == 6)
                            <tr>
                                <th>入金</th>
                           
                                <td class="clearfix">
                                	<fieldset class="form-group checkbox">
                                        <label>
                                            <?php
                                                $checked = '';
                                                if(Ctm::isOld()) {
                                                    if(old('pay_done'))
                                                        $checked = ' checked';
                                                }
                                                else {
                                                    if(isset($saleRel) && $saleRel->pay_done) {
                                                        $checked = ' checked';
                                                    }
                                                }
                                            ?>
                                            <input type="checkbox" name="pay_done" value="1"{{ $checked }}> 入金済みにする
                                        </label>
                                    </fieldset>   
                                </td>
                            </tr>
                            @endif
                            
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
                
                <div class="mt-3 mb-5">
                	<fieldset class="mb-2 form-group{{ $errors->has('information') ? ' is-invalid' : '' }}">
                        <label for="detail" class="control-label">ご連絡事項（ユーザー反映）</label>

                            <textarea id="information" class="form-control" name="information" rows="8">{{ Ctm::isOld() ? old('information') : (isset($saleRel) ? $saleRel->information : '') }}</textarea>

                            @if ($errors->has('information'))
                                <span class="help-block">
                                    <strong class="text-danger">{{ $errors->first('information') }}</strong>
                                </span>
                            @endif
                    </fieldset>   
                </div>
                
                
                <div class="btn-box mt-4">
                	<h5 class="mb-4"><i class="fa fa-envelope"></i> メール送信</h5>
                
                    @if($saleRel->pay_method == 2 || $saleRel->pay_method == 6 || Ctm::isEnv('local'))
                        
                        {{-- @if( ! $saleRel->pay_done || Ctm::isEnv('local'))  --}}                   
                            <div class="form-group clearfix my-3">
                                <button type="submit" class="btn btn-danger col-md-5 text-white py-2" name="with_paydone" value="{{ $templs['payDone'] }}"><i class="fa fa-yen"></i> 入金済メール送信</button>
                            </div>
                        {{-- @endif --}}
                    @endif
                    
                    <div class="clearfix">
                        <div class="form-group clearfix my-3 w-50 float-left">
                            <button type="submit" class="btn btn-success col-md-10 text-white py-2" name="with_mail" value="{{ $templs['thanks'] }}"><i class="fa fa-thumbs-up"></i> サンクスメール送信</button>
                        </div>
                        
                        <div class="form-group clearfix my-3 w-50 float-left">
                            <button type="submit" class="btn btn-warning col-md-10 text-white py-2" name="with_mail" value="{{ $templs['stockNow'] }}"><i class="fa fa-check"></i> 在庫確認中メール送信</button>
                        </div>
                        
                        <div class="form-group clearfix my-3 w-50 float-left">
                            <button type="submit" class="btn btn-purple col-md-10 text-white py-2" name="with_mail" value="{{ $templs['howToUe'] }}"><i class="fa fa-check"></i> 植え付け方法メール送信</button>
                        </div>

                        
                        <div class="form-group clearfix my-3 w-50 float-left">
                            <button type="submit" class="btn btn-info col-md-10 text-white py-2" name="with_mail" value="{{ $templs['deliDoneNo'] }}"><i class="fa fa-truck"></i> 出荷完了（伝票番号未確認）メール送信</button>
                        </div>
                        
                        <div class="form-group clearfix my-3 w-50 float-left">
                            <button type="submit" class="btn btn-info col-md-10 text-white py-2" name="with_mail" value="{{ $templs['deliDone'] }}"><i class="fa fa-truck"></i> 出荷完了メール送信</button>
                        </div>
                        
                        <div class="form-group clearfix my-3 w-50 float-left">
                            <button type="submit" class="btn btn-danger col-md-10 text-white py-2" name="with_mail" value="{{ $templs['cancel'] }}"><i class="fa fa-times"></i> キャンセルメール送信</button>
                        </div>
                    </div>
                
                </div>
                
                <div class="mt-5 pt-3">
                	<fieldset class="mt-5 mb-2 form-group{{ $errors->has('memo') ? ' is-invalid' : '' }}">
                        <label for="memo" class="control-label">メモ<span class="text-small">（内部のみ）</span></label>

                            <textarea id="memo" class="form-control" name="memo" rows="10">{{ Ctm::isOld() ? old('memo') : (isset($saleRel) ? $saleRel->memo : '') }}</textarea>

                            @if ($errors->has('memo'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('memo') }}</strong>
                                </span>
                            @endif
                    </fieldset>
                    
                    <fieldset class="mb-2 form-group{{ $errors->has('craim') ? ' is-invalid' : '' }}">
                        <label for="detail" class="control-label">クレーム<span class="text-small">（内部のみ）</span></label>

                            <textarea id="detail" class="form-control" name="craim" rows="10">{{ Ctm::isOld() ? old('craim') : (isset($saleRel) ? $saleRel->craim : '') }}</textarea>

                            @if ($errors->has('craim'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('craim') }}</strong>
                                </span>
                            @endif
                    </fieldset>
                    
                    <div class="form-group float-left w-25 mt-3">
                        <button type="submit" class="btn btn-primary btn-block w-btn w-100 text-white" name="only_up" value="1"> 更新のみする</button>
                    </div>
                </div>
        </form>
        
    </div>

@endsection
