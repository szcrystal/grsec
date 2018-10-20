@extends('layouts.app')

@section('content')
<div id="main" class="mt-4 row top-cont">

	<div class="col-md-9 mx-auto">
        <h4 class="card-header">パスワードのリセット</h4>

        	@if (session('status'))
                <div class="my-3 pb-1 mx-1">
                    {{ session('status') }}
                    <br>
                    まだパスワードのリセットはされていません。メールの内容に従い手続きを進めて下さい。
                </div>
            @else
            
            <p class="my-3 pb-1 mx-1">パスワードリセット用のリンクを、登録しているメールアドレスへ送信します。<br>メールアドレスを入力して下さい。</p>
			
            <div class="card-body px-1">
                <form method="POST" action="{{ route('password.email') }}">
                    @csrf

                    <fieldset class="form-group row">
                        <label for="email" class="col-md-3 col-form-label"><b>メールアドレス</b></label>

                        <div class="col-md-8">
                            <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" autofocus>

                            @if ($errors->has('email'))
                                <span class="invalid-feedback">
                                    <strong><i class="fas fa-exclamation"></i> {{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>
                    </fieldset>

                    <div class="form-group row mb-0">
                        <div class="col-md-6 offset-md-3">
                            <button type="submit" class="btn btn-custom mt-3 w-100">
                                送信する
                            </button>
                        </div>
                    </div>
                </form>
            @endif
        </div>
     
     </div>       

</div>
@endsection
