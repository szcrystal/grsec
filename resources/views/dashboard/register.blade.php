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

        <div class="mt-5">

            <form class="form-horizontal" role="form" method="POST" action="/dashboard/register">
                {{ csrf_field() }}

                <input type="hidden" name="edit_id" value="{{$editId}}">

                <fieldset class="form-group">
                    <label for="name" class="control-label">管理者名</label>

                        <input id="name" type="text" class="form-control col-md-6{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ isset($admin) ? $admin->name : old('name') }}" required autofocus>

                        @if ($errors->has('name'))
                            <span class="help-block text-danger">
                                <strong>{{ $errors->first('name') }}</strong>
                            </span>
                        @endif

                </fieldset>

                <fieldset class="form-group">
                    <label for="email" class="control-label">メールアドレス</label>

                        <input id="email" type="email" class="form-control col-md-6{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ isset($admin) ? $admin->email : old('email') }}" required>

                        @if ($errors->has('email'))
                            <span class="help-block text-danger">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif

                </fieldset>

                <fieldset class="form-group">
                    <label for="password" class="control-label">パスワード</label>

                        <input id="password" type="password" class="form-control col-md-6{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                        @if ($errors->has('password'))
                            <span class="help-block text-danger">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        @endif
                </fieldset>


                <div class="form-group">
                    <div class="">
                        <button type="submit" class="btn btn-primary col-md-2">
                            登録
                        </button>
                    </div>
                </div>
            </form>

        </div>

		<div class="row mt-5">
        <div class="table-responsive col-md-10">
        <table class="table table-striped table-bordered bg-white">
          <thead>
            <tr>
              <th>ID</th>
              <th>管理者名</th>
              <th>メールアドレス</th>
              <th></th>
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
                
                <td>
                	@if($obj->id > 2 && $obj->id != Auth::guard('admin')->id())
                        <form role="form" method="POST" action="{{ url('/dashboard/register/'.$obj->id) }}">
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}

                            <input type="submit" class="btn btn-danger btn-sm center-block" value="削除">
                        </form>
                    @endif
                </td>

        	</tr>
        @endforeach
        
        </tbody>
        </table>
        </div>
        </div>
    
    {{ $admins->links() }}


@endsection
