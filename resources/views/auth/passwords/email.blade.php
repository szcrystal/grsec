@extends('layouts.app')

@section('content')
<div id="main" class="mt-5 col-md-8 top-cont mx-auto">

        <h4 class="card-header">パスワードのリセット</h4>

        	@if (session('status'))
                <div class="text-info">
                    {{ session('status') }}
                    
                </div>
            @else
            
            <p class="my-3 pb-2 mx-2">パスワードリセット用のリンクを、登録しているメールアドレスへ送信します。<br>メールアドレスを入力して下さい。</p>
			
            <div class="card-body">
                <form method="POST" action="{{ route('password.email') }}">
                    @csrf

                    <fieldset class="form-group row">
                        <label for="email" class="col-md-3 col-form-label text-md-right"><b>メールアドレス</b></label>

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
                            <button type="submit" class="btn btn-custom mt-5 w-100">
                                送信する
                            </button>
                        </div>
                    </div>
                </form>
            @endif
        </div>
            

</div>
@endsection
