@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">パスワードのリセット</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    
                    <p class="mb-3 pb-3">パスワードリセット用のリンクを送信します。<br>メールアドレスを入力して下さい。</p>

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                        <fieldset class="form-group row">
                            <label for="email" class="col-md-3 col-form-label text-md-right">メールアドレス</label>

                            <div class="col-md-9">
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}">

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback">
                                        <strong><i class="fas fa-exclamation"></i> {{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </fieldset>

                        <div class="form-group row mb-0">
                            <div class="col-md-5 mx-auto">
                                <button type="submit" class="btn btn-custom mt-3 px-5 w-100">
                                    送信する
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
