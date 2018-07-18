@extends('layouts.appDashBoard')

@section('content')

    <div class="text-left">
		<h1 class="Title"> 売上一覧</h1>
		<p class="Description"></p>
    </div>


    <div class="mb-4 pb-3">

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
        
        @if ($errors->has('first_y'))
            <div class="help-block text-danger">
                <span class="fa fa-exclamation form-control-feedback"></span>
                <span>{{ $errors->first('first_y') }}</span>
            </div>
        @endif
        
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
        
        @if ($errors->has('first_m'))
            <div class="help-block text-danger">
                <span class="fa fa-exclamation form-control-feedback"></span>
                <span>{{ $errors->first('first_m') }}</span>
            </div>
        @endif
        
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
                        if(old('user.birth_year') == $y)
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
        
        @if ($errors->has('last_y'))
            <div class="help-block text-danger">
                <span class="fa fa-exclamation form-control-feedback"></span>
                <span>{{ $errors->first('last_y') }}</span>
            </div>
        @endif
        
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
        
        @if ($errors->has('last_m'))
            <div class="help-block text-danger">
                <span class="fa fa-exclamation form-control-feedback"></span>
                <span>{{ $errors->first('last_m') }}</span>
            </div>
        @endif
        
        
        <button type="submit" name="set" value="1" class="btn btn-info ml-2 mr-4">送 信</button>
        <a href="{{ url('dashboard/sales') }}" class="btn border border-secondary bg-white"><span class="text-secondary">クリア</span></a>
        </form>
        
        
        <div class="mt-3 text-big">
        	@if(isset($saleRelForSum))
            	<?php 
                	$total = 
                    	$saleRelForSum->sum('all_price') + 
                        $saleRelForSum->sum('deli_fee') + 
                        $saleRelForSum->sum('cod_fee') - 
                        $saleRelForSum->sum('use_point');
                ?>
            	<p class="mb-0">売上 計：¥{{ number_format($total) }}</p>
                <?php
                	$tax = $saleRelForSum->sum('all_price') - ($saleRelForSum->sum('all_price') / 1.08);
//                    echo $tax. "<br>";
//                    echo $saleObjs->sum('cost_price'). "<br>";
//                    echo $saleRelForSum->sum('take_charge_fee'). "<br>";
//                    echo $saleRelForSum->sum('all_price') . "<br>";
                    $arari = $total - $tax - $saleObjs->sum('cost_price') - $saleRelForSum->sum('take_charge_fee');
                ?>
                <p>粗利 計：¥{{ number_format($arari) }}</p>
                
            @else
            
            @endif
        	{{-- $saleObjs->sum('total_price') + $saleObjs->sum('deli_fee') + $saleObjs->sum('cod_fee') --}}
            
        </div>

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
    	

        <div class="">
          <div class="table-responsive">
            <table id="dataTable" class="table table-striped table-bordered table-hover bg-white"{{-- id="dataTable"--}} width="100%" cellspacing="0">
              <thead>
                <tr>
                	<th></th>
                  <th>ID</th>
                  <th>注文番号</th>
                  <th>(ID)商品名</th>
                  <th>発送状況</th>
                  <th>個数</th>
                  <th>金額（税込）</th>
                  <th>送料</th>
                  <th>代引手数料</th>
                  <th>決済方法</th>
                  <th>粗利額</th>
                  <th>粗利率</th>
                  <th>会員</th>
                  <th>購入日</th>
                  
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
                  <th>発送状況</th>
                  <th>個数</th>
                  <th>{{ $saleObjs->sum('total_price') }}</th>
                  <th>{{ $saleObjs->sum('deli_fee') }}</th>
                  <th>代引手数料</th>
                  <th>決済方法</th>
                  <th>粗利額</th>
                  <th>粗利率</th>
                  <th>会員</th>
                  <th>購入日</th>
                  
                  <th></th>
                
                </tr>
              </tfoot>
              --}}
              
              <tbody>
              @foreach($saleObjs as $sale)
                <tr>
                	<?php
                 		$saleRel = $saleRels->find($sale->salerel_id);
                 	?>   
                	
                    {{-- <td><a href="{{ url('dashboard/sales/order/'. $sale->order_number) }}" class="btn btn-success btn-sm center-block">確認</a></td> --}}
                  <td>{{ $sale->id }}</td>
                  
                  <td>{{ Ctm::changeDate($sale->created_at, 0) }}</td>
                  
                  <td>{{ $sale->order_number }}</td>
                  
                  <td>
                  	@if($sale->is_user)
                		<span class="text-primary">会員</span>:{{ $users->find($sale->user_id)->name }}
                	@else
                 		<span class="text-danger">非会員</span>:{{ $userNs->find($sale->user_id)->name }}
                 	@endif   
                </td>
                
                
                  
                  <td>
                  	@if($sale->pay_method == 6)
                    <a href="{{ url('dashboard/sales/order/'. $sale->order_number) }}">
                    	{{ $pms->find($sale->pay_method)->name }}<br>
                        <?php
                        	$payDone = $sale->pay_done;
                        ?>
                        @if($payDone)
                        	<span class="text-success"><small>入金済み</small></span>
                        @else
                        	<span class="text-danger"><small>未入金</small></span>
                        @endif
                    </a>
                	@else
                    	{{ $pms->find($sale->pay_method)->name }}
                    @endif
                	</td>
                  
                  
                  <td>出荷日</td>
                  
                  <td>
                  	 @if($sale->deli_done)
                       <span class="text-success">発送済み</span>
                     @else
                      <span class="text-danger">未発送</span>
                    @endif   
                  </td>
                  
                  <td>{{ $sale->item_count }}</td>
                  
                  <td>
                  	¥{{ number_format($sale->total_price) }}<br>
                  	¥{{ number_format($sale->deli_fee) }}<br>
                    ¥{{ number_format($sale->cod_fee) }}<br>
                  </td>
                  
                  
                  
                  
                  <td><a href="{{ url('dashboard/sales/order/'. $sale->order_number) }}" class="btn btn-success btn-sm center-block">確認</a></td>
                  
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

