@extends('layouts.app')


@section('content')

    	<article class="error404 col-md-8 mx-auto text-center">
        	<header class="mb-3 mt-3">
        		<h2 class="main-title"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> ページがありません</h2>
            </header>

            <div>
                <p>お探しのページがありませんでした。<br><a href="{{ url('/') }}">TOPページ</a>に戻り、再度リンクより入り直して下さい。</p>
                <a href="{{ url('/') }}" class="edit-btn">TOPへ <i class="fa fa-angle-double-right" aria-hidden="true"></i></a>
            </div>
        </article>

@endsection
