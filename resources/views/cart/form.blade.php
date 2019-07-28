@extends('layouts.app')

@section('content')

<?php
use App\Item;
use App\DeliveryGroup;
?>

	{{-- @include('main.shared.carousel') --}}

<div id="main" class="cart-form">

<div class="clearfix">

@include('cart.shared.guide', ['active'=>2])

@if(count($cardErrors) > 0)
	<div class="alert alert-danger">
        <i class="far fa-exclamation-triangle"></i> 確認して下さい。
        <ul class="mt-2">
            @foreach ($cardErrors as $cardError)
                <li>{{ $cardError }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if (count($errors) > 0)
    <div class="alert alert-danger">
        <i class="far fa-exclamation-triangle"></i>
        @if ($errors->has('no_delivery.*'))
        	配送不可の商品があります。
        @else
        	確認して下さい。
        @endif
        
        <ul class="mt-2">
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
<div class="table-responsive table-normal">
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
             {{ $userObj->prefecture }}{{ $userObj->address_1 }} {{ $userObj->address_2 }}<br>
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
             <th>氏名<em>必須</em></th>
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
             <th>フリガナ<em>必須</em></th>
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
             <th>電話番号<em>必須</em>
             	{{-- <small>例）09012345678ハイフンなし半角数字</small> --}}
             </th>
               <td>
                <input type="text" class="form-control col-md-12{{ $errors->has('user.tel_num') ? ' is-invalid' : '' }}" name="user[tel_num]" value="{{ Ctm::isOld() ? old('user.tel_num') : (Session::has('all.data.user') ? session('all.data.user.tel_num') : '') }}" placeholder="例）09012345678（ハイフンなし半角数字）">
                
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
                <input id="zipcode" type="text" class="form-control col-md-6{{ $errors->has('user.post_num') ? ' is-invalid' : '' }}" name="user[post_num]" value="{{ Ctm::isOld() ? old('user.post_num') : (Session::has('all.data.user') ? session('all.data.user.post_num') : '') }}" placeholder="例）1234567（ハイフンなし半角数字）">
                
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
             <th>住所1<span class="text-small">（都市区それ以降）</span><em>必須</em></th>
               <td>
                <input id="address" type="text" class="form-control col-md-12{{ $errors->has('user.address_1') ? ' is-invalid' : '' }}" name="user[address_1]" value="{{ Ctm::isOld() ? old('user.address_1') : (Session::has('all.data.user') ? session('all.data.user.address_1') : '') }}" placeholder="例）小美玉市下吉影1-1">
                
                @if ($errors->has('user.address_1'))
                    <div class="help-block text-danger">
                        <span class="fa fa-exclamation form-control-feedback"></span>
                        <span>{{ $errors->first('user.address_1') }}</span>
                    </div>
                @endif
            </td>
         </tr>
         
         <tr class="form-group">
             <th>住所2<span class="text-small">（建物/マンション名等）</span></th>
               <td>
                <input type="text" class="form-control col-md-12{{ $errors->has('user.address_2') ? ' is-invalid' : '' }}" name="user[address_2]" value="{{ Ctm::isOld() ? old('user.address_2') : (Session::has('all.data.user') ? session('all.data.user.address_2') : '') }}" placeholder="例）GRビル 101号">
                
                @if ($errors->has('user.address_2'))
                    <div class="help-block text-danger">
                        <span class="fa fa-exclamation form-control-feedback"></span>
                        <span>{{ $errors->first('user.address_2') }}</span>
                    </div>
                @endif
            </td>
         </tr>
         
         
         <tr class="form-group">
             <th>メールアドレス<em>必須</em></th>
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
             <th>パスワード<em>必須</em></th>
               <td>
                <input type="password" class="form-control col-md-12{{ $errors->has('user.password') ? ' is-invalid' : '' }}" name="user[password]" value="{{ Ctm::isOld() ? old('user.password') : (Session::has('all.data.user') ? session('all.data.user.password') : '') }}" placeholder="8文字以上（半角）">
                                    
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
                <input type="password" class="form-control col-md-12{{ $errors->has('user.password_confirmation') ? ' is-invalid' : '' }}" name="user[password_confirmation]" value="{{ Ctm::isOld() ? old('user.password_confirmation') : (Session::has('all.data.user') ? session('all.data.user.password_confirmation') : '') }}">
                
                @if ($errors->has('user.password_confirmation'))
                    <div class="help-block text-danger">
                        <span class="fa fa-exclamation form-control-feedback"></span>
                        <span>{{ $errors->first('user.password_confirmation') }}</span>
                    </div>
                @endif
            </td>
         </tr>
         
         
         
         
         {{--
         <tr class="form-group">
             <th>住所3（）</th>
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
         --}}
         
        </table>
        </div>
         
         
         
        
        @if($regist)
            <div id="magazine" class="table-responsive table-custom">
                <p class="mt-3 text-small mb-0 ml-2 pl-1"><i class="fas fa-square"></i> 当店からのお知らせを希望しますか？</p>
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
                                if(Session::has('all.data.user')  && session('all.data.user.magazine')) {
                                    $checked = ' checked';
                                }
                            }
                        ?>
                        
                        <input id="check-magazine" type="checkbox" name="user[magazine]" value="1"{{ $checked }}>
                        <label for="check-magazine" class="checks">登録する</label>
                        
                        {{--
                        <input type="checkbox" name="user[magazine]" value="1"{{ $checked }}> 登録する
                        --}}
                        
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
        @endif
 

@endif {{-- AuthCheck --}}                     
        
        <div class="receiver">
            <h3 class="mt-4 card-header">お届け先</h3>     
                 
            <fieldset class="form-group mt-3 py-1">
                    <?php                            
                        $checked = '';
                        if(Ctm::isOld()) {
                             if(old('destination')) 
                                $checked = ' checked';
                        }
                        else {
                            if(Session::has('all.data.destination') && session('all.data.destination')) 
                                $checked = ' checked';
                                
                        }
                    ?>
                    
                    <div class="mb-2">
                    	<input id="radio-destination-1" type="radio" name="destination" value="0" checked>
                    	<label for="radio-destination-1" class="radios">登録先と同じ</label>
                    </div>
                    
                    <div class="">
                    	<input id="radio-destination-2" type="radio" name="destination" value="1"{{ $checked }}>
                    	<label for="radio-destination-2" class="radios">別の住所へお届け</label>
                    </div>
                    
                    {{--
                    <label class="d-block">                                      
                    	<input type="radio" name="destination" class="destinationRadio ml-2" value="0" checked> 登録先と同じ
                    </label>
                     
                    <label class="d-block">
                        <input type="radio" name="destination" class="destinationRadio ml-2" value="1"{{ $checked }}> 別の住所へお届け
                    </label>
                    --}}
                    
                    @if ($errors->has('receiver.*'))
                        <div class="help-block text-danger receiver-error">
                            <span class="fa fa-exclamation form-control-feedback"></span>
                            <span>上記登録先住所に配送をご希望の場合は「登録先と同じ」にチェックをして下さい。</span>
                        </div>
                    @endif
            </fieldset>     
        
            <div class="table-responsive table-custom receiver-wrap">
                <table class="table table-borderd border">

                    <tr class="form-group">
                         <th>配送先氏名<em>必須</em></th>
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
                         <th>配送先フリガナ<em>必須</em></th>
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
                         <th>配送先電話番号<em>必須</em>
                         	{{-- <small>例）09012345678ハイフンなし半角数字</small> --}}
                         </th>
                           <td>
                            <input type="text" class="form-control col-md-12{{ $errors->has('receiver.tel_num') ? ' is-invalid' : '' }}" name="receiver[tel_num]" value="{{ Ctm::isOld() ? old('receiver.tel_num') : (Session::has('all.data.receiver') ? session('all.data.receiver.tel_num') : '') }}" placeholder="例）09012345678（ハイフンなし半角数字）">
                            
                            @if ($errors->has('receiver.tel_num'))
                                <div class="help-block text-danger receiver-error">
                                    <span class="fa fa-exclamation form-control-feedback"></span>
                                    <span>{{ $errors->first('receiver.tel_num') }}</span>
                                </div>
                            @endif
                        </td>
                     </tr>
                     
                     
                     
                     <tr class="form-group">
                         <th>配送先郵便番号<em>必須</em>
                         	{{-- <small>例）1234567ハイフンなし半角数字</small> --}}
                         </th>
                           <td>
                            <input id="zipcode_2" type="text" class="form-control col-md-6{{ $errors->has('receiver.post_num') ? ' is-invalid' : '' }}" name="receiver[post_num]" value="{{ Ctm::isOld() ? old('receiver.post_num') : (Session::has('all.data.receiver') ? session('all.data.receiver.post_num') : '') }}" placeholder="例）1234567（ハイフンなし半角数字）">
                            
                            @if ($errors->has('receiver.post_num'))
                                <div class="help-block help-block text-danger receiver-error">
                                    <span class="fa fa-exclamation form-control-feedback"></span>
                                    <span>{{ $errors->first('receiver.post_num') }}</span>
                                </div>
                            @endif
                        </td>
                     </tr>
                     
                     <tr class="form-group">
                        <th>配送先都道府県<em>必須</em></th>
                        <td>
                           	<div class="select-wrap col-md-6 p-0">
                                <select id="pref_2" class="form-control select-first {{ $errors->has('receiver.prefecture') ? ' is-invalid' : '' }}" name="receiver[prefecture]">
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
                             </div>   
                            
                            @if ($errors->has('receiver.prefecture'))
                                <div class="help-block text-danger receiver-error">
                                    <span class="fa fa-exclamation form-control-feedback"></span>
                                    <span>{{ $errors->first('receiver.prefecture') }}</span>
                                </div>
                            @endif
                            
                        </td>
                     </tr>
                     
                     <tr class="form-group">
                         <th>配送先住所1<span class="text-small">（都市区それ以降）</span><em>必須</em></th>
                           <td>
                            <input id="address_2" type="text" class="form-control col-md-12{{ $errors->has('receiver.address_1') ? ' is-invalid' : '' }}" name="receiver[address_1]" value="{{ Ctm::isOld() ? old('receiver.address_1') : (Session::has('all.data.receiver') ? session('all.data.receiver.address_1') : '') }}" placeholder="例）小美玉市下吉影1-1">
                            
                            @if ($errors->has('receiver.address_1'))
                                <div class="help-block text-danger receiver-error">
                                    <span class="fa fa-exclamation form-control-feedback"></span>
                                    <span>{{ $errors->first('receiver.address_1') }}</span>
                                </div>
                            @endif
                        </td>
                     </tr>
                     
                     <tr class="form-group">
                         <th>配送先住所2<span class="text-small">（建物/マンション名等）</span></th>
                           <td>
                            <input type="text" class="form-control col-md-12{{ $errors->has('receiver.address_2') ? ' is-invalid' : '' }}" name="receiver[address_2]" value="{{ Ctm::isOld() ? old('receiver.address_2') : (Session::has('all.data.receiver') ? session('all.data.receiver.address_2') : '') }}" placeholder="例）GRビル 101号">
                            
                            @if ($errors->has('receiver.address_2'))
                                <div class="help-block text-danger receiver-error">
                                    <span class="fa fa-exclamation form-control-feedback"></span>
                                    <span>{{ $errors->first('receiver.address_2') }}</span>
                                </div>
                            @endif
                        </td>
                     </tr>
                     
                     {{--
                     <tr class="form-group">
                         <th>配送先住所3（）</th>
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
                     --}}
                     
                     </table>
                </div> 
         </div><!-- receiver -->
         
                
                
                
                <div class="pt-3">
                	<h3 class="card-header mt-4">配送希望日時</h3>
                    
                    <fieldset class="mb-4 mt-3 col-md-7 form-group{{ $errors->has('plan_date') ? ' has-error' : '' }}">
                        <label for="plan_date" class="control-label">■ご希望日程<span class="text-small"></span></label>
                        
                        <div class="select-wrap col-md-6 p-0">
                        <select class="form-control {{ $errors->has('plan_date') ? ' is-invalid' : '' }}" name="plan_date">
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
                        </div>
                        
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
                            <div class="mb-2 py-2">
                            
                            @if(session()->has('item.data') && count(session('item.data')) > 0)
                                <p class="mb-1 pb-2">■下記の商品につきまして、ご希望配送時間の指定ができます。</p>
                                 @foreach($val as $itemId)
                                 	<?php $i = Item::find($itemId); ?>
                                    ・<b>{{ Ctm::getItemTitle($i) }}</b><br>
                                 @endforeach
                            @endif
                             
                            
                            <div class="mt-2 mb-3 ml-1">
                                <?php
                                    $timeTable = DeliveryGroup::find($key)->time_table;
                                    $timeTable = explode(",", $timeTable);
                                ?>
                                
                                <span class="deliRadioWrap">
                                	<input id="radio-deli-{{ $key }}-no" type="radio" name="plan_time[{{$key}}]" value="希望なし" class="deliRadio" checked>
                    				<label for="radio-deli-{{ $key }}-no" class="radios">希望なし</label>
                                    
                                    {{--
                                	<input type="radio" name="plan_time[{{$key}}]" class="deliRadio" value="希望なし" checked><span class="mr-3"> 希望なし</span>
                                    --}}
                                </span>
                                
                                @foreach($timeTable as $k => $table)
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
                                    
                                    <span class="deliRadioWrap">
                                    	<input id="radio-deli-{{ $key }}-{{ $k }}" type="radio" name="plan_time[{{$key}}]" value="{{ $table }}" class="deliRadio" {{ $checked }}>
                    					<label for="radio-deli-{{ $key }}-{{ $k }}" class="radios">{{ $table }}</label>
                                    	
                                        {{--
                                    	<input type="radio" name="plan_time[{{$key}}]" class="deliRadio" value="{{ $table }}" {{ $checked }}> <span class="mr-3">{{ $table }}</span>
                                        --}}
                                    </span>
                                @endforeach
                                    
                            </div>
                            </div>
                            
                         @endforeach
                    
                	</fieldset>
                @endif
                
                </div>
                
                <div>
                	<h3 class="card-header mt-4">その他コメント</h3>
                    
                    <fieldset class="form-group my-3 pb-4">
                        <textarea id="user_comment" class="form-control{{ $errors->has('user_comment') ? ' is-invalid' : '' }}" name="user_comment" rows="10">{{ Ctm::isOld() ? old('user_comment') : (Session::has('all.data.user_comment') ? session('all.data.user_comment') : '') }}</textarea>
                        
                        @if ($errors->has('user_comment'))
                            <div class="help-block text-danger receiver-error">
                                <span class="fa fa-exclamation form-control-feedback"></span>
                                <span>{{ $errors->first('user_comment') }}</span>
                            </div>
                        @endif
                    </fieldset>
                </div>
                
                
                <div>
                	<h3 class="card-header mt-4">お支払い方法</h3>
   					<a href="{{ url('about-pay') }}" class="d-inline-block mt-2 ml-1 text-small" target="_brank">お支払についてのご注意はこちら <i class="fal fa-angle-double-right"></i></a>
                    
                    @if ($errors->has('pay_method'))
                        <div class="help-block text-danger mt-2 mb-0">
                            <span class="fa fa-exclamation form-control-feedback"></span>
                            <span>{{ $errors->first('pay_method') }}</span>
                        </div>
                    @endif
                    
                    <fieldset class="form-group mt-1 mb-2 pb-4 pt-3 pb-2{{ $errors->has('pay_method') ? ' border border-danger' : '' }}">

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
                             
                            <div class="mb-3">
                                   
                                @if($method->id == 1)
                                	<input id="radio-pay-{{ $method->id }}" type="radio" name="pay_method" value="{{ $method->id }}" class="payMethodRadio"{{ $checked }}>
                    				<label for="radio-pay-{{ $method->id }}" class="radios">{{ $method->name }}</label>
                                    
                                    {{--
                                    <input type="radio" name="pay_method" class="payMethodRadio ml-2" value="{{ $method->id }}"{{ $checked }}> {{ $method->name }}
                                    --}}
                                    
                                    <div class="wrap-all-card">
                                    
                                    
                                    <?php //get RegistCard ------------------------- ?>
                                    
                                    @if(count($regCardDatas) > 0)
                                        <div class="wrap-regist-card mt-3 mb-2 ml-1 pl-3">
                                            @if(isset($regCardErrors))
                                            	<small class="d-inline-block ml-3 mb-3">
                                                	<span class="text-danger"><i class="fal fa-exclamation-triangle"></i> 登録カード情報が取得出来ません。</span>
                                                    @if(isset($regCardErrors))
                                                    <br><span class="text-secondary">{{ $regCardErrors }}</span>
                                                    @endif
                                                </small>
                                            @else
                                                @foreach($regCardDatas['CardSeq'] as $k => $seqNum)
                                                    <?php 
                                                        $checked = '';
                                                        
                                                        if( Ctm::isOld()) {
                                                            if( old('card_seq') == $seqNum) {
                                                                $checked = ' checked';
                                                            }
                                                        }
                                                        elseif(Session::has('all.data.card_seq')) {
                                                            if(session('all.data.card_seq') == $seqNum) {
                                                                $checked = ' checked';
                                                            }
                                                        }
                                                    ?>
                                                     
                                                    <div class="mb-4 pb-1">
                                                        <input id="use-card-{{ $k }}" type="radio" name="card_seq" class="useCardRadio" value="{{ $seqNum }}"{{ $checked }}>
                                                        <label for="use-card-{{ $k }}" class="radios">
                                                        	カード番号： <span>{{ $regCardDatas['CardNo'][$k] }}</span>
                                                        </label>
                                                        
                                                        <?php
                                                        	//wordwrap($regCardDatas['Expire'][$k], 2, '/', 1)
                                                        	$y = substr($regCardDatas['Expire'][$k], 0, 2); //年
                                                            $m = substr($regCardDatas['Expire'][$k], 2); //月
                                                        ?>
                                                        
                                                        <small class="d-block ml-4 mt-1">有効期限（月/年）：{{ $m.'/'.$y }}</small>
                                                        
                                                    </div>
                                                @endforeach
                                            @endif
                                            
                                        </div>
                                    @endif
                                    
                                    
                                    <?php //NewCard ------------------------- ?>

                                    <div class="mt-2 mb-5 ml-1 pl-3">
                                        
                                        @if(count($regCardDatas) > 0)
                                            <?php 
                                            	$ml = ' ml-4';
                                                $checked = '';
                                                
                                                if( Ctm::isOld()) {
                                                    if( old('card_seq') == 99) {
                                                        $checked = ' checked';
                                                    }
                                                }
                                                elseif(Session::has('all.data.card_seq')) {
                                                    if(session('all.data.card_seq') == 99) {
                                                        $checked = ' checked';
                                                    }
                                                }
                                            ?>
                                        
                                            <input id="use-new-card" type="radio" name="card_seq" class="useCardRadio" value="99"{{ $checked }}>
                                            <label for="use-new-card" class="radios">新しいクレジットカードを使う</label>
                                        @else
                                        	<?php $ml = ' ml-2'; ?>
                                            
                                            <input type="hidden" name="card_seq" value="99">
                                        @endif
                                        
                                        <div class="wrap-new-card mt-3 pl-1{{ $ml }}">
                                        	
                                            @if (count($cardErrors) > 0)
                                            	<p class="mb-1">
                                                <span class="fa fa-exclamation form-control-feedback text-danger"></span>
                                                <span class="text-danger">{{ $cardErrors['carderr'] }}</span>
                                                </p>
                                            @endif
                                            
                                            <div class="{{ count($cardErrors) > 0 ? ' border border-danger pl-2' : '' }}">
                                            <div class="mb-3">
                                                <label>カード番号</label>
                                                <input type="text" id="cardno" class="form-control col-md-5{{ $errors->has('cardno') ? ' is-invalid' : '' }}" name="cardno" value="{{ Ctm::isOld() ? old('cardno') : (Session::has('all.data.cardno') ? session('all.data.cardno') : '') }}" placeholder="例）1234123412341234（ハイフンなし半角数字）">
                                       
                                                @if ($errors->has('cardno'))
                                                    <div class="help-block text-danger receiver-error">
                                                        <span class="fa fa-exclamation form-control-feedback"></span>
                                                        <span>{{ $errors->first('cardno') }}</span>
                                                    </div>
                                                @endif
                                            </div>
                                            
                                            <div class="mb-3">
                                                <label>セキュリティコード</label>
                                                <input type="text" id="securitycode" class="form-control col-md-5{{ $errors->has('securitycode') ? ' is-invalid' : '' }}" name="securitycode" value="{{ Ctm::isOld() ? old('securitycode') : (Session::has('all.data.securitycode') ? session('all.data.securitycode') : '') }}" placeholder="例）1234（3〜4桁 半角数字）">
                                       
                                                @if ($errors->has('securitycode'))
                                                    <div class="help-block text-danger receiver-error">
                                                        <span class="fa fa-exclamation form-control-feedback"></span>
                                                        <span>{{ $errors->first('securitycode') }}</span>
                                                    </div>
                                                @endif
                                            </div>
                                            
                                            <div class="mb-3">
                                                <?php
                                                    $time = new DateTime('now');
                                                    $expireYear = $time->format('y');
                                                    //$withYoubi .= ' (' . $week[$time->format('w')] . ')';
                                                
                                                    $yn = 0;
                                                    $mn = 1;
                                                ?>
                                            
                                                <label class="d-block">有効期限（月/年）</label>
                                                
                                                <label class="select-wrap col-md-2 p-0">
                                                <select id="expire_month" class="form-control d-inline-block {{ $errors->has('expire_month') || $errors->has('expire') ? ' is-invalid' : '' }}" name="expire_month">
                                                    
                                                    @while($mn < 13)
                                                        <?php
                                                            $expireMonth = str_pad($mn, 2, 0, STR_PAD_LEFT); //2桁0埋め
                                                            
                                                            $selected = '';
                                                            if(Ctm::isOld()) {
                                                                if(old('expire_month') == $expireMonth)
                                                                    $selected = ' selected';
                                                            }
                                                            else {
                                                                if(Session::has('all.data.expire_month')  && session('all.data.expire_month') == $expireMonth) {
                                                                    $selected = ' selected';
                                                                }
                                                            }
                                                        ?>
                                                        
                                                        <option value="{{ $expireMonth }}"{{ $selected }}>{{ $expireMonth }}</option>
                                                        
                                                        <?php $mn++; ?>
                                                    @endwhile
                                                </select>
                                                </label>
                                                <span class="mr-4">月</span>
                                                
                                                
                                                @if ($errors->has('expire_month'))
                                                    <div class="help-block text-danger col-md-2">
                                                        <span class="fa fa-exclamation form-control-feedback"></span>
                                                        <span>{{ $errors->first('expire_month') }}</span>
                                                    </div>
                                                @endif
                                                
                                                <label class="select-wrap col-md-2 p-0">
                                                <select id="expire_year" class="form-control d-inline-block {{ $errors->has('expire_year') || $errors->has('expire') ? ' is-invalid' : '' }}" name="expire_year">
                                                    
                                                    @while($yn < 11)
                                                        <?php
                                                            $selected = '';
                                                            if(Ctm::isOld()) {
                                                                if(old('expire_year') == $expireYear + $yn)
                                                                    $selected = ' selected';
                                                            }
                                                            else {
                                                                if(Session::has('all.data.expire_year')  && session('all.data.expire_year') == $expireYear + $yn) {
                                                                    $selected = ' selected';
                                                                }
                                                            }
                                                        ?>
                                                        
                                                        <option value="{{ $expireYear + $yn }}"{{ $selected }}>{{ $expireYear + $yn }}</option>
                                                        
                                                        <?php $yn++; ?>
                                                    @endwhile
                                                </select>
                                                </label>
                                                <span>年</span>
                                                
                                                
                                                
                                                @if ($errors->has('expire_year'))
                                                    <div class="help-block text-danger col-md-2">
                                                        <span class="fa fa-exclamation form-control-feedback"></span>
                                                        <span>{{ $errors->first('expire_year') }}</span>
                                                    </div>
                                                @endif
                                                
                                                <input type="hidden" name="expire" value="">
                                                @if ($errors->has('expire'))
                                                    <div class="help-block text-danger">
                                                        <span class="fa fa-exclamation form-control-feedback"></span>
                                                        <span>{{ $errors->first('expire') }}</span>
                                                    </div>
                                                @endif
                                                
                                            </div>
                                            
                                            </div><!-- ErrorBlock -->
                                            
                                            @if($regist || (isset($userObj) && $userObj->card_regist_count < 6))
                                            	@if(isset($userObj) && $userObj->card_regist_count > 4)
                                                	<span class="text-small text-secondary"><i class="fas fa-exclamation-circle"></i> 新規カード登録不可（最大5つまで）</span>
                                                @else
                                                    <label class="mt-2">
                                                        <?php                            
                                                            $checked = '';
                                                            if(Ctm::isOld()) {
                                                                 if(old('is_regist_card') !== null) 
                                                                    $checked = ' checked';
                                                            }
                                                            else {
                                                                if(Session::has('all.data.is_regist_card') && session('all.data.is_regist_card'))
                                                                    $checked = ' checked';
                                                            }
                                                        ?>
                                                        
                                                        <input id="check-regist-card" type="checkbox" name="is_regist_card" value="1"{{ $checked }}>
                        								<label for="check-regist-card" class="checks">このクレジットカード情報を登録する</label>
                                                        
                                                        {{--
                                                        <input type="checkbox" name="is_regist_card" value="1"{{ $checked }}> このクレジットカード情報を登録する
                                                        --}}
                                                        
                                                        @if ($errors->has('is_regist_card'))
                                                            <div class="help-block text-danger">
                                                                <span class="fa fa-exclamation form-control-feedback"></span>
                                                                <span>{{ $errors->first('is_regist_card') }}</span>
                                                            </div>
                                                        @endif
                                                    </label>
                                                @endif
                                            @endif
                                        
                                        </div>
                                        
                                        {{--
                                        <div class="mb-3">
                                            <label>カード名義人</label>
                                            <input type="text" id="holdername" class="form-control col-md-6{{ $errors->has('holdername') ? ' is-invalid' : '' }}" name="holdername" value="{{ Ctm::isOld() ? old('holdername') : (Session::has('all.data.holdername') ? session('all.data.holdername') : '') }}" placeholder="例：tarou yamada">
                                   
                                            @if ($errors->has('holdername'))
                                                <div class="help-block text-danger receiver-error">
                                                    <span class="fa fa-exclamation form-control-feedback"></span>
                                                    <span>{{ $errors->first('holdername') }}</span>
                                                </div>
                                            @endif
                                        </div>
                                        
                                        <input type="hidden" value="1" name="tokennumber" id="tokennumber">
                                        --}}
                                        
                                    </div>
                                    
                                    </div>
                                
                                
                                @elseif(! $codCheck && $method->id == 5)
                                	<input id="radio-pay-{{ $method->id }}" type="radio" name="pay_method" value="{{ $method->id }}" class="payMethodRadio" disabled>
                    				<label for="radio-pay-{{ $method->id }}" class="radios">{{ $method->name }}</label>
                                    
                                    {{--
                                    <input type="radio" name="pay_method" class="payMethodRadio ml-2" value="{{ $method->id }}" disabled> {{ $method->name }}
                                    --}}
                                    
                                    <span class="text-secondary text-small ml-0"><i class="fas fa-exclamation-circle"></i> ご注文商品の代金引換不可</span>
                                    
                                @else
                                	<input id="radio-pay-{{ $method->id }}" type="radio" name="pay_method" value="{{ $method->id }}" class="payMethodRadio"{{ $checked }}>
                    				<label for="radio-pay-{{ $method->id }}" class="radios">{{ $method->name }}</label>
                                    
                                    
                                    @if($method->id == 3)
                                        <div class="wrap-pmc mt-1 pt-1 mb-3 ml-3 pl-2{{ $errors->has('net_bank') ? ' border border-danger' : '' }}">
                                            @foreach($pmChilds as $pmChild)
                                                <?php 
                                                    $ch = '';
                                                    if( Ctm::isOld()) {
                                                        if( old('net_bank') == $pmChild->id) {
                                                            $ch = ' checked';
                                                        }
                                                    }
                                                    elseif(Session::has('all.data.net_bank')) {
                                                        if(session('all.data.net_bank') == $pmChild->id) {
                                                            $ch = ' checked';
                                                        }
                                                    }
                                                 ?>
                                                
                                                <span class="deliRadioWrap">
                                                    <input type="radio" name="net_bank" class="pmcRadio" value="{{ $pmChild->id }}" {{ $ch }}> <span class="mr-3">{{ $pmChild->name }}</span>
                                                </span>   
                                            @endforeach
                                        </div>
                                    @endif
                                    
                                @endif
                            
                            </div>
                            
                         @endforeach
                    
                	</fieldset>
                </div>
                

        <input type="hidden" name="regist" value="{{ $regist }}">
        
        <div>
        	<button class="btn btn-block btn-pink col-md-4 mb-4 mx-auto py-2" type="submit" name="recognize" value="1">確認する</button>
        </div>
       
    </form>
    
</div>


@includeWhen(Ctm::isEnv('local'), 'cart.shared.backBtn', ['urlForBack'=>'cart', 'textForBack'=>'カートに戻る'])

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


