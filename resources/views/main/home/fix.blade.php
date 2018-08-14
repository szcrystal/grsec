@extends('layouts.app')

@section('content')

<div id="main" class="fix-page col-md-12 {{ $fix->slug }}">

    <div class="panel panel-default">
        <h2 class="h2 mb-3 card-header">{{ $fix->title }}</h2>

        <div class="panel-body">

            <div class="top-cont clearfix">








                {!! $fix->contents !!}
            </div>

		</div>

    </div>


</div>

@endsection


@section('leftbar')
    @include('main.shared.leftbar')
@endsection






