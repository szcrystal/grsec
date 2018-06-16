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
<p>入力内容をご確認下さい。<br>よろしければ{{ $str }}ボタンを押して下さい。</p>
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

<div class="table-responsive table-custom">
    <table class="table table-borderd border bg-white">
        <col style="width:27%;"></col>
        <col></col>
        
        <tr class="form-group">
             <th><label class="control-label">氏名</label></th>
               <td>
                {{ $data['name'] }}
            </td>
         </tr> 
      
          <tr class="form-group">
             <th><label class="control-label">フリガナ</label></th>
               <td>{{ $data['hurigana'] }}</td>
         </tr>
         
         <tr class="form-group">
             <th><label class="control-label">メールアドレス</label></th>
            <td>{{ $data['email'] }}</td>
         </tr>
         
         <tr class="form-group">
             <th><label class="control-label">電話番号</label></th>
            <td>{{ $data['tel_num'] }}</td>
         </tr>
         
         <tr class="form-group">
             <th><label class="control-label">郵便番号</label></th>
               <td>〒{{ Ctm::getPostNum($data['post_num']) }}</td>               
         </tr>
         
         <tr class="form-group">
             <th><label class="control-label">都道府県</label></th>
               <td>
                {{ $data['prefecture'] }}
            </td>
         </tr>
         
         <tr class="form-group">
             <th><label class="control-label">住所1（都市区）</label></th>
               <td>{{ $data['address_1'] }}</td>
              
         </tr>
         
         <tr class="form-group">
             <th><label class="control-label">住所2（それ以降）</label></th>
               <td>{{ $data['address_2'] }}</td>
                
            </td>
         </tr>
         
         <tr class="form-group">
             <th><label class="control-label">住所3（建物/マンション名等）</label></th>
               <td>
               @if(isset($data['address_3']))
               	{{ $data['address_3'] }}
               @endif
               </td>               
         </tr>
    </table>
</div>
         
<div class="table-responsive table-custom mt-3">
    <table class="table table-borderd border bg-white">
        <col style="width:27%;"></col>
        <col></col>
        
        <tr class="form-group">
             <th><label class="control-label">性別</label></th>
            <td>
                 @if(isset($data['gender']))
                 {{ $data['gender'] }}
                 @endif
             </td>
         </tr>
    
         <tr class="form-group">
             <th><label class="control-label">生年月日</label></th>
               <td>
                   @if($data['birth_year'])
                    {{ $data['birth_year'] }}年
                   @endif
                   
                   @if($data['birth_month'])
                       {{ $data['birth_month'] }}月
                   @endif
                   
                   @if($data['birth_day'])
                       {{ $data['birth_day'] }}日
                   @endif
                </td>
         </tr>
         
    </table>
</div>

<div class="table-responsive table-custom mt-3">
    <table class="table table-borderd border bg-white">
        <col style="width:27%;"></col>
        <col></col>
         
         <tr class="form-group">
             <th><label class="control-label">メールマガジンの登録</label></th>
               <td>
               @if(isset($data['magazine']) && $data['magazine'])
               登録する
               @else
               登録しない
               @endif
               
            </td>
         </tr>
</table>
</div>
 
@if(! $isMypage)
 <div class="table-responsive table-custom mt-3">
    <table class="table table-borderd border bg-white">
        <col style="width:27%;"></col>
        <col></col>        
         <tr class="form-group">
             <th><label class="control-label">パスワード</label></th>
               <td>********（表示されません）</td>
               
         </tr>

         </table>
         </div>
@endif


	{{-- <p class="text-center">この内容で登録します。</p> --}}
	<form class="form-horizontal" role="form" method="POST" action="{{ $url }}">
		@csrf
		<button class="btn btn-block btn-custom col-md-3 my-4 mx-auto py-2" type="submit" name="recognize" value="1">{{ $str }}</button>                 
    </form>

@if($isMypage)
<a href="{{ url('mypage/register') }}" class="btn border-secondary bg-white mt-5">
@else
<a href="{{ url('register') }}" class="btn border-secondary bg-white mt-5">
@endif
<i class="fas fa-angle-double-left"></i> 入力画面に戻る
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


