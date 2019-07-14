@extends('layouts.app')

@section('content')


	{{-- @include('main.shared.carousel') --}}

<div id="main" class="top">

        <div class="panel panel-default">

            <div class="panel-body">
                {{-- @include('main.shared.main') --}}

				<div class="main-list clearfix">
<h3 class="mb-3 card-header">会員登録情報の確認</h3>
<?php
$url = $isMypage ? url('mypage/register/end') : url('register/end');
$str = $isMypage ? '変更する' : '登録する';
?>

<p class="ml-2 mb-4 pb-2">
	入力内容をご確認下さい。<br>よろしければ{{ $str }}ボタンを押して下さい。
</p>

@if (count($errors) > 0)
    <div class="alert alert-danger">
        <strong><i class="fas fa-exclamation-triangle"></i> Error!!</strong> 以下の入力を確認して下さい。<br><br>
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

<div class="">

<div class="table-responsive table-normal">
    <table class="table table-borderd border bg-white">
        
        <tr class="form-group">
             <th>氏名</th>
               <td>
                {{ $data['name'] }}
            </td>
         </tr> 
      
          <tr class="form-group">
             <th>フリガナ</th>
               <td>{{ $data['hurigana'] }}</td>
         </tr>
         
         <tr class="form-group">
             <th>電話番号</th>
            <td>{{ $data['tel_num'] }}</td>
         </tr>
         
         <tr class="form-group">
             <th>郵便番号</th>
               <td>〒{{ Ctm::getPostNum($data['post_num']) }}</td>               
         </tr>
         
         <tr class="form-group">
             <th>都道府県</th>
               <td>
                {{ $data['prefecture'] }}
            </td>
         </tr>
         
         <tr class="form-group">
             <th>住所1（都市区それ以降）</th>
               <td>{{ $data['address_1'] }}</td>
              
         </tr>
         
         <tr class="form-group">
             <th>住所2（建物/マンション名等）</th>
               <td>{{ $data['address_2'] }}</td>
                
            </td>
         </tr>
         
         <tr class="form-group">
             <th>メールマガジンの登録</th>
               <td>
               @if(isset($data['magazine']) && $data['magazine'])
               登録する
               @else
               登録しない
               @endif
               
            </td>
         </tr>
         
         <tr class="form-group">
             <th>メールアドレス</th>
            <td>{{ $data['email'] }}</td>
         </tr>
         
        @if(! $isMypage)               
            <tr class="form-group">
                <th>パスワード</th>
                <td>********（表示されません）</td>
            </tr>
        @endif

         
         {{--
         <tr class="form-group">
             <th>住所3（）</th>
               <td>
               @if(isset($data['address_3']))
               	{{ $data['address_3'] }}
               @endif
               </td>               
         </tr>
         --}}
    </table>
</div>

{{--
<div class="table-responsive table-custom mt-3">
    <table class="table table-borderd border bg-white">
        
        <tr class="form-group">
             <th>性別</th>
            <td>
                @if(isset($data['gender']))
                 	{{ $data['gender'] }}
                @endif
             </td>
         </tr>
    
         <tr class="form-group">
             <th>生年月日</th>
               <td>
                   	@if($data['birth_year'] && $data['birth_month'] && $data['birth_day'])
                    	{{ $data['birth_year'] }}/{{ $data['birth_month'] }}/{{ $data['birth_day'] }}
                    @endif
                </td>
         </tr>
         
    </table>
</div>
--}}


@if($isMypage)
    <div class="table-responsive table-normal mt-3">
        <table class="table table-borderd border bg-white">
             
             <tr class="form-group">
                <th>登録クレジットカードの変更</th>
                <td>
                	<?php $noRes = 0; ?>
                    
                    @if(isset($data['edit_mode']))

                        @foreach($data['edit_mode'] as $k => $v)
                        	@if($v)
                            	<?php $noRes = 1; ?>
                            
                                <div class="wrap-regist-card mt-0 mb-3 pb-3"> 
                                    @if($v == 1)
                                        <label><i class="fas fa-square text-small text-gray"></i> 有効期限の変更</label>
                                        <p class="ml-3">
                                            <span>カード番号： {{ $data['card_num'][$k] }}</span>
                                            <span class="d-block">有効期限（月/年）: <b>{{ $data['expire_month'][$k] }}/{{ $data['expire_year'][$k] }}</b></span>
                                        </p>
                                       
                                    
                                    @elseif($v == 2)
                                        <label><i class="fas fa-square text-small text-gray"></i> 登録カードの削除</label>
                                        <p class="ml-3">
                                            <span>カード番号： {{ $data['card_num'][$k] }}</span>
                                            <small class="d-block">有効期限（月/年）: {{ $data['expire_month'][$k] }}/{{ $data['expire_year'][$k] }}</small>
                                        </p>
                                        <?php $noRes = 1; ?>
                                    
                                    @endif
                                </div>
                            @endif
                        @endforeach
                        
                        @if(! $noRes)
                            なし
                        @endif

                    @endif
	                   
                </td>
             </tr>
        </table>
    </div>
@endif


 


	{{-- <p class="text-center">この内容で登録します。</p> --}}
	<form class="form-horizontal" role="form" method="POST" action="{{ $url }}">
		@csrf
        
        <div class="mt-3 mb-4">
        	<div class="loader-wrap">
                <span class="loader"><i class="fas fa-square mr-1"></i> 処理中..</span>
            </div>
            
            <?php 
            	$submitId = '';
            	
                if($isMypage && $noRes)
            		$submitId = 'regist-submit';
            ?>
            
            <button id="{{ $submitId }}" class="btn btn-block btn-custom col-md-4 mx-auto py-2" type="submit" name="recognize" value="1">{{ $str }}</button>
        </div>
        
    </form>

@if($isMypage)
<a href="{{ url('mypage/register') }}" class="btn border-secondary bg-white my-3">
@else
<a href="{{ url('register') }}" class="btn border-secondary bg-white my-3">
@endif
<i class="fal fa-angle-double-left"></i> 入力画面に戻る
</a>
</div>
</div>
</div>
</div>
</div>

@endsection




