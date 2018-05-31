@extends('layouts.appDashBoard')

@section('content')

    <div class="text-left">
		<h1 class="Title"> 売上一覧</h1>
		<p class="Description"></p>
    </div>


    <div class="row">


    </div>
    <!-- /.row -->


  
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

    {{ $saleObjs->links() }}


    <!-- Example DataTables Card-->
    <div style="overflow:scroll;" class="col-md-12">
    <div class="mb-3">
    	

        <div style="width: 130%;" class="">
          <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover bg-white"{{-- id="dataTable"--}} width="100%" cellspacing="0">
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
                  <th></th>
                </tr>
              </thead>
              
              <tbody>
              @foreach($saleObjs as $sale)
                <tr>
                	<?php
                 		$saleRel = $saleRels->find($sale->salerel_id);
                 	?>   
                	<td><a href="{{url('dashboard/sales/'. $sale->id)}}" class="btn btn-success btn-sm center-block">確認</a></td>
                  <td>{{ $sale->id }}</td>
                  <td>{{ $saleRel->order_number }}</td>
                  <td>({{ $sale->item_id }}){{ $items->find($sale->item_id)->title }}</td>
                  <td>
                  	 @if($sale->deli_done)
                       <span class="text-success">発送済み</span>
                     @else
                      <span class="text-danger">未配送</span>
                    @endif   
                  </td>
                  <td>{{ $sale->item_count }}</td>
                  <td>¥{{ number_format($sale->total_price) }}</td>
                  <td>¥{{ number_format($sale->deli_fee) }}</td>
                  <td>¥{{ number_format($sale->cod_fee) }}</td>
                  <td>{{ $pms->find($sale->pay_method)->name }}</td>
                  <td></td>
                  <td></td>
                  <td>
                  	@if($saleRel->is_user)
                		<span class="text-primary">会員</span>:{{ $users->find($saleRel->user_id)->name }}さん
                	@else
                 		<span class="text-danger">非会員</span>:{{ $userNs->find($saleRel->user_id)->name }}さん
                 	@endif   
                </td>
                  
                  <td>{{ Ctm::changeDate($sale->created_at, 0) }}</td>
                  
                  <td><a href="{{url('dashboard/sales/'. $sale->id)}}" class="btn btn-success btn-sm center-block">確認</a></td>
                  
                  <td></td>
                </tr>
            @endforeach

              </tbody>
            </table>
          </div>
        </div>

        <!-- <div class="card-footer small text-muted"></div> -->

    </div><!-- /.card -->
    </div>
    </div>
    
    {{ $saleObjs->links() }}

        
@endsection

