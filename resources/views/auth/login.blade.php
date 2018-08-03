@extends('layouts.app')

@section('content')

<div id="main" class="clearfix login mb-5">
     
        <div style="min-height: 600px;">
            <h4 class="card-header">会員の方</h4>

            <div class="card-body">
                <p>メールアドレスとパスワードを入力してログインして下さい。</p>
            
            @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <strong><i class="fas fa-exclamation-triangle"></i> Error</strong> 以下の入力を確認して下さい。<br><br>
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
                        <label for="email" class="col-sm-4 col-form-label text-md-right">メールアドレス</label>

                        <div class="col-md-7">
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
                        <label for="password" class="col-md-4 col-form-label text-md-right">パスワード</label>

                        <div class="col-md-7">
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
                        <div class="col-md-7 offset-md-4">
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

            <div class="card-body">
                <p class="mb-5">初めての方はこちらより会員登録をして下さい。<br>あらかじめ会員登録を済ませておくと、お買い物が便利になります。</p>

                <a href="{{ url('register') }}" class="col-md-6 btn btn-custom rounded-0 btn-block m-auto">新規会員登録</a>
            </div>
        </div>
            
            
            
	</div>
</div>

@endsection
