@extends('layouts.appSingle')

@section('content')
    <div class="row">
        <div class="col-md-10 mx-auto py-4">
            <div class="panel panel-default">

                <div class="panel-heading">
                	<h2 class="h2">お問合せ完了</h2>
                </div>

                <div class="panel-body">
					<p>お問合せが完了しました。<br><a href="{{ url('/') }}">HOMEへ</a></p>
				</div>

	    	</div>
        </div>
    </div>
@endsection
