@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">パスワードのリセット</div>
                
                <p class="my-3 pb-2 mx-4">新しいパスワードを入力して下さい。</p>

                <div class="card-body">
                    <form method="POST" action="{{ route('password.request') }}">
                        @csrf

                        <input type="hidden" name="token" value="{{ $token }}">

                        <fieldset class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">メールアドレス</label>

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
                            <label for="password" class="col-md-4 col-form-label text-md-right">パスワード</label>

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
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">パスワード（確認用）</label>

                            <div class="col-md-8">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation">
                            </div>
                        </fieldset>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-custom px-3 my-4">
                                    パスワードをリセットする
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
