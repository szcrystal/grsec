@extends('layouts.appDashBoard')

@section('content')
	
	<h3 class="page-header">問合せ:カテゴリー編集</h3>

    <div class="bs-component clearfix">
        <div class="pull-left">
            <a href="{{ url('/dashboard/contacts/create') }}" class=""><i class="fa fa-angle-double-left" aria-hidden="true"></i>一覧へ戻る</a>
        </div>
    </div>

    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <strong>Error!!</strong> 追加できません<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    
    @if (isset($status))
        <div class="alert alert-success">
            {{ $status }}
        </div>
    @endif
        
    <div class="well">
        <form class="form-horizontal" role="form" method="POST" action="/dashboard/contacts/cate/{{$cateId}}">

            {{ csrf_field() }}

            <div class="form-group{{ $errors->has('category') ? ' has-error' : '' }}">
                <label for="category" class="col-md-3 control-label">カテゴリー</label>
                <div class="col-md-7">
                    <input id="category" type="text" class="form-control" name="category" value="{{ old('category') !== NULL ? old('category') : $cate->category }}" required>

                    @if ($errors->has('category'))
                        <span class="help-block">
                            <strong>{{ $errors->first('category') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-4 col-md-offset-3">
                    <button type="submit" class="btn btn-primary center-block w-btn"><span class="octicon octicon-sync"></span>更　新</button>
                </div>
            </div>
        </form>
    </div>

@endsection
