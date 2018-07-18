@extends('layouts.app')

@section('content')


	{{-- @include('main.shared.carousel') --}}

<div id="main" class="top confirm">

        <div class="panel panel-default">

            <div class="panel-body">
                {{-- @include('main.shared.main') --}}

				<div class="main-list clearfix">


<div class="clearfix">
@include('cart.guide')

<div class="float-left col-md-8">
	<h5 class="card-header mb-3 py-2">ご注文の商品</h5>
	<div class="table-responsive table-cart">
    <table class="table table-bordered bg-white">
        <thead>
              <tr>
                <th>商品名</th>
                <th>数量</th>
                <th>金額（税込）</th>
            </tr>
          </thead>  
    
        <tbody>
             
             @foreach($itemData as $item)    
             <tr>
                
                <td>
                	<img src="{{ Storage::url($item->main_img) }}" alt="{{ $item->title }}" class="img-fluid" width=80 height=80>
                	{{ $item->title }}<br>[ {{ $item->number }} ]
                </td>
                
                <td>{{ $item->count }}</td>

                <td>
                	<b>¥{{ number_format( $item->item_total_price ) }}</b>
                
                	{{--
                	@if(isset($item->deli_time))
                    	<br><small class="pt-3">ご希望配送時間：</small><br>{{ $item->deli_time }}
                    @endif
                    --}}
                </td>

               </tr> 
             @endforeach
                          
         </tbody> 
         
    </table>
</div>


<h5 class="card-header mb-3 py-2 mt-5">配送情報</h5>
<div class="table-responsive table-custom mt-3">
    <table class="table table-borderd border bg-white">
    	<thead>
     	   <tr><th>お届け先</th></tr>
        </thead>
        
        <tbody>
        	<tr>
            <td>
        
@if(! isset($data['destination']))
    〒{{ Ctm::getPostNum($data['receiver']['post_num']) }}<br>
    {{ $data['receiver']['prefecture'] }}&nbsp;
    {{ $data['receiver']['address_1'] }}&nbsp;
    {{ $data['receiver']['address_2'] }}<br>
    {{ $data['receiver']['address_3'] }}
    <span class="d-block mt-2">{{ $data['receiver']['name'] }} 様</span>
    TEL : {{ $data['receiver']['tel_num'] }}
    
@else
	〒{{ Ctm::getPostNum($userArr['post_num']) }}<br>
	{{ $userArr['prefecture'] }}&nbsp;
    {{ $userArr['address_1'] }}&nbsp;
    {{ $userArr['address_2'] }}<br>
    {{ $userArr['address_3'] }}
    <span class="d-block mt-2">{{ $userArr['name'] }} 様</span>
    TEL : {{ $userArr['tel_num'] }}
    
@endif
	</td>
	</tr>
         </tbody> 
    </table>
</div>


<div class="table-responsive table-custom mt-3">
    <table class="table table-borderd border bg-white">
    	<thead>
     	   <tr><th>ご希望日時</th></tr>
        </thead>
        
        <tbody>
        	<tr>
            <td>
            @if(isset($data['plan_date']))
            {{ $data['plan_date'] }}<br>
            @else
            最短出荷<br>
            @endif
			
			<ul class="px-4 mt-2">
                @foreach($itemData as $item) 
                	@if(isset($item->deli_time))                   
                    <li>
                        {{ $item->title }}<br>[ {{ $item->deli_time }} ]
                    </li>
                    @endif
                @endforeach
            </ul>
            
        	</tr>
            </td>
        </tbody>
    </table>
</div>
                

@if(! Auth::check())
<h5 class="card-header mb-3 py-2 mt-5">
@if($regist)
会員登録情報
@else
お客様情報
@endif
</h5>
<div class="table-responsive table-custom">
    <table class="table border table-borderd bg-white">
        
        <tbody>
        <tr>
        	<th><label class="control-label">氏名</label></th>
         	<td>{{ $userArr['name'] }}</td>
        </tr>
        <tr>
            <th><label class="control-label">フリガナ</label></th>
             <td>{{ $userArr['hurigana'] }}</td>
        </tr>
        <tr>
            <th><label class="control-label">メールアドレス</label></th>
             <td>{{ $userArr['email'] }}</td>
        </tr>
        <tr>
            <th><label class="control-label">電話番号</label></th>
             <td>{{ $userArr['tel_num'] }}</td>
        </tr>
        <tr>
            <th><label class="control-label">性別</label></th>
             <td>
             	@if(isset($userArr['gender']))
                 {{ $userArr['gender'] }}
                @else
                	--
                @endif
            </td>
        </tr>
        <tr>
            <th><label class="control-label">生年月日</label></th>
             <td>
             	@if($userArr['birth_year'] && $userArr['birth_month'] && $userArr['birth_day'])
             		{{ $userArr['birth_year'] }}/{{ $userArr['birth_month'] }}/{{ $userArr['birth_day'] }}
               @else
               	--      
              	@endif   
            </td>
        </tr>
        <tr>
            <th><label class="control-label">住所</label></th>
             <td>〒{{ Ctm::getPostNum($userArr['post_num']) }}<br>
             		{{ $userArr['prefecture'] }}&nbsp;
             		{{ $userArr['address_1'] }}&nbsp;
                    {{ $userArr['address_2'] }}<br>
               		{{ $userArr['address_3'] }}     
             
             </td>
        </tr>
        <tr>
            <th><label class="control-label">メールマガジンの登録</label></th>
             <td>
             	@if(isset($userArr['magazine']))
                	する
                @else
                	しない
              	@endif   
            </td>
        </tr>
        
        </tbody>

	</table>
</div>
@endif

</div> 


<div class="float-right col-md-4 mt-2">
<h5 class="">&nbsp;</h5>
<div class="table-responsive table-custom show-price">
    <table class="table border table-borderd bg-white">
        
        <tbody>
        <tr>
            <th><label class="control-label">商品金額合計（税込）</label></th>
             <td>¥{{ number_format($allPrice) }}</td>
        </tr>
        <tr>
            <th><label class="control-label">送料</label></th>
            <td>¥{{ number_format($deliFee) }}</td>
        </tr>
        
        @if($data['pay_method'] == 5)
            <tr>
                <th><label class="control-label">代引き手数料</label></th>
                <td>¥{{ number_format($codFee) }}</td>
            </tr>
        @endif
        
        @if(Auth::check())
        <tr>
            <th><label class="control-label">利用ポイント</label></th>
             <td>-{{ $usePoint }}</td>
        </tr>
        @endif
        
        <tr>
            <th><label class="control-label">注文金額合計（税込）</label></th>
             <td class="text-danger text-big">
                  ¥{{ number_format($allPrice + $deliFee + $codFee - $usePoint) }}  
            </td>
        </tr>
        </tbody>
    </table>
</div>

@if($regist || Auth::check())
<div class="table-responsive table-custom show-price mt-3">
    <table class="table border table-borderd bg-white">

        @if(Auth::check())
        <tr>
            <th><label class="control-label">ポイント残高</label></th>
             <td>{{ $userArr['point'] - $usePoint }}</td>
        </tr>
        @endif
        <tr>
            <th><label class="control-label">ポイント発生</label></th>
            <td>{{ $addPoint }}</td>
        </tr>
    </table>
</div>
@endif

<div class="table-responsive table-custom show-price mt-3">
    <table class="table border table-borderd bg-white">
        
        <tr>
            <th><label class="control-label">お支払い方法</label></th>
            <td>
            	{{ $payMethod->find($data['pay_method'])->name }}
            </td>
        </tr>

    </table>
</div>

</div> {{-- float-right --}}

</div>

<div class="mt-5">
<form id="with1" class="form-horizontal" role="form" method="POST" action="{{ $settles['url'] }}">
    {{ csrf_field() }}
    
    <?php //print_r($itemData); ?>
    
    <input type="hidden" name="regist" value="{{ $regist }}">
    <input type="hidden" name="all_price" value="{{ $allPrice }}">
    
    @if($data['pay_method'] == 5)
    	<input type="hidden" name="trans_code" value="888888">
    @elseif($data['pay_method'] == 6)
    	<input type="hidden" name="trans_code" value="999999">
    @endif   
    
    @foreach($itemData as $item)
        <input type="hidden" name="item_id[]" value="{{ $item->id}}">
        <input type="hidden" name="item_count[]" value="{{ $item->count}}">
    @endforeach
    
    @foreach($settles as $key => $settle)
    	<input type="hidden" name="{{ $key }}" value="{{ $settle }}">
    @endforeach
    
  <small class="col-md-5 mx-auto d-block px-5 mb-3">
  上記ご注文内容で注文を確定します。<br>
	<b>「注文する」ボタンをクリックすると注文を確定します。</b>
  </small>
  
  <div class="col-md-12">
  	<button class="btn btn-block btn-custom col-md-4 mb-4 mx-auto py-2" type="submit" name="regist_off" value="1">注文する</button>
	</div>                
</form>

<a href="{{ url('shop/form') }}" class="btn border border-secondary bg-white mt-5"><i class="fas fa-angle-double-left"></i> お客様情報の入力に戻る</a>
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


