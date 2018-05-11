@extends('layouts.appDashBoard')

@section('content')

    <div class="clearfix">
		<h3 class="page-header">ユーザー編集</h3>
    </div>

    <div class="bs-component clearfix">
        <div class="pull-left">
            <a href="{{ url('/dashboard/users') }}" class=""><i class="fa fa-angle-double-left" aria-hidden="true"></i>一覧へ戻る</a>
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
        <form class="form-horizontal" role="form" method="POST" action="/dashboard/users/{{$user->id}}">
        	{{ method_field('PUT') }}

            {{ csrf_field() }}



			<div class="teble-responsibe">
            <table class="table table-bordered">
            	<colgroup>
                    <col style="background: #fefefe; width: 25%;" class="cth">
                    <col style="background: #fefefe;" class="ctd">
                </colgroup>
                <tbody>
            	<tr>
					<th>ユーザー名</th>
                    <td>{{ $user->name}}</td>
                </tr>
                <tr>
					<th>メールアドレス</th>
                    <td>{{ $user->email}}</td>
                </tr>
                <tr>
					<th>登録日</th>
                    <td>{{ date('Y/m/d H:m', strtotime($user->created_at)) }}</td>
                </tr>
                <tr>
					<th></th>
                    <td>
                    	<div class="form-group">
                            <div class="col-md-6">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="active" value="1"{{isset($user) && ! $user->active ? ' checked' : '' }}> 無効にする
                                    </label>
                                </div>
                            </div>
                        </div>
            		</td>
                </tr>
                </tbody>
            </table>
            </div>

          <div class="form-group">
            <div class="col-md-4 col-md-offset-2">
                <button type="submit" class="btn btn-primary center-block w-btn">更　新</button>
            </div>
        </div>

        </form>

    </div>


@endsection
