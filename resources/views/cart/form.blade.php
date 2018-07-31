@extends('layouts.app')

@section('content')

<?php
use App\Item;
use App\DeliveryGroup;
?>

	{{-- @include('main.shared.carousel') --}}

<div id="main" class="top">

        <div class="panel panel-default">

            <div class="panel-body">
                {{-- @include('main.shared.main') --}}

				<div class="main-list clearfix">
@include('cart.guide')

@if (count($errors) > 0)
    <div class="alert alert-danger">
        <strong><i class="fas fa-exclamation-triangle"></i> Error!!</strong> 確認して下さい。<br><br>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="">
<form id="with1" class="form-horizontal" role="form" method="POST" action="{{ url('shop/confirm') }}">
    {{ csrf_field() }}
    
    <?php 
//    print_r($itemData); 
//    exit;
//    echo session('all.all_price'). "///";
//    echo session('all.regist');
    ?>
    

    
@if(Auth::check())
<h3 class="mb-3 card-header">会員登録情報</h3>
<div class="table-responsive table-custom">
    <table class="table table-borderd border">

        <tr>
        	<th>氏名</th>
         	<td>{{ $userObj->name }}</td>   
        </tr>
        <tr>
            <th>メールアドレス</th>
             <td>{{ $userObj->email }}</td>   
        </tr>
        <tr>
            <th>電話番号</th>
             <td>{{ $userObj->tel_num }}</td>   
        </tr>
        <tr>
            <th>住所</th>
             <td>〒{{ Ctm::getPostNum( $userObj->post_num) }}<br>
             {{ $userObj->prefecture }} {{ $userObj->address_1 }} {{ $userObj->address_2 }}<br>
             {{ $userObj->address_3 }}
             </td>   
        </tr>
        <tr>
            <th>ポイントのご利用</th>
            <td>
            	<div class="mb-2">
             	   現在の保持ポイント：<span class="text-primary">{{ $userObj->point }}</span>ポイント
                </div>
            	<div class="mb-2">
                <input class="form-control d-inline col-md-2{{ $errors->has('use_point') ? ' is-invalid' : '' }}" name="use_point" value="{{ Ctm::isOld() ? old('use_point') : (Session::has('all.use_point') ? session('all.use_point') : 0) }}" placeholder=""><span class="mx-1 my-2">ポイント利用する</span>
                </div>
               
                @if ($errors->has('use_point'))
                    <div class="text-danger">
                        <span class="fa fa-exclamation form-control-feedback"></span>
                        <span>{{ $errors->first('use_point') }}</span>
                    </div>
                @endif
            </td>   
        </tr>
	</table>
</div>

@else
<h3 class="mb-3 card-header">お客様情報</h3>

<input type="hidden" name="use_point" value="0">

<div class="table-responsive table-custom">
    <table class="table table-borderd border">
       
        
        <tr class="form-group">
             <th><label class="control-label">氏名</label><em>必須</em></th>
               <td>
                <input class="form-control col-md-12{{ $errors->has('user.name') ? ' is-invalid' : '' }}" name="user[name]" value="{{ Ctm::isOld() ? old('user.name') : (Session::has('all.data.user') ? session('all.data.user.name') : '') }}" placeholder="例）山田太郎">
               
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
                <input type="text" class="form-control col-md-12{{ $errors->has('user.hurigana') ? ' is-invalid' : '' }}" name="user[hurigana]" value="{{ Ctm::isOld() ? old('user.hurigana') : (Session::has('all.data.user') ? session('all.data.user.hurigana') : '') }}" placeholder="例）ヤマダタロウ">
                
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
                <input type="email" class="form-control col-md-12{{ $errors->has('user.email') ? ' is-invalid' : '' }}" name="user[email]" value="{{ Ctm::isOld() ? old('user.email') : (Session::has('all.data.user') ? session('all.data.user.email') : '') }}" placeholder="例）abcde@example.com">
                
                @if ($errors->has('user.email'))
                    <div class="help-block text-danger">
                        <span class="fa fa-exclamation form-control-feedback"></span>
                        <span>{{ $errors->first('user.email') }}</span>
                    </div>
                @endif
            </td>
         </tr>
         
         <tr class="form-group">
             <th><label class="control-label">電話番号</label><em>必須</em><br>
             	<small>例）09012345678 ハイフンなし半角数字</small>
             </th>
               <td>
                <input type="text" class="form-control col-md-12{{ $errors->has('user.tel_num') ? ' is-invalid' : '' }}" name="user[tel_num]" value="{{ Ctm::isOld() ? old('user.tel_num') : (Session::has('all.data.user') ? session('all.data.user.tel_num') : '') }}" placeholder="例）09012345678 ハイフンなし半角数字">
                
                @if ($errors->has('user.tel_num'))
                    <div class="help-block text-danger">
                        <span class="fa fa-exclamation form-control-feedback"></span>
                        <span>{{ $errors->first('user.tel_num') }}</span>
                    </div>
                @endif
            </td>
         </tr>
         
         <tr class="form-group">
             <th><label class="control-label">郵便番号</label><em>必須</em><br>
             	<small>例）1234567 ハイフンなし半角数字</small>
             </th>
               <td>
                <input id="zipcode" type="text" class="form-control col-md-6{{ $errors->has('user.post_num') ? ' is-invalid' : '' }}" name="user[post_num]" value="{{ Ctm::isOld() ? old('user.post_num') : (Session::has('all.data.user') ? session('all.data.user.post_num') : '') }}" placeholder="例）1234567 ハイフンなし半角数字">
                
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
                <select id="pref" class="form-control select-first col-md-6{{ $errors->has('user.prefecture') ? ' is-invalid' : '' }}" name="user[prefecture]">
                    <option selected value="0">選択して下さい</option>
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
                                if(Session::has('all.data.user')  && session('all.data.user.prefecture') == $pref->name) {
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
                <input id="address" type="text" class="form-control col-md-12{{ $errors->has('user.address_1') ? ' is-invalid' : '' }}" name="user[address_1]" value="{{ Ctm::isOld() ? old('user.address_1') : (Session::has('all.data.user') ? session('all.data.user.address_1') : '') }}" placeholder="例）小美玉市">
                
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
                <input type="text" class="form-control col-md-12{{ $errors->has('user.address_2') ? ' is-invalid' : '' }}" name="user[address_2]" value="{{ Ctm::isOld() ? old('user.address_2') : (Session::has('all.data.user') ? session('all.data.user.address_2') : '') }}" placeholder="例）下吉影1-1">
                
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
                <input type="text" class="form-control col-md-12{{ $errors->has('user.address_3') ? ' is-invalid' : '' }}" name="user[address_3]" value="{{ Ctm::isOld() ? old('user.address_3') : (Session::has('all.data.user') ? session('all.data.user.address_3') : '') }}" placeholder="例）GRビル 101号">
                
                @if ($errors->has('user.address_3'))
                    <div class="help-block text-danger">
                        <span class="fa fa-exclamation form-control-feedback"></span>
                        <span>{{ $errors->first('user.address_3') }}</span>
                    </div>
                @endif
            </td>
         </tr>
        </table>
        </div>
         
         
         <div class="table-responsive table-custom">
         <p class="mt-3 text-small">よろしければ以下もお答え下さい。</p>
            <table class="table table-borderd">

         <tr class="form-group">
             <th><label class="control-label">性別</label></th>
               <td>
                <?php 
                     $arrs = array('男性', '女性');
                    
                    function checked($str) {
                        $checked = '';
                        if( Ctm::isOld() && old('user.gender') == $str) {
                            $checked = ' checked';
                        }
                        //elseif(isset($user) && $user->gender == $str) {
                        elseif(Session::has('all.data.user')  && session('all.data.user.gender') == $str) {
                            $checked = ' checked';
                        }  
                        return $checked;
                      }             
                 ?>  
              
                  @foreach($arrs as $arr)    
                    <label class="radio-inline pr-3{{ $errors->has('user.gender') ? ' is-invalid' : '' }}">
                        <input type="radio" name="user[gender]" value="{{ $arr }}"{{ checked($arr) }}>{{ $arr }}
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
                                if(Session::has('all.data.user')  && session('all.data.user.birth_year') == $y) {
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
                                if(Session::has('all.data.user')  && session('all.data.user.birth_month') == $m) {
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
                                if(Session::has('all.data.user')  && session('all.data.user.birth_day') == $d) {
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
        </table>
        </div>
         
         
         <div id="magazine" class="table-responsive table-custom">
        <p class="mt-3 text-small">当店からのお知らせを希望しますか？</p>
            <table class="table table-borderd border">
 
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
                        if(Session::has('all.data.user')  && session('all.data.user.magazine')) {
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
        </table>
        </div>
         
         @if($regist)
         <div class="table-responsive table-custom">
            <p class="mt-3 text-small">8文字以上（半角）で、忘れないものを入力して下さい。<br>メールアドレスとパスワードは当店をご利用の際に必要となります。</p>
            <table class="table table-borderd border">

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

@endif {{-- AuthCheck --}}                     
        
        <div class="receiver">
            <h3 class="mt-5 card-header">お届け先</h3>     
                 
            <fieldset class="form-group col-md-12 text-left mt-3 py-3 border rounded bg-white">
                <div class="checkbox">
                    <label class="big-check">
                        <?php                            
                            $checked = '';
                            if(Ctm::isOld()) {
                            	 if(old('destination') !== null) 
                                	$checked = ' checked';
                            }
                            else {
                            	if(Session::has('all.data.destination') && session('all.data.destination'))
                                	$checked = ' checked';
                            }
                        ?>
                        <input type="checkbox" name="destination" value="1"{{ $checked }}> 上記登録先へ配送する（上記の登録先住所へ配送する場合はここをチェックして下さい。）
                    </label>
                    
                    @if ($errors->has('receiver.*'))
                        <div class="help-block text-danger receiver-error">
                            <span class="fa fa-exclamation form-control-feedback"></span>
                            <span>登録先住所と配送先が同じ場合は「上記登録先へ配送する」にチェックをして下さい。<br>&nbsp;&nbsp;登録先住所と配送先が異なる場合は下記項目の入力をして下さい。</span>
                        </div>
                    @endif
                </div>
            </fieldset>     
        
            <div class="table-responsive table-custom">
                <table class="table table-borderd border">

                    <tr class="form-group">
                         <th><label class="control-label">配送先氏名</label><em>必須</em></th>
                           <td>
                            <input type="text" class="form-control col-md-12{{ $errors->has('receiver.name') ? ' is-invalid' : '' }}" name="receiver[name]" value="{{ Ctm::isOld() ? old('receiver.name') : (Session::has('all.data.receiver') ? session('all.data.receiver.name') : '') }}" placeholder="例）山田太郎">
                           
                            @if ($errors->has('receiver.name'))
                                <div class="help-block text-danger receiver-error">
                                    <span class="fa fa-exclamation form-control-feedback"></span>
                                    <span>{{ $errors->first('receiver.name') }}</span>
                                </div>
                            @endif
                        </td>
                     </tr> 
                  
                      <tr class="form-group">
                         <th><label class="control-label">配送先フリガナ</label><em>必須</em></th>
                           <td>
                            <input type="text" class="form-control col-md-12{{ $errors->has('receiver.hurigana') ? ' is-invalid' : '' }}" name="receiver[hurigana]" value="{{ Ctm::isOld() ? old('receiver.hurigana') : (Session::has('all.data.receiver') ? session('all.data.receiver.hurigana') : '') }}" placeholder="例）ヤマダタロウ">
                            
                            @if ($errors->has('receiver.hurigana'))
                                <div class="help-block text-danger receiver-error">
                                    <span class="fa fa-exclamation form-control-feedback"></span>
                                    <span>{{ $errors->first('receiver.hurigana') }}</span>
                                </div>
                            @endif
                        </td>
                     </tr>
                     
                     <tr class="form-group">
                         <th><label class="control-label">配送先電話番号</label><em>必須</em><br>
                         	<small>例）09012345678 ハイフンなし半角数字</small>
                         </th>
                           <td>
                            <input type="text" class="form-control col-md-12{{ $errors->has('receiver.tel_num') ? ' is-invalid' : '' }}" name="receiver[tel_num]" value="{{ Ctm::isOld() ? old('receiver.tel_num') : (Session::has('all.data.receiver') ? session('all.data.receiver.tel_num') : '') }}" placeholder="例）09012345678 ハイフンなし半角数字">
                            
                            @if ($errors->has('receiver.tel_num'))
                                <div class="help-block text-danger receiver-error">
                                    <span class="fa fa-exclamation form-control-feedback"></span>
                                    <span>{{ $errors->first('receiver.tel_num') }}</span>
                                </div>
                            @endif
                        </td>
                     </tr>
                     
                     
                     
                     <tr class="form-group">
                         <th><label class="control-label">配送先郵便番号</label><em>必須</em><br>
                         	<small>例）1234567 ハイフンなし半角数字</small>
                         </th>
                           <td>
                            <input id="zipcode_2" type="text" class="form-control col-md-6{{ $errors->has('receiver.post_num') ? ' is-invalid' : '' }}" name="receiver[post_num]" value="{{ Ctm::isOld() ? old('receiver.post_num') : (Session::has('all.data.receiver') ? session('all.data.receiver.post_num') : '') }}" placeholder="例）1234567 ハイフンなし半角数字">
                            
                            @if ($errors->has('receiver.post_num'))
                                <div class="help-block help-block text-danger receiver-error">
                                    <span class="fa fa-exclamation form-control-feedback"></span>
                                    <span>{{ $errors->first('receiver.post_num') }}</span>
                                </div>
                            @endif
                        </td>
                     </tr>
                     
                     <tr class="form-group">
                         <th><label class="control-label">配送先都道府県</label><em>必須</em></th>
                           <td>
                            <select id="pref_2" class="form-control select-first col-md-6{{ $errors->has('receiver.prefecture') ? ' is-invalid' : '' }}" name="receiver[prefecture]">
                                <option disabled selected>選択して下さい</option>

                                @foreach($prefs as $pref)
                                    <?php
                                        $selected = '';
                                        if(Ctm::isOld()) {
                                            if(old('receiver.prefecture') == $pref->name)
                                                $selected = ' selected';
                                        }
                                        else {
                                            if(Session::has('all.data.receiver') && session('all.data.receiver.prefecture') == $pref->name) {
                                                $selected = ' selected';
                                            }
                                        }
                                    ?>
                                    <option value="{{ $pref->name }}"{{ $selected }}>{{ $pref->name }}</option>
                                @endforeach
                            </select>
                            
                            @if ($errors->has('receiver.prefecture'))
                                <div class="help-block text-danger receiver-error">
                                    <span class="fa fa-exclamation form-control-feedback"></span>
                                    <span>{{ $errors->first('receiver.prefecture') }}</span>
                                </div>
                            @endif
                        </td>
                     </tr>
                     
                     <tr class="form-group">
                         <th><label class="control-label">配送先住所1（都市区）</label><em>必須</em></th>
                           <td>
                            <input id="address_2" type="text" class="form-control col-md-12{{ $errors->has('receiver.address_1') ? ' is-invalid' : '' }}" name="receiver[address_1]" value="{{ Ctm::isOld() ? old('receiver.address_1') : (Session::has('all.data.receiver') ? session('all.data.receiver.address_1') : '') }}" placeholder="例）小美玉市">
                            
                            @if ($errors->has('receiver.address_1'))
                                <div class="help-block text-danger receiver-error">
                                    <span class="fa fa-exclamation form-control-feedback"></span>
                                    <span>{{ $errors->first('receiver.address_1') }}</span>
                                </div>
                            @endif
                        </td>
                     </tr>
                     
                     <tr class="form-group">
                         <th><label class="control-label">配送先住所2（それ以降）</label><em>必須</em></th>
                           <td>
                            <input type="text" class="form-control col-md-12{{ $errors->has('receiver.address_2') ? ' is-invalid' : '' }}" name="receiver[address_2]" value="{{ Ctm::isOld() ? old('receiver.address_2') : (Session::has('all.data.receiver') ? session('all.data.receiver.address_2') : '') }}" placeholder="例）下吉影1-1">
                            
                            @if ($errors->has('receiver.address_2'))
                                <div class="help-block text-danger receiver-error">
                                    <span class="fa fa-exclamation form-control-feedback"></span>
                                    <span>{{ $errors->first('receiver.address_2') }}</span>
                                </div>
                            @endif
                        </td>
                     </tr>
                     
                     <tr class="form-group">
                         <th><label class="control-label">配送先住所3（建物/マンション名等）</label></th>
                           <td>
                            <input type="text" class="form-control col-md-12{{ $errors->has('receiver.address_3') ? ' is-invalid' : '' }}" name="receiver[address_3]" value="{{ Ctm::isOld() ? old('receiver.address_3') : (Session::has('all.data.receiver') ? session('all.data.receiver.address_3') : '') }}" placeholder="GRビル 101号">
                            
                            @if ($errors->has('receiver.address_3'))
                                <div class="help-block text-danger receiver-error">
                                    <span class="fa fa-exclamation form-control-feedback"></span>
                                    <span>{{ $errors->first('receiver.address_3') }}</span>
                                </div>
                            @endif
                        </td>
                     </tr>
                     
                     </table>
                </div> 
         </div><!-- receiver -->       
                
                <div>
                	<h3 class="card-header mt-5">お支払い方法</h3>
   
                    <fieldset class="form-group my-3 px-4 py-2{{ $errors->has('pay_method') ? ' border border-danger' : '' }}">
                    @if ($errors->has('pay_method'))
                        <div class="help-block text-danger mb-2">
                            <span class="fa fa-exclamation form-control-feedback"></span>
                            <span>{{ $errors->first('pay_method') }}</span>
                        </div>
                    @endif
                    {{-- <label class="d-block card-header">お支払い方法</label> --}}
                    @foreach($payMethod as $method)
                        <?php 
                            $checked = '';
                            
                            if( Ctm::isOld()) {
                            	if( old('pay_method') == $method->id) {
                                	$checked = ' checked';
                                }
                            }
                            elseif(Session::has('all.data.pay_method')) {
                            	if(session('all.data.pay_method') == $method->id) {
                                	$checked = ' checked';
                                }
                            }
                         ?>
                         
                         
                        <label class="d-block mb-2">
                        	@if(! $codCheck && $method->id == 5)
                         		<input type="radio" name="pay_method" class="payMethodRadio" value="{{ $method->id }}" disabled>{{ $method->name }}
                           		<span class="text-secondary ml-3"><i class="fas fa-exclamation-circle"></i> ご注文商品の代金引換決済はご利用できません。</span>      
                         	@else
                                <input type="radio" name="pay_method" class="payMethodRadio" value="{{ $method->id }}"{{ $checked }}>{{ $method->name }}
                            @endif
                        </label>
                        
                     @endforeach
                    
                </fieldset>
                </div>
                
                
                
                <div class="mb-5 pb-3">
                	<h3 class="card-header mt-5">配送希望日時指定</h3>
                    
                    <fieldset class="mb-4 mt-3 col-md-7 form-group{{ $errors->has('plan_date') ? ' has-error' : '' }}">
                        <label for="plan_date" class="control-label">■ご希望日程<span class="text-small"></span></label>
                        
                        <select class="form-control col-md-6{{ $errors->has('plan_date') ? ' is-invalid' : '' }}" name="plan_date">
                            <option value="希望なし（最短出荷）" selected>希望なし（最短出荷）</option>
                            	<?php 
                                	$days = array();
                                    $week = ['日', '月', '火', '水', '木', '金', '土'];
                                
                                    for($plusDay = 4; $plusDay < 64; $plusDay++) {
                                        $now = date('Y-m-d', time());
                                        $first = strtotime($now." +". $plusDay . " day");
                                        $days[] = date('Y/m/d', $first) . '（' . $week[date('w', $first)] . '）';
                                    }
                                ?>

                                @foreach($days as $day)
                                    <?php
                                        $selected = '';
                                        if(Ctm::isOld()) {
                                            if(old('plan_date') == $day)
                                                $selected = ' selected';
                                        }
                                        else {
                                            if(Session::has('all.data.plan_date') && session('all.data.plan_date') == $day) {
                                                $selected = ' selected';
                                            }
                                        }
                                    ?>
                                    <option value="{{ $day }}"{{ $selected }}>{{ $day }}</option>
                                @endforeach
                        </select>
                        
                        @if ($errors->has('plan_date'))
                            <span class="help-block">
                                <strong>{{ $errors->first('plan_date') }}</strong>
                            </span>
                        @endif

						{{--
                        <textarea id="plan_date" type="text" class="form-control" name="plan_date" rows="2">{{ Ctm::isOld() ? old('plan_date') : (Session::has('all.data.plan_date') ? session('all.data.plan_date') : '') }}</textarea>
                        --}}

                        
                	</fieldset>
				
                @if(count($dgGroup) > 0)
                    <fieldset class="form-group my-3 px-3 py-2{{ $errors->has('deli_time.*') ? ' border border-danger' : '' }}">
                        @if ($errors->has('deli_time.*'))
                            <div class="help-block text-danger mb-2">
                                <span class="fa fa-exclamation form-control-feedback"></span>
                                <span>{{ $errors->first('deli_time.*') }}</span>
                            </div>
                        @endif
                        
                        @foreach($dgGroup as $key => $val)
                            <div class="mb-3 pb-2">
                            
                            @if(session()->has('item.data') && count(session('item.data')) > 0)
                                <p>■下記の商品につきまして、ご希望配送時間の指定ができます。</p>
                                 @foreach($val as $itemId)
                                    ・<b>{{ Item::find($itemId)->title }}</b><br>
                                 @endforeach
                            @endif
                             
                            
                            <label class="d-block mt-2 mb-3 ml-1">
                                <?php
                                    $timeTable = DeliveryGroup::find($key)->time_table;
                                    $timeTable = explode(",", $timeTable);
                                ?>
                                
                                <input type="radio" name="plan_time[{{$key}}]" class="payMethodRadio" value="希望しない" checked><span class="mr-3">希望しない</span>
                                @foreach($timeTable as $table)
                                    <?php 
                                        $checked = '';
                                        
                                        if( Ctm::isOld()) {
                                            if( old('plan_time.'.$key) == $table) {
                                                $checked = ' checked';
                                            }
                                        }
                                        elseif(Session::has('all.data.plan_time.'.$key)) {
                                            if(session('all.data.plan_time.'.$key) == $table) {
                                                $checked = ' checked';
                                            }
                                        }
                                     ?>
                                    <input type="radio" name="plan_time[{{$key}}]" class="payMethodRadio" value="{{ $table }}" {{ $checked }}><span class="mr-3">{{ $table }}</span>
                                @endforeach
                                    
                            </label>
                            </div>
                            
                         @endforeach
                    
                	</fieldset>
                @endif
                
                </div>
                

        <input type="hidden" name="regist" value="{{ $regist }}">
       <button class="btn btn-block btn-custom col-md-3 mb-4 mx-auto py-2 mt-5" type="submit" name="recognize" value="1">確認する</button>                 
    </form>
    
</div>
<a href="{{ url('shop/cart') }}" class="btn border-secondary bg-white mt-5">
<i class="fas fa-angle-double-left"></i> カートに戻る
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


