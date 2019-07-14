@extends('layouts.app')

@section('content')

<div id="main" class="mt-4 row top-cont mx-auto">

	<div class="col-md-9 mx-auto">
    
        <h4 class="card-header">パスワードのリセット</h4>
        
        <p class="my-3 pb-1 mx-1">
        	登録しているメールアドレスと新しいパスワードを入力してリセットして下さい。
        </p>

        <div class="card-body px-1">
            <form method="POST" action="{{ route('password.request') }}">
                @csrf

                <input type="hidden" name="token" value="{{ $token }}">

                <fieldset class="form-group row">
                    <label for="email" class="col-md-3 col-form-label"><b>メールアドレス</b></label>

                    <div class="col-md-8">
                        <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ $email ?? old('email') }}" autofocus>

                        @if ($errors->has('email'))
                            <span class="invalid-feedback">
                                <strong><i class="fas fa-exclamation"></i> {{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                    </div>
                </fieldset>

                <fieldset class="form-group row">
                    <label for="password" class="col-md-3 col-form-label"><b>新パスワード</b></label>

                    <div class="col-md-8">
                        <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password">

                        @if ($errors->has('password'))
                            <span class="invalid-feedback">
                                <strong><i class="fas fa-exclamation"></i> {{ $errors->first('password') }}</strong>
                            </span>
                        @endif
                    </div>
                </fieldset>

                <fieldset class="form-group row">
                    <label for="password-confirm" class="col-md-3 col-form-label"><b>新パスワード（確認）</b></label><!-- text-md-right -->

                    <div class="col-md-8">
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation">
                    </div>
                </fieldset>

                <div class="form-group row mb-0">
                    <div class="col-md-6 offset-md-3">
                        <button type="submit" class="btn btn-custom my-3 w-100">
                            パスワードをリセットする
                        </button>
                    </div>
                </div>
            </form>
        </div>
    
    </div>

</div>
@endsection
