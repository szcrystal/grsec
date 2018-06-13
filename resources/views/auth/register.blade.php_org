@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">お客様情報登録</div>

				<form method="POST" action="{{ route('register') }}">
                	@csrf
                 
                 <style>
                 	th {
                  		background: #555;
                    	color: #fff; 
                     	width: 30%;        
                  	}   
                 </style>
                   
                <div class="table-responsive">
                <table class="table table-borderd">
                	
                    <tr class="form-group">
                 		<th><label class="control-label">氏名</label></th>
                   		<td>
                            <input class="form-control col-md-12{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ Ctm::isOld() ? old('name') : (isset($user) ? $user->name : '') }}" placeholder="例）山田太郎">
                           
                            @if ($errors->has('name'))
                                <div class="text-danger">
                                    <span class="fa fa-exclamation form-control-feedback"></span>
                                    <span>{{ $errors->first('name') }}</span>
                                </div>
                            @endif
                        </td>
                 	</tr> 
                  
                  	<tr class="form-group">
                         <th><label class="control-label">フリガナ</label></th>
                           <td>
                            <input type="text" class="form-control col-md-12{{ $errors->has('hurigana') ? ' has-error' : '' }}" name="hurigana" value="{{ Ctm::isOld() ? old('hurigana') : (isset($user) ? $user->hurigana : '') }}" placeholder="例）ヤマダタロウ">
                            
                            @if ($errors->has('hurigana'))
                                <div class="text-danger">
                                    <span class="fa fa-exclamation form-control-feedback"></span>
                                    <span>{{ $errors->first('hurigana') }}</span>
                                </div>
                            @endif
                        </td>
                     </tr>
                     
                     <tr class="form-group">
                         <th><label class="control-label">性別</label></th>
                           <td>
                        	<?php 
                         		$arrs = array('男性', '女性');
                                
                                function checked($str) {
                                	$checked = '';
                                    if( Ctm::isOld() && old('gender') == $str) {
                                        $checked = ' checked';
                                    }
                                    elseif(isset($user) && $user->gender == $str) {
                                   		$checked = ' checked';
                                    }  
                                    return $checked;
                              	}             
                         	?>  
                          
                          	@foreach($arrs as $arr)    
                            <label class="radio-inline">
                                <input type="radio" name="gender" id="gender1" value="{{ $arr }}"{{ checked($arr) }}>{{ $arr }}
                            </label>
                            @endforeach
                            
                            @if ($errors->has('gender'))
                                <div class="text-danger">
                                    <span class="fa fa-exclamation form-control-feedback"></span>
                                    <span>{{ $errors->first('gender') }}</span>
                                </div>
                            @endif
                        </td>
                     </tr>
                
                     <tr class="form-group">
                         <th><label class="control-label">生年月日</label></th>
                           <td>
                           	
                            <select class="form-control select-first col-md-2 d-inline" name="birth_year">
                                <option disabled selected>年</option>
                                <?php
                                    $yNow = date('Y');
                                    $y = 1900;
                                ?>
                                @while($y <= $yNow)
                                    <?php
                                        $selected = '';
                                        if(Ctm::isOld()) {
                                            if(old('birth_year') == $y)
                                                $selected = ' selected';
                                        }
                                        else {
                                            if(isset($user) && $user->birth_year == $y) {
                                                $selected = ' selected';
                                            }
                                        }
                                    ?>
                                    <option value="{{ $y }}"{{ $selected }}>{{ $y }}</option>
                                    
                                    <?php $y++; ?>
                                
                                @endwhile
                            </select>
                            <span class="mr-2">年</span>
                            
                            @if ($errors->has('birth_year'))
                                <div class="help-block text-danger">
                                    <span class="fa fa-exclamation form-control-feedback"></span>
                                    <span>{{ $errors->first('birth_year') }}</span>
                                </div>
                            @endif
                            
                            <select class="form-control select-first col-md-1 d-inline" name="birth_month">
                                <option disabled selected>月</option>
                                <?php
                                    $m = 1;
                                ?>
                                @while($m <= 12)
                                    <?php
                                        $selected = '';
                                        if(Ctm::isOld()) {
                                            if(old('birth_month') == $m)
                                                $selected = ' selected';
                                        }
                                        else {
                                            if(isset($user) && $user->birth_month == $m) {
                                                $selected = ' selected';
                                            }
                                        }
                                    ?>
                                    <option value="{{ $m }}"{{ $selected }}>{{ $m }}</option>
                                    
                                    <?php $m++; ?>
                                
                                @endwhile
                            </select>
                            <span class="mr-2">月</span>
                            
                            @if ($errors->has('birth_month'))
                                <div class="help-block text-danger">
                                    <span class="fa fa-exclamation form-control-feedback"></span>
                                    <span>{{ $errors->first('birth_month') }}</span>
                                </div>
                            @endif
                            
                            <select class="form-control select-first col-md-1 d-inline" name="birth_day">
                                <option disabled selected>日</option>
                                <?php
                                    $d = 1;
                                ?>
                                @while($d <= 31)
                                    <?php
                                        $selected = '';
                                        if(Ctm::isOld()) {
                                            if(old('birth_day') == $d)
                                                $selected = ' selected';
                                        }
                                        else {
                                            if(isset($user) && $user->birth_day == $d) {
                                                $selected = ' selected';
                                            }
                                        }
                                    ?>
                                    <option value="{{ $d }}"{{ $selected }}>{{ $d }}</option>
                                    
                                    <?php $d++; ?>
                                
                                @endwhile
                            </select>
                            <span>日</span>
                            
                            @if ($errors->has('birth_day'))
                                <div class="help-block text-danger">
                                    <span class="fa fa-exclamation form-control-feedback"></span>
                                    <span>{{ $errors->first('birth_day') }}</span>
                                </div>
                            @endif
                            
                        </td>
                     </tr>
                     
                     
                     <tr class="form-group">
                         <th><label class="control-label">郵便番号</label></th>
                           <td>
                            <input type="text" class="form-control col-md-12{{ $errors->has('post_num') ? ' has-error' : '' }}" name="post_num" value="{{ Ctm::isOld() ? old('post_num') : (isset($user) ? $user->post_num : '') }}">
                            
                            @if ($errors->has('post_num'))
                                <div class="help-block text-danger">
                                    <span class="fa fa-exclamation form-control-feedback"></span>
                                    <span>{{ $errors->first('post_num') }}</span>
                                </div>
                            @endif
                        </td>
                     </tr>
                     
                     <tr class="form-group">
                         <th><label class="control-label">都道府県</label></th>
                           <td>
                            <select class="form-control select-first col-md-6" name="pref_id">
                                <option disabled selected>選択して下さい</option>
                                <?php
                                	use App\Prefecture;
                                    $prefs = Prefecture::all();  
                                ?>
                                @foreach($prefs as $pref)
                                    <?php
                                        $selected = '';
                                        if(Ctm::isOld()) {
                                            if(old('pref_id') == $pref->id)
                                                $selected = ' selected';
                                        }
                                        else {
                                            if(isset($user) && $user->pref_id == $pref->id) {
                                                $selected = ' selected';
                                            }
                                        }
                                    ?>
                                    <option value="{{ $pref->id }}"{{ $selected }}>{{ $pref->name }}</option>
                                @endforeach
                            </select>
                            
                            @if ($errors->has('pref_id'))
                                <div class="help-block text-danger">
                                    <span class="fa fa-exclamation form-control-feedback"></span>
                                    <span>{{ $errors->first('pref_id') }}</span>
                                </div>
                            @endif
                        </td>
                     </tr>
                     
                     <tr class="form-group">
                         <th><label class="control-label">住所1（都市区）</label></th>
                           <td>
                            <input type="text" class="form-control col-md-12{{ $errors->has('address_1') ? ' has-error' : '' }}" name="address_1" value="{{ Ctm::isOld() ? old('address_1') : (isset($user) ? $user->address_1 : '') }}">
                            
                            @if ($errors->has('address_1'))
                                <div class="help-block text-danger">
                                    <span class="fa fa-exclamation form-control-feedback"></span>
                                    <span>{{ $errors->first('address_1') }}</span>
                                </div>
                            @endif
                        </td>
                     </tr>
                     
                     <tr class="form-group">
                         <th><label class="control-label">住所2（それ以降）</label></th>
                           <td>
                            <input type="text" class="form-control col-md-12{{ $errors->has('address_2') ? ' has-error' : '' }}" name="address_2" value="{{ Ctm::isOld() ? old('address_2') : (isset($user) ? $user->address_2 : '') }}">
                            
                            @if ($errors->has('address_2'))
                                <div class="help-block text-danger">
                                    <span class="fa fa-exclamation form-control-feedback"></span>
                                    <span>{{ $errors->first('address_2') }}</span>
                                </div>
                            @endif
                        </td>
                     </tr>
                     
                     <tr class="form-group">
                         <th><label class="control-label">住所3（建物/マンション名等）</label></th>
                           <td>
                            <input type="text" class="form-control col-md-12{{ $errors->has('address_3') ? ' has-error' : '' }}" name="address_3" value="{{ Ctm::isOld() ? old('address_3') : (isset($user) ? $user->address_3 : '') }}">
                            
                            @if ($errors->has('address_3'))
                                <div class="help-block text-danger">
                                    <span class="fa fa-exclamation form-control-feedback"></span>
                                    <span>{{ $errors->first('address_3') }}</span>
                                </div>
                            @endif
                        </td>
                     </tr>
                     
                     <tr class="form-group">
                         <th><label class="control-label">メールアドレス</label></th>
                           <td>
                            <input type="email" class="form-control col-md-12{{ $errors->has('email') ? ' has-error' : '' }}" name="email" value="{{ Ctm::isOld() ? old('email') : (isset($user) ? $user->email : '') }}">
                            
                            @if ($errors->has('email'))
                                <div class="help-block text-danger">
                                    <span class="fa fa-exclamation form-control-feedback"></span>
                                    <span>{{ $errors->first('email') }}</span>
                                </div>
                            @endif
                        </td>
                     </tr>
                     
                     <tr class="form-group">
                         <th><label class="control-label">電話番号</label></th>
                           <td>
                            <input type="text" class="form-control col-md-12{{ $errors->has('tel_num') ? ' has-error' : '' }}" name="tel_num" value="{{ Ctm::isOld() ? old('tel_num') : (isset($user) ? $user->tel_num : '') }}">
                            
                            @if ($errors->has('tel_num'))
                                <div class="help-block text-danger">
                                    <span class="fa fa-exclamation form-control-feedback"></span>
                                    <span>{{ $errors->first('tel_num') }}</span>
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
                                    if(old('magazine'))
                                        $checked = ' checked';
                                }
                                else {
                                    if(isset($user) && ! $user->magazine) {
                                        $checked = ' checked';
                                    }
                                }
                            ?>
                            <input type="checkbox" name="magazine" value="1"{{ $checked }}> 登録する
                            
                            @if ($errors->has('magazine'))
                                <div class="help-block text-danger">
                                    <span class="fa fa-exclamation form-control-feedback"></span>
                                    <span>{{ $errors->first('magazine') }}</span>
                                </div>
                            @endif
                        </td>
                     </tr>
                     
                     
                     <tr class="form-group">
                         <th><label class="control-label">パスワード</label></th>
                           <td>
                            <input type="password" class="form-control col-md-12{{ $errors->has('password') ? ' has-error' : '' }}" name="password" value="{{ Ctm::isOld() ? old('password') : (isset($user) ? $user->password : '') }}">
                            
                            @if ($errors->has('password'))
                                <div class="help-block text-danger">
                                    <span class="fa fa-exclamation form-control-feedback"></span>
                                    <span>{{ $errors->first('password') }}</span>
                                </div>
                            @endif
                        </td>
                     </tr>
                     
                     <tr class="form-group">
                         <th><label class="control-label">パスワードの確認</label></th>
                           <td>
                            <input type="password" class="form-control col-md-12{{ $errors->has('password_confirmation') ? ' has-error' : '' }}" name="password" value="{{ Ctm::isOld() ? old('password_confirmation') : (isset($user) ? $user->password_confirmation : '') }}">
                            
                            @if ($errors->has('password_confirmation'))
                                <div class="help-block text-danger">
                                    <span class="fa fa-exclamation form-control-feedback"></span>
                                    <span>{{ $errors->first('password_confirmation') }}</span>
                                </div>
                            @endif
                        </td>
                     </tr>
                     
                     </table>
                     </div>
                     
                     
                <h3 class="mt-5">お届け先</h3>     
                     
                <div class="form-group">
                    <div class="col-md-12 text-left">
                        <div class="checkbox">
                            <label>
                                <?php
                                    $checked = '';
                                    if(Ctm::isOld()) {
                                        if(old('destination'))
                                            $checked = ' checked';
                                    }
                                    else {
                                        if(isset($user) && ! $user->destination) {
                                            $checked = ' checked';
                                        }
                                    }
                                ?>
                                <input type="checkbox" name="destination" value="1"{{ $checked }}> 上記登録先へ配送する（上記の登録先住所へ配送する場合はここをチェックして下さい。）
                            </label>
                        </div>
                    </div>
                </div>     
                        
                        
                        
                        
                        
                <div class="table-responsive">
                <table class="table table-borderd">
                    
                    <tr class="form-group">
                         <th><label class="control-label">氏名</label></th>
                           <td>
                            <input class="form-control col-md-12{{ $errors->has('an_name') ? ' is-invalid' : '' }}" name="an_name" value="{{ Ctm::isOld() ? old('an_name') : (isset($user) ? $user->an_name : '') }}" placeholder="例）山田太郎">
                           
                            @if ($errors->has('an_name'))
                                <div class="text-danger">
                                    <span class="fa fa-exclamation form-control-feedback"></span>
                                    <span>{{ $errors->first('an_name') }}</span>
                                </div>
                            @endif
                        </td>
                     </tr> 
                  
                      <tr class="form-group">
                         <th><label class="control-label">フリガナ</label></th>
                           <td>
                            <input type="text" class="form-control col-md-12{{ $errors->has('an_hurigana') ? ' has-error' : '' }}" name="an_hurigana" value="{{ Ctm::isOld() ? old('an_hurigana') : (isset($user) ? $user->an_hurigana : '') }}" placeholder="例）ヤマダタロウ">
                            
                            @if ($errors->has('an_hurigana'))
                                <div class="text-danger">
                                    <span class="fa fa-exclamation form-control-feedback"></span>
                                    <span>{{ $errors->first('an_hurigana') }}</span>
                                </div>
                            @endif
                        </td>
                     </tr>
                     
                     
                     
                     <tr class="form-group">
                         <th><label class="control-label">郵便番号</label></th>
                           <td>
                            <input type="text" class="form-control col-md-12{{ $errors->has('an_post_num') ? ' has-error' : '' }}" name="an_post_num" value="{{ Ctm::isOld() ? old('an_post_num') : (isset($user) ? $user->an_post_num : '') }}">
                            
                            @if ($errors->has('an_post_num'))
                                <div class="help-block text-danger">
                                    <span class="fa fa-exclamation form-control-feedback"></span>
                                    <span>{{ $errors->first('an_post_num') }}</span>
                                </div>
                            @endif
                        </td>
                     </tr>
                     
                     <tr class="form-group">
                         <th><label class="control-label">都道府県</label></th>
                           <td>
                            <select class="form-control select-first col-md-6" name="an_pref_id">
                                <option disabled selected>選択して下さい</option>
                                <?php
//                                    use App\Prefecture;
//                                    $prefs = Prefecture::all();  
                                ?>
                                @foreach($prefs as $pref)
                                    <?php
                                        $selected = '';
                                        if(Ctm::isOld()) {
                                            if(old('an_pref_id') == $pref->id)
                                                $selected = ' selected';
                                        }
                                        else {
                                            if(isset($user) && $user->an_pref_id == $pref->id) {
                                                $selected = ' selected';
                                            }
                                        }
                                    ?>
                                    <option value="{{ $pref->id }}"{{ $selected }}>{{ $pref->name }}</option>
                                @endforeach
                            </select>
                            
                            @if ($errors->has('an_pref_id'))
                                <div class="help-block text-danger">
                                    <span class="fa fa-exclamation form-control-feedback"></span>
                                    <span>{{ $errors->first('an_pref_id') }}</span>
                                </div>
                            @endif
                        </td>
                     </tr>
                     
                     <tr class="form-group">
                         <th><label class="control-label">住所1（都市区）</label></th>
                           <td>
                            <input type="text" class="form-control col-md-12{{ $errors->has('an_address_1') ? ' has-error' : '' }}" name="an_address_1" value="{{ Ctm::isOld() ? old('an_address_1') : (isset($user) ? $user->an_address_1 : '') }}">
                            
                            @if ($errors->has('an_address_1'))
                                <div class="help-block text-danger">
                                    <span class="fa fa-exclamation form-control-feedback"></span>
                                    <span>{{ $errors->first('an_address_1') }}</span>
                                </div>
                            @endif
                        </td>
                     </tr>
                     
                     <tr class="form-group">
                         <th><label class="control-label">住所2（それ以降）</label></th>
                           <td>
                            <input type="text" class="form-control col-md-12{{ $errors->has('an_address_2') ? ' has-error' : '' }}" name="an_address_2" value="{{ Ctm::isOld() ? old('an_address_2') : (isset($user) ? $user->an_address_2 : '') }}">
                            
                            @if ($errors->has('an_address_2'))
                                <div class="help-block text-danger">
                                    <span class="fa fa-exclamation form-control-feedback"></span>
                                    <span>{{ $errors->first('an_address_2') }}</span>
                                </div>
                            @endif
                        </td>
                     </tr>
                     
                     <tr class="form-group">
                         <th><label class="control-label">住所3（建物/マンション名等）</label></th>
                           <td>
                            <input type="text" class="form-control col-md-12{{ $errors->has('an_address_3') ? ' has-error' : '' }}" name="an_address_3" value="{{ Ctm::isOld() ? old('an_address_3') : (isset($user) ? $user->an_address_3 : '') }}">
                            
                            @if ($errors->has('an_address_3'))
                                <div class="help-block text-danger">
                                    <span class="fa fa-exclamation form-control-feedback"></span>
                                    <span>{{ $errors->first('an_address_3') }}</span>
                                </div>
                            @endif
                        </td>
                     </tr>
                     
                     </table>
                </div> 
                
                
                <div>
                	<fieldset class="form-group">
                    <label class="d-block card-header">お支払い方法</label>
                    <?php 
                         $arrs = array('男性', '女性');
                        
                        function payChecked($str) {
                            $checked = '';
                            if( Ctm::isOld() && old('pay_method') == $str) {
                                $checked = ' checked';
                            }
                            elseif(isset($user) && $user->pay_method == $str) {
                                   $checked = ' checked';
                            }  
                            return $checked;
                          }             
                     ?>  
                    <label class="d-block">
                        <input type="radio" name="pay_method" id="optionsRadiosInline1" value="1">クレジットカード
                    </label>
                    <label class="d-block">
                        <input type="radio" name="pay_method" id="optionsRadiosInline2" value="2">コンビニ決済
                    </label>
                    <label class="d-block">
                        <input type="radio" name="pay_method" id="optionsRadiosInline3" value="3">ネットバンク
                    </label>
                    <label class="d-block">
                        <input type="radio" name="pay_method" id="optionsRadiosInline3" value="4">代引き決済
                    </label>
                    <label class="d-block">
                        <input type="radio" name="pay_method" id="optionsRadiosInline3" value="5">銀行振込
                    </label>
                </fieldset>
                
                </div>
                        
                        
                        
                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required autofocus>

                                @if ($errors->has('name'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                        
                        
                       
                        
        
            
            
            
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
