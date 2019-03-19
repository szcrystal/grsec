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
                @if(Ctm::isEnv('local'))
                <p class="mt-3">グリーンロケットをご利用いただき誠にありがとうございます。<br>以下より、ご希望のお問い合わせをお選び下さい。</p> 
                @endif  
            </div>

            <div class="panel-body mt-5">

                    @if(Ctm::isEnv('local'))
                        <?php
                            $telActive = '';
                            $mailActive = '';
                        ?>
                                
                        @if(Ctm::isOld() || Session::has('contact'))
                            <?php
                                //echo session('contact.is_ask_type').'/'.old('is_ask_type');
                                                          
                                if( 
                                    (old('is_ask_type') !== null && ! old('is_ask_type')) || 
                                    (session('contact.is_ask_type') !== null && ! session('contact.is_ask_type')) 
                                ) {
                                    $telActive = 'active';
                                }
                                else { 
                                    $mailActive = 'active';
                                }
                            ?>
                        @endif
                        
                    <div class="mt-4">
                        <ul class="nav nav-tabs">
                            <li class="nav-item">
                               <a href="#tab-1" class="nav-link {{ $telActive }}" data-toggle="tab"><i class="fal fa-phone"></i> お電話でのお問い合わせ</a>
                            </li>
                            <li class="nav-item">
                               <a href="#tab-2" class="nav-link {{ $mailActive }}" data-toggle="tab"><i class="fal fa-envelope"></i> メールでのお問い合わせ</a>
                            </li>
                        </ul>
                        

                        <div class="tab-content mt-4 px-1">
                            
                            @for($i = 0; $i < 2; $i++)
                                <?php
                                    $isActive = 0;
                                    
                                    if( (! $i && $telActive != '') || ($i && $mailActive != '') ) {
                                        $isActive = 1;
                                    }
                                ?>
       
                            <div id="tab-{{ $i+1 }}" class="tab-pane {{ $isActive ? 'active' : '' }}">
                                
                                @if ($isActive && count($errors) > 0)
                                    <div class="alert alert-danger">
                                        <i class="far fa-exclamation-triangle"></i> 確認して下さい。
                                        <ul class="mt-2">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                
                                <p>
                                    @if(! $i)
                                    お電話でのお問合わせをご希望の方は、こちらより改めて専門スタッフがお電話致します。<br>
                                    ご希望の時間帯をお選び頂き、送信をお願い致します。<br>
                                    <span class="text-small"><b>営業時間：9:00〜16:00／月〜金（土曜不定休、日・祝休）</b></span>
                                    @endif
                                </p>
                            
                                <div class="table-responsive table-custom mt-4 pt-1">
                                    <form class="form-horizontal" role="form" method="POST" action="/contact">
                                        {{ csrf_field() }}

                                        <input type="hidden" name="is_ask_type" value="{{ $i }}">

                                    <table class="table table-bordered">
                                        
                                        <tbody>
                                            <tr class="form-group">
                                                <th>お問い合わせ種別<em>必須</em></th>
                                                <td>
                                                    <select class="form-control col-md-9{{ $isActive && $errors->has('ask_category') ? ' is-invalid' : '' }}" name="ask_category">
                                                        <option disabled selected>選択して下さい</option>
                                                        @foreach($cate_option as $val)
                                                            <?php
                                                                $selected = '';
                                                                if(Ctm::isOld()) {
                                                                    if(old('ask_category') == $val)
                                                                        $selected = ' selected';
                                                                }
                                                                else {
                                                                    if($isActive && Session::has('contact') && session('contact.ask_category') == $val) {
                                                                        $selected = ' selected';
                                                                    }
                                                                }
                                                            ?>
                                                            <option value="{{ $val }}"{{ $selected }}>{{ $val }}</option>
                                                        @endforeach
                                                    </select>

                                                    @if ($isActive && $errors->has('ask_category'))
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
                                                    <input class="form-control rounded-0 col-md-12{{ $isActive && $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ Ctm::isOld() ? old('name') : ($isActive && Session::has('contact') ? session('contact.name') : '') }}" placeholder="例）山田太郎">
                                               
                                                    @if ($isActive && $errors->has('name'))
                                                        <div class="text-danger">
                                                            <span class="fa fa-exclamation form-control-feedback"></span>
                                                            <span>{{ $errors->first('name') }}</span>
                                                        </div>
                                                    @endif
                                                </td>
                                            </tr>
                                            
                                            <tr class="form-group">
                                                <th>
                                                    メールアドレス<em>必須</em>
                                                </th>
                                                <td>
                                                    <input class="form-control rounded-0 col-md-12{{ $isActive && $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ Ctm::isOld() ? old('email') : ($isActive && Session::has('contact') ? session('contact.email') : '') }}" placeholder="例）info@example.com">
                                               
                                                    @if ($isActive && $errors->has('email'))
                                                        <div class="text-danger">
                                                            <span class="fa fa-exclamation form-control-feedback"></span>
                                                            <span>{{ $errors->first('email') }}</span>
                                                        </div>
                                                    @endif
                                                </td>
                                            </tr>
                                            
                                            @if(! $i)
                                            <tr class="form-group">
                                                <th>電話番号<em>必須</em><small>例）09012345678ハイフンなし半角数字</small></th>
                                                <td>
                                                    <input class="form-control rounded-0 col-md-12{{ $isActive && $errors->has('tel_num') ? ' is-invalid' : '' }}" name="tel_num" value="{{ Ctm::isOld() ? old('tel_num') : ($isActive && Session::has('contact') ? session('contact.tel_num') : '') }}" placeholder="例）09012345678（ハイフンなし半角数字）">
                                               
                                                    @if ($isActive && $errors->has('tel_num'))
                                                        <div class="text-danger">
                                                            <span class="fa fa-exclamation form-control-feedback"></span>
                                                            <span>{{ $errors->first('tel_num') }}</span>
                                                        </div>
                                                    @endif
                                                </td>
                                            </tr>
                                            
                                            <tr class="form-group">
                                                <th>ご希望日<em>必須</em>
                                                    @if(! $i)
                                                        <small class="text-danger">指定日が祝日の場合は・・・</small>
                                                    @endif
                                                </th>
                                                <td>
                                                    <select class="form-control col-md-9{{ $isActive && $errors->has('request_day') ? ' is-invalid' : '' }}" name="request_day">
                                                
                                                    <option disabled selected>選択して下さい</option>

                                                    @foreach($reqDays as $key => $day)
                                                        <?php
                                                            $selected = '';
                                                            //$key = date('Y-m-d', $key);
                                                            
                                                            if(Ctm::isOld()) {
                                                                if(old('request_day') == $key)
                                                                    $selected = ' selected';
                                                            }
                                                            else {
                                                                if($isActive && Session::has('contact') && session('contact.request_day') == $key) {
                                                                    $selected = ' selected';
                                                                }
                                                            }                                                    ?>
                                                        
                                                        <option value="{{ $key }}"{{ $selected }}>{{ $day }}</option>
                                                    @endforeach
                                                    
                                                    </select>
                                                    
                                                    @if ($isActive && $errors->has('request_day'))
                                                        <div class="text-danger">
                                                            <span class="fa fa-exclamation form-control-feedback"></span>
                                                            <span>{{ $errors->first('request_day') }}</span>
                                                        </div>
                                                    @endif
                                                </td>
                                            </tr>
                                            
                                            <tr class="form-group">
                                                <th>ご希望時間帯<em>必須</em>
                                                    @if(! $i)
                                                        <small>9時〜16時（12〜13時除く）</small>
                                                    @endif
                                                </th>
                                                <td>
                                                    <select class="form-control col-md-9{{ $isActive && $errors->has('request_time') ? ' is-invalid' : '' }}" name="request_time">
                                                        <option disabled selected>選択して下さい</option>
                                                        @foreach($reqTimes as $time)
                                                            <?php
                                                                $selected = '';
                                                                if(Ctm::isOld()) {
                                                                    if(old('request_time') == $time)
                                                                        $selected = ' selected';
                                                                }
                                                                else {
                                                                    if($isActive && Session::has('contact') && session('contact.request_time') == $time) {
                                                                        $selected = ' selected';
                                                                    }
                                                                }
                                                            ?>
                                                            <option value="{{ $time }}"{{ $selected }}>{{ $time }}</option>
                                                        @endforeach
                                                    </select>

                                                    @if ($isActive && $errors->has('request_time'))
                                                        <span class="text-danger">
                                                            <span class="fa fa-exclamation form-control-feedback"></span>
                                                            <span>{{ $errors->first('request_time') }}</span>
                                                        </span>
                                                    @endif

                                                </td>
                                            </tr>
                                            @endif
                                            
                                            <tr class="form-group">
                                                <th>
                                                    お問い合わせ内容<em>必須</em>
                                                    <small>*具体的な内容を記載頂けますとスムーズです。</small>
                                                </th>
                                                <td>
                                                    <textarea id="comment" class="form-control rounded-0 col-md-12{{ $isActive && $errors->has('comment') ? ' is-invalid' : '' }}" name="comment" rows="20">{{ Ctm::isOld() ? old('comment') : ($isActive && Session::has('contact') ? session('contact.comment') : '') }}</textarea>

                                                    @if ($isActive && $errors->has('comment'))
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

                            </div>
                                                      
                            @endfor
                        
                        </div>

                    </div>

                @else
                
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
                    
                    <div class="table-responsive table-custom">
                        <form class="form-horizontal" role="form" method="POST" action="/contact">
                            {{ csrf_field() }}

                            <input type="hidden" name="done_status" value="0">
                            

                        <table class="table table-bordered">
                            
                            <tbody>
                                <tr class="form-group">
                                    <th>お問い合わせ種別<em>必須</em></th>
                                    <td>
                                        <select class="form-control col-md-9{{ $errors->has('ask_category') ? ' is-invalid' : '' }}" name="ask_category">
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
                                
                                <tr class="form-group">
                                    <th>お問い合わせ内容<em>必須</em></th>
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
                            <button type="submit" class="btn btn-block btn-custom col-md-4 mb-4 mx-auto py-2">確認する</button>
                        </div>
                    </form>
                    </div>
                @endif
            
            </div><!-- panel-body -->


        </div><!-- panel -->

    </div>
</div>
@endsection
