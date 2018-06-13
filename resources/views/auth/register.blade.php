@extends('layouts.app')

@section('content')


	{{-- @include('main.shared.carousel') --}}

<div id="main" class="top">

        <div class="panel panel-default">

            <div class="panel-body">
                {{-- @include('main.shared.main') --}}

				<div class="main-list clearfix">
<h3 class="mb-3 card-header">会員登録情報</h3>

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
@if(isset($isMypage) && $isMypage)
<form class="form-horizontal" role="form" method="POST" action="{{ url('mypage/register') }}">
@else
<form class="form-horizontal" role="form" method="POST" action="{{ route('register') }}">
@endif
    {{ csrf_field() }}
    

<div class="table-responsive table-custom">
    <table class="table table-borderd border">
        <col style="width:27%;"></col>
        <col></col>
        
        <tr class="form-group">
             <th><label class="control-label">氏名</label><em>必須</em></th>
               <td>
                <input class="form-control col-md-12{{ $errors->has('user.name') ? ' is-invalid' : '' }}" name="user[name]" value="{{ Ctm::isOld() ? old('user.name') : (isset($user) ? $user->name : '') }}" placeholder="例）山田太郎">
               
                @if ($errors->has('user.name'))
                    <div class="text-danger">
                        <span class="fa fa-exclamation form-control-feedback"></span>
                        <span>{{ $errors->first('user.name') }}</span>
                    </div>
                @endif
            </td>
         </tr> 
      
          <tr class="form-group">
             <th><label class="control-label">フリガナ</label><em>必須</em></th>
               <td>
                <input type="text" class="form-control col-md-12{{ $errors->has('user.hurigana') ? ' is-invalid' : '' }}" name="user[hurigana]" value="{{ Ctm::isOld() ? old('user.hurigana') : (isset($user) ? $user->hurigana : '') }}" placeholder="例）ヤマダタロウ">
                
                @if ($errors->has('user.hurigana'))
                    <div class="text-danger">
                        <span class="fa fa-exclamation form-control-feedback"></span>
                        <span>{{ $errors->first('user.hurigana') }}</span>
                    </div>
                @endif
            </td>
         </tr>
         
         <tr class="form-group">
             <th><label class="control-label">メールアドレス</label><em>必須</em></th>
               <td>
                <input type="email" class="form-control col-md-12{{ $errors->has('user.email') ? ' is-invalid' : '' }}" name="user[email]" value="{{ Ctm::isOld() ? old('user.email') : (isset($user) ? $user->email : '') }}" placeholder="例）abcde@example.com">
                
                @if ($errors->has('user.email'))
                    <div class="help-block text-danger">
                        <span class="fa fa-exclamation form-control-feedback"></span>
                        <span>{{ $errors->first('user.email') }}</span>
                    </div>
                @endif
            </td>
         </tr>
         
         <tr class="form-group">
             <th><label class="control-label">電話番号</label><em>必須</em></th>
               <td>
                <input type="text" class="form-control col-md-12{{ $errors->has('user.tel_num') ? ' is-invalid' : '' }}" name="user[tel_num]" value="{{ Ctm::isOld() ? old('user.tel_num') : (isset($user) ? $user->tel_num : '') }}" placeholder="例）09012345678 ハイフンなし半角数字">
                
                @if ($errors->has('user.tel_num'))
                    <div class="help-block text-danger">
                        <span class="fa fa-exclamation form-control-feedback"></span>
                        <span>{{ $errors->first('user.tel_num') }}</span>
                    </div>
                @endif
            </td>
         </tr>
         
         <tr class="form-group">
             <th><label class="control-label">性別</label></th>
               <td>
                <?php 
                     $arrs = array('男性', '女性');
                 ?>  
              		
                @foreach($arrs as $arr) 
                  	<?php
                   	$checked = '';   
                    if( Ctm::isOld() && old('user.gender') == $arr) {
                        $checked = ' checked';
                    }
                    else if(isset($user) && $user->gender == $arr) {
                    //elseif(Session::has('all.data.user')  && session('all.data.user.gender') == $str) {
                        $checked = ' checked';
                    }
                    ?>
                      
                    <label class="radio-inline pr-3{{ $errors->has('user.gender') ? ' is-invalid' : '' }}">
                        <input type="radio" name="user[gender]" value="{{ $arr }}"{{ $checked }}>{{ $arr }}
                    </label>
                @endforeach
                
                @if ($errors->has('user.gender'))
                    <div class="text-danger">
                        <span class="fa fa-exclamation form-control-feedback"></span>
                        <span>{{ $errors->first('user.gender') }}</span>
                    </div>
                @endif
            </td>
         </tr>
    
         <tr class="form-group">
             <th><label class="control-label">生年月日</label></th>
               <td>
                   
                <select class="form-control select-first col-md-2 d-inline{{ $errors->has('user.birth_year') ? ' is-invalid' : '' }}" name="user[birth_year]">
                    <option value="0" selected>年</option>
                    <?php
                        $yNow = date('Y');
                        $y = 1900;
                    ?>
                    @while($y <= $yNow)
                        <?php
                            $selected = '';
                            if(Ctm::isOld()) {
                                if(old('user.birth_year') == $y)
                                    $selected = ' selected';
                            }
                            else {
                            	if(isset($user) && $user->birth_year == $y) {
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
                
                @if ($errors->has('user.birth_year'))
                    <div class="help-block text-danger">
                        <span class="fa fa-exclamation form-control-feedback"></span>
                        <span>{{ $errors->first('user.birth_year') }}</span>
                    </div>
                @endif
                
                <select class="form-control select-first col-md-1 d-inline{{ $errors->has('user.birth_month') ? ' is-invalid' : '' }}" name="user[birth_month]">
                    <option value="0" selected>月</option>
                    <?php
                        $m = 1;
                    ?>
                    @while($m <= 12)
                        <?php
                            $selected = '';
                            if(Ctm::isOld()) {
                                if(old('user.birth_month') == $m)
                                    $selected = ' selected';
                            }
                            else {
                            	if(isset($user) && $user->birth_month == $m) {
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
                
                @if ($errors->has('user.birth_month'))
                    <div class="help-block text-danger">
                        <span class="fa fa-exclamation form-control-feedback"></span>
                        <span>{{ $errors->first('user.birth_month') }}</span>
                    </div>
                @endif
                
                <select class="form-control select-first col-md-1 d-inline{{ $errors->has('user.birth_day') ? ' is-invalid' : '' }}" name="user[birth_day]">
                    <option value="0" selected>日</option>
                    <?php
                        $d = 1;
                    ?>
                    @while($d <= 31)
                        <?php
                            $selected = '';
                            if(Ctm::isOld()) {
                                if(old('user.birth_day') == $d)
                                    $selected = ' selected';
                            }
                            else {
                            	if(isset($user) && $user->birth_day == $d) {
                                //if(Session::has('all.data.user')  && session('all.data.user.birth_day') == $d) {
                                    $selected = ' selected';
                                }
                            }
                        ?>
                        <option value="{{ $d }}"{{ $selected }}>{{ $d }}</option>
                        
                        <?php $d++; ?>
                    
                    @endwhile
                </select>
                <span>日</span>
                
                @if ($errors->has('user.birth_day'))
                    <div class="help-block text-danger">
                        <span class="fa fa-exclamation form-control-feedback"></span>
                        <span>{{ $errors->first('user.birth_day') }}</span>
                    </div>
                @endif
                
            </td>
         </tr>
         
         
         <tr class="form-group">
             <th><label class="control-label">郵便番号</label><em>必須</em></th>
               <td>
                <input type="text" class="form-control col-md-12{{ $errors->has('user.post_num') ? ' is-invalid' : '' }}" name="user[post_num]" value="{{ Ctm::isOld() ? old('user.post_num') : (isset($user) ? $user->post_num : '') }}" placeholder="例）1234567 ハイフンなし半角数字">
                
                @if ($errors->has('user.post_num'))
                    <div class="help-block text-danger">
                        <span class="fa fa-exclamation form-control-feedback"></span>
                        <span>{{ $errors->first('user.post_num') }}</span>
                    </div>
                @endif
            </td>
         </tr>
         
         <tr class="form-group">
             <th><label class="control-label">都道府県</label><em>必須</em></th>
               <td>
                <select class="form-control select-first col-md-6{{ $errors->has('user.prefecture') ? ' is-invalid' : '' }}" name="user[prefecture]">
                    <option disabled selected>選択して下さい</option>
                    <?php
//                        use App\Prefecture;
//                        $prefs = Prefecture::all();  
                    ?>
                    @foreach($prefs as $pref)
                        <?php
                            $selected = '';
                            if(Ctm::isOld()) {
                                if(old('user.prefecture') == $pref->name)
                                    $selected = ' selected';
                            }
                            else {
                            	if(isset($user) && $user->prefecture == $pref->name) {
                                //if(Session::has('all.data.user')  && session('all.data.user.prefecture') == $pref->name) {
                                    $selected = ' selected';
                                }
                            }
                        ?>
                        <option value="{{ $pref->name }}"{{ $selected }}>{{ $pref->name }}</option>
                    @endforeach
                </select>
                
                @if ($errors->has('user.prefecture'))
                    <div class="help-block text-danger">
                        <span class="fa fa-exclamation form-control-feedback"></span>
                        <span>{{ $errors->first('user.prefecture') }}</span>
                    </div>
                @endif
            </td>
         </tr>
         
         <tr class="form-group">
             <th><label class="control-label">住所1（都市区）</label><em>必須</em></th>
               <td>
                <input type="text" class="form-control col-md-12{{ $errors->has('user.address_1') ? ' is-invalid' : '' }}" name="user[address_1]" value="{{ Ctm::isOld() ? old('user.address_1') : (isset($user) ? $user->address_1 : '') }}" placeholder="例）小美玉市">
                
                @if ($errors->has('user.address_1'))
                    <div class="help-block text-danger">
                        <span class="fa fa-exclamation form-control-feedback"></span>
                        <span>{{ $errors->first('user.address_1') }}</span>
                    </div>
                @endif
            </td>
         </tr>
         
         <tr class="form-group">
             <th><label class="control-label">住所2（それ以降）</label><em>必須</em></th>
               <td>
                <input type="text" class="form-control col-md-12{{ $errors->has('user.address_2') ? ' is-invalid' : '' }}" name="user[address_2]" value="{{ Ctm::isOld() ? old('user.address_2') : (isset($user) ? $user->address_2 : '') }}" placeholder="例）下吉影1-1">
                
                @if ($errors->has('user.address_2'))
                    <div class="help-block text-danger">
                        <span class="fa fa-exclamation form-control-feedback"></span>
                        <span>{{ $errors->first('user.address_2') }}</span>
                    </div>
                @endif
            </td>
         </tr>
         
         <tr class="form-group">
             <th><label class="control-label">住所3（建物/マンション名等）</label></th>
               <td>
                <input type="text" class="form-control col-md-12{{ $errors->has('user.address_3') ? ' is-invalid' : '' }}" name="user[address_3]" value="{{ Ctm::isOld() ? old('user.address_3') : (isset($user) ? $user->address_3 : '') }}" placeholder="例）GRビル 101号">
                
                @if ($errors->has('user.address_3'))
                    <div class="help-block text-danger">
                        <span class="fa fa-exclamation form-control-feedback"></span>
                        <span>{{ $errors->first('user.address_3') }}</span>
                    </div>
                @endif
            </td>
         </tr>
         
         
         
         <tr class="form-group">
             <th><label class="control-label">メールマガジンの登録</label></th>
               <td>
                <?php
                    $checked = '';
                    if(Ctm::isOld()) {
                        if(old('user.magazine'))
                            $checked = ' checked';
                    }
                    else {
                    	if(isset($user) && $user->magazine) {
                        //if(Session::has('all.data.user')  && session('all.data.user.magazine')) {
                            $checked = ' checked';
                        }
                    }
                ?>
                <input type="checkbox" name="user[magazine]" value="1"{{ $checked }}> 登録する
                
                @if ($errors->has('user.magazine'))
                    <div class="help-block text-danger">
                        <span class="fa fa-exclamation form-control-feedback"></span>
                        <span>{{ $errors->first('user.magazine') }}</span>
                    </div>
                @endif
            </td>
         </tr>
         
			@if(! Auth::check())
             <tr class="form-group">
                 <th><label class="control-label">パスワード</label><em>必須</em></th>
                   <td>
                    <input type="password" class="form-control col-md-12{{ $errors->has('user.password') ? ' is-invalid' : '' }}" name="user[password]" value="{{ Ctm::isOld() ? old('user.password') : (Session::has('all.data.user') ? session('all.data.user.password') : '') }}" placeholder="8文字以上">
                                        
                    @if ($errors->has('user.password'))
                        <div class="help-block text-danger">
                            <span class="fa fa-exclamation form-control-feedback"></span>
                            <span>{{ $errors->first('user.password') }}</span>
                        </div>
                    @endif
                </td>
             </tr>
             
             <tr class="form-group">
                 <th><label class="control-label">パスワードの確認</label><em>必須</em></th>
                   <td>
                    <input type="password" class="form-control col-md-12{{ $errors->has('user.password_confirmation') ? ' is-invalid' : '' }}" name="user[password_confirmation]" value="{{ Ctm::isOld() ? old('user.password_confirmation') : (Session::has('all.data.user') ? session('all.data.user.password_confirmation') : '') }}">
                    
                    @if ($errors->has('user.password_confirmation'))
                        <div class="help-block text-danger">
                            <span class="fa fa-exclamation form-control-feedback"></span>
                            <span>{{ $errors->first('user.password_confirmation') }}</span>
                        </div>
                    @endif
                </td>
             </tr>
             @endif
         
         </table>
         </div>

	<button class="btn btn-block btn-custom col-md-3 mb-4 mx-auto py-2" type="submit" name="recognize" value="1">変更する</button>                 
    </form>

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


