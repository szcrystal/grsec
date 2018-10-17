@extends('layouts.app')

@section('content')

<div id="main" class="clearfix login top-cont">
     
        <div class="">
            <h4 class="card-header">会員の方</h4>
			
            <p class="my-3 pb-2 mx-2">メールアドレスとパスワードを入力してログインして下さい。</p>
            
            <div class="card-body">
                
            
            @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <i class="far fa-exclamation-triangle"></i> 確認して下さい。
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            
            <?php
//                    print_r(session()->all());
//                     exit;   
            ?>
            
                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <fieldset class="form-group row">
                        <label for="email" class="col-md-3 col-form-label">メールアドレス</label>

                        <div class="col-md-8">
                            <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" autofocus>

                            @if ($errors->has('email'))
                                <span class="invalid-feedback">
                                    <span class="fa fa-exclamation form-control-feedback"></span>
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>
                    </fieldset>

                    <fieldset class="form-group row">
                        <label for="password" class="col-md-3 col-form-label">パスワード</label><!-- text-md-right -->

                        <div class="col-md-8">
                            <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password">

                            @if ($errors->has('password'))
                                <span class="invalid-feedback">
                                    <span class="fa fa-exclamation form-control-feedback"></span>
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>
                    </fieldset>

                    <fieldset class="form-group row">
                        <div class="col-md-8 offset-md-3">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> ログイン状態を保存する
                                </label>
                            </div>
                        </div>
                    </fieldset>
                    

                    <fieldset class="form-group mt-3">
                        <div class="">
                            @if(Request::has('to_cart'))
                                <input type="hidden" name="to_cart" value="1">
                            @endif
                          
                            <input type="hidden" name="previous" value="{{ session('_previous.url') }}">   
                             
                            <button type="submit" class="col-md-6 btn btn-custom btn-block mx-auto rounded-0">
                                ログイン
                            </button>

                            
                        </div>
                    </fieldset>
                    
                    <div class="text-right pt-2">
                        <a class="" href="{{ route('password.request') }}">
                            パスワードをお忘れの方 <i class="fas fa-angle-double-right"></i>
                        </a>
                    </div>
                </form>
                
            </div>
        </div>
            
            
        <div class="">
            <h4 class="card-header">会員登録がお済みでない方</h4>
			
            <p class="my-3 pb-2 mx-2">初めての方はこちらより会員登録をして下さい。<br>あらかじめ会員登録を済ませておくと、お買い物が便利になります。</p>
            
            <div class="card-body">

                <a href="{{ url('register') }}" class="col-md-6 btn btn-custom rounded-0 btn-block m-auto">新規会員登録</a>
            </div>
        </div>
            
            
            
	</div>
</div>

@endsection
