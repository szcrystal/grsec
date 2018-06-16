@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div style="min-height:800px;" class="col-md-8 my-5 pb-5">
            <div class="card">
                <div class="card-header">ログイン</div>

                <div class="card-body">
                
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

                        <div class="form-group row">
                            <label for="email" class="col-sm-3 col-form-label text-md-right">メールアドレス</label>

                            <div class="col-md-8">
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" autofocus>

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback">
                                    	<span class="fa fa-exclamation form-control-feedback"></span>
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-3 col-form-label text-md-right">パスワード</label>

                            <div class="col-md-8">
                                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password">

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback">
                                    	<span class="fa fa-exclamation form-control-feedback"></span>
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-7 offset-md-3">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> ログイン状態を保存する
                                    </label>
                                </div>
                            </div>
                        </div>
                        
                        <div class="text-right">
                        	<a class="btn btn-link" href="{{ route('password.request') }}">
                                パスワードを忘れた方 <i class="fas fa-angle-double-right"></i>
                            </a>
                        </div>

                        <div class="form-group mt-3">
                            <div class="">
                            	@if(Request::has('to_cart'))
                             		<input type="hidden" name="to_cart" value="1">
                             	@endif
                              
                              	<input type="hidden" name="previous" value="{{ session('_previous.url') }}">   
                                 
                                <button type="submit" class="col-md-6 btn btn-custom btn-block m-auto">
                                    ログイン
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
