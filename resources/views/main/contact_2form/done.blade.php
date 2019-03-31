@extends('layouts.app')

{{--
@section('bread')
@include('main.shared.bread')
@endsection
--}}

@section('content')
    <div class="row contact">
        <div class="col-md-12 mx-auto">
            <div class="panel panel-default">

                <div class="panel-heading">
                	<h2 class="card-header">お問い合せの完了</h2>
                </div>

                <div style="min-height:650px;" class="panel-body text-center mt-3">
					<p class="my-4">お問い合せの送信が完了しました。</p>
                    <a href="{{ url('/') }}">HOMEへ <i class="fal fa-angle-double-right"></i></a>
				</div>

	    	</div>
        </div>
    </div>
@endsection
