@extends('layouts.app')

{{--
@section('bread')
@include('main.shared.bread')
@endsection
--}}

@section('content')
<div class="row contact">
    <div class="col-md-12 mx-auto">
        <div class="panel panel-default">

            <div class="panel-heading">
                <h2 class="card-header">お問い合わせ</h2>
                <p class="mt-3">
                	グリーンロケットをご利用いただき誠にありがとうございます。<br>
                    お問い合わせのご希望方法より、お電話かメールのどちらかを選択して下さい。<br><br>
                    お電話でのお問い合わせをご希望の方は、こちらより改めて専門スタッフがお電話致します。<br>
                    ご希望の日時を入力頂き、送信をお願い致します。<br>
                    <span class="text-small"><b>営業時間：9:00〜16:00／月〜金（土曜不定休、日・祝休）</b></span>
                </p> 
            </div>

            <div class="panel-body mt-5">
            
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

                                                    
                <div class="table-responsive table-custom mt-4 pt-1">
                    <form class="form-horizontal" role="form" method="POST" action="/contact">
                        {{ csrf_field() }}

                        <table class="table table-bordered">
                            
                            <tbody>
                                <tr class="form-group">
                                    <th>ご希望方法<em>必須</em></th>
                                    <td>
                                        <div class="p-0 my-0{{ $errors->has('is_ask_type') ? ' border border-danger' : '' }}">
                                        
                                        <?php 
                                            $askTypes = [1 =>'電話', 2 =>'メール'];
                                        ?>
                                            
                                        @foreach($askTypes as $k => $v) 
                                            <?php
                                                $checked = '';
                                                
                                                if( Ctm::isOld()) {
                                                    if(old('is_ask_type') == $k) {
                                                        $checked = ' checked';
                                                    }
                                                }
                                                elseif(Session::has('contact')) {
                                                    if(session('contact.is_ask_type') == $k) {
                                                        $checked = ' checked';
                                                    }
                                                }
                                            ?>
                                        
                                        	
                                            <span class="askRadioWrap">
                                            	<input id="is-ask-type-{{ $k }}" type="radio" name="is_ask_type" class="isAskType" value="{{ $k }}" {{ $checked }}>
                                                <label for="is-ask-type-{{ $k }}" class="radios">{{ $v }}</label>
                                                
                                                {{--
                                                <input type="radio" name="is_ask_type" class="isAskType" value="{{ $k }}" {{ $checked }}><span class="mr-3"> {{ $v }}</span>
                                                --}}
                                            </span>
                                        
                                        @endforeach
                            
                                        </div>
                                        
                                        @if ($errors->has('is_ask_type'))
                                            <span class="text-danger">
                                                <span class="fa fa-exclamation form-control-feedback"></span>
                                                <span>{{ $errors->first('is_ask_type') }}</span>
                                            </span>
                                        @endif
                                    </td>
                                
                                </tr>
                            
                                <tr class="form-group">
                                    <th>お問い合わせ種別<em>必須</em></th>
                                    <td>
                                    	<div class="select-wrap col-md-9 p-0">
                                        <select class="form-control {{ $errors->has('ask_category') ? ' is-invalid' : '' }}" name="ask_category">
                                            <option disabled selected>選択して下さい</option>
                                            @foreach($cate_option as $val)
                                                <?php
                                                    $selected = '';
                                                    if(Ctm::isOld()) {
                                                        if(old('ask_category') == $val)
                                                            $selected = ' selected';
                                                    }
                                                    else {
                                                        if(Session::has('contact') && session('contact.ask_category') == $val) {
                                                            $selected = ' selected';
                                                        }
                                                    }
                                                ?>
                                                <option value="{{ $val }}"{{ $selected }}>{{ $val }}</option>
                                            @endforeach
                                        </select>
                                        </div>

                                        @if ($errors->has('ask_category'))
                                            <span class="text-danger">
                                                <span class="fa fa-exclamation form-control-feedback"></span>
                                                <span>{{ $errors->first('ask_category') }}</span>
                                            </span>
                                        @endif

                                    </td>
                                </tr>


                                <tr class="form-group">
                                    <th>お名前<em>必須</em></th>
                                    <td>
                                        <input class="form-control rounded-0 col-md-12{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ Ctm::isOld() ? old('name') : (Session::has('contact') ? session('contact.name') : '') }}" placeholder="例）山田太郎">
                                   
                                        @if ($errors->has('name'))
                                            <div class="text-danger">
                                                <span class="fa fa-exclamation form-control-feedback"></span>
                                                <span>{{ $errors->first('name') }}</span>
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                                    
                                <tr class="form-group">
                                    <th>メールアドレス<em>必須</em></th>
                                    <td>
                                        <input class="form-control rounded-0 col-md-12{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ Ctm::isOld() ? old('email') : (Session::has('contact') ? session('contact.email') : '') }}" placeholder="例）info@example.com">
                                   
                                        @if ($errors->has('email'))
                                            <div class="text-danger">
                                                <span class="fa fa-exclamation form-control-feedback"></span>
                                                <span>{{ $errors->first('email') }}</span>
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                                
                                
                                    <tr class="form-group ask-tel-wrap">
                                        <th>電話番号<em>必須</em><small>例）09012345678ハイフンなし半角数字</small></th>
                                        <td>
                                            <input class="form-control rounded-0 col-md-12{{ $errors->has('tel_num') ? ' is-invalid' : '' }}" name="tel_num" value="{{ Ctm::isOld() ? old('tel_num') : (Session::has('contact') ? session('contact.tel_num') : '') }}" placeholder="例）09012345678（ハイフンなし半角数字）">
                                       
                                            @if ($errors->has('tel_num'))
                                                <div class="text-danger">
                                                    <span class="fa fa-exclamation form-control-feedback"></span>
                                                    <span>{{ $errors->first('tel_num') }}</span>
                                                </div>
                                            @endif
                                        </td>
                                    </tr>
                                    
                                    <tr class="form-group ask-tel-wrap">
                                        <th>ご希望日<em>必須</em><small>例）3/15、3月15日など月日を入力下さい</small></th>
                                        <td>
                                            <input class="form-control rounded-0 col-md-12{{ $errors->has('request_day') ? ' is-invalid' : '' }}" name="request_day" value="{{ Ctm::isOld() ? old('request_day') : (Session::has('contact') ? session('contact.request_day') : '') }}" placeholder="例）3/15、3月15日など月日を入力下さい">
                                            
                                            @if ($errors->has('request_day'))
                                                <div class="text-danger">
                                                    <span class="fa fa-exclamation form-control-feedback"></span>
                                                    <span>{{ $errors->first('request_day') }}</span>
                                                </div>
                                            @endif
                                        </td>
                                    </tr>
                                    
                                    <tr class="form-group ask-tel-wrap">
                                        <th>ご希望時間帯<em>必須</em>
                                            <small>*9時〜16時（12〜13時除く）</small>
                                        </th>
                                        <td>
                                        	<div class="select-wrap col-md-9 p-0">
                                            <select class="form-control {{ $errors->has('request_time') ? ' is-invalid' : '' }}" name="request_time">
                                                <option disabled selected>選択して下さい</option>
                                                @foreach($reqTimes as $time)
                                                    <?php
                                                        $selected = '';
                                                        if(Ctm::isOld()) {
                                                            if(old('request_time') == $time)
                                                                $selected = ' selected';
                                                        }
                                                        else {
                                                            if(Session::has('contact') && session('contact.request_time') == $time) {
                                                                $selected = ' selected';
                                                            }
                                                        }
                                                    ?>
                                                    <option value="{{ $time }}"{{ $selected }}>{{ $time }}</option>
                                                @endforeach
                                            </select>
											<div>
                                            
                                            @if ($errors->has('request_time'))
                                                <span class="text-danger">
                                                    <span class="fa fa-exclamation form-control-feedback"></span>
                                                    <span>{{ $errors->first('request_time') }}</span>
                                                </span>
                                            @endif

                                        </td>
                                    </tr>
                                
                                    <tr class="form-group">
                                        <th>
                                            お問い合わせ内容<em>必須</em>
                                            <small>*具体的な内容を記載頂けますとスムーズです。</small>
                                        </th>
                                        <td>
                                            <textarea id="comment" class="form-control rounded-0 col-md-12{{ $errors->has('comment') ? ' is-invalid' : '' }}" name="comment" rows="20">{{ Ctm::isOld() ? old('comment') : (Session::has('contact') ? session('contact.comment') : '') }}</textarea>

                                            @if ($errors->has('comment'))
                                                <span class="text-danger">
                                                    <span class="fa fa-exclamation form-control-feedback"></span>
                                                    <span>{{ $errors->first('comment') }}</span>
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            
                            <div>
                                <button type="submit" class="btn btn-block btn-custom col-md-4 mt-5 mb-4 mx-auto py-2">確認する</button>
                            </div>
                        
                        </form>
                    </div>

            
            </div><!-- panel-body -->


        </div><!-- panel -->

    </div>
</div>
@endsection
