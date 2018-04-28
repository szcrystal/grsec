@extends('layouts.appDashBoard')

@section('content')

    <h3 class="page-header">
	@if($editId)
    管理者編集
    @else
    管理者登録
    @endif
    </h3>

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

    	@if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif

        <div class="well">

            <form class="form-horizontal" role="form" method="POST" action="/dashboard/register">
                {{ csrf_field() }}

                <input type="hidden" name="edit_id" value="{{$editId}}">

                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                    <label for="name" class="col-md-2 control-label">管理者名</label>

                    <div class="col-md-6">
                        <input id="name" type="text" class="form-control" name="name" value="{{ isset($admin) ? $admin->name : old('name') }}" required autofocus>

                        @if ($errors->has('name'))
                            <span class="help-block">
                                <strong>{{ $errors->first('name') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                    <label for="email" class="col-md-2 control-label">メールアドレス</label>

                    <div class="col-md-6">
                        <input id="email" type="email" class="form-control" name="email" value="{{ isset($admin) ? $admin->email : old('email') }}" required>

                        @if ($errors->has('email'))
                            <span class="help-block">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                    <label for="password" class="col-md-2 control-label">パスワード</label>

                    <div class="col-md-6">
                        <input id="password" type="password" class="form-control" name="password" required>

                        @if ($errors->has('password'))
                            <span class="help-block">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>


                <div class="form-group">
                    <div class="col-md-2 col-md-offset-2">
                        <button type="submit" class="btn btn-primary col-md-12">
                            登録
                        </button>
                    </div>
                </div>
            </form>

        </div>

		<div class="row">
        <div class="table-responsive col-md-10">
        <table class="table table-striped table-bordered">
          <thead>
            <tr>
              <th class="col-md-1">ID</th>
              <th class="col-md-4">管理者名</th>
              <th class="col-md-4">メールアドレス</th>
            </tr>
          </thead>
          <tbody>
          
    	<?php //echo "SESSION: " . session('del_key'); ?>
        
    	@foreach($admins as $obj)
        	<tr>
            	<td>{{$obj->id}}</td>
                                    
                <td>
                	{{ $obj->name }}
                </td>

                <td>
                	{{ $obj->email }}
                </td>

                {{--
                <td>
                	<a href="{{url('dashboard/register/'.$obj->id)}}" class="btn btn-primary btn-sm center-block">編集</a>
                </td>
                --}}

        	</tr>
        @endforeach
        
        </tbody>
        </table>
        </div>
        </div>
    
    {{ $admins->links() }}


@endsection
