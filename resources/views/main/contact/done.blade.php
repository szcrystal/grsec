@extends('layouts.appSingle')

@section('content')
    <div class="row contact">
        <div class="col-md-12 mx-auto py-4">
            <div class="panel panel-default">

                <div class="panel-heading">
                	<h2 class="card-header">お問合せ完了</h2>
                </div>

                <div style="min-height: 500px;" class="panel-body text-center mt-3">
					<p class="my-4">お問合せの送信が完了しました。</p>
                    <a href="{{ url('/') }}">HOMEへ</a>
				</div>

	    	</div>
        </div>
    </div>
@endsection
