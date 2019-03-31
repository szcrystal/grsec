@extends('layouts.app')

@section('content')

<?php
	use App\Setting;
?>

<div id="main" class="confirm">

        <div class="panel panel-default">

            <div class="panel-body">


<div class="clearfix">
@include('cart.guide')


@if (count($errors) > 0)
    <div class="alert alert-danger">
        <i class="far fa-exclamation-triangle"></i> 確認して下さい。
        
        <ul class="mt-2">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="confirm-left">
	<h5 class="card-header mb-3 py-2">ご注文の商品</h5>
	<div class="table-responsive table-cart">
        <table class="table table-bordered bg-white">
            <thead>
                  <tr>
                    <th>商品名</th>
                    <th>数量</th>
                    <th>金額<span class="text-small">（税込）</span></th>
                </tr>
              </thead>  
        
            <tbody>
                 
                 @foreach($itemData as $item)    
                 <tr>
                    <td>
                        <?php $obj = $item; ?>
                        @include('main.shared.smallThumbnail')

                        {!! Ctm::getItemTitle($item, 1) !!}
                        <br>
                        [ {{ $item->number }} ]
                        <span class="d-block mt-1">¥{{ Ctm::getItemPrice($item) }}（税込）</span>
                    </td>
                    
                    <td>{{ $item->count }}</td>

                    <td>
                        ¥{{ number_format( $item->item_total_price ) }}
                    
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

</div><!-- left -->



<div class="confirm-right mt-3">
    <h5 class="">&nbsp;</h5>
    <div class="table-responsive show-price table-custom">
        <table class="table border table-borderd bg-white">
            
            <tbody>
            <tr>
                <th>商品金額合計（税込）</th>
                 <td>¥{{ number_format($allPrice) }}</td>
            </tr>
            <tr>
                <th>送料</th>
                <td>¥{{ number_format($deliFee) }}</td>
            </tr>
            
            @if($data['pay_method'] == 2)
                <tr>
                    <th>コンビニ決済手数料</th>
                    <td>¥{{ number_format($codFee) }}</td>
                </tr>
            
            @elseif($data['pay_method'] == 4)
                <tr>
                    <th>後払い手数料</th>
                    <td>¥{{ number_format($codFee) }}</td>
                </tr>
            
            @elseif($data['pay_method'] == 5)
                <tr>
                    <th>代引き手数料</th>
                    <td>¥{{ number_format($codFee) }}</td>
                </tr>
            @endif
            
            @if(Auth::check())
            <tr>
                <th>利用ポイント</th>
                 <td>
                 @if($usePoint)
                 -
                 @endif
                 {{ $usePoint }}</td>
            </tr>
            @endif
            
            <tr>
                <th>注文金額合計（税込）</th>
                 <td class="text-danger text-big{{ count($errors) > 0 ? ' alert-danger' : '' }}">
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
                    <th>ポイント残高</th>
                     <td>{{ $userArr['point'] - $usePoint }}</td>
                </tr>
                @endif
                <tr>
                    <th>ポイント発生</th>
                    <td>{{ $addPoint }}</td>
                </tr>
            </table>
        </div>
    @endif

    <div class="table-responsive table-custom show-price mt-3">
        <table class="table border table-borderd bg-white"> 
            <tr>
                <th>お支払い方法</th>
                <td class="{{ count($errors) > 0 ? 'alert-danger' : '' }}">
                    {{ $payMethod->find($data['pay_method'])->name }}
                    
                    @if($data['pay_method'] == 3)
                        <br><span class="text-small">{{ $pmChild->find($data['net_bank'])->name }}</span>
                    @endif
                </td>
            </tr>
            
            @if($data['pay_method'] == 1 && $data['card_seq'] == 99)
            	<tr>
                    <th>カード番号の登録</th>
                    <td>
                        @if(isset($data['is_regist_card']))
                            する
                        @else
                            しない
                        @endif
                    </td>
                </tr>
            @endif
        </table>
    </div>

</div><!-- right -->


<div class="confirm-left">
<h5 class="card-header mb-3 py-2 mt-4">配送情報</h5>
<div class="table-responsive table-cart mt-3">
    <table class="table table-borderd border bg-white">
    	<thead>
     	   <tr><th>お届け先</th></tr>
        </thead>
        
        <tbody>
        	<tr>
            <td>
        
@if(isset($data['destination']))
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


<div class="table-responsive table-cart mt-3">
    <table class="table table-borderd border bg-white">
    	<thead>
     	   <tr><th>ご希望配送日時</th></tr>
        </thead>
        
        <tbody>
        	<tr>
            <td>
            ご希望日：
            @if(isset($data['plan_date']))
            {{ $data['plan_date'] }}<br>
            @else
            最短出荷<br>
            @endif
			
			<ul class="px-4 mt-3">
                @foreach($itemData as $item) 
                	@if(isset($item->plan_time))                   
                        <li class="mb-3">
                            {{ Ctm::getItemTitle($item) }}<br>
                            ご希望時間：[ {{ $item->plan_time }} ]
                        </li>
                    @endif
                @endforeach
            </ul>
            
        	</tr>
            </td>
        </tbody>
    </table>
</div>

@if(isset($data['user_comment']) && $data['user_comment'] != '')
<div class="mb-5">
    <h5 class="card-header mb-3 py-2 mt-4">その他コメント</h5>
    <div style="min-height:8em;" class="bg-white p-2 border border-gray">
    	{!! nl2br($data['user_comment']) !!}
    </div>
</div>
@endif

@if(! Auth::check())
<h5 class="card-header mb-3 py-2 mt-4">
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
        	<th>氏名</th>
         	<td>{{ $userArr['name'] }}</td>
        </tr>
        <tr>
            <th>フリガナ</th>
             <td>{{ $userArr['hurigana'] }}</td>
        </tr>
        <tr>
            <th>メールアドレス</th>
             <td>{{ $userArr['email'] }}</td>
        </tr>
        <tr>
            <th>電話番号</th>
             <td>{{ $userArr['tel_num'] }}</td>
        </tr>
        <tr>
            <th>住所</th>
             <td>〒{{ Ctm::getPostNum($userArr['post_num']) }}<br>
             		{{ $userArr['prefecture'] }}&nbsp;
             		{{ $userArr['address_1'] }}&nbsp;
                    {{ $userArr['address_2'] }}<br>
               		{{ $userArr['address_3'] }}
             </td>
        </tr>
        <tr>
            <th>性別</th>
             <td>
             	@if(isset($userArr['gender']))
                 {{ $userArr['gender'] }}
                @else
                	--
                @endif
            </td>
        </tr>
        <tr>
            <th>生年月日</th>
             <td>
             	@if($userArr['birth_year'] && $userArr['birth_month'] && $userArr['birth_day'])
             		{{ $userArr['birth_year'] }}/{{ $userArr['birth_month'] }}/{{ $userArr['birth_day'] }}
               @else
               	--      
              	@endif   
            </td>
        </tr>
        
        <tr>
            <th>メールマガジンの登録</th>
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




</div>

<div class="mt-5">
<?php
	$isCard = 0;
    if($data['pay_method'] == 1) {
    	if(! isset($data['card_seq']) || (isset($data['card_seq']) && $data['card_seq'] == 99)) {
        	$isCard = 1;
        }
    }
?>

@if($isCard)
<form id="getTokenForm">

	@foreach($cardInfo as $key => $ci)
    	<input id="{{ $key }}" type="hidden" name="{{ $key }}" value="{{ $ci }}">
	@endforeach

	<div class="">
        <small class="col-md-5 mx-auto d-block px-5 mb-1 confirm-small">
            上記ご注文内容で注文を確定します。<br>
            <b>「注文する」ボタンをクリックすると注文を確定します。</b>
        </small>
        
        <div class="loader-wrap">
	        <span class="loader mr-3"><i class="fas fa-square mr-1"></i> 処理中..</span>
  		</div>
    
    	<?php
        	$isProduct = Setting::get()->first()->is_product ? 1 : 0;
        ?>
        <input type="button" id="card-submit" class="btn btn-block btn-enji col-md-4 mb-4 mx-auto py-2" data-product="{{ $isProduct }}" value="注文する">
        
        {{--
        <button class="btn btn-block btn-enji col-md-4 mb-4 mx-auto py-2" type="submit" name="regist_off" value="1"{{ $disabled }} onclick="doPurchase()">注文する</button>
        --}}
	</div>

</form>
@endif

<form id="purchaseForm" class="form-horizontal" role="form" method="POST" action="{{ $actionUrl }}">
    {{ csrf_field() }}
    
    @foreach($settles as $key => $settle)
    	<input type="hidden" name="{{ $key }}" value="{{ $settle }}">
    @endforeach
    
    <input type="hidden" value="" id="token" name="token">
    
    @if(! $isCard)
    	<?php        	
            $disabled = '';
            if(count($errors) > 0) {
            	$disabled = ' disabled';
            }
        ?>
        
    	<small class="col-md-5 mx-auto d-block px-5 mb-1 confirm-small">
            @if($errors->has('konbiniLimit'))
                <span class="text-danger text-big">
                    {{ $errors->first('konbiniLimit') }}<br>
                    戻ってお支払い方法か購入商品を変更して下さい。
                </span>
            @elseif($errors->has('gmoLimit'))
                <span class="text-danger text-big">
                    {{ $errors->first('gmoLimit') }}<br>
                    戻ってお支払い方法か購入商品/数量を変更して下さい。
                </span>
            @else
                上記ご注文内容で注文を確定します。<br>
                <b>「注文する」ボタンをクリックすると注文を確定します。</b>
            @endif
        </small>

            
        <div class="loader-wrap">
            <span class="loader mr-3"><i class="fas fa-square mr-1"></i> 処理中..</span>
        </div>
        
    	<button id="exist-submit" class="btn btn-block btn-enji col-md-4 mb-4 mx-auto py-2" type="submit"{{ $disabled }}>注文する</button>
    @endif
  
</form>




<a href="{{ url('shop/form') }}" class="btn border border-secondary bg-white my-3"><i class="fal fa-angle-double-left"></i> お客様情報の入力に戻る</a>
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


