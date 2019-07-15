@extends('layouts.app')

@section('content')

<?php
use App\Item;
?>


<div id="main" class="history">

        <div class="panel panel-default">

            <div class="panel-body">


<h3 class="mb-3 card-header">購入履歴一覧</h3>
@if(! count($sales) > 0)
<div>
	<p style="min-height: 350px;">まだ購入した商品がありません。</p>
</div>
@else

<div>
    {{ $sales->links() }}
</div>

<div class="table-responsive table-cart min-height-45">
    <table class="table">
    	        
        <tbody>
        @foreach($sales as $sale)
        
        	<?php $item = Item::find($sale->item_id); ?>
        
        	<tr>
                <th>
                	@include('main.shared.smallThumbnail')
                </th>
            
             <td class="clearfix">
             	<div class="float-left col-md-9 mt-0">
                    <div>
                    	<small>ご購入日: </small>{{ Ctm::changeDate($sale->created_at, 1) }}<br>
                    	<small>ご注文番号: </small>{{ $sale->order_number }}
                    </div>
                    
                    <div class="my-2">
                        @if($sale->is_cancel)
                            <span class="text-danger text-small"><b>キャンセル 
                            @if(isset($sale->cancel_date))
                            [{{ Ctm::changeDate($sale->cancel_date, 1) }}]
                            @endif
                            </b></span><br>
                        @else
                            @if($sale->is_keep)
                                <span class="text-success text-small"><b>お取り置き中 
                                @if(isset($sale->keep_date))
                                [{{ Ctm::changeDate($sale->keep_date, 1) }}〜]
                                @endif
                                </b></span><br> 
                            @endif
                        @endif
                        
                        <a href="{{ url('item/' . $item->id) }}">{{ Ctm::getItemTitle($item) }}</a><br>
                        
                        <span class="mr-2">[{{ $item->number }}]</span>
                        ¥{{ number_format($sale->single_price) }}（税込）
                        </span> 
                   </div>
                   
                   
                   <div class="d-none">
                   		<small>数量: </small>{{ $sale->item_count }}<br>
            

                        <small>小計: </small>¥{{ number_format($sale->total_price) }}
                        [{{ $pm->find($sale->pay_method)->name }}]<br>

                        @if($item->is_ensure)
                        	<small>枯れ保証残期間: </small>
                            @if($sale->deli_done)
                                <?php 
                                   $days = Ctm::getKareHosyou($sale->deli_schedule_date);   
                                ?>
                                
                                @if($days['diffDay'])
                                    {{ $days['limit'] }}まで 
                                    <b>残{{ $days['diffDay'] }}日</b>
                                @else
                                    {{ $days['limit'] }}にて 
                                    <b>枯れ保証期間終了</b>
                                @endif
         
                            @else
                                未発送
                            @endif
                          @else
                            枯れ保証なし
                          @endif
                    </div>
                    
                </div>
                
                <div class="mt-2 float-right col-md-3">
                	<a href="{{ url('mypage/history/'. $sale->salerel_id) }}" class="btn btn-block border-secondary bg-white text-small mb-3 w-100 rounded-0">
                    詳細を確認 <i class="fal fa-angle-double-right"></i>
                    </a>
                    
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('shop/cart') }}">
                        {{ csrf_field() }}
                                                                               
                        <input type="hidden" name="item_count[]" value="1">
                        <input type="hidden" name="from_item" value="1">
                        <input type="hidden" name="item_id[]" value="{{ $item->id }}">
                        <input type="hidden" name="uri" value="{{ Request::path() }}"> 
                                          
                       <button class="btn btn-custom text-small text-center w-100" type="submit" name="regist_off" value="1">もう一度購入</button>                 
                    </form>
                </div>
            </td>
           
        </tr>
        @endforeach
        
    </tbody>
        
     
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


