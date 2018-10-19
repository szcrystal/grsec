@extends('layouts.appDashBoard')

@section('content')

<?php
use App\SaleRelation;
use App\Setting;
?>

    <div class="text-left">
		<h1 class="Title"> 売上一覧</h1>
		<p class="Description"></p>
    </div>


    <div class="mb-3">
    	@if (count($errors) > 0)
            <div class="alert alert-danger py-1">
                <ul class="px-2">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

		<form class="form-horizontal" role="form" method="GET" action="/dashboard/sales">
        
		<select class="form-control col-md-2 d-inline{{ $errors->has('first_y') ? ' is-invalid' : '' }}" name="first_y">
            <option selected disabled>--</option>
            <?php
                $yNow = date('Y');
                $y = 2018;
            ?>
            @while($y <= $yNow)
                <?php
                    $selected = '';
                    if(Ctm::isOld()) {
                        if(old('first_y') == $y)
                            $selected = ' selected';
                    }
                    else {
                        if(Request::has('first_y') && Request::input('first_y') == $y) {
                        //if(Session::has('all.data.user')  && session('all.data.user.birth_year') == $y) {
                            $selected = ' selected';
                        }
                    }
                ?>
                <option value="{{ $y }}"{{ $selected }}>{{ $y }}</option>
                
                <?php $y++; ?>
            
            @endwhile
        </select>
        <span class="mr-2">年</span>
        
       
        
        <select class="form-control col-md-1 d-inline{{ $errors->has('first_m') ? ' is-invalid' : '' }}" name="first_m">
            <option selected disabled>--</option>
            <?php
                $m = 1;
            ?>
            @while($m <= 12)
                <?php
                    $selected = '';
                    if(Ctm::isOld()) {
                        if(old('first_m') == $m)
                            $selected = ' selected';
                    }
                    else {
                        if(Request::has('first_m') && Request::input('first_m') == $m) {
                        //if(Session::has('all.data.user')  && session('all.data.user.birth_month') == $m) {
                            $selected = ' selected';
                        }
                    }
                ?>
                <option value="{{ $m }}"{{ $selected }}>{{ $m }}</option>
                
                <?php $m++; ?>
            
            @endwhile
        </select>
        <span class="mr-2">月</span>
        
        
        <b>〜</b>&nbsp;&nbsp;&nbsp;
        
        <select class="form-control col-md-2 d-inline{{ $errors->has('last_y') ? ' is-invalid' : '' }}" name="last_y">
            <option selected disabled>--</option>
            <?php
                $yNow = date('Y');
                $y = 2018;
            ?>
            @while($y <= $yNow)
                <?php
                    $selected = '';
                    if(Ctm::isOld()) {
                        if(old('last_y') == $y)
                            $selected = ' selected';
                    }
                    else {
                        if(Request::has('last_y') && Request::input('last_y') == $y) {
                        //if(Session::has('all.data.user')  && session('all.data.user.birth_year') == $y) {
                            $selected = ' selected';
                        }
                    }
                ?>
                <option value="{{ $y }}"{{ $selected }}>{{ $y }}</option>
                
                <?php $y++; ?>
            
            @endwhile
        </select>
        <span class="mr-2">年</span>
        

        
        <select class="form-control col-md-1 d-inline{{ $errors->has('last_m') ? ' is-invalid' : '' }}" name="last_m">
            <option selected disabled>--</option>
            <?php
                $m = 1;
            ?>
            @while($m <= 12)
                <?php
                    $selected = '';
                    if(Ctm::isOld()) {
                        if(old('last_month') == $m)
                            $selected = ' selected';
                    }
                    else {
                        if(Request::has('last_m') && Request::input('last_m') == $m) {
                        //if(Session::has('all.data.user')  && session('all.data.user.birth_month') == $m) {
                            $selected = ' selected';
                        }
                    }
                ?>
                <option value="{{ $m }}"{{ $selected }}>{{ $m }}</option>
                
                <?php $m++; ?>
            
            @endwhile
        </select>
        <span class="mr-2">月</span>
        
        
        
        <button type="submit" name="set" value="1" class="btn btn-info ml-2 mr-4">送 信</button>
        <a href="{{ url('dashboard/sales') }}" class="btn border border-secondary bg-white"><span class="text-secondary">クリア</span></a>
        </form>
        
        
        <div class="mt-3 text-big">
        	@if(Request::has('set'))
            	<?php 
                	$total = $saleObjs->sum('all_price')
                        	+ $saleObjs->sum('deli_fee') 
                        	+ $saleObjs->sum('cod_fee')
                        	- $saleObjs->sum('use_point');
                ?>
            	<p class="mb-0">売上 計：¥{{ number_format($total) }}</p>
                <?php
                	$taxPer = Setting::get()->first()->tax_per;
                    $taxPer = $taxPer/100 + 1; //$taxPer ->1.08

                	$tax = $saleObjs->sum('all_price') - ($saleObjs->sum('all_price') / $taxPer); //$taxPer ->1.08
//                    echo $tax. "<br>";
//                    echo $saleObjs->sum('cost_price'). "<br>";
//                    echo $saleRelForSum->sum('take_charge_fee'). "<br>";
//                    echo $saleRelForSum->sum('all_price') . "<br>";
                    $arari = $total - $tax - $saleForSum->sum('cost_price') - $saleForSum->sum('charge_loss');
                ?>
                <p>粗利 計：¥{{ number_format($arari) }}</p>
                
            @else
            
            @endif
        	{{-- $saleObjs->sum('total_price') + $saleObjs->sum('deli_fee') + $saleObjs->sum('cod_fee') --}}
            
        </div>

    </div>

	<div class="mb-4 text-right">
        <a href="{{ url('dashboard/sales/csv') }}" class="btn btn-light border border-secondary px-3">CSV DL</a>
    </div>
  
    {{--
    <div class="row -row-compact-sm -row-compact-md -row-compact-lg">
      <div class="col-sm-12 col-md-6 col-lg-6 col-xl-5 -sameheight">
        <div class="Card DashboardStats">
            <form role="form" method="POST" action="">
                <div class="form-group input-group">
                    <input type="text" class="form-control">
                    <span class="input-group-btn">
                        <button class="btn btn-secondary" type="button"><i class="fa fa-search"></i></button>
                    </span>
                </div>
            </form>
          </div>
    	</div>
  	</div>
   --}}   


	<div class="row">
	@if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif
    </div>

    {{-- $saleObjs->links() --}}

    {{--
	<style>
    	#dataTable_filter input[type="search"] {
        	margin-right: 30em;
        }
    </style>
    --}}
	
    
    
    <!-- Example DataTables Card-->
    <div class="mb-3">
    	

        <div class="mt-3">
          <div class="table-responsive">
            <table id="dataTable" class="table table-striped table-bordered table-hover bg-white"{{-- id="dataTable"--}} width="100%" cellspacing="0">
              <thead>
                <tr>
                	<th>ID</th>
                    
                  <th>購入日</th>
                  <th>注文番号</th>
                  <th>購入者</th>
                  <th>決済方法</th>
                  <th>発送状況/出荷日</th>
                  <th>メモ</th>
                  <th>金額計（税込）</th>
                  <th>リピ情報</th>
                  
                  <th></th>
                </tr>
              </thead>
              
              {{--
              <tfoot>
              	<tr>
                	<th></th>
                  <th>ID</th>
                  <th>注文番号</th>
                  <th>(ID)商品名</th>
                  <th></th>
                
                </tr>
              </tfoot>
              --}}
              
              <tbody>
              @foreach($saleObjs as $saleRel)
                <tr>
                	<?php
                 		$sales = $saleSingle->where('salerel_id', $saleRel->id)->get();
                 	?>   
                	
                    {{-- <td><a href="{{ url('dashboard/sales/order/'. $saleRel->order_number) }}" class="btn btn-success btn-sm center-block">確認</a></td> --}}
                  <td>{{ $saleRel->id }}</td>
                  
                  <td><b>{{ Ctm::changeDate($saleRel->created_at, 0) }}</b></td>
                  
                  <td><span class="text-small">{{ $saleRel->order_number }}</span></td>
                  
                  <td>
                  	@if($saleRel->is_user)
                		<span class="text-primary"><small>会員</small></span><br>{{ $users->find($saleRel->user_id)->name }}
                	@else
                 		<span class="text-danger"><small>非会員</small></span><br>{{ $userNs->find($saleRel->user_id)->name }}
                 	@endif   
                </td>

                  <td>
                  	@if($saleRel->pay_method == 6)
                        <a href="{{ url('dashboard/sales/order/'. $saleRel->order_number) }}">
                            {{ $pms->find($saleRel->pay_method)->sec_name }}<br>

                            @if($saleRel->pay_done)
                                <span class="text-success"><small>入金済</small></span>
                            @else
                                <span class="text-danger"><small>未入金</small></span>
                            @endif
                        </a>
                	@else
                    	{{ $pms->find($saleRel->pay_method)->sec_name }}
                    @endif
                	</td>
                  
                  
                  <td>
                  	<small>
                    商品数：{{ count($sales) }}<br>
                  	@foreach($sales as $sale)
                    	@if($sale->deli_done)
                           <a href="{{ url('dashboard/sales/'.$sale->id) }}">
                               <span class="text-success">済</span>
                               {{ Ctm::changeDate($sale->deli_start_date, 1) }}
                           </a><br>
                         @else
                         	<a href="{{ url('dashboard/sales/'.$sale->id) }}">
                          		<span class="text-danger">未</span>
                          	</a><br>
                        @endif 
                    @endforeach
                    </small>
                  </td>
                  
                  <td style="line-height: 1em;">
                  	<small>
                        @foreach($sales as $sale)
                        	@if($sale->memo != '')
                                {{ Ctm::shortStr($sale->memo, 15) }}
                                <hr class="my-1">
                            @endif
                        @endforeach
                    </small>
                  
                  
                  
                  </td>
                  
                  <td>
                  	¥{{ number_format($saleRel->all_price + $saleRel->deli_fee + $saleRel->cod_fee) }}<br>
                  </td>
                  
                  <td>
                	<?php 
                    	
                    	$repes = SaleRelation::whereNotIn('id', [$saleRel->id])->where(['is_user'=>$saleRel->is_user, 'user_id'=>$saleRel->user_id])->get();
                    	
                    ?>
                    @if(count($repes) > 0)
                    	@foreach($repes as $repe)
                        	<a href="{{ url('dashboard/sales/order/'. $repe->order_number) }}" class="text-small">{{ Ctm::changeDate($repe->created_at, 1) }}</a><br>
                        @endforeach
                    @else
                    	<span>--</span>
                    @endif
                    
                    
                  
                  </td>
 
                  <td>
                  	<a href="{{ url('dashboard/sales/order/'. $saleRel->order_number) }}" class="btn btn-success btn-sm center-block">確認</a><br>
                	<small class="text-secondary ml-1">ID{{ $saleRel->id }}</small>
                </td>
                  
                </tr>
            @endforeach

              </tbody>
            </table>
          </div>
        </div>

        <!-- <div class="card-footer small text-muted"></div> -->

    </div>
    </div>
    
    {{-- $saleObjs->links() --}}

        
@endsection

