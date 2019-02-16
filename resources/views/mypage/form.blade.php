@extends('layouts.app')

@section('content')


	{{-- @include('main.shared.carousel') --}}

<div id="main" class="top">

        <div class="panel panel-default">

            <div class="panel-body">
                {{-- @include('main.shared.main') --}}

				<div class="main-list clearfix">
<h3 class="mb-3 card-header">会員登録情報の入力</h3>

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

@if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
@endif

<div class="">
<?php
$url = $isMypage ? url('mypage/register') : url('register');
?>

<form class="form-horizontal" role="form" method="POST" action="{{ $url }}">

    {{ csrf_field() }}

<div class="table-responsive table-custom">
    <table class="table table-borderd border">
        
        <tr class="form-group">
             <th>氏名<em>必須</em></th>
               <td>
                <input class="form-control rounded-0 col-md-12{{ $errors->has('user.name') ? ' is-invalid' : '' }}" name="user[name]" value="{{ Ctm::isOld() ? old('user.name') : (isset($user) ? $user->name : '') }}" placeholder="例）山田太郎">
               
                @if ($errors->has('user.name'))
                    <div class="text-danger">
                        <span class="fa fa-exclamation form-control-feedback"></span>
                        <span>{{ $errors->first('user.name') }}</span>
                    </div>
                @endif
            </td>
         </tr> 
      
          <tr class="form-group">
             <th>フリガナ<em>必須</em></th>
               <td>
                <input type="text" class="form-control rounded-0 col-md-12{{ $errors->has('user.hurigana') ? ' is-invalid' : '' }}" name="user[hurigana]" value="{{ Ctm::isOld() ? old('user.hurigana') : (isset($user) ? $user->hurigana : '') }}" placeholder="例）ヤマダタロウ">
                
                @if ($errors->has('user.hurigana'))
                    <div class="text-danger">
                        <span class="fa fa-exclamation form-control-feedback"></span>
                        <span>{{ $errors->first('user.hurigana') }}</span>
                    </div>
                @endif
            </td>
         </tr>
         
         <tr class="form-group">
             <th>メールアドレス<em>必須</em></th>
               <td>
                <input type="email" class="form-control rounded-0 col-md-12{{ $errors->has('user.email') ? ' is-invalid' : '' }}" name="user[email]" value="{{ Ctm::isOld() ? old('user.email') : (isset($user) ? $user->email : '') }}" placeholder="例）abcde@example.com">
                
                @if ($errors->has('user.email'))
                    <div class="help-block text-danger">
                        <span class="fa fa-exclamation form-control-feedback"></span>
                        <span>{{ $errors->first('user.email') }}</span>
                    </div>
                @endif
            </td>
         </tr>
         
         <tr class="form-group">
             <th>電話番号<em>必須</em>
             	<small>例）09012345678ハイフンなし半角数字</small>
             </th>
               <td>
                <input type="text" class="form-control rounded-0 col-md-12{{ $errors->has('user.tel_num') ? ' is-invalid' : '' }}" name="user[tel_num]" value="{{ Ctm::isOld() ? old('user.tel_num') : (isset($user) ? $user->tel_num : '') }}" placeholder="例）09012345678 ハイフンなし半角数字">
                
                @if ($errors->has('user.tel_num'))
                    <div class="help-block text-danger">
                        <span class="fa fa-exclamation form-control-feedback"></span>
                        <span>{{ $errors->first('user.tel_num') }}</span>
                    </div>
                @endif
            </td>
         </tr>
         
         <tr class="form-group">
             <th>郵便番号<em>必須</em>
             	<small>例）1234567ハイフンなし半角数字</small>
             </th>
               <td>
                <input id="zipcode" type="text" class="form-control rounded-0 col-md-6{{ $errors->has('user.post_num') ? ' is-invalid' : '' }}" name="user[post_num]" value="{{ Ctm::isOld() ? old('user.post_num') : (isset($user) ? $user->post_num : '') }}" placeholder="例）1234567 ハイフンなし半角数字">
                
                @if ($errors->has('user.post_num'))
                    <div class="help-block text-danger">
                        <span class="fa fa-exclamation form-control-feedback"></span>
                        <span>{{ $errors->first('user.post_num') }}</span>
                    </div>
                @endif
            </td>
         </tr>
         
         <tr class="form-group">
             <th>都道府県<em>必須</em></th>
               <td>
                <select id="pref" class="form-control rounded-0 select-first col-md-6{{ $errors->has('user.prefecture') ? ' is-invalid' : '' }}" name="user[prefecture]">
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
             <th>住所1（都市区）<em>必須</em></th>
               <td>
                <input id="address" type="text" class="form-control rounded-0 col-md-12{{ $errors->has('user.address_1') ? ' is-invalid' : '' }}" name="user[address_1]" value="{{ Ctm::isOld() ? old('user.address_1') : (isset($user) ? $user->address_1 : '') }}" placeholder="例）小美玉市">
                
                @if ($errors->has('user.address_1'))
                    <div class="help-block text-danger">
                        <span class="fa fa-exclamation form-control-feedback"></span>
                        <span>{{ $errors->first('user.address_1') }}</span>
                    </div>
                @endif
            </td>
         </tr>
         
         <tr class="form-group">
             <th>住所2（それ以降）<em>必須</em></th>
               <td>
                <input type="text" class="form-control rounded-0 col-md-12{{ $errors->has('user.address_2') ? ' is-invalid' : '' }}" name="user[address_2]" value="{{ Ctm::isOld() ? old('user.address_2') : (isset($user) ? $user->address_2 : '') }}" placeholder="例）下吉影1-1">
                
                @if ($errors->has('user.address_2'))
                    <div class="help-block text-danger">
                        <span class="fa fa-exclamation form-control-feedback"></span>
                        <span>{{ $errors->first('user.address_2') }}</span>
                    </div>
                @endif
            </td>
         </tr>
         
         <tr class="form-group">
             <th>住所3（建物/マンション名等）</th>
               <td>
                <input type="text" class="form-control rounded-0 col-md-12{{ $errors->has('user.address_3') ? ' is-invalid' : '' }}" name="user[address_3]" value="{{ Ctm::isOld() ? old('user.address_3') : (isset($user) ? $user->address_3 : '') }}" placeholder="例）GRビル 101号">
                
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
         <p class="mt-4 text-small">よろしければ以下もお答え下さい。</p>
   		 <table class="table table-borderd border">

         <tr>
         	<fieldset  class="form-group">
             <th>性別</th>
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
            </fieldset>
         </tr>
        
        
         <tr class="form-group">
             <th>生年月日</th>
               <td class="wrap-birth">
                   
                <select class="form-control rounded-0 select-first col-md-2 d-inline{{ $errors->has('user.birth_year') ? ' is-invalid' : '' }}" name="user[birth_year]">
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
                            else if(isset($user) && $user->birth_year) {
                                if($user->birth_year == $y) {
                                //if(Session::has('all.data.user')  && session('all.data.user.birth_year') == $y) {
                                    $selected = ' selected';
                                }
                            }
                            else {
                                if($y == 1970) {
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
                
                <select class="form-control rounded-0 select-first col-md-1 d-inline{{ $errors->has('user.birth_month') ? ' is-invalid' : '' }}" name="user[birth_month]">
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
         
         </table>
         </div>
         
<div id="magazine" class="table-responsive table-custom">
<p class="mt-4 text-small">当店からのお知らせを希望しますか？</p>
    <table class="table table-borderd border">
      
         <tr class="form-group">
             <th>メールマガジンの登録</th>
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
    </table>
    </div>
    
<div class="table-responsive table-custom">
	@if(! $isMypage)
		<p class="mt-4 text-small">8文字以上（半角）で、忘れないものを入力して下さい。<br>メールアドレスとパスワードは当店をご利用の際に必要となります。</p>
	@endif
    
         
    @if(! $isMypage)
    	<table class="table table-borderd border">
             <tr class="form-group">
                 <th>パスワード<em>必須</em></th>
                   <td>
                    <input type="password" class="form-control rounded-0 col-md-12{{ $errors->has('user.password') ? ' is-invalid' : '' }}" name="user[password]" value="{{ Ctm::isOld() ? old('user.password') : (Session::has('all.data.user') ? session('all.data.user.password') : '') }}" placeholder="8文字以上">
                                        
                    @if ($errors->has('user.password'))
                        <div class="help-block text-danger">
                            <span class="fa fa-exclamation form-control-feedback"></span>
                            <span>{{ $errors->first('user.password') }}</span>
                        </div>
                    @endif
                </td>
             </tr>
             
             <tr class="form-group">
                <th>パスワードの確認<em>必須</em></th>
                <td>
                    <input type="password" class="form-control rounded-0 col-md-12{{ $errors->has('user.password_confirmation') ? ' is-invalid' : '' }}" name="user[password_confirmation]" value="{{ Ctm::isOld() ? old('user.password_confirmation') : (Session::has('all.data.user') ? session('all.data.user.password_confirmation') : '') }}">
                    
                    @if ($errors->has('user.password_confirmation'))
                        <div class="help-block text-danger">
                            <span class="fa fa-exclamation form-control-feedback"></span>
                            <span>{{ $errors->first('user.password_confirmation') }}</span>
                        </div>
                    @endif
                </td>
             </tr>
             
    @else
        <table class="table table-borderd border mt-5">
            <tr class="form-group"> 
                <th>パスワードの変更</th>
                <td>
                    パスワードの変更は <a href="{{ url('password/reset') }}">こちら <i class="fal fa-angle-double-right"></i></a>
                </td>
            </tr>
             
    @endif
    
    </table>
 </div>            
 
    
@if($isMypage)
    <div class="table-responsive table-custom mt-5">
        <table class="table table-borderd border">
             <tr class="form-group">
                <th>
                    登録済クレジットカード
                    <small>＊登録最大数5つまで</small>
                    <small>＊カード情報の新規登録は購入時に出来ます。</small>
                </th>
                <td>
                    @if(count($regCardDatas) > 0)
                        <div class="wrap-regist-card mt-3 mb-2">
                            @if(isset($regCardErrors))
                                <span class="d-inline-block ml-2 mb-4 text-small">
                                    <span class="text-danger"><i class="fal fa-exclamation-triangle"></i> 登録カード情報が取得出来ません。</span><br>
                                    {{ $regCardErrors }}
                                </span>
                            @else
                                
                                @foreach($regCardDatas['CardSeq'] as $k => $seqNum)
                                    <?php
                                        //ここではkeyもseqnumも同じものになる Array ( [0] => 0 [1] => 1 [2] => 2 [3] => 3)
                                    ?>
                                    
                                    @if(! $regCardDatas['DeleteFlag'][$k])
                                    
                                        <div class="mb-4 pb-1">
                                            
                                            <label><i class="fas fa-square text-small text-gray"></i> カード番号： </label>
                                            <span>{{ $regCardDatas['CardNo'][$k] }}</span>
                                            <input type="hidden" name="user[card_num][{{ $seqNum }}]" value="{{ $regCardDatas['CardNo'][$k] }}">
                                            
                                            <?php
                                                //wordwrap($regCardDatas['Expire'][$k], 2, '/', 1)
                                                $y = substr($regCardDatas['Expire'][$k], 0, 2); //年
                                                $m = substr($regCardDatas['Expire'][$k], 2); //月
                                            ?>
                                            
                                            <small class="d-block ml-3">有効期限（月/年）：{{ $m.'/'.$y }}</small>
                                            <input type="hidden" name="user[card_expire][{{ $seqNum }}]" value="{{ $m.'/'.$y }}">
                                        

                                            <div class="mt-3 mb-4 ml-2">
                                                
                                                <?php
                                                    $time = new DateTime('now');
                                                    $expireYear = $time->format('y');
                                                    //$withYoubi .= ' (' . $week[$time->format('w')] . ')';
                                                
                                                    $yn = 0;
                                                    $mn = 1;
                                                    
                                                    
                                                    $radioChecked = '';
                                                    $radioCheckedSec = '';
                                                    
                                                    if( Ctm::isOld()) {
                                                        if(old('user.edit_mode.'.$seqNum) == 1) {
                                                            $radioChecked = ' checked';
                                                        }
                                                        elseif(old('user.edit_mode.'.$seqNum) == 2) {
                                                            $radioCheckedSec = ' checked';
                                                        }
                                                    }
                                                ?>
                                            
                                                <label class="d-block mb-3">
                                                    <input type="radio" name="user[edit_mode][{{ $seqNum }}]" class="editCardRadio ml-2" value="0" checked> 変更しない
                                                </label>
                                                
                                                <label class="d-block mb-3">
                                                    <input type="radio" name="user[edit_mode][{{ $seqNum }}]" class="editCardRadio ml-2" value="1"{{ $radioChecked }}> 有効期限（月/年）を変更する
                                                </label>

                                                <div class="wrap-expire ml-3 pl-1 mb-3" data-seq="{{ $seqNum }}">
                                                    <select id="expire_month" class="form-control d-inline-block col-md-2{{ $errors->has('user.expire_month.'.$seqNum) || $errors->has('user.expire.'.$seqNum) ? ' is-invalid' : '' }}" name="user[expire_month][{{ $seqNum }}]">
                                                        
                                                        @while($mn < 13)
                                                            <?php
                                                                $expireMonth = str_pad($mn, 2, 0, STR_PAD_LEFT); //2桁0埋め
                                                                
                                                                $selected = '';
                                                                if(Ctm::isOld()) {
                                                                    if(old('user.expire_month.'.$seqNum) == $expireMonth)
                                                                        $selected = ' selected';
                                                                }
                                                                else {
                                                                    if($mn == $m) {
                                                                        $selected = ' selected';
                                                                    }
                                                                }
                                                            ?>
                                                            
                                                            <option value="{{ $expireMonth }}"{{ $selected }}>{{ $expireMonth }}</option>
                                                            
                                                            <?php $mn++; ?>
                                                        @endwhile
                                                    </select>
                                                    <span class="mr-4">月</span>
                                                    
                                                    @if ($errors->has('user.expire_month.'.$seqNum))
                                                        <div class="help-block text-danger">
                                                            <span class="fa fa-exclamation form-control-feedback"></span>
                                                            <span>{{ $errors->first('user.expire_month.'.$seqNum) }}</span>
                                                        </div>
                                                    @endif
                                                    
                                                    <select id="expire_year" class="form-control d-inline-block col-md-2{{ $errors->has('user.expire_year.'.$seqNum) || $errors->has('user.expire.'.$seqNum) ? ' is-invalid' : '' }}" name="user[expire_year][{{ $seqNum }}]">
                                                        
                                                        @while($yn < 11)
                                                            <?php
                                                                $selected = '';
                                                                if(Ctm::isOld()) {
                                                                    if(old('user.expire_year.'.$seqNum) == $expireYear + $yn)
                                                                        $selected = ' selected';
                                                                }
                                                                else {
                                                                    if($expireYear + $yn == $y) {
                                                                        $selected = ' selected';
                                                                    }
                                                                }
                                                            ?>
                                                            
                                                            <option value="{{ $expireYear + $yn }}"{{ $selected }}>{{ $expireYear + $yn }}</option>
                                                            
                                                            <?php $yn++; ?>
                                                        @endwhile
                                                    </select>
                                                    <span>年</span>
                                                    
                                                    @if ($errors->has('user.expire_year.'.$seqNum))
                                                        <div class="help-block text-danger">
                                                            <span class="fa fa-exclamation form-control-feedback"></span>
                                                            <span>{{ $errors->first('user.expire_year.'.$seqNum) }}</span>
                                                        </div>
                                                    @endif
                                                    
                                                    <input type="hidden" name="user[expire][{{ $seqNum }}]" value="">
                                                    @if ($errors->has('user.expire.'.$seqNum))
                                                        <div class="help-block text-danger mt-1">
                                                            <span class="fa fa-exclamation form-control-feedback"></span>
                                                            <span>{{ $errors->first('user.expire.'.$seqNum) }}</span>
                                                        </div>
                                                    @endif
                                                
                                                </div>
                                                
                                                
                                                <label class="d-block mt-3">
                                                    <input type="radio" name="user[edit_mode][{{ $seqNum }}]" class="editCardRadio ml-2" value="2"{{ $radioCheckedSec }}> このカードを削除する
                                                </label>
                                                    
                                                @if ($errors->has('user.card_del.'. $seqNum))
                                                    <div class="help-block text-danger">
                                                        <span class="fa fa-exclamation form-control-feedback"></span>
                                                        <span>{{ $errors->first('user.card_del.'. $seqNum) }}</span>
                                                    </div>
                                                @endif
                                            
                                            </div>
                                        
                                        </div>
                                    
                                    @endif
                                    
                                @endforeach
                            @endif
                            
                        </div>
                    @else
                        現在、登録しているカードはありません。<br>
                        新規登録はお買い物中に登録出来ます。
                    @endif  
                    
                </td>
             </tr>
        </table>
     </div>
@endif
         
         
    <div class="mt-4 mb-4">
        <button class="btn btn-block btn-custom col-md-4 mx-auto py-2" type="submit" name="recognize" value="1">確認する</button>
    </div>                
</form>

@if($isMypage)
<a href="{{ url('mypage') }}" class="btn border-secondary bg-white my-3">
<i class="fal fa-angle-double-left"></i> マイページに戻る
</a>
@endif

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


