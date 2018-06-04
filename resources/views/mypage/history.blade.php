@extends('layouts.app')

@section('content')


	{{-- @include('main.shared.carousel') --}}

<div id="main" class="top">

        <div class="panel panel-default">

            <div class="panel-body">
                {{-- @include('main.shared.main') --}}

				<div class="main-list clearfix">



<div class="">

<h3 class="mb-3 card-header">購入履歴一覧</h3>
<div class="table-responsive table-custom">
    <table class="table table-borderd border bg-white">
        <thead>
        <tr>
        	<th>購入日</th>
        	<th>注文番号</th>
         	<th>商品名</th>
          	<th>個数</th>
           	<th>お支払い方法</th>
			<th>残 枯れ保証期間</th>
   			<th></th>         
        </tr>
        </thead>
        
        <tbody>
        @foreach($sales as $sale)
        <tr>
             <td>{{ Ctm::changeDate($sale->created_at, 1) }}</td>
             <td>{{ $sale->order_number }}</td>
             <td>
             	<?php $i = $item->find($sale->item_id); ?>
              	<img src="{{ Storage::url($i->main_img) }}" width="75" height="75">  
             	{{ $i->title }}
            </td>
             <td>{{ $sale->item_count }}</td>
             <td>{{ $pm->find($sale->pay_method)->name }}</td>
             <td>
             	<?php
              		$limit = strtotime($sale->created_at." +91 day");
                	$limitDay = new DateTime(date('Y-m-d', $limit));
                 	$current = new DateTime('now');
					$diff = $current->diff($limitDay);
          			//echo $diff->days;
                	
//                    $limit = $limit - strtotime("now");  
//                     $days = (strtotime('Y-m-d', $limit) - strtotime("1970-01-01")) / 86400;   
          
                	//echo $days;
                 	//exit;         
              	?> 
               {{ date('Y/m/d', $limit) }}まで<br>
               残{{ $diff->days }}日     
             </td>
             <td></td>
        </tr>
        @endforeach
        
        </tbody>
        
	</table>
</div>

<a href="{{ url('mypage') }}" class="btn border-secondary bg-white mt-5">
<i class="fas fa-angle-double-left"></i> マイページに戻る
</a>                  

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


