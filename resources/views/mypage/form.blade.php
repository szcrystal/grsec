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
             <th>電話番号<em>必須</em>
             	{{-- <small>例）09012345678ハイフンなし半角数字</small> --}}
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
             	{{-- <small>例）1234567ハイフンなし半角数字</small> --}}
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
               		<div class="select-wrap col-md-6 p-0">
            			<select id="pref" class="form-control select-first{{ $errors->has('user.prefecture') ? ' is-invalid' : '' }}" name="user[prefecture]">
                            <option style="display:none;" disabled selected>選択して下さい</option>

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
                                
                                <option class="text-danger" value="{{ $pref->name }}"{{ $selected }}>{{ $pref->name }}</option>
                                
                            @endforeach
                		</select>
                	</div>
                
                    @if ($errors->has('user.prefecture'))
                        <div class="help-block text-danger">
                            <span class="fa fa-exclamation form-control-feedback"></span>
                            <span>{{ $errors->first('user.prefecture') }}</span>
                        </div>
                    @endif
            </td>
         </tr>
         
         <tr class="form-group">
            <th>住所1（都市区それ以降）<em>必須</em></th>
            <td>
                    <input id="address" type="text" class="form-control rounded-0 col-md-12{{ $errors->has('user.address_1') ? ' is-invalid' : '' }}" name="user[address_1]" value="{{ Ctm::isOld() ? old('user.address_1') : (isset($user) ? $user->address_1 : '') }}" placeholder="例）小美玉市下吉影1-1">
                    
                    @if ($errors->has('user.address_1'))
                        <div class="help-block text-danger">
                            <span class="fa fa-exclamation form-control-feedback"></span>
                            <span>{{ $errors->first('user.address_1') }}</span>
                        </div>
                    @endif
            </td>
         </tr>
         
         <tr class="form-group">
             <th>住所2（建物/マンション名等）<em>必須</em></th>
               <td>
                <input type="text" class="form-control rounded-0 col-md-12{{ $errors->has('user.address_2') ? ' is-invalid' : '' }}" name="user[address_2]" value="{{ Ctm::isOld() ? old('user.address_2') : (isset($user) ? $user->address_2 : '') }}" placeholder="例）GRビル 101号">
                
                @if ($errors->has('user.address_2'))
                    <div class="help-block text-danger">
                        <span class="fa fa-exclamation form-control-feedback"></span>
                        <span>{{ $errors->first('user.address_2') }}</span>
                    </div>
                @endif
            </td>
         </tr>
         
         
         {{--
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
         --}}
         
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
         
         <tr>
         	<th>
            	@if(! $isMypage)
	                パスワード<em>必須</em>
            	@else
                	パスワードの変更
                @endif
            </th>
            <td>
            	@if(! $isMypage)
                    <input type="password" class="form-control rounded-0 col-md-12{{ $errors->has('user.password') ? ' is-invalid' : '' }}" name="user[password]" value="{{ Ctm::isOld() ? old('user.password') : (Session::has('all.data.user') ? session('all.data.user.password') : '') }}" placeholder="8文字以上（半角）">
                                        
                    @if ($errors->has('user.password'))
                        <div class="help-block text-danger">
                            <span class="fa fa-exclamation form-control-feedback"></span>
                            <span>{{ $errors->first('user.password') }}</span>
                        </div>
                    @endif
                    
                @else
					パスワードの変更は <a href="{{ url('password/reset') }}">こちら <i class="fal fa-angle-double-right"></i></a>
                @endif
            </td>
         </tr>
         
         @if(! $isMypage)
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
         @endif
         
    </table>
</div> 


 {{--
 @include('mypage.genderBirth')
 --}}                   


<div id="magazine" class="table-responsive table-custom">
<p class="mt-3 mb-0 ml-2 text-small">当店からのお知らせを希望しますか？</p>
    <table class="table">
      
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
                
                <input id="user-magazine" type="checkbox" name="user[magazine]" value="1"{{ $checked }}>
                <label for="user-magazine" class="checks">登録する</label>
                
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
 
    
@if($isMypage)
    <div class="table-responsive table-custom mt-5">
        <table class="table table-borderd border">
             <tr class="form-group">
                <th>
                    登録済クレジットカード
                    <small>＊登録最大数5つまで</small>
                    <small>＊カード情報の登録は購入時に出来ます。</small>
                </th>
                <td>
                    @if(count($regCardDatas) > 0)
                        <div class="wrap-regist-card mt-3 mb-2">
                            @if(isset($regCardErrors))
                                <span class="d-inline-block ml-2 mb-4 text-small">
                                    <span class="text-danger"><i class="fal fa-exclamation-triangle"></i> 登録カード情報が取得出来ません。</span>
                                    <br><small class="text-secondary">{{ $regCardErrors }}</small>
                                </span>
                            @else
                                
                                @foreach($regCardDatas['CardSeq'] as $k => $seqNum)
                                    <?php
                                        //ここではkeyもseqnumも同じものになる Array ( [0] => 0 [1] => 1 [2] => 2 [3] => 3)
                                    ?>
                                    
                                    @if(! $regCardDatas['DeleteFlag'][$k])
                                    
                                        <div class="mb-4 pb-1">
                                            
                                            <label class="mb-1"><i class="fas fa-square text-small text-gray"></i> カード番号： </label>
                                            <span>{{ $regCardDatas['CardNo'][$k] }}</span>
                                            <input type="hidden" name="user[card_num][{{ $seqNum }}]" value="{{ $regCardDatas['CardNo'][$k] }}">
                                            
                                            <?php
                                                //wordwrap($regCardDatas['Expire'][$k], 2, '/', 1)
                                                $y = substr($regCardDatas['Expire'][$k], 0, 2); //年
                                                $m = substr($regCardDatas['Expire'][$k], 2); //月
                                            ?>
                                            
                                            <small class="d-block ml-3">有効期限（月/年）：{{ $m.'/'.$y }}</small>
                                            <input type="hidden" name="user[card_expire][{{ $seqNum }}]" value="{{ $m.'/'.$y }}">
                                            
                                            <div class="mt-2 mb-4 ml-2 pl-1">
                                                
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
                                            
                                                <div class="mb-2">
                                                    <input id="editCardRadio-{{ $seqNum }}-1" type="radio" name="user[edit_mode][{{ $seqNum }}]" class="editCardRadio" value="0" checked>
                                                    <label for="editCardRadio-{{ $seqNum }}-1" class="radios">変更しない</label>
                                                </div>
                                                
                                                <div class="mb-2">
                                                    <input id="editCardRadio-{{ $seqNum }}-2" type="radio" name="user[edit_mode][{{ $seqNum }}]" class="editCardRadio" value="1"{{ $radioChecked }}>
                                                    <label for="editCardRadio-{{ $seqNum }}-2" class="radios">有効期限（月/年）を変更する</label>
                                                </div>

                                                <div class="wrap-expire ml-3 pl-1 mb-3" data-seq="{{ $seqNum }}">
                                                	<div class="select-wrap d-inline-block col-md-2 p-0">
                                                        <select id="expire_month" class="form-control{{ $errors->has('user.expire_month.'.$seqNum) || $errors->has('user.expire.'.$seqNum) ? ' is-invalid' : '' }}" name="user[expire_month][{{ $seqNum }}]">
                                                            
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
                                                    </div>
                                                    <span class="mr-4">月</span>
                                                    
                                                    @if ($errors->has('user.expire_month.'.$seqNum))
                                                        <div class="help-block text-danger">
                                                            <span class="fa fa-exclamation form-control-feedback"></span>
                                                            <span>{{ $errors->first('user.expire_month.'.$seqNum) }}</span>
                                                        </div>
                                                    @endif
                                                    
                                                    <div class="select-wrap d-inline-block col-md-2 p-0">
                                                        <select id="expire_year" class="form-control{{ $errors->has('user.expire_year.'.$seqNum) || $errors->has('user.expire.'.$seqNum) ? ' is-invalid' : '' }}" name="user[expire_year][{{ $seqNum }}]">
                                                            
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
                                                    </div>
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
                                                
                                                
                                                <div class="mt-2">
                                                    <input id="editCardRadio-{{ $seqNum }}-3" type="radio" name="user[edit_mode][{{ $seqNum }}]" class="editCardRadio" value="2"{{ $radioCheckedSec }}>
                                                    <label for="editCardRadio-{{ $seqNum }}-3" class="radios">このカードを削除する</label>
                                                </div>
                                                    
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


