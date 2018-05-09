@extends('app')

@section('content')
    <main>
    	<div class="main-head">
        	<h1>送信エラー</h1>
            <p></p>
        </div>
        
        @if(! Request::is('password/email'))
        	@include('shared.move_3')
        @endif
        
        <div class="send-end">
            <span>正常に送信されませんでした</span>
            <p></p>
        </div>

        <div>
            <a href="{{ getUrl('/') }}" class="edit-btn"><span class="octicon octicon-mail-reply"></span>HOMEへ</a>
        </div>
    </main>
@endsection
