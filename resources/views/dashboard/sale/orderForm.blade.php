@extends('layouts.appDashBoard')

@section('content')
<?php
use App\Item;
use App\Setting;
use App\PayMethod;
use App\DeliveryCompany;
use App\MailTemplate;
use App\SendMailFlag;
use App\PayMethodChild;
?>




<div class="order-form-wrap">
	
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
            <a href="{{ url('/dashboard/sales') }}" class="btn bg-white border border-1 border-round border-secondary text-primary d-block mb-2"><i class="fa fa-angle-double-left" aria-hidden="true"></i> 全一覧へ戻る</a>
            
            <a href="{{ url('/dashboard/sales?done=0') }}" class="btn bg-white border border-1 border-round border-secondary text-primary d-block"><i class="fa fa-angle-double-left" aria-hidden="true"></i> 未処理一覧へ戻る</a>
        </div>
        </div>
    </div>
  </div>
  
  <div class="col-lg-12 mb-5 clearfix">

	<div class="col-lg-10 pl-0 pr-5">
    
    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <strong>Error!!</strong>
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
    
        
    
        <form class="form-horizontal" role="form" method="POST" action="/dashboard/sales/order">

            {{ csrf_field() }}
            
            
            @if(session('preview'))
            
                <div class="preview-tgl">
                	<b><i class="fa fa-times"></i></b>
                </div>
                
                <div class="mail-preview-wrap">
                	
                    <?php
                    	$templateId = old('with_preview');
                    	$typeName = MailTemplate::find($templateId)->type_name;
                    ?>
                    
                    <h5 class="p-0 mb-2"><b>{{ $typeName }}メール</b></h5>

                    <div class="mail-preview">
                        {!! session('preview') !!}
                    </div>
                    
                    <div style="margin-left: 28%;" class="form-group clearfix mt-3 w-25">
                    	<p class="text-center p-0 m-0"><b>{{ $typeName }}メール</b></p>
                        <button type="submit" class="btn btn-primary w-100 text-white py-2 d-inline-block" name="with_mail" value="{{ $templateId }}"><i class="fa fa-envelope"></i> 送信</button>
                    </div>
                    
                </div>
                
            @endif
            

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
            
            <div class="form-group w-25 mt-3">
                <button type="submit" class="btn btn-primary btn-block w-btn w-100 text-white" name="only_up" value="1"> 更新のみする</button>
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
                                    	<?php
                                        	$users = $users->find($saleRel->user_id);
                                        ?>
                                        
                                        <span class="text-dark">
                                        	会員
                                            @if(! $users->active)
                                                <span class="text-warning"><b>[退会]</b></span>
                                            @endif
                                        </span>
                                        
                                        <a href="{{ url('dashboard/users/'. $saleRel->user_id) }}">
                                    @else
                                         <span class="text-danger">非会員</span>: 
                                         <a href="{{ url('dashboard/users/'. $saleRel->user_id.'?no_r=1') }}">
                                         <?php
                                            $users = $userNs->find($saleRel->user_id);
                                        ?>   
                                     @endif
                                     （{{ $users->id }}）{{ $users->name }} <span class="text-small ml-1">（{{ $users->hurigana }}）</span><br>
                                     <a href="mailto:{{ $users->email }}">{{ $users->email }}</a><br>
                                     
                                     〒{{ Ctm::getPostNum($users->post_num) }}<br>
                                     {{ $users->prefecture }}{{ $users->address_1 }}&nbsp;{{ $users->address_2 }}
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
                                {{ $receiver->prefecture }}{{ $receiver->address_1 }}&nbsp;{{ $receiver->address_2 }}
                                {{ $receiver->address_3 }}<br>
                                {{ $receiver->name }}<span class="text-small ml-1">（{{ $receiver->hurigana }}）</span> 様<br>
                                TEL: {{ $receiver->tel_num }}
                                
                                </td>
                            </tr>
                            
                            <tr>
                                <th>コメント</th>
                                <td>
                                	{!! nl2br($saleRel->user_comment) !!}
                                </td>
                            </tr>
                                                        
                            <tr>
                                <th>決済方法</th>
                                <td>
                                	<span class="text-big"><b>{{ $pms->find($saleRel->pay_method)->name }}</b></span>
                                    @if($saleRel->pay_method == 3)
                                        <span>（{{ PayMethodChild::find($saleRel->pay_method_child)->name }}）</span>
                                    @endif
                                    
                                	@if($saleRel->pay_method == 2 && $saleRel->pay_method == 6)
                                        @if($saleRel->pay_done)
                                        <span class="text-success">(入金済み)</span>
                                        @else
                                        <span class="text-danger">(未入金)</span>
                                        @endif  
                                     @endif 
                                
                                </td>
                            </tr>
                                
                            @if($saleRel->pay_method == 1)
                            	<tr>
                                    <th>GmoID<br>クレカ登録数</th>
                                    <td>
                                        @if(isset($users->member_id))
                                            {{ $users->member_id }}<br>
                                            <small>登録数：</small>{{ $users->card_regist_count }}
                                        @else
                                            未登録<br>
                                            {{-- <p class="m-0 p-0"><span class="text-small">利用可能なGmoID：</span>{{ Ctm::getOrderNum(11) }}</p> --}}
                                        @endif
                                    </td>
                                </tr>
                            @endif

                  
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
                                                    
                                                    @if($sale->is_cancel)
                                                    	<b class="text-small text-danger">キャンセル [{{ Ctm::changeDate($sale->cancel_date) }}]</b><br>
                                                    @else
                                                        @if($sale->is_keep)
                                                            <b class="text-small text-success">取り置き中 [{{ Ctm::changeDate($sale->keep_date) }}]</b>
                                                        @endif
                                                    @endif
                                                    
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
                                                <td>
                                                	{{ $sale->item_count }}
                                                </td>
                                            </tr>
                                            
                                            <tr>
                                            	<th>合計金額（税込）</th>
                                                <td>
                                                	¥{{ number_format($sale->total_price) }}
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    
                                    <div class="text-center py-0 my-0 border bg-white text-warning open-tgl">MORE <i class="fa fa-caret-down"></i></div>
                                    
                                    <div class="table-second-wrap">
                                    <table class="table-tyumon w-100 table-striped">
                                    	<tbody>
                                        	
                                        	<tr>
                                            	<th>個別送料</th>
                                                <td>
                                                	@if(isset($sale->deli_fee))
                                                        ¥{{ number_format($sale->deli_fee) }}
                                                    @endif
                                                </td>
                                            </tr>
                                            
                                            
                                            <tr>
                                            	<th>ご希望配送日時</th>
                                                <td>
                                                	日付:
                                                	@if(isset($sale->plan_date))
                                                        {{ $sale->plan_date }}
                                                    @else
                                                    	--
                                                    @endif
                                                    ／ 時間:
                                                    @if(isset($sale->plan_time))
                                                        {{ $sale->plan_time }}
                                                    @else
                                                    	--
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
                                                <input type="hidden" name="deli_slip_num[{{ $sale->id }}]" value="{{ $sale->deli_slip_num }}">
                                            </tr>
                                            
                                            <tr>
                                            	<th>配送状況</th>
                                                <td>
                                                	@if($sale->deli_done)
                                                       <span class="text-success">発送済み（{{ date('Y/m/d H:i', strtotime($sale->deli_sended_date)) }}）</span>
                                                     @else
                                                      <span class="text-danger">未発送</span>
                                                    @endif
                                                </td>
                                            </tr>

											<tr>
                                            	<td colspan="2" class="bg-white pt-2 pb-1 pl-1 text-small"><b>メール送信</b></td>
                                            </tr>
 											
                                            <tr>
                                            	<th>サンクス</th>
                                                <td>
                                                	<?php $sendMail = SendMailFlag::where(['sale_id'=>$sale->id, 'templ_id'=>$templs['thanks']])->get(); ?>
                                                	
                                                	@if($sendMail->isNotEmpty())
                                                    <span class="text-success">済 （{{ date('Y/m/d H:i', strtotime($sendMail->first()->created_at)) }}）</span>
                                                    @else
                                                    <span class="text-danger">未</span>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                            	<th>在庫確認中</th>
                                                <td>
                                                	<?php $sendMail = SendMailFlag::where(['sale_id'=>$sale->id, 'templ_id'=>$templs['stockNow']])->get(); ?>
                                                    
                                                	@if($sendMail->isNotEmpty())
                                                    <span class="text-success">済 （{{ date('Y/m/d H:i', strtotime($sendMail->first()->created_at)) }}）</span>
                                                    @else
                                                    <span class="text-danger">未</span>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                            	<th>植え付け方法</th>
                                                <td>
                                                	<?php $sendMail = SendMailFlag::where(['sale_id'=>$sale->id, 'templ_id'=>$templs['howToUe']])->get(); ?>
                                                    
                                                	@if($sendMail->isNotEmpty())
                                                    <span class="text-success">済 （{{ date('Y/m/d H:i', strtotime($sendMail->first()->created_at)) }}）</span>
                                                    @else
                                                    <span class="text-danger">未</span>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                            	<th>出荷完了（伝票未）</th>
                                                <td>
                                                	<?php $sendMail = SendMailFlag::where(['sale_id'=>$sale->id, 'templ_id'=>$templs['deliDoneNo']])->get(); ?>
                                                    
                                                	@if($sendMail->isNotEmpty())
                                                    <span class="text-success">済 （{{ date('Y/m/d H:i', strtotime($sendMail->first()->created_at)) }}）</span>
                                                    @else
                                                    <span class="text-danger">未</span>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                            	<th>出荷完了</th>
                                                <td>
                                                	<?php $sendMail = SendMailFlag::where(['sale_id'=>$sale->id, 'templ_id'=>$templs['deliDone']])->get(); ?>
                                                    
                                                	@if($sendMail->isNotEmpty())
                                                    <span class="text-success">済 （{{ date('Y/m/d H:i', strtotime($sendMail->first()->created_at)) }}）</span>
                                                    @else
                                                    <span class="text-danger">未</span>
                                                    @endif
                                                </td>
                                            </tr>
                                            
                                            <tr>
                                            	<th>シマトネ越冬</th>
                                                <td>
                                                	<?php $sendMail = SendMailFlag::where(['sale_id'=>$sale->id, 'templ_id'=>$templs['simatone_ettou']])->get(); ?>
                                                    
                                                	@if($sendMail->isNotEmpty())
                                                    <span class="text-success">済 （{{ date('Y/m/d H:i', strtotime($sendMail->first()->created_at)) }}）</span>
                                                    @else
                                                    <span class="text-danger">未</span>
                                                    @endif
                                                </td>
                                            </tr>
                                            
                                            <tr>
                                            	<th>石灰硫黄合剤</th>
                                                <td>
                                                	<?php $sendMail = SendMailFlag::where(['sale_id'=>$sale->id, 'templ_id'=>$templs['sekkai_iou']])->get(); ?>
                                                    
                                                	@if($sendMail->isNotEmpty())
                                                    <span class="text-success">済 （{{ date('Y/m/d H:i', strtotime($sendMail->first()->created_at)) }}）</span>
                                                    @else
                                                    <span class="text-danger">未</span>
                                                    @endif
                                                </td>
                                            </tr>
                                            
                                            <tr>
                                            	<td colspan="2" class="bg-white pt-2 pb-1 pl-1 text-small"><b>ステータス</b></td>
                                            </tr>
                                            
                                            <tr>
                                            	<th>お取り置き</th>
                                                <td>
                                                	@if($sale->is_keep)
                                                        <span class="text-info">お取り置き中  
                                                            @if(isset($sale->keep_date))
                                                                {{ Ctm::changeDate($sale->keep_date, 1) }}〜
                                                            @endif
                                                        </span><br>
                                                    @else
                                                    --
                                                    @endif 
                                                </td>
                                            </tr>
                                            
                                            <tr>
                                            	<th>キャンセル状況／<br>キャンセルメール</th>
                                                <td>
                                                	@if($sale->is_cancel)
                                                    <span class="text-danger">キャンセル済
                                                    	@if(isset($sale->cancel_date))
                                                            {{ Ctm::changeDate($sale->cancel_date, 1) }}
                                                        @endif
                                                    </span><br>
                                                    @else
                                                    --<br>
                                                    <input type="hidden" name="is_cancel[{{ $sale->id }}]" value="{{ $sale->is_cancel }}">
                                                    @endif
                                                    
                                                    <?php $sendMail = SendMailFlag::where(['sale_id'=>$sale->id, 'templ_id'=>$templs['cancel']])->get(); ?>
                                                    
                                                	@if($sendMail->isNotEmpty())
                                                    <span class="text-success">済 （{{ date('Y/m/d H:i', strtotime($sendMail->first()->created_at)) }}）</span>
                                                    @else
                                                    <span class="text-danger">未</span>
                                                    @endif
                                                </td>
                                            </tr>
                                            
                                            
                                        </tbody>
                                    </table>
                                    </div>
                                	
                                    
                                    <?php 
                                    	$all += $sale->total_price;
                                     	$num++;   
                                    ?>
                                    
                                </td>
                            </tr>
                            @endforeach
                            
                            <?php
                            	//$relModel = $allCancel ? $saleRelCancel : $saleRel;
                            ?>
                            
                            <tr>
                                <th>商品総合計（税込）[A]</th>
                                <?php
                                	$taxPer = Setting::get()->first()->tax_per;
                                    $taxPer = $taxPer/100 + 1; //$taxPer ->1.08
                                    
                                	$ap = $saleRel->all_price;
                                    $zeinuki = ceil($ap / $taxPer);
                                ?>
                                <td><b style="font-size: 1.2em;">¥{{ number_format($saleRel->all_price) }}<small>（税抜／税：{{ number_format($zeinuki) }}／{{ number_format($ap - $zeinuki) }}）</small></b></td>
                            </tr>
                            
                            <tr>
                                <th>送料 [B]</th>
                                <td>
                                	<fieldset class="mt-2 mb-4 form-group">
                                        <input class="form-control col-md-6 d-inline{{ $errors->has('deli_fee') ? ' is-invalid' : '' }}" name="deli_fee" value="{{ Ctm::isOld() ? old('deli_fee') : (isset($saleRel->deli_fee) ? $saleRel->deli_fee : '') }}">
                                        
                                        @if ($errors->has('deli_fee'))
                                            <div class="text-danger">
                                                <span class="fa fa-exclamation form-control-feedback"></span>
                                                <span>{{ $errors->first('deli_fee') }}</span>
                                            </div>
                                        @endif
                                    </fieldset>
                                	{{-- <span style="font-size: 1.2em;">¥{{ number_format($saleRel->deli_fee) }}</span> --}}
                                </td>
                            </tr>
                            
                            <tr>
                                <th>手数料 [C]</th>
                                <td>
                                	@if(! $sale->cod_fee)
                                    	--
                                    @else
                                    	¥{{ number_format($saleRel->cod_fee) }} [{{ $pms->find($saleRel->pay_method)->name }}]
                                    @endif
                                	
                                </td>
                            </tr>
                            
                            <tr>
                                <th>ポイント利用 [D]</th>
                                <td>
	                                {{ $saleRel->use_point }}
                                </td>
                            </tr>
                            
                            <tr>
                                <th>購入総合計（税込）<br>[A+B+C-D]</th>
                                <?php 
                                	if(isset($saleRel->total_price)) {
                                    	$total = $saleRel->total_price;
                                    }
                                    else {
	                                	$total = $saleRel->all_price + $saleRel->deli_fee + $saleRel->cod_fee - $saleRel->use_point;
                                    }
                                ?>
                                
                                <td>
                                	<b style="font-size:1.4em;" class="text-success">¥{{ number_format($total) }}</b>
                                    
                                    @if($allCancel)
                                		<br><span class="text-danger">全キャンセル</span>
                                    @endif
                                    
                                    @if($saleRel->pay_method == 6)
                                    	<br>
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
//                                    $taxPer = Setting::get()->first()->tax_per;
//                                    $taxPer = $taxPer/100 + 1; //$taxPer ->1.08

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
                                <th>入金状況／<br>入金メール</th>
                           
                                <td class="clearfix">
                                	<fieldset class="form-group checkbox mb-0 pb-0">
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
                                    
                                    <?php $sendMail = SendMailFlag::where(['sale_id'=>$sale->id, 'templ_id'=>$templs['payDone']])->get(); ?>
                                                    
                                    @if($sendMail->isNotEmpty())
                                    <span class="text-success">メール 済 （{{ date('Y/m/d H:i', strtotime($sendMail->first()->created_at)) }}）</span>
                                    @else
                                    <span class="text-danger">メール 未</span>
                                    @endif
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
                
                <div class="mt-3">
                	<h6>ご連絡事項<small>（ユーザー反映/ホワイトボード/全てのメールテンプレに反映されるので、非反映にする場合は空にして下さい。）</small></h6>
                    
                	<fieldset class="mt-3 mb-4 form-group{{ $errors->has('information') ? ' is-invalid' : '' }}">
                        <label for="information" class="control-label">ヘッダー内（商品情報の直上部分）</label>

                        <textarea class="form-control" name="information" rows="12">{{ Ctm::isOld() ? old('information') : (isset($saleRel) ? $saleRel->information : '') }}</textarea>

                        @if ($errors->has('information'))
                            <span class="help-block">
                                <strong class="text-danger">{{ $errors->first('information') }}</strong>
                            </span>
                        @endif
                    </fieldset>
                    
                    <fieldset class="mb-2 form-group{{ $errors->has('information_foot') ? ' is-invalid' : '' }}">
                        <label for="information_foot" class="control-label">フッター内（商品情報の直下部分）</label>

                        <textarea class="form-control" name="information_foot" rows="12">{{ Ctm::isOld() ? old('information_foot') : (isset($saleRel) ? $saleRel->information_foot : '') }}</textarea>

                        @if ($errors->has('information_foot'))
                            <span class="help-block">
                                <strong class="text-danger">{{ $errors->first('information_foot') }}</strong>
                            </span>
                        @endif
                    </fieldset>
                </div>

                
                <hr class="mt-5">
                
                
                <div class="mt-3">
                	<fieldset class="mt-5 mb-2 form-group{{ $errors->has('memo') ? ' is-invalid' : '' }}">
                        <label for="memo" class="control-label">メモ<span class="text-small">（内部のみ）</span></label>

                            <textarea class="form-control" name="memo" rows="10">{{ Ctm::isOld() ? old('memo') : (isset($saleRel) ? $saleRel->memo : '') }}</textarea>

                            @if ($errors->has('memo'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('memo') }}</strong>
                                </span>
                            @endif
                    </fieldset>
                    
                    <fieldset class="mb-2 form-group{{ $errors->has('craim') ? ' is-invalid' : '' }}">
                        <label for="detail" class="control-label">クレーム<span class="text-small">（内部のみ）</span></label>

                            <textarea class="form-control" name="craim" rows="10">{{ Ctm::isOld() ? old('craim') : (isset($saleRel) ? $saleRel->craim : '') }}</textarea>

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
                
                </div><!-- wrap col-lg-12 -->
                
                
                <div class="btn-box col-lg-2 mt-4 pt-5">
                	<h5 class="mb-4"><i class="fa fa-file"></i> プレビュー確認</h5>
                    
                    <div class="clearfix">
                    
                        @if($saleRel->pay_method == 2 || $saleRel->pay_method == 6 || Ctm::isEnv('local'))
                            <div class="form-group clearfix my-3">
                                <button type="submit" class="btn btn-danger col-md-12 text-white py-2" name="with_preview" value="{{ $templs['payDone'] }}"><i class="fa fa-yen"></i> 入金済</button>
                            </div>
                        @endif
                    
                    
                        <div class="form-group clearfix my-3">
                            <button type="submit" class="btn btn-success col-md-12 text-white py-2" name="with_preview" value="{{ $templs['thanks'] }}"><i class="fa fa-thumbs-up"></i> サンクス</button>
                        </div>
                        
                        <div class="form-group clearfix my-3">
                            <button type="submit" class="btn btn-warning col-md-12 text-white py-2" name="with_preview" value="{{ $templs['stockNow'] }}"><i class="fa fa-check"></i> 在庫確認中</button>
                        </div>
                        
                        <div class="form-group clearfix my-3">
                            <button type="submit" class="btn btn-purple col-md-12 text-white py-2" name="with_preview" value="{{ $templs['howToUe'] }}"><i class="fa fa-check"></i> 植え付け方法</button>
                        </div>

                        <div class="form-group clearfix my-3">
                            <button type="submit" class="btn btn-info col-md-12 text-white py-2" name="with_preview" value="{{ $templs['deliDoneNo'] }}"><i class="fa fa-truck"></i> 出荷完了（伝番未）</button>
                        </div>
                        
                        <div class="form-group clearfix my-3">
                            <button type="submit" class="btn btn-info col-md-12 text-white py-2" name="with_preview" value="{{ $templs['deliDone'] }}"><i class="fa fa-truck"></i> 出荷完了</button>
                        </div>
                        
                        <div class="form-group clearfix my-3">
                            <button type="submit" class="btn btn-danger col-md-12 text-white py-2" name="with_preview" value="{{ $templs['cancel'] }}"><i class="fa fa-ban"></i> キャンセル</button>
                        </div>
                        
                        <div class="form-group clearfix my-3">
                            <button type="submit" class="btn btn-blue col-md-12 text-white py-2" name="with_preview" value="{{ $templs['simatone_ettou'] }}"><i class="fa fa-envelope"></i> シマトネ越冬</button>
                        </div>
                        
                        <div class="form-group clearfix my-3">
                            <button type="submit" class="btn btn-blue col-md-12 text-white py-2" name="with_preview" value="{{ $templs['sekkai_iou'] }}"><i class="fa fa-envelope"></i> 石灰硫黄合剤</button>
                        </div>
                    </div>
                
                </div>
                
        </form>
        
    </div>

</div>
@endsection



