@extends('layouts.app')

@section('content')


	{{-- @include('main.shared.carousel') --}}

<div id="main" class="history">

        <div class="panel panel-default">

            <div class="panel-body">
                {{-- @include('main.shared.main') --}}


<h3 class="mb-3 card-header">購入履歴一覧</h3>
@if(! count($sales) > 0)
<div>
	<p style="min-height: 350px;">まだ購入した商品がありません。</p>
</div>
@else

    @if(! Ctm::isAgent('sp'))
    <div class="table-responsive table-cart">
    <table class="table table-bordered bg-white">
        <thead>
        <tr>
        	<th>購入日/<br>ご注文番号</th>
         	<th>商品名</th>
          	<th>数量</th>
           	<th>金額合計（税込）</th>
			<th>枯れ保証期間 残</th>
   			<th></th>         
        </tr>
        </thead>
        
        <tbody>
        @foreach($sales as $sale)
        <tr>
             <td>
             	{{ Ctm::changeDate($sale->created_at, 1) }}
            	<p class="mt-2"><small>ご注文番号</small><br>{{ $sale->order_number }}</p>
            </td>
            <td class="clearfix">
            	<?php $i = $item->find($sale->item_id); ?>
                
                @if(isset($i->main_img) && $i->main_img != '')
                <img src="{{ Storage::url($i->main_img) }}" alt="{{ $i->title }}" class="img-fluid" width="80">
                @else
                <span class="no-img mr-2">No Image</span>
                @endif
                
            	
            
            	<div class="">
             	{{ Ctm::getItemTitle($i) }}&nbsp;
              	[{{ $i->number }}]
               <span class="d-block mt-1">¥{{ number_format($sale->single_price) }}（税込）</span> 
               </div>
            </td>
             <td>{{ $sale->item_count }}</td>
             <td>
             	¥{{ number_format($sale->total_price) }}<br>
             	[{{ $pm->find($sale->pay_method)->name }}]
            </td>
             <td>
             	@if($i->is_ensure)
                    @if($sale->deli_done)
                    <?php 
                       $days = Ctm::getKareHosyou($sale->deli_start_date);   
                    ?>
                    @if($days['diffDay'])
                		{{ $days['limit'] }}まで<br>
                   		<b>残{{ $days['diffDay'] }}日</b>
                    @else
                    	{{ $days['limit'] }}にて<br>
                    	<b>枯れ保証期間終了</b>
                    @endif
                    
                    <?php
    //                      $limit = strtotime($sale->created_at." +91 day");
    //                    $limitDay = new DateTime(date('Y-m-d', $limit));
    //                     $current = new DateTime('now');
    //                    $diff = $current->diff($limitDay);
                        //echo $diff->days;
                        
    //                    $limit = $limit - strtotime("now");  
    //                     $days = (strtotime('Y-m-d', $limit) - strtotime("1970-01-01")) / 86400;   
              
                        //echo $days;
                        //exit;         
                    ?> 
                    @else
                    未発送
                    @endif
                  @else
                  枯れ保証なし
                  @endif
             </td>
             <td>
             	<a href="{{ url('mypage/history/'.$sale->id) }}" class="btn btn-block border-secondary bg-white text-small mb-3 w-100 rounded-0">
                詳細を確認
                </a>
                
                <form class="form-horizontal" role="form" method="POST" action="{{ url('shop/cart') }}">
                    {{ csrf_field() }}
                                                                           
                    <input type="hidden" name="item_count[]" value="1">
                    <input type="hidden" name="from_item" value="1">
                    <input type="hidden" name="item_id[]" value="{{ $i->id }}">
                    <input type="hidden" name="uri" value="{{ Request::path() }}"> 
                                      
                   <button class="btn btn-custom text-small text-center w-100" type="submit" name="regist_off" value="1">もう一度購入</button>                 
				</form>
             </td>
        </tr>
        @endforeach
        
        </tbody>
        
    @else
    <div class="table-responsive">
    <table class="table table-bordered bg-white">
        	<tbody>
            	@foreach($sales as $sale)
        		<tr>
                     <td class="clearfix mb-1">
                        <p>
                        	購入日：{{ Ctm::changeDate($sale->created_at, 1) }}<br>
                        	ご注文番号：{{ $sale->order_number }}
                        </p>
                        
                        <?php $i = $item->find($sale->item_id); ?>
                        
                        @if(isset($i->main_img) && $i->main_img != '')
                        <img src="{{ Storage::url($i->main_img) }}" alt="{{ $i->title }}" class="d-block img-fluid float-left mr-2" width="70">
                        @else
                        <span class="no-img mr-2">No Image</span>
                        @endif
                        
                        
                    
                        <div class="float-left w-70">
                            <b>{{ Ctm::getItemTitle($i) }}</b>&nbsp;
                            [{{ $i->number }}]
                           <span class="d-block mt-1">¥{{ number_format($sale->single_price) }}（税込）</span> 
                           
                           数量:{{ $sale->item_count }}
                           
                           <p>金額合計（税込）:<b>
                           ¥{{ number_format($sale->total_price) }}&nbsp;&nbsp;
             				<small>[{{ $pm->find($sale->pay_method)->name }}]</small></b>
                        	</p>
                       
                       		枯れ保証期間 残：<b>
                    		@if($i->is_ensure)
                                @if($sale->deli_done)
                                    <?php 
                                       $days = Ctm::getKareHosyou($sale->deli_start_date);   
                                    ?>
                                    @if($days['diffDay'])
                                        {{ $days['limit'] }}まで<br>
                                        <b>残{{ $days['diffDay'] }}日</b>
                                    @else
                                        {{ $days['limit'] }}にて<br>
                                        <b>枯れ保証期間終了</b>
                                    @endif
                                

                                @else
                                    未発送
                                @endif
                            @else
                              枯れ保証なし
                            @endif
                            </b>
                       </div>
                       
                       
                       <div class="w-50 float-right mt-3">
                       		<a href="{{ url('mypage/history/'.$sale->id) }}" class="btn btn-block border-secondary text-small bg-white mb-2 w-100 rounded-0">詳細を確認</a>
                            
                            <form class="form-horizontal" role="form" method="POST" action="{{ url('shop/cart') }}">
                                {{ csrf_field() }}
                                                                                       
                                <input type="hidden" name="item_count[]" value="1">
                                <input type="hidden" name="from_item" value="1">
                                <input type="hidden" name="item_id[]" value="{{ $i->id }}">
                                <input type="hidden" name="uri" value="{{ Request::path() }}"> 
                                                  
                               <button class="btn btn-custom text-center text-small w-100" type="submit" name="regist_off" value="1">もう一度購入</button>                 
                            </form>
                       </div>
                       
                       
                    </td>
                </tr>
                @endforeach
                    
            </tbody>
        
    @endif
        
	</table>
</div>

<div>
    {{ $sales->links() }}
</div>
@endif


<a href="{{ url('mypage') }}" class="btn border border-secondary bg-white mt-5">
<i class="fal fa-angle-double-left"></i> マイページに戻る
</a>                  


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


